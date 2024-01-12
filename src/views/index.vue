<template>
    <div class="tableContainer" v-loading="loading">
        <div class="topBar">
            <div class="topBar__name">
                <h1 v-if="home">{{ home.house_name }}</h1>
                <el-skeleton animated :rows="0" v-if="loadTable" />
            </div>
            <filter-rooms
                @reset="reset"
                :filter="filter"
                :selectOptions="selectOptions"
                :area="area"
                v-model:filter="filter"
                v-model:area="area"
            />
        </div>
        <indicator-rooms
            v-if="home"
            @hoverStatus="hoverStatus"
            @removeHoverStatus="removeHoverStatus"
            :total="home.total_apartments"
            :free="home.total_free_apartments"
            :booked="home.total_booked_apartments"
            :sold="home.total_sold_apartments"
            :unavailable="home.total_unavailable_apartments"
        />
        <div class="table" v-if="home && home.entrances">
            <floors-number
                :length="home.max_floors"
                v-if="home.max_floors > 1"
                right
                @hoverFloor="hoverFloor"
                @removeHoverFloor="removeHoverFloor"
                @confirmFloor="confirmFloor"
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
                                v-for="floor in entrance.floors"
                                :key="floor.id"
                                :class="{
                                    active: hoveredFloor === floor.floor_number,
                                    confirmed: checkConfirmedFloor(
                                        floor.floor_number,
                                    ),
                                }"
                            >
                                <td v-if="floor.apartments.length > 0">
                                    <room
                                        :floor="floor"
                                        :hoveredRoom="hoveredRoom"
                                    />
                                </td>
                                <td v-else>
                                    <div
                                        class="room empty"
                                        :class="hoveredRoom"
                                    >
                                        Отсутствуют
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
    </div>
</template>

<script setup>
import { reactive, ref, onMounted, watch } from "vue"
import axios from "axios"

const filter = reactive({
    selectValue: "",
    room1: true,
    room2: true,
    room3: true,
    room4: true,
})
const area = reactive({
    from: null,
    to: null,
})

const home = ref({})
const loadTable = ref(true)
const noData = ref(false)
const loading = ref(true)

const takeHome = async () => {
    loading.value = true
    try {
        await axios
            .post("https://juniorgroup.uz/api/public/api/house", {
                rooms: [
                    filter.room1 ? 1 : "",
                    filter.room2 ? 2 : "",
                    filter.room3 ? 3 : "",
                    filter.room4 ? 4 : "",
                ],
                type_room: filter.selectValue,
                square_in: area.from,
                square_out: area.to,
            })
            .then((res) => {
                home.value = res.data.house
                loadTable.value = false
                loading.value = false
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

const selectOptions = ref([])
const takeOptions = async () => {
    try {
        await axios
            .get("https://juniorgroup.uz/api/public/api/type_room")
            .then((res) => {
                selectOptions.value = res.data.type_rooms
            })
    } catch (e) {
        console.log(e)
    }
}

const reset = () => {
    filter.room1 = true
    filter.room2 = true
    filter.room3 = true
    filter.room4 = true
    filter.selectValue = ""
    area.from = 0
    area.to = 0
    takeHome()
}

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
const removeHoverFloor = () => {
    hoveredFloor.value = ""
}

const confirmedFloor = ref([])

const confirmFloor = (floor) => {
    confirmedFloor.value = floor
}

const checkConfirmedFloor = (floor) => {
    return confirmedFloor.value.includes(floor) ? true : false
}

watch(filter, () => {
    takeHome()
})

watch(area, () => {
    setTimeout(() => {
        takeHome()
    }, 300)
})
onMounted(async () => {
    await takeHome()
    await takeOptions()
})
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
}

.table {
    position: relative;
    width: 100%;
    padding: 0 53px;
    display: flex;
    flex-direction: column;
    margin-bottom: 30px;
    &__scrollable {
        overflow-x: auto;
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
                        display: flex;
                        gap: 10px;
                    }
                    .room {
                        &.empty {
                            height: 25px;
                            border: 1px solid rgb(120 113 108);
                            color: rgb(120 113 108);
                            font-size: 12px;
                            width: auto;
                            padding: 3px;
                            &.bookedActive {
                                opacity: 0.2;
                            }
                            &.soldActive {
                                opacity: 0.2;
                            }
                            &.unavailableActive {
                                opacity: 0.2;
                            }
                            &.freeActive {
                                opacity: 0.2;
                            }
                        }
                    }
                    &.active,
                    &.confirmed {
                        background-color: rgb(82 82 91);
                        box-shadow: 0 0 10px rgb(229 231 235);
                        td {
                            .room {
                                &.unavailable {
                                    border-color: #fff;
                                    color: #fff;
                                    opacity: 0.6;
                                    &.unavailableActive {
                                        opacity: 1;
                                    }
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
}
</style>
