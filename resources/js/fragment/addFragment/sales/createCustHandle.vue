<template>
    <div class="w-[80%] ">
        <Headers tittle="Create New Handler" />
        <form @submit.prevent="handleSubmit">
            <InputFragment v-model="formData.nama_sales" name="nama_sales" content="Sales Name" type="text" label="black" />
            <InputFragment v-model="formData.diskon" name="diskon" content="Diskon(for pcs)" type="decimal" label="black" />
            <div class="w-full flex text-center justify-center">
                <FormButton name="Submit" custom="text-center w-[80%] py-4 mt-4" :disabled="loading"  />
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
    import InputFragment from "../../../components/InputFragment.vue";
    import FormButton from "../../../components/inputComponent/FormButton.vue";
    import Headers from "../../../components/Headers.vue";

    // Form data model
    const formData = ref({
        nama_sales: '',
        diskon: '', 
    });

    const loading = ref(false);

    const props = defineProps({
        stock:{
            type: Number,
        }
    })
    const qtyLabel = `QTY (Stock : ${props.stock})`

    const handleSubmit = () => {
        loading.value = true;
        router.post("/admin/createCustHandle", formData.value, {
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
