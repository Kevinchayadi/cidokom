<template>
    <SideBarUser>
        <CreateCommercial :pen="pen" />
    </SideBarUser>
</template>

<script setup>
import SideBarUser from '../../layout/SideBarUser.vue'
import CreateCommercial from '../../fragment/transactionFragment/CreateCommercial.vue'
import { onMounted } from 'vue';

const props = defineProps({
    pen:{
        type:Array,
        default: () => []
    }
})
onMounted(() => {
  console.log(props.pen)
});
</script>

<style>

</style>