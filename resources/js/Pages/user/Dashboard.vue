<template>
    <SideBarUser>
        <UserDashboard />
    </SideBarUser>
</template>
<script setup>
import SideBarUser from '../../layout/SideBarUser.vue';
import UserDashboard from '../../fragment/viewFragment/userDashboard.vue';
import { onMounted } from "vue";
onMounted(() => {
    if (!localStorage.getItem('page_refreshed')) {
        localStorage.setItem('page_refreshed', true);
        window.location.reload();
        window.location.reload(true);
    }
});


</script>
<style>
    
</style>