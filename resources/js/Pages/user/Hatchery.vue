<template>
    <SideBarUser>
        <HatcheryList :hatchery="hatchery" />
    </SideBarUser>
</template>

<script setup>
import { onMounted } from 'vue';
import HatcheryList from '../../fragment/viewFragment/hatcheryList.vue';
import KandangList from '../../fragment/viewFragment/kandangList.vue';
import SideBarUser from '../../layout/SideBarUser.vue';

const props = defineProps({
  hatchery: {
    type: Array,
    required: true,
  }
});
onMounted(() => {
  console.log(props.hatchery)
});
</script>

<style>

</style>