<template>
    <div class="w-[80%] ">
        <Headers tittle="Create New Sales" />
        <form @submit.prevent="handleSubmit">
            <InputFragment v-model="formData.tanggal_Penjualan" name="Date" content="Sale Date" type="date" label="black" />
            <InputFragment v-model="formData.id_pembeli" name="id_pembeli" content="Customer Name" type="dropdown" label="black" :datas="customerList"/>
            <InputFragment v-model="formData.jumlah_ayam" name="qty" :content='qtyLabel' type="number"label="black" />
            <InputFragment v-model="formData.id_ayam" name="id_ayam" content="Select Chicken Type" type="dropdown"label="black"  :datas="chickenList"/>
            <InputFragment v-model="formData.description" name="desc" content="Description" type="textArea" label="black" />
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
    import InputFragment from "../../../components/InputFragment.vue";
    import FormButton from "../../../components/inputComponent/FormButton.vue";
    import Headers from "../../../components/Headers.vue";

    // Form data model
    const formData = ref({
        tanggal_Penjualan: '',
        id_pembeli: '',
        jumlah_ayam: '',
        id_ayam: '',
        description: '' 
    });


    const loading = ref(false);
    const props = defineProps({
        stock:{
            type: Number,
        },
        customer:{
            type: Array,
        },
        chickenSize:{
            type : Number,
        },
        
    })
    const customerList = computed(()=>
        props.customer.map((customer) => ({
            id: customer.id,
            name: customer.nama_pelanggan
        })));

    const chickenList = computed(()=>
        props.chickenSize.map((size) => ({
            id: size.id,
            name: size.size
        })));

    const qtyLabel = `QTY (Stock : ${props.stock})`

    const handleSubmit = () => {
        loading.value = true;
        router.post("/admin/createsales", formData.value, {
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
