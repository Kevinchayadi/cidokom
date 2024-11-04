<template>
    <SideBarUser>
        <HatcheryEightynDays :hatcheryDetail="hatcheryDetail"/>
    </SideBarUser>
</template>

<script setup>
import { onMounted } from 'vue';
import HatcheryEightynDays from '../../fragment/transactionFragment/HatcheryEightynDays.vue';
import SideBarUser from '../../layout/SideBarUser.vue';

const props = defineProps({
        hatcheryDetail: {
            type: Object,
            required: true
        }
    })
    onMounted(()=>
    console.log(props.hatcheryDetail.id)
)


</script>

<style>

</style>