<template>
    <div class="w-[80%]">
        <Headers tittle="Edit Residence" />
        <form @submit.prevent="handleSubmit">
            <!-- Residence Name Input -->
            <InputFragment v-model="formData.nama_Resident" name="nama_Residence" content="Residence Name" type="text" label="black" />

            <!-- Building Type Dropdown -->
            <InputFragment v-model="formData.tipe" name="tipe" content="Type Building" type="dropdown" label="black" :datas="data"/>

            <div class="w-full flex text-center justify-center">
                <FormButton name="Submit" custom="text-center w-[80%] py-4 mt-4" :disabled="loading"/>
            </div>
        </form>
    </div>
</template>

<script setup>
    import { computed, onMounted, ref } from "vue";
    import { router } from "@inertiajs/vue3";
    import InputFragment from "../../../components/InputFragment.vue";
    import FormButton from "../../../components/inputComponent/FormButton.vue";
    import Headers from "../../../components/Headers.vue";

    // Form data model
    const formData = ref({
        nama_Resident: '',
        tipe: '',
    });
    const loading = ref(false);
    // Dropdown options for 'tipe'
    const data = ref([
        {id: 'Residence', name: 'Residence'},
        {id: 'Market', name: 'Market'},
        {id: 'Restorant', name: 'Restorant'},
        {id: 'Retail', name: 'Retail'},
        {id: 'Industrial', name: 'Industrial'},
    ]);

    // Props from parent component
    const props = defineProps({
        id: { type: Number },
        data: { type: Object }
    });

    // When the component is mounted, fill the form data with the received data
    onMounted(() => {
        if (props.data) {
            formData.value.nama_Resident = props.data.name;
            formData.value.tipe = props.data.Type;
        }
    });

    // Handle form submission
    const handleSubmit = () => {
        loading.value = true;
        router.put(`/admin/editResidence/${props.id}`, formData.value, {
            onError: (errors) => {
                let errorMessage = "";
                if (errors.error) {
                    alert(errors.error);
                }
                Object.values(errors).forEach((errorArray) => {
                    if (Array.isArray(errorArray)) {
                        errorMessage += errorArray.join("\n") + "\n";
                    } else {
                        errorMessage += String(errorArray) + "\n";
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
/* Add any custom styles here */
</style>
