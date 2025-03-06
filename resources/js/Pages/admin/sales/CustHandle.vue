<template>

    <Sidebarnew title="Dashboard">
        <CustHandle :sales="sales" />
    </Sidebarnew>

  
</template>

<script setup>
import CustHandle from '../../../fragment/Admin/Sales/CustHandle.vue';
import Sales from '../../../fragment/Admin/Sales/sales.vue';
import Sidebarnew from '../../../layout/sidebarnew.vue';
import { watch } from 'vue';


const props = defineProps({
    sales:{
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