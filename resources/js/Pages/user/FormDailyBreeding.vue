<template>
    <SideBarUser>
        <DailyBreeding :id_breeding="id_breeding"/>
    </SideBarUser>
    
</template>

<script setup>
import SideBarUser from '../../layout/SideBarUser.vue';
import DailyBreeding from '../../fragment/transactionFragment/DailyBreeding.vue'

const props = defineProps({
    id_breeding: {
        type: String,
        required: true
    }
})
</script>

<style>

</style>