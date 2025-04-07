<template>
    <SideBarUser>
        <DailyCommercial  :id_commercial="id_commercial" :feed="feed" :pen="pen" :name="name" :chicken="chicken"/>
    </SideBarUser>
</template>

<script setup>
import SideBarUser from '../../layout/SideBarUser.vue';
import DailyCommercial from '../../fragment/transactionFragment/DailyCommercial.vue'
import { onMounted } from 'vue';

    const props = defineProps({
        id_commercial :{
            type: String,
            required: true
        },
        feed:{
            type: Array,
            required: true
        },
        pen:{
            type: Array
        },
        name:{
            type: String
        },
        chicken:{
            type: Array
        }
    })

</script>

<style>

</style>