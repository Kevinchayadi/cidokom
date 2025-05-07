<template>
    <div class="w-[80%]">
        <Headers tittle="Edit Customer" />
        <form @submit.prevent="handleSubmit" class=" max-h-[65vh] overflow-y-auto">
            <InputFragment v-model="formData.nama_pelanggan" name="nama_pelanggan" content="Customer Name" type="text" label="black" />
            <InputFragment v-model="formData.alamat_pelanggan" name="alamat_pelanggan" content="Customer Address" type="text" label="black" />
            <InputFragment v-model="formData.no_telepon_pelanggan" name="no_telepon_pelanggan" content='no_telepon_pelanggan' type="numeric" label="black" />
            <InputFragment v-model="formData.id_sales" name="id_sales" content="sales" type="dropdown" label="black" :datas="salesData" />
            <InputFragment v-model="formData.id_residence" name="id_residence" content="residence" type="dropdown" label="black" :datas="residenceData" />
           
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
        nama_pelanggan: '',
        alamat_pelanggan: '',
        no_telepon_pelanggan: '',
        id_sales: '',
        id_residence: '' 
    });
    const loading = ref(false);
    // Props untuk menerima data yang dikirimkan oleh induk
    const props = defineProps({
        stock: {
            type: Number,
        },
        sales: {
            type: Array,
        },
        residence: {
            type: Array,
        },
        id: {
            type: Number,
        },
        data: {
            type: Object,
            required: true,
        }
    });

    // Data untuk dropdown Sales
    const salesData = computed(() =>
        props.sales.map(sales => ({ 
            id: sales.id, 
            name: sales.nama_sales
        }))
    );

    // Data untuk dropdown Residence
    const residenceData = computed(() =>
        props.residence.map(residence => ({ 
            id: residence.id, 
            name: residence.nama_Resident
        }))
    );

    // Label untuk quantity
    const qtyLabel = `QTY (Stock : ${props.stock})`;

    // onMounted untuk mengisi form dengan data yang diterima
    onMounted(() => {
        // Mengisi formData dengan data yang diterima dari props.data
        if (props.data) {
            formData.value.nama_pelanggan = props.data.nama_pelanggan || '';
            formData.value.alamat_pelanggan = props.data.alamat_pelanggan || '';
            formData.value.no_telepon_pelanggan = props.data.no_telepon_pelanggan || '';
            formData.value.id_sales = props.data.id_sales || '';
            formData.value.id_residence = props.data.id_residence || '';
        }
    });

    // Handle form submission
    const handleSubmit = () => {
        loading.value = true;
        router.put(`/admin/editCustomer/${props.id}`, formData.value, {
            onError: (errors) => {
                let errorMessage = "";
                if (errors.error) {
                    alert(errors.error);
                }
                Object.values(errors).forEach((errorArray) => {
                    if (Array.isArray(errorArray)) {
                        errorMessage += errorArray.join("\n") + "\n"; // Gabungkan jika array
                    } else {
                        errorMessage += String(errorArray) + "\n"; // Konversi ke string jika bukan array
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
