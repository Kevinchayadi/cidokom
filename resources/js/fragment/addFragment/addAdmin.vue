<template>
    <div class="w-[80%] ">
        <Headers tittle="Add Admin" />
        <form @submit.prevent="handleSubmit">
            <InputFragment v-model="formData.name" name="name" content="Admin Name" type="dropDown"
                :data="adminNames" label="black" />
            <InputFragment v-model="formData.username" name="username" content="Username" type="text" label="black" />
            <InputFragment v-model="formData.password" name="password" content="Password" type="password"
                label="black" />
            <InputFragment v-model="formData.password_confirmation" name="password_confirmation"
                content="Confirm Password" type="password" label="black" />
            <InputFragment v-model="formData.role" name="role" content="role" type="dropdown" label="black"
                :datas="data" />

            <div class="w-full flex text-center justify-center">
                <FormButton name="Submit" custom="text-center w-[80%] py-4 mt-4" :disabled="loading"/>
            </div>
        </form>
    </div>
</template>

<script setup>
    import {
        computed,
        onMounted,
        ref
    } from "vue";
    import {
        router
    } from "@inertiajs/vue3";
    import InputFragment from "../../components/InputFragment.vue";
    import FormButton from "../../components/inputComponent/FormButton.vue";
    import Headers from "../../components/Headers.vue";

    // Form data model
    const formData = ref({
        name: '',
        username: '',
        password: '', // Corrected field name
        password_confirmation: '', // Corrected field name
        role: '',
    });

    const props = defineProps({
        role: {
            type: Array
        }
    })
    const loading = ref(false);
    const data = computed(() =>
        props.role.map(item => ({
            id: item.id,
            name: item.role
        }))
    );

    const handleSubmit = () => {

        if (formData.value.password !== formData.value.password_confirmation) {
            alert('Passwords do not match!');
            return;
        }

        loading.value = true;
        router.post("/admin/register", formData.value, {
            onError: (errors) => {
                let errorMessage = "";
                if (errors.error) {
                    alert(errors.error);
                }
                Object.values(errors).forEach((errorArray) => {
                    if (Array.isArray(errorArray)) {
                        errorMessage += errorArray.join("\n") + "\n"; // Gabungkan jika array
                    } else {
                        errorMessage += String(errorArray) +
                        "\n"; // Konversi ke string jika bukan array
                    }
                });
                alert(errorMessage);
                loading.value = false;
            }, 
            onSuccess: () => {
            loading.value = false; 
        },
        });
    };
</script>

<style scoped>

</style>
