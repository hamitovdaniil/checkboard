<template>
    <div>
        <div class="floorFixed">
            <table>
                <thead>
                    <tr class="text-center">
                        <td class="floorNumber">Этаж</td>
                    </tr>
                </thead>
                <tbody>
                    <th class="floorNumber">
                        <template v-for="floor in length" :key="floor">
                            <el-popconfirm
                                width="220"
                                hide-icon
                                confirm-button-text="Да"
                                cancel-button-text="Нет"
                                title="Закрепить этаж?"
                                @confirm="confirmEvent(floor)"
                                @cancel="cancelEvent(floor)"
                            >
                                <template #reference>
                                    <tr
                                        class="floor"
                                        :class="{
                                            hoverdActive: floorNum === floor,
                                            confirmed: checkConfimed(floor),
                                        }"
                                        @mouseenter="hoverFloor(floor)"
                                        @mouseleave="removeHoverFloor(floor)"
                                    >
                                        <td>
                                            <div class="room">{{ floor }}</div>
                                        </td>
                                    </tr>
                                </template>
                            </el-popconfirm>
                        </template>
                    </th>
                </tbody>
            </table>
        </div>
        <div class="floorFixed right" v-if="right">
            <table>
                <thead>
                    <tr class="text-center">
                        <td class="floorNumber">Этаж</td>
                    </tr>
                </thead>
                <tbody>
                    <th class="floorNumber">
                        <template v-for="floor in length" :key="floor">
                            <el-popconfirm
                                width="220"
                                hide-icon
                                confirm-button-text="Да"
                                cancel-button-text="Нет"
                                title="Закрепить этаж?"
                                @confirm="confirmEvent(floor)"
                                @cancel="cancelEvent(floor)"
                            >
                                <template #reference>
                                    <tr
                                        class="floor"
                                        :class="{
                                            hoverdActive: floorNum === floor,
                                            confirmed: checkConfimed(floor),
                                        }"
                                        @mouseenter="hoverFloor(floor)"
                                        @mouseleave="removeHoverFloor(floor)"
                                    >
                                        <td>
                                            <div class="room">{{ floor }}</div>
                                        </td>
                                    </tr>
                                </template>
                            </el-popconfirm>
                        </template>
                    </th>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script setup>
import { defineEmits, ref } from "vue"
const emits = defineEmits()
const props = defineProps({
    length: {
        type: Number,
    },
    right: {
        type: Boolean,
        default: false,
    },
})

const confirmedFloor = ref([])
const confirmEvent = (floor) => {
    confirmedFloor.value.push(floor)
    emits("confirmFloor", confirmedFloor.value)
}
const cancelEvent = (floor) => {
    const index = confirmedFloor.value.indexOf(floor)
    if (index !== -1) {
        confirmedFloor.value.splice(index, 1)
        emits("confirmFloor", confirmedFloor.value)
    }
}

const checkConfimed = (floor) => {
    return confirmedFloor.value.includes(floor) ? true : false
}

const floorNum = ref(0)
const hoverFloor = (floor) => {
    emits("hoverFloor", floor)
    floorNum.value = floor
}
const removeHoverFloor = (floor) => {
    emits("removeHoverFloor", floor)
    floorNum.value = 0
}
</script>
<style lang="scss" scoped>
.floorFixed {
    position: absolute;
    top: 0;
    left: 0;
    tr {
        text-align: center;
    }
    td {
        &.floorNumber {
            font-size: 12px;
            line-height: 184%;
        }
    }
    tbody {
        tr {
            &:hover {
                background-color: rgb(82 82 91);
                .room {
                    color: #fff;
                }
            }
            .room{
                height: 25px;
            }
            &.hoverdActive,
            &.confirmed {
                background-color: rgb(82 82 91);
                .room {
                    color: #fff;
                }
            }
        }
    }
    &.right {
        left: auto;
        right: 0;
        table {
            border-left: 1px solid rgb(229 231 235);
        }
    }
    table {
        border-right: 1px solid rgb(229 231 235);
    }
}
</style>
