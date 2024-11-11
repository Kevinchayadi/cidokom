<template>
    <SideBarUser>
        <PakanList :pakan="pakan"/>
    </SideBarUser>
</template>

<script setup>
import { onMounted } from 'vue';

import SideBarUser from '../../layout/SideBarUser.vue';
import AyamList from '../../fragment/viewFragment/ayamList.vue';
import PakanList from '../../fragment/viewFragment/pakanList.vue';

const props = defineProps({
  pakan: {
    type: Array,
    required: true,
  }
});
onMounted(() => {
  console.log(props.pakan)
});
</script>

<style>

</style>