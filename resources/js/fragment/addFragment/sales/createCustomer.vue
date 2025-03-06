<template>
    <div class="w-[80%] ">
        <Headers tittle="Create New Sales" />
        <form @submit.prevent="handleSubmit">
            <InputFragment v-model="formData.nama_pelanggan" name="nama_pelanggan" content="Customer Name" type="text" label="black" />
            <InputFragment v-model="formData.alamat_pelanggan" name="alamat_pelanggan" content="Customer Address" type="text" label="black" />
            <InputFragment v-model="formData.no_telepon_pelanggan" name="no_telepon_pelanggan" content='no_telepon_pelanggan' type="numeric"label="black" />
            <InputFragment v-model="formData.id_sales" name="id_sales" content="sales" type="dropdown"label="black" :datas="salesData" />
            <InputFragment v-model="formData.id_residence" name="id_residence" content="residence" type="dropdown"label="black" :datas="residenceData" />
           
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
    import InputFragment from "../../../components/InputFragment.vue";
    import FormButton from "../../../components/inputComponent/FormButton.vue";
    import Headers from "../../../components/Headers.vue";

    // Form data model
    const formData = ref({
        nama_pelanggan: '',
        alamat_pelanggan: '',
        no_telepon_pelanggan: '',
        id_sales: '',
        id_residence: '' 
    });



    const props = defineProps({
        stock:{
            type: Number,
        },
        sales: {
            type: Array,
        },
        residence: {
            type: Array,
        },
    })

    const salesData= computed(() =>
        props.sales.map(sales => ({ 
            id: sales.id, 
            name: sales.nama_sales
        })))

    const residenceData= computed(() =>
        props.residence.map(residence => ({ 
            id: residence.id, 
            name: residence.nama_Resident
        })))
    const qtyLabel = `QTY (Stock : ${props.stock})`

    const handleSubmit = () => {

        router.post("/admin/createCustomer", formData.value, {
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
