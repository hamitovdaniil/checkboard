<template>
    <div class="tableContainer">
        <div class="topBar">
            <div class="topBar__name">
                <h1 v-if="home">{{ home.house_name }}</h1>
                <el-skeleton animated :rows="0" v-if="loadTable" />
            </div>
            <div class="topBar__filters">
                <div class="topBar__filters__rooms">
                    <div class="topBar__filters__rooms__title">
                        Количество комнат:
                    </div>
                    <div class="topBar__filters__rooms__wrapper">
                        <div class="filterRoom">
                            <el-switch v-model="rommsValue.room1" id="1" />
                            <label for="1">1 - комн.</label>
                        </div>
                        <div class="filterRoom">
                            <el-switch v-model="rommsValue.room2" id="2" />
                            <label for="2">2 - комн.</label>
                        </div>
                        <div class="filterRoom">
                            <el-switch v-model="rommsValue.room3" id="3" />
                            <label for="3">3 - комн.</label>
                        </div>
                        <div class="filterRoom">
                            <el-switch v-model="rommsValue.room4" id="4" />
                            <label for="4">4 - комн.</label>
                        </div>
                    </div>
                </div>
                <div class="topBar__filters__type">
                    <p>Тип квартиры</p>
                    <div class="filterInput">
                        <el-select
                            v-model="selectValue"
                            placeholder="Выберите тип помещения"
                            style="width: 240px"
                            size="large"
                        >
                            <el-option
                                v-for="item in selectOptions"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"
                                :disabled="item.disabled"
                            />
                        </el-select>
                    </div>
                </div>
                <div class="topBar__filters__area">
                    <p>Площадь</p>
                    <div class="filterInput">
                        <el-input v-model="areaFrom" type="number" size="large">
                            <template #prepend>от</template>
                            <template #append>м²</template>
                        </el-input>
                        <el-input v-model="areaTo" type="number" size="large">
                            <template #prepend>до</template>
                            <template #append>м²</template>
                        </el-input>
                    </div>
                </div>
            </div>
        </div>
        <div class="table" v-if="home && home.entrances">
            <floors-number
                :length="home.max_floors"
                v-if="home.max_floors > 1"
                right
                @hoverFloor="hoverFloor"
                @removeHoverFloor="removeHoverFloor"
            />
            <div class="table__scrollable">
                <table>
                    <thead>
                        <tr class="text-center">
                            <td
                                class="thtb"
                                v-for="entrance in home.entrances"
                                :key="entrance.id"
                            >
                                Подъезд №{{ entrance.entrance_number }}
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <th
                            class="thtb"
                            v-for="(entrance, index) in home.entrances"
                            :key="index"
                        >
                            <tr
                                v-for="(floor, index) in entrance.floors"
                                :key="floor.id"
                                :class="{ active: hoveredFloor === index }"
                            >
                                <td class="floor">
                                    <div
                                        class="room"
                                        :class="[
                                            roomStatus(room.status),
                                            hoveredRoom,
                                        ]"
                                        v-for="room in floor.apartments"
                                        :key="room.id"
                                    >
                                        {{ room.room_count }}
                                    </div>
                                </td>
                            </tr>
                        </th>
                    </tbody>
                </table>
            </div>
        </div>
        <el-skeleton animated :rows="15" v-if="loadTable" />
        <el-empty description="В данном доме нет помещений" v-if="noData" />
        <div
            class="roomsIndicator"
            v-if="home.entrances && home.entrances.length"
        >
            <div class="roomsIndicator__wrapper">
                <div
                    class="roomsIndicator__item roomsIndicator__item-free"
                    @mouseenter="hoverStatus('freeActive')"
                    @mouseleave="removeHoverStatus"
                >
                    Свободные
                </div>
                <div
                    class="roomsIndicator__item roomsIndicator__item-booked"
                    @mouseenter="hoverStatus('bookedActive')"
                    @mouseleave="removeHoverStatus"
                >
                    Забронированные
                </div>
                <div
                    class="roomsIndicator__item roomsIndicator__item-sold"
                    @mouseenter="hoverStatus('soldActive')"
                    @mouseleave="removeHoverStatus"
                >
                    Проданные
                </div>
                <div
                    class="roomsIndicator__item roomsIndicator__item-unavailable"
                    @mouseenter="hoverStatus('unavailableActive')"
                    @mouseleave="removeHoverStatus"
                >
                    Недоступные
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref, onMounted, watch } from "vue"
import axios from "axios"
const rommsValue = reactive({
    room1: true,
    room2: true,
    room3: true,
    room4: true,
})

