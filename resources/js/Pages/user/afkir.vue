<template>
    <SideBarUser dashboard="true">
        
        <afkirList :afkir="afkir" />
    </SideBarUser>
</template>

<script setup>
import { onMounted } from 'vue';
import HatcheryList from '../../fragment/viewFragment/hatcheryList.vue';
import KandangList from '../../fragment/viewFragment/kandangList.vue';
import SideBarUser from '../../layout/SideBarUser.vue';
import afkirList from '../../fragment/viewFragment/afkirList.vue';


const props = defineProps({
  afkir: {
    type: Array,
    required: true,
  },
  pakan:{
    type: Array,
    required: true,
  }
});
onMounted(() => {
  console.log(props.afkir[0])
});
</script>

<style>

</style>