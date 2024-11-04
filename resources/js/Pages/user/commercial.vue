<template>
    <SideBarUser>
        <commercialList :commercial="commercial"/>
    </SideBarUser>
</template>

<script setup>
import { onMounted } from 'vue';
import commercialList from '../../fragment/viewFragment/commercialList.vue';
import KandangList from '../../fragment/viewFragment/kandangList.vue';
import SideBarUser from '../../layout/SideBarUser.vue';

const props = defineProps({
  commercial: {
    type: Array,
    required: true,
  }
});
onMounted(() => {
  console.log(props.commercial)
});
</script>

<style>

</style>