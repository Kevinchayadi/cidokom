<template>
    <div class="w-[80%]">
        <Headers tittle="Edit Chicken Type" />
        <form @submit.prevent="handleSubmit">
            <!-- Pre-fill form fields with the data from the selected item -->
            <InputFragment v-model="formData.size" name="Size" content="Size Chicken (character)" type="text" label="black" />
            <InputFragment v-model="formData.harga" name="harga" content="Price" type="decimal" label="black" />
            <div class="w-full flex text-center justify-center">
                <FormButton name="Submit" custom="text-center w-[80%] py-4 mt-4" :disabled="loading"/>
            </div>
        </form>
    </div>
</template>

<script setup>
    import { ref, onMounted } from "vue";
    import { router } from "@inertiajs/vue3";
    import InputFragment from "../../../components/InputFragment.vue";
    import FormButton from "../../../components/inputComponent/FormButton.vue";
    import Headers from "../../../components/Headers.vue";

    // Props to receive the existing chicken type data
    const props = defineProps({
        item: {
            type: Object,
            required: true,  // Ensure the item prop is passed from the parent
        }
    });
    const loading = ref(false);
    // Form data model for the form fields
    const formData = ref({
        size: '',  // Chicken size
        harga: '',  // Price
    });

    // Populate the form with existing data when the component is mounted
    onMounted(() => {
        if (props.item) {
            formData.value.size = props.item.size || '';  // Ensure existing data is populated
            formData.value.harga = props.item.harga || '';  // Ensure existing data is populated
        }
    });

    // Handle form submission for updating the chicken type
    const handleSubmit = () => {
        loading.value = true;
        router.put(`/admin/editChickenSize/${props.item.id}`, formData.value, {
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
    /* Add your styling here if needed */
</style>
