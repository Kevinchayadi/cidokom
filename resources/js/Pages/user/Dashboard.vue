<template>
    <SideBarUser dashboard="true">
        <UserDashboard />
    </SideBarUser>
</template>
<script setup>
import SideBarUser from '../../layout/SideBarUser.vue';
// import dashoard from '../../fragment/Admin/dashoard.vue';
import UserDashboard from '../../fragment/viewFragment/userDashboard.vue';
import { onMounted } from "vue";
import { useStore } from 'vuex';
import FrontTemplate from '../../layout/frontTemplate.vue';
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
<style>
    
</style>