<template>
    <div>
        <div class="floorFixed">
            <table>
                <thead>
                    <tr class="text-center">
                        <td class="floorNumber">№</td>
                    </tr>
                </thead>
                <tbody>
                    <th class="floorNumber">
                        <tr
                            v-for="(entrance, index) in length"
                            :key="entrance"
                            class="floor"
                            @mouseenter="$emit('hoverFloor', index)"
                            @mouseleave="$emit('removeHoverFloor', index)"
                        >
                            <td>
                                <div class="room">{{ index + 1 }}</div>
                            </td>
                        </tr>
                    </th>
                </tbody>
            </table>
        </div>
        <div class="floorFixed right" v-if="right">
            <table>
                <thead>
                    <tr class="text-center">
                        <td class="floorNumber">№</td>
                    </tr>
                </thead>
                <tbody>
                    <th class="floorNumber">
                        <tr
                            v-for="(entrance, index) in length"
                            :key="entrance"
                            class="floor"
                            @mouseenter="$emit('hoverFloor', index)"
                            @mouseleave="$emit('removeHoverFloor', index)"
                        >
                            <td>
                                <div class="room">{{ index + 1 }}</div>
                            </td>
                        </tr>
                    </th>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script setup>
import { defineEmits } from "vue"
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
</script>
<style lang="scss" scoped>
.floorFixed {
    position: absolute;
    top: 0;
    left: 0;
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
