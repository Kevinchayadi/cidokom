<template>
    <div class="w-[80%]">
        <Headers tittle="Buat Kandang farm" />
        <form @submit.prevent="handleSubmit">
            <InputFragment v-model="form.nama_kandang" name="nama_kandang" content="code kandang" type="text" />
            <InputFragment v-model="form.lokasi_kandang" name="lokasi_kandang" content="Lokasi Kandang" type="text" />
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
    { id: "breeding", name: "breeding" },
    { id: "commerce", name: "commercial" },
    { id: "afkir", name: "afkir" },
];  
    const form = ref({
        nama_kandang: '',
        lokasi_kandang:'',
        jenis_kandang: ''
    })

    const handleSubmit = () => {
        router.post("/user/farm/create", form.value);
    };
</script>
<style></style>
