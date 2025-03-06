<template>
    <div class="w-[80%] ">
        <Headers tittle="Add Feed" />
        <form @submit.prevent="handleSubmit">
            <InputFragment v-model="formData.nama_pakan" name="nama_pakan" content="nama Pakan" type="text" label="black" />
            <InputFragment v-model="formData.qty" name="qty" content="qty" type="decimal" label="black" />
            <InputFragment v-model="formData.harga" name="harga" content="total(price)" type="decimal"
                label="black" />

            <div class="w-full flex text-center justify-center">
                <FormButton name="Submit" custom="text-center w-[80%] py-4 mt-4" />
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
        nama_pakan: '',
        qty: '',
        harga: '', // Corrected field name
    });
    const props = defineProps({
        pakan:{
            type: Array,
        }
    })

    const data = computed(() =>
        props.pakan.map(item => ({
            id: item.id,
            name: item.nama_pakan
        }))
    );

    const handleSubmit = () => {

        // if (formData.value.harga !== formData.value.harga_confirmation) {
        //     alert('hargas do not match!');
        //     return;
        // }


        router.post("/admin/createPakan", formData.value, {
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
            }
        });
    };
</script>

<style scoped>

</style>
