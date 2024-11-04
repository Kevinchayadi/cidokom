<template>
    <SideBarUser>
        <KandangList :kandang="kandang"/>
    </SideBarUser>
</template>

<script setup>
import { onMounted } from 'vue';
import HatcheryList from '../../fragment/viewFragment/hatcheryList.vue';
import KandangList from '../../fragment/viewFragment/kandangList.vue';
import SideBarUser from '../../layout/SideBarUser.vue';

const props = defineProps({
  kandang: {
    type: Array,
    required: true,
  }
});
onMounted(() => {
  console.log(props.kandang)
});
</script>

<style>

</style>