<template>
    <div class="w-[80%]">
        <Headers tittle="Edit Sales" />

        <form @submit.prevent="handleSubmit">
            <!-- Sales Name Input -->
            <InputFragment
                v-model="formData.nama_sales"
                name="nama_sales"
                content="Sales Name"
                type="text"
                label="black"
            />

            <!-- Discount Input -->
            <InputFragment
                v-model="formData.diskon"
                name="diskon"
                content="Diskon (for pcs)"
                type="decimal"
                label="black"
            />

            <!-- Displaying Stock Label (if needed) -->
            <div class="text-center my-2 text-sm">
                <span>{{ qtyLabel }}</span>
            </div>

            <!-- Submit Button -->
            <div class="w-full flex text-center justify-center">
                <FormButton name="Submit" custom="text-center w-[80%] py-4 mt-4" :disabled="loading" />
            </div>
        </form>
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import { router } from '@inertiajs/vue3';
    import InputFragment from "../../../components/InputFragment.vue";
    import FormButton from "../../../components/inputComponent/FormButton.vue";
    import Headers from "../../../components/Headers.vue";

    // Form data model
    const formData = ref({
        nama_sales: '',
        diskon: '', 
    });
    const loading = ref(false);
    // Props for receiving selected data
    const props = defineProps({
        selectedId: {
            type: Number,
            required: true
        },
        selectedData: {
            type: Object,
            default: () => ({})
        },
        stock: {
            type: Number,
        }
    });

    const qtyLabel = `QTY (Stock: ${props.stock})`;

    // Initialize the form when the component is mounted with selectedData
    onMounted(() => {
        if (props.selectedData) {
            formData.value.nama_sales = props.selectedData.nama_sales || '';
            formData.value.diskon = props.selectedData.diskon || '';
        }
    });

    // Submit the form and send data to the backend
    const handleSubmit = () => {
        loading.value = true;
        router.put(`/admin/editCustHandle/${props.selectedId}`, formData.value, {
            onError: (errors) => {
                let errorMessage = "";
                if (errors.error) {
                    alert(errors.error);
                }
                Object.values(errors).forEach((errorArray) => {
                    if (Array.isArray(errorArray)) {
                        errorMessage += errorArray.join("\n") + "\n"; // Combine if array
                    } else {
                        errorMessage += String(errorArray) + "\n"; // Convert to string if not array
                    }
                });
                alert(errorMessage);
                loading.value = false;
            },
            onSuccess: () => {
                alert('Sales updated successfully!');
                loading.value = false;
                // Reset form after success
                formData.value = { nama_sales: '', diskon: '' };
            }
        });
    };
</script>

<style scoped>
    /* Custom styles for the form */
</style>