const selectValue = ref("")
const selectOptions = [
    {
        value: "Коммерческое помещение",
        label: "Коммерческое помещение",
    },
    {
        value: "Жилое помещение",
        label: "Жилое помещение",
    },
]

const areaFrom = ref(0)
const areaTo = ref(0)

const home = ref({})
const loadTable = ref(true)
const noData = ref(false)
const takeHome = () => {
    try {
        axios
            .post("https://juniorgroup.uz/api/public/api/filter_house", {
                rooms: [
                    rommsValue.room1 ? 1 : "",
                    rommsValue.room2 ? 2 : "",
                    rommsValue.room3 ? 3 : "",
                    rommsValue.room4 ? 4 : "",
                ],
                type_room: selectValue.value,
                square_in: areaFrom.value,
                square_out: areaTo.value,
            })
            .then((res) => {
                home.value = res.data.house
                loadTable.value = false
                if (
                    res.data.house.entrances &&
                    !res.data.house.entrances.length > 0
                ) {
                    console.log(res.data.house.entrances.length)
                    noData.value = true
                }
            })
    } catch (e) {
        console.log(e)
        loadTable.value = false
        noData.value = true
    }
}

watch(rommsValue, () => {
    takeHome()
})
watch(selectValue, () => {
    takeHome()
})
watch(areaFrom, () => {
    setTimeout(() => {
        takeHome()
    }, 300)
})
watch(areaTo, () => {
    setTimeout(() => {
        takeHome()
    }, 300)
})

onMounted(async () => {
    takeHome()
})

const hoveredRoom = ref("")

const hoverStatus = (status) => {
    hoveredRoom.value = status
}
const removeHoverStatus = () => {
    hoveredRoom.value = ""
}

const hoveredFloor = ref("")

const hoverFloor = (floor) => {
    hoveredFloor.value = floor
}
const removeHoverFloor = (index) => {
    hoveredFloor.value = ""
}

