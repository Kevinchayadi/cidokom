<template>
    <SideBarUser>
        <DailyBreeding :id_breeding="id_breeding" :pakan="pakan" :pen="pen" :name="name"/>
    </SideBarUser>
    
</template>

<script setup>
import SideBarUser from '../../layout/SideBarUser.vue';
import DailyBreeding from '../../fragment/transactionFragment/DailyBreeding.vue'
import { onMounted } from 'vue';

const props = defineProps({
    id_breeding: {
        type: String,
        required: true
    },
    pakan:{
        type: Array,
        required: true
    },
    pen:{
        type: Array,
        required: true
    },
    name:{
        type: String,
    }
})

</script>

<style>

</style>