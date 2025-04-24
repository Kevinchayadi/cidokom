<template>
    <div class="w-[80%] ">
        <Headers tittle="Edit Sales" />
        <form @submit.prevent="handleSubmit">
            <InputFragment v-model="formData.jumlah_ayam" name="qty" :content='qtyLabel' type="number"label="black" />
            <InputFragment v-model="formData.id_ayam" name="id_ayam" content="Select Chicken Type" type="dropdown"label="black"  :datas="chickenList"/>
            <InputFragment v-model="formData.diskon" name="discount" content='Discount' type="numeric"label="black" />
            <InputFragment v-model="formData.description" name="desc" content="Description" type="textArea" label="black" />
            <div class="w-full flex text-center justify-center">
                <FormButton name="Submit" custom="text-center w-[80%] py-4 mt-4" :disabled="loading"/>
            </div>
        </form>
    </div>
</template>

<script setup>
    import { computed, onMounted, ref } from 'vue';
    import { router } from '@inertiajs/vue3';
    import InputFragment from '../../../components/InputFragment.vue';
    import FormButton from '../../../components/inputComponent/FormButton.vue';
    import Headers from '../../../components/Headers.vue';

    // Form data model
    const formData = ref({
        tanggal_Penjualan: '', // to store sale date
        id_pembeli: '', // to store customer name
        jumlah_ayam: '', // to store quantity of chicken
        diskon:'',
        harga: '', // to store price
        description: '' // to store description
    });
    const loading = ref(false);
    const props = defineProps({
        id: { type: Number },
        data: { type: Object },
        customer:{
            type: Array,
        },
        chickenSize:{
            type : Number,
        }, // To receive the selected data from parent component
    });

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

    // Populate form data on mounted
    onMounted(() => {
        if (props.data) {
            formData.value.tanggal_Penjualan = props.data.tanggal_Penjualan; // assuming the field name in selectedData is 'date'
            formData.value.id_pembeli = props.data.id_pembeli; // assuming the field name in selectedData is 'name'
            formData.value.jumlah_ayam = props.data.jumlah_ayam; // assuming the field name in selectedData is 'qty'
            formData.value.id_ayam = props.data.id_ayam; // assuming the field name in selectedData is 'id_ayam'
            formData.value.diskon = props.data.diskon; // assuming the field name in selectedData is 'id_ayam'
            formData.value.harga = props.data.total_harga; // assuming the field name in selectedData is 'price'
            formData.value.description = props.data.description; // assuming the field name in selectedData is 'desc'
        }
    });

    const handleSubmit = () => {
        // Submit the form
        router.put(`/admin/editSales/${props.id}`, formData.value, {
            onError: (errors) => {
                let errorMessage = '';
                if (errors.error) {
                    alert(errors.error);
                }
                Object.values(errors).forEach((errorArray) => {
                    if (Array.isArray(errorArray)) {
                        errorMessage += errorArray.join('\n') + '\n'; // Combine if it's an array
                    } else {
                        errorMessage += String(errorArray) + '\n'; // Convert to string if not an array
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

<style scoped></style>
