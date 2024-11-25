<template>
    <SideBarUser>
        <DailyCommercial  :id_commercial="id_commercial" :feed="feed" :pen="pen"/>
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
        }
    })

    onMounted(() => {
  console.log(props.feed)
});
</script>

<style>

</style>