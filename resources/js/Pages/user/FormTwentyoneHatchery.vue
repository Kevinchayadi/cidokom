<template>
    <SideBarUser>
        <HatcheryTwentyoneDays :hatcheryDetail="hatcheryDetail"/>
    </SideBarUser>
</template>

<script setup>
import HatcheryTwentyoneDays from '../../fragment/transactionFragment/HatcheryTwentyoneDays.vue';
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