<template>
    <SideBarUser>
        <MoveHarchery :pen="pen" :hatchery="hatchery"/>
    </SideBarUser>
</template>

<script setup>
import { onMounted } from 'vue';
import SideBarUser from '../../layout/SideBarUser.vue';
import MoveHarchery from '../../fragment/transactionFragment/moveHarchery.vue';

const props = defineProps({
    hatchery:{
        type:Array
    },
  pen: {
    type: Array,
    required: true,
  }
});
onMounted(() => {
  console.log(props.pen)
});
</script>

<style>

</style>