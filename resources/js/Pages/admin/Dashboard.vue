<!-- App.vue -->
<template>

    <Sidebarnew title="Dashboard">
        <Dashboard />
    </Sidebarnew>
    <!-- <BreedingHeaderTable /> -->
  
</template>

<script setup>
import { onMounted } from 'vue';
import Sidebarnew from '../../layout/sidebarnew.vue';
import Dashboard from '../../fragment/Admin/dashboard.vue';
// const props = defineProps({
//     auth: {
//         type: Object,
//         required: true
//     }
// })
// onMounted(()=>{
//     console.log(props.auth.user.name)
// })
// import BreedingHeaderTable from '../fragment/Admin/breedingHeaderTable.vue';
import { useStore } from 'vuex';
const store = useStore();
onMounted(() => {
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