<template>

    <Sidebarnew title="Dashboard">
        <Sales :sale="sale" :saleTransaction="saleTransaction" :stockleft="stockleft" :customer="customer" :chickenSize="chickenSize" :start="start" :end="end"  />
    </Sidebarnew>

  
</template>

<script setup>
import Sales from '../../../fragment/Admin/Sales/sales.vue';
import Sidebarnew from '../../../layout/sidebarnew.vue';
import { onMounted, watch } from 'vue';


const props = defineProps({
    sale:{
        type: Array,
    },
    saleTransaction:{
        type: Array,
    },
    stockleft:{
        type : Number,
    },
    customer:{
        type: Array,
    },
    chickenSize:{
        type : Number,
    },
    flash: {
        type: Object,
        default: () => ({})
    },
    start: {
        type: String,
    },
    end: {
        type: String,
    },
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