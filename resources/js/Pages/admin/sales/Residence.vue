<template>

    <Sidebarnew title="Dashboard">
        <Residence :resident="resident" />
    </Sidebarnew>

  
</template>

<script setup>
import Residence from '../../../fragment/Admin/Sales/Residence.vue';

import Sidebarnew from '../../../layout/sidebarnew.vue';
import { watch } from 'vue';


const props = defineProps({
    resident:{
        type: Array,
    },
    flash: {
        type: Object,
        default: () => ({})
    }
})
const emit = defineEmits(['updateFlash']);

watch(() => props.flash.success, (newValue) => {
    if (newValue) {
        alert(newValue);
        emit('updateFlash', null); // Emit event untuk mengatur flash.success menjadi null
        window.location.reload();
        // this.$forceUpdate();
    }
});



</script>