const roomStatus = (status) => {
    return {
        free: status === 1,
        booked: status === 2,
        sold: status === 3,
        unavailable: status === 4,
    }
}
const roomStatusText = (status) => {
    return {
        free: "Свободен",
        booked: "Забронирован",
        sold: "Продан",
        unavailable: "Недоступен",
    }[status]
}
</script>
<style lang="scss">
.topBar {
    display: flex;
    flex-direction: column;
    gap: 30px;
    padding: 30px 20px;
    h1 {
        font-size: 32px;
        font-weight: 500;
    }
    &__filters {
        display: flex;
        gap: 20px;
        &__rooms {
            display: flex;
            flex-direction: column;
            gap: 6px;
            &__wrapper {
                display: flex;
                flex-direction: column;
                gap: 6px;
                .filterRoom {
                    display: flex;
                    gap: 6px;
                    align-items: center;
                    label {
                        font-size: 16px;
                        cursor: pointer;
                    }
                }
            }
        }
        &__type {
            display: flex;
            flex-direction: column;
            gap: 6px;
            p {
                font-size: 16px;
            }
        }
        &__area {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .filterInput {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        &__title {
            font-size: 16px;
        }
    }
}
.roomsIndicator {
    padding: 50px 30px;
    &__wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 50px;
    }
    &__item {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        cursor: pointer;
        &::before {
            content: "";
            width: 20px;
            height: 20px;
            background: rgb(120 113 108);
            border: 1px solid transparent;
        }
        &-free {
            &::before {
                background: rgb(34 197 94);
            }
        }
        &-booked {
            &::before {
                background: rgb(251 146 60);
            }
        }
        &-sold {
            &::before {
                background: rgb(59 130 246);
            }
        }
        &-unavailable {
            &::before {
                border-color: rgb(120 113 108);
                background: transparent;
            }
        }
    }
}
.table {
    position: relative;
    width: 100%;
    padding: 0 37px;
    display: flex;
    flex-direction: column;
    &__scrollable {
        overflow-x: auto;
    }
}

table {
    border-collapse: collapse;
    th {
        vertical-align: top;
    }
    thead {
        td {
            padding: 10px 15px;
            &:nth-child(odd) {
                background-color: rgb(248 250 252);
            }
            &:nth-child(even) {
                background-color: rgb(241 245 249);
            }
            border-bottom: 1px solid rgb(229 231 235);
            font-size: 16px;
            font-weight: 500;
            text-transform: uppercase;
            &.floorNumber {
                padding: 10px 10px;
            }
        }
    }
    tbody {
        th {
            &:nth-child(odd) {
                background-color: rgb(248 250 252);
            }
            &:nth-child(even) {
                background-color: rgb(241 245 249);
            }
            &:not(:last-child) {
                border-right: 1px solid rgb(229 231 235);
            }
            tr {
                padding: 10px 20px;
                display: block;
                width: 100%;
                border-bottom: 1px solid rgb(229 231 235);
                transition: 0.2s ease;
                td {
                    width: 100%;
                    font-size: 14px;
                    .room {
                        width: 25px;
                        height: 25px;
                        border: 1px solid rgb(120 113 108);
                        color: rgb(120 113 108);
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        cursor: pointer;
                        transition: 0.2s ease;
                        &.free {
                            border-color: rgb(34 197 94);
                            background: rgb(34 197 94);
                            color: #fff;
                            order: -4;
                            &.bookedActive {
                                opacity: 0.2;
                            }
                            &.soldActive {
                                opacity: 0.2;
                            }
                            &.unavailableActive {
                                opacity: 0.2;
                            }
                        }
                        &.booked {
                            border-color: rgb(251 146 60);
                            background: rgb(251 146 60);
                            color: #fff;
                            order: -3;
                            &.freeActive {
                                opacity: 0.2;
                            }
                            &.soldActive {
                                opacity: 0.2;
                            }
                            &.unavailableActive {
                                opacity: 0.2;
                            }
                        }
                        &.sold {
                            border-color: rgb(59 130 246);
                            background: rgb(59 130 246);
                            color: #fff;
                            order: -2;
                            &.freeActive {
                                opacity: 0.2;
                            }
                            &.bookedActive {
                                opacity: 0.2;
                            }
                            &.unavailableActive {
                                opacity: 0.2;
                            }
                        }
                        &.unavailable {
                            opacity: 0.3;
                            order: -1;
                            &.freeActive {
                                opacity: 0.2;
                            }
                            &.bookedActive {
                                opacity: 0.2;
                            }
                            &.soldActive {
                                opacity: 0.2;
                            }
                            &.unavailableActive {
                                opacity: 1;
                            }
                        }
                    }
                }
                &.active {
                    background-color: rgb(82 82 91);
                    box-shadow: 0 0 10px rgb(229 231 235);
                    td {
                        .room {
                            &.unavailable {
                                border-color: #fff;
                                color: #fff;
                                opacity: 1;
                            }
                        }
                    }
                }
            }
            &.floorNumber {
                tr {
                    padding: 10px 10px;
                    cursor: pointer;
                }
                td {
                    .room {
                        width: 100%;
                        border: none;
                    }
                }
            }
        }
    }
}

.floor {
    display: flex;
    align-items: center;
    gap: 10px;
}
</style>
