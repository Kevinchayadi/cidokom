<template>
    <div class="w-[80%]">
        <Headers tittle="Buat Kandang" />
        <form @submit.prevent="handleSubmit">
            <InputFragment v-model="form.nama_kandang" name="nama_kandang" content="nama Kandang" type="text" />
            <InputFragment v-model="form.jenis_kandang" content="Jenis kandang" type="dropdown" :datas="jenisKandang" />

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

    const jenisKandang = [
    { id: "breeding", name: "indukan" },
    { id: "doc", name: "kandang doc" },
    { id: "commerce", name: "penjualan" },
    { id: "pembesaran", name: "kandang pembesaran" },
];  
    const form = ref({
        nama_kandang: '',
        jenis_kandang: ''
    })

    const handleSubmit = () => {
        router.post("/user/kandang/create", form.value);
    };
</script>
<style></style>
