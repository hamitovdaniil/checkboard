<template>
    <template v-for="room in floor.apartments" :key="room.id">
        <el-popover placement="top-start" :width="250" trigger="hover">
            <template #reference>
                <div
                    class="room"
                    :class="[roomStatus(room.status), hoveredRoom]"
                >
                    {{ room.room_count }}
                </div>
            </template>
            <template #default>
                <ul class="roomInfo">
                    <li class="roomInfo__item roomInfo__item-type">
                        {{ room.apartment_type_name }}
                    </li>
                    <li class="roomInfo__item roomInfo__item-entrance">
                        <b>{{ room.entrance_number }}</b> подъезд
                    </li>
                    <li class="roomInfo__item roomInfo__item-floor">
                        <b>{{ room.floor_number }}</b> этаж
                    </li>
                    <li class="roomInfo__item roomInfo__item-count">
                        <b>{{ room.room_count }}-x</b> комн.
                    </li>
                    <li class="roomInfo__item roomInfo__item-square">
                        <b>{{ room.square }}</b> м<sup>2</sup>
                    </li>
                    <li
                        class="roomInfo__item roomInfo__item-status"
                        :class="roomStatus(room.status)"
                    >
                        {{ statusText(room.status) }}
                    </li>
                </ul>
            </template>
        </el-popover>
    </template>
</template>

<script setup>
import { defineProps, defineEmits } from "vue"
const props = defineProps({
    floor: {
        type: Object,
    },
    hoveredRoom: {
        type: String,
    },
})

const emit = defineEmits()
const roomStatus = (status) => {
    return {
        free: status === 1,
        booked: status === 2,
        sold: status === 3,
        unavailable: status === 4,
    }
}

const statusText = (status) => {
    switch (status) {
        case 1:
            return "Свободено"
        case 2:
            return "Забронировано"
        case 3:
            return "Продано"
        case 4:
            return "Недоступено"
    }
}
</script>

<style lang="scss" scoped>
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
    &:hover{
        scale: 1.1;
    }
    &.empty {
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
.roomInfo {
    &__item {
        list-style-position: inside;
        font-size: 13px;
        margin-bottom: 3px;
        font-weight: 500;
        &-type {
            font-weight: 600;
        }
        &-status {
            &.free {
                color: rgb(34 197 94);
            }
            &.booked {
                color: rgb(251 146 60);
            }
            &.sold {
                color: rgb(59 130 246);
            }
            &.unavailable {
                color: rgb(82 82 91);
            }
        }
    }
}
</style>
