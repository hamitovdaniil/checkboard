<template>
    <el-config-provider :size="size" :z-index="zIndex">
        <main>
            <router-view></router-view>
        </main>
    </el-config-provider>
</template>

<script setup>
import { ElConfigProvider } from "element-plus"
const zIndex = 3000
const size = "small"
</script>
