<template>
    <SideBarUser>
        <PenList :pen="pen" :tittle="tittle"/>
    </SideBarUser>
</template>

<script setup>
import { onMounted } from 'vue';
import HatcheryList from '../../fragment/viewFragment/hatcheryList.vue';
import KandangList from '../../fragment/viewFragment/kandangList.vue';
import SideBarUser from '../../layout/SideBarUser.vue';
import PenList from '../../fragment/viewFragment/penList.vue';

const props = defineProps({
  tittle:{
    type: String,

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