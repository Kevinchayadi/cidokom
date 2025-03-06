<!-- App.vue -->
<template>

    <Sidebarnew title="Dashboard">
        <Dashboard :totalAfkir="totalAfkir" :totalBreeding="totalBreeding" :totalDeath="totalDeath" :afkir="afkir" :breeding="breeding" :hatchery="hatchery"/>
    </Sidebarnew>
    <!-- <BreedingHeaderTable /> -->
  
</template>

<script setup>
import { onMounted } from 'vue';
import Sidebarnew from '../../layout/sidebarnew.vue';
import Dashboard from '../../fragment/Admin/Main/dashboard.vue';
import { useStore } from 'vuex';

const props = defineProps({
    totalAfkir:{
        type: Number,
        required: true,
    },
    totalBreeding:{
        type: Number,
        required: true,
    },
    totalDeath:{
        type: Number,
        required: true,
    },
    afkir:{
        type: Array,
    },
    breeding:{
        type: Array,
    },
    hatchery:{
        type: Array,
    },

})
const store = useStore();
onMounted(() => {
    // console.log(props.hatchery[0].hatchery_details[0].saleable)
    if (!localStorage.getItem('page_refreshed')) {
        localStorage.setItem('page_refreshed', true);
        window.location.reload();
        window.location.reload(true);
    }
    if(!store.getters.user){
        console.log('test')
        window.location.reload();
        window.location.reload(true);
    }
});



</script>