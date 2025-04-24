<template>
    <div class="flex justify-start sticky top-0 left-0 bg-primary">
        <button :class="buttonclasses" @click="createItem">
            Create Sales
        </button>
        <button :class="[buttonclasses, { 'text-primary-text-light-hover': !selectedId }]" @click="addItem"
            :disabled="!selectedId">
            Edit
        </button>
        <button :class="buttonclasses" @click="downloadItem">
            Download
        </button>
    </div>
    <div class="row-span-10 bg-gray-100 h-[95vh] overflow-x-auto overflow-y-auto p-0 m-0">
        <div class="divide-y divide-x divide-gray-300 border-collapse">
            <table>
                <thead>
                    <tr>
                        <th class="z-20" rowspan="3" :class="classesth"> No. </th>
                        <th class="z-20" rowspan="3" :class="classesth"> Date </th>
                        <th class="z-20" rowspan="3" :class="classesth"> Customer Name </th>
                        <th class="z-20" rowspan="3" :class="classesth"> Chicken Size </th>
                        <th class="z-20" rowspan="3" :class="classesth"> qty </th>
                        <th class="z-20" rowspan="3" :class="classesth"> price </th>
                        <th class="z-20" rowspan="3" :class="classesth"> discount </th>
                        <th class="z-20" rowspan="3" :class="classesth"> Total Price </th>
                        <th class="z-20" rowspan="3" :class="classesth"> description </th>
                        <th class="z-20" rowspan="3" :class="classesth"> Sales Name </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in SalesData" :key="item.id" 
                        @click="selectItem(item.id)"
                        :class="[classestd, { 'bg-gray-300': item.id === selectedId, 'hover:bg-gray-200': true }]">
                        <td :class="classestd">{{ index + 1 }}</td>
                        <td :class="classestd">{{ item.date }}</td>
                        <td :class="classestd">{{ item.name }}</td>
                        <td :class="classestd">{{ item.chickenSize }}</td>
                        <td :class="classestd">{{ item.qty }}</td>
                        <td :class="classestd">{{ formatRupiah(item.price) }}</td>
                        <td :class="classestd">{{ formatRupiah(item.discount) }}</td>
                        <td :class="classestd">{{ formatRupiah(item.total) }}</td>
                        <td :class="classestd" class="w-[250px]">{{ item.desc }}</td>
                        <td :class="classestd" class="w-[250px]">{{ item.sales }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <ModalComp :isVisible="isModalOpen" @update:isVisible="isModalOpen = $event">
        <CreateSale :customer="customer" :chickenSize="chickenSize" />
    </ModalComp>
    <ModalComp :isVisible="isModalOpen2" @update:isVisible="isModalOpen2 = $event">
        <EditSales :customer="customer" :chickenSize="chickenSize" :id="selectedId" :data="selectedData"/>
    </ModalComp>
</template>

<script setup>
    import { computed, ref } from 'vue';
    import ModalComp from '../../../components/displayComponent/ModalComp.vue';
    import CreateSale from '../../addFragment/sales/createSale.vue';
    import EditSales from '../../addFragment/sales/editSales.vue';
import formatRupiah from '../../../composables/currency';

    const classesth = ' bg-blue-300 text-center text-xs border-gray-300 text-table font-medium text-gray-700 uppercase tracking-wider sticky top-[0px] min-w-[120px] shadow-[inset_1px_-1px_1px_white]';
    const classestd = 'p-1 text-xs text-gray-900 text-table text-center min-w-[75px] shadow-[inset_1px_-1px_1px_rgba(128,128,128,0.2)]';

    const selectedId = ref(null);
    const selectedData = ref(null);
    const buttonclasses = 'text-primary-text-light rounded hover:text-primary-text-light-hover sticky top-0 px-2';
    const isModalOpen = ref(false);
    const isModalOpen2 = ref(false);

    const props = defineProps({
        saleTransaction: { type: Array },
        customer: { type: Array },
        chickenSize: { type: Number }
    });

    // Computed property untuk memproses data dari props
    const SalesData = computed(() =>
        props.saleTransaction.map(item => ({
            date: item.tanggal_Penjualan,
            name: item.customers.nama_pelanggan,
            chickenSize: item.chicken_size.size,
            qty: item.jumlah_ayam,
            price: item.harga,
            discount: item.diskon,
            total: item.total_harga,
            desc: item.description,
            sales: item.customers.sales.nama_sales,
            id: item.id, // Tambahkan ID untuk referensi
        }))
    );

    // Fungsi untuk memilih item
    const selectItem = (id) => {
        selectedId.value = id;
        // Find the selected item from the customer list and store it in selectedData
        selectedData.value = props.saleTransaction.find(item => item.id === id);
        console.log('Selected ID:', selectedId.value);
        console.log('Selected Data:', selectedData.value); // Simpan data item yang dipilih
        console.log('Selected Item:', selectedData.value);
    };

    // Fungsi untuk membuka modal untuk edit
    const addItem = () => {
        isModalOpen2.value = true; // Buka modal Edit
    };

    const createItem = () => {
        isModalOpen.value = true; // Buka modal Create
    };

    // Fungsi untuk download item
    const downloadItem = () => {
        console.log('Download:', selectedId.value);
        axios.get(`/download/vaksin`, {
                responseType: 'blob'
            })
            .then((response) => {
                // Membuat URL objek untuk file binary
                const url = window.URL.createObjectURL(new Blob([response.data]));
                // Membuat elemen <a> untuk mendownload file
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `vaksin.xlsx`); // Nama file
                document.body.appendChild(link);
                link.click(); // Memicu unduhan
                document.body.removeChild(link); // Menghapus link setelah klik
            })
            .catch(error => {
                console.error("Error downloading file:", error);
            });
    };
</script>

<style scoped>
    /* Hover effect for table rows */

</style>
