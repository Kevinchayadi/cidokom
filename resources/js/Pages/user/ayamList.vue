<template>
    <SideBarUser>
        <AyamList :ayam="ayam"/>
    </SideBarUser>
</template>

<script setup>
import { onMounted } from 'vue';
import HatcheryList from '../../fragment/viewFragment/hatcheryList.vue';
import KandangList from '../../fragment/viewFragment/kandangList.vue';
import SideBarUser from '../../layout/SideBarUser.vue';
import AyamList from '../../fragment/viewFragment/ayamList.vue';

const props = defineProps({
  ayam: {
    type: Array,
    required: true,
  }
});
onMounted(() => {
  console.log(props.ayam[0].id)
});
</script>

<style>

</style>