<template>
    <SideBarUser dashboard="true">
        <MachineList :machine="machine"/>
    </SideBarUser>
</template>

<script setup>
import { onMounted } from 'vue';
import HatcheryList from '../../fragment/viewFragment/hatcheryList.vue';
import KandangList from '../../fragment/viewFragment/kandangList.vue';
import SideBarUser from '../../layout/SideBarUser.vue';
import MachineList from '../../fragment/viewFragment/machineList.vue';

const props = defineProps({
  machine: {
    type: Array,
    required: true,
  }
});
onMounted(() => {
  console.log(props.machine)
});
</script>

<style>

</style>