<template>

    <Sidebarnew title="Dashboard">
        <Chicken :ayam="ayam"/>
    </Sidebarnew>
  
</template>

<script setup>
import Sidebarnew from '../../layout/sidebarnew.vue';
import Chicken from '../../fragment/Admin/Operational/chicken.vue';
const props = defineProps({
    ayam:{
        type: Array,
    }
})

</script>