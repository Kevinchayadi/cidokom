<template>
    <SideBarUser>
        <breedingList :breeding="breeding"/>
    </SideBarUser>
</template>

<script setup>
import { onMounted } from 'vue';

import breedingList from '../../fragment/viewFragment/breedingList.vue';
import SideBarUser from '../../layout/SideBarUser.vue';

const props = defineProps({
  breeding: {
    type: Array,
    required: true,
  }
});
// onMounted(() => {
//   console.log(props.breeding)
// });
</script>

<style>

</style>