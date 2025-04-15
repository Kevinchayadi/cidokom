<!-- App.vue -->
<template>

    <Sidebarnew title="Dashboard">
        <Summary :breeding="breeding" :commercial="commercial"  :startDate="startDate" :endDate="endDate" />
    </Sidebarnew>
    <!-- <BreedingHeaderTable /> -->
  
</template>

<script setup>
import { onMounted } from 'vue';
import Sidebarnew from '../../layout/sidebarnew.vue';
import { useStore } from 'vuex';
import Summary from '../../fragment/Admin/Main/Summary.vue';

const props = defineProps({
    breeding :{
        type: Array,
        required: true
    },
    commercial:{
        type: Array,
        required: true
    },
    startDate:{
        type: String,
    },
    endDate:{
        type: String,
    },

})
const store = useStore();
onMounted(() => {
    // console.log(props.commercial[0].id_commercial)
    
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