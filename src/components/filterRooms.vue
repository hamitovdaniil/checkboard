<template>
    <div class="topBar__filters">
        <div class="topBar__filters__rooms">
            <div class="topBar__filters__rooms__title">Количество комнат:</div>
            <div class="topBar__filters__rooms__wrapper">
                <div class="filterRoom">
                    <el-switch
                        v-model="filter.room1"
                        @change="$emit('updateFilter', value)"
                        id="1"
                    />
                    <label for="1">1 - комн.</label>
                </div>
                <div class="filterRoom">
                    <el-switch
                        v-model="filter.room2"
                        @change="$emit('updateFilter', value)"
                        id="2"
                    />
                    <label for="2">2 - комн.</label>
                </div>
                <div class="filterRoom">
                    <el-switch
                        v-model="filter.room3"
                        @change="$emit('updateFilter', value)"
                        id="3"
                    />
                    <label for="3">3 - комн.</label>
                </div>
                <div class="filterRoom">
                    <el-switch
                        v-model="filter.room4"
                        @change="$emit('updateFilter', value)"
                        id="4"
                    />
                    <label for="4">4 - комн.</label>
                </div>
            </div>
        </div>
        <div class="topBar__filters__type">
            <p>Тип помещения</p>
            <div class="filterInput">
                <el-select
                    v-model="filter.selectValue"
                    @change="$emit('updateFilter', value)"
                    placeholder="Выберите тип помещения"
                    style="width: 240px"
                    size="large"
                >
                    <el-option
                        v-for="item in selectOptions"
                        :key="item.id"
                        :label="item.type_name"
                        :value="item.id"
                        :disabled="item.disabled"
                    />
                </el-select>
            </div>
        </div>
        <div class="topBar__filters__area">
            <p>Площадь помещения</p>
            <div class="filterInput">
                <el-input
                    v-model="area.from"
                    @input="$emit('updateArea', value)"
                    type="number"
                    size="large"
                >
                    <template #prepend>от</template>
                    <template #append>м²</template>
                </el-input>
                <el-input
                    v-model="area.to"
                    @input="$emit('updateArea', value)"
                    type="number"
                    size="large"
                >
                    <template #prepend>до</template>
                    <template #append>м²</template>
                </el-input>
            </div>
        </div>
        <div class="topBar__filters__reset">
            <el-button type="primary" size="large" @click="reset"
                >Сбросить
            </el-button>
        </div>
    </div>
</template>
<script setup>
import { defineEmits } from "vue"
const emit = defineEmits()
const props = defineProps({
    filter: {
        type: Object,
    },
    area: {
        type: Object,
    },
    selectOptions: {
        type: Array,
    },
})

const reset = () => {
    emit("reset")
}
</script>
<style lang="scss">
.topBar {
    &__filters {
        display: flex;
        align-items: flex-end;
        flex-wrap: wrap;
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
            flex-wrap: wrap;
            gap: 6px;
            .el-select,
            .el-input {
                min-width: 150px;
                max-width: 300px;
                width: 100%;
            }
        }
        &__title {
            font-size: 16px;
        }
    }
}
</style>
