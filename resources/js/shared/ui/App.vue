<template>
    <div>
        <Toast position="top-right" />
        <slot></slot>
    </div>
</template>

<script>
import Toast from 'primevue/toast';
import { notificationService } from "../../services/notificationService.js";

export default {
    name: "App",
    components: {
        Toast
    }
}
</script>

<style scoped lang="scss">

</style>
