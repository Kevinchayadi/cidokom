<template>

    <Sidebarnew title="Dashboard">
        <Chicken :ayam="ayam"/>
    </Sidebarnew>
  
</template>

<script setup>
import Sidebarnew from '../../layout/sidebarnew.vue';
import Dashboard from '../../fragment/Admin/dashboard.vue';
import Chicken from '../../fragment/Admin/chicken.vue';
const props = defineProps({
    ayam:{
        type: Array,
    }
})

</script>