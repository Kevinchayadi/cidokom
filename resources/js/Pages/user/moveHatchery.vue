<template>
    <SideBarUser>
        <MoveHarchery :pen="pen" :id="id" :hatchery="hatchery"/>
    </SideBarUser>
</template>

<script setup>
import { onMounted } from 'vue';
import SideBarUser from '../../layout/SideBarUser.vue';
import MoveHarchery from '../../fragment/transactionFragment/moveHarchery.vue';

const props = defineProps({
    id:{
        type:String
    },
    hatchery:{
        type:Object
    },
  pen: {
    type: Array,
    required: true,
  }
});
onMounted(() => {
  if (props.hatchery  ) {
    console.log();
  } else {
    console.log("Hatchery details not available or empty.");
  }
});
</script>

<style>

</style>