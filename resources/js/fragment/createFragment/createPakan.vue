<template>
    <div class="w-[80%]">
        <Headers tittle="Add Admin" />
        <form @submit.prevent="handleSubmit">
            <InputFragment v-model="form.nama_pakan"  name="namaPakan" content="Feed Name" type="string" />
            <InputFragment v-model="form.qty" name="qty" content="quantity" type="number" />
            <InputFragment name="Harga" type="number" />

            <div class="w-full flex text-center justify-center">
                <FormButton name="Submit" custom=" text-center w-[80%] py-4 mt-4" />
            </div>
        </form>
    </div>
</template>
<script setup>
    import {
        router
    } from "@inertiajs/vue3";

    import InputFragment from "../../components/InputFragment.vue";
    import FormButton from "../../components/inputComponent/FormButton.vue";
    import Headers from "../../components/Headers.vue";
import { ref } from "vue";

    const form = ref({
        nama_pakan:'',
        qty: 0,
    })
    
    const handleSubmit = () => {
        router.post("/pakan/create", form.value);
    };
</script>
<style></style>
