<template>

    <Sidebarnew title="Dashboard">
        <Customer :customer="customer" :sales="sales" :residence="residence" />
    </Sidebarnew>

  
</template>

<script setup>
import Customer from '../../../fragment/Admin/Sales/Customer.vue';
import Sales from '../../../fragment/Admin/Sales/sales.vue';
import Sidebarnew from '../../../layout/sidebarnew.vue';
import { watch } from 'vue';


const props = defineProps({
    customer:{
        type: Array,
    },
    sales:{
        type: Array,
    },
    residence:{
        type:Array,
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