<template>
    <div class="roomsIndicator">
        <div class="roomsIndicator__all">Всего помещений - {{ total }}</div>
        <div class="roomsIndicator__wrapper">
            <div
                class="roomsIndicator__item roomsIndicator__item-free"
                @mouseenter="hoverStatus('freeActive')"
                @mouseleave="removeHoverStatus"
            >
                Свободные -
                {{ free }}
            </div>
            <div
                class="roomsIndicator__item roomsIndicator__item-booked"
                @mouseenter="hoverStatus('bookedActive')"
                @mouseleave="removeHoverStatus"
            >
                Забронированные -
                {{ booked }}
            </div>
            <div
                class="roomsIndicator__item roomsIndicator__item-sold"
                @mouseenter="hoverStatus('soldActive')"
                @mouseleave="removeHoverStatus"
            >
                Проданные -
                {{ sold }}
            </div>
            <div
                class="roomsIndicator__item roomsIndicator__item-unavailable"
                @mouseenter="hoverStatus('unavailableActive')"
                @mouseleave="removeHoverStatus"
            >
                Недоступные -
                {{ unavailable }}
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineEmits } from "vue"
const props = defineProps({
    total: {
        type: Number,
    },
    free: {
        type: Number,
    },
    booked: {
        type: Number,
    },
    sold: {
        type: Number,
    },
    unavailable: {
        type: Number,
    },
})
const emit = defineEmits(["hoverStatus", "removeHoverStatus"])

const hoverStatus = (status) => {
    emit("hoverStatus", status)
}

const removeHoverStatus = () => {
    emit("removeHoverStatus")
}
</script>

<style lang="scss" scoped>
.roomsIndicator {
    padding: 20px 20px 30px;
    &__all{
        text-align: center;
        margin-bottom: 20px;
        font-weight: 500;
    }
    &__wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        column-gap: 50px;
        row-gap: 20px;
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
</style>
