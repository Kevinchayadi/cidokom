<template>
    <SideBarUser>
        <HatcherythreeDays :hatcheryDetail="hatcheryDetail" />
    </SideBarUser>
</template>

<script setup>
    import HatcherythreeDays from '../../fragment/transactionFragment/HatcheryThreeDays.vue';
    import SideBarUser from '../../layout/SideBarUser.vue';

    const props = defineProps({
        hatcheryDetail: {
            type: Object,
            required: true
        }
    })
</script>

<style>

</style>
