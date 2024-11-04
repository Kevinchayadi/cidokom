<template>
    <SideBarUser>
        <CreateAyam :ayam="ayam"/>
    </SideBarUser>
</template>

<script setup>
import SideBarUser from '../../layout/SideBarUser.vue'
import CreateAyam from '../../fragment/createFragment/CreateAyam.vue';
import { onMounted } from 'vue';

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