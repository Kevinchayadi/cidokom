<template>
    <SideBarUser>
        <DailyAfkir :id="id"  :pen="pen"/>
    </SideBarUser>
    
</template>

<script setup>
import SideBarUser from '../../layout/SideBarUser.vue';
import DailyBreeding from '../../fragment/transactionFragment/DailyBreeding.vue'
import { onMounted } from 'vue';
import DailyAfkir from '../../fragment/transactionFragment/DailyAfkir.vue';

const props = defineProps({
    id: {
        type: Number,
        required: true
    },
    pen:{
        type: Array,
        required: true
    }
})

</script>

<style>

</style>