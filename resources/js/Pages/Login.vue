<template>
    <AuthTemplate> 
        <LoginFragment />
    </AuthTemplate>
</template>
<script setup>
import AuthTemplate from "../layout/AuthTemplate.vue";
import TextArea from "../components/inputComponent/TextArea.vue";
import LoginFragment from "../fragment/LoginFragment.vue";
import { onMounted } from "vue";
onMounted(() => {
    if (!localStorage.getItem('page_refreshed')) {
    localStorage.setItem('page_refreshed', true);
    window.location.reload();
  }
});


</script>
<style></style>
