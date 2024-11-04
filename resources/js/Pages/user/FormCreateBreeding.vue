<template>
    <SideBarUser>
        <CreateBreeding  :pen="pen" :ayam="ayam"/>
    </SideBarUser>
</template>

<script setup>
import SideBarUser from '../../layout/SideBarUser.vue'
import CreateBreeding from '../../fragment/transactionFragment/CreateBreeding.vue'
import { onMounted } from 'vue';

const props = defineProps({
    pen:{
        type: Array,
        required: true
    },
    ayam:{
        type: Array,
        required: true
    }
})
onMounted(()=>
    console.log(props.pen),
    console.log(props.ayam)
    )
</script>

<style>

</style>