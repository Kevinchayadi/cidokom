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
                        <th class="z-20" rowspan="3" :class="classesth">No.</th>
                        <th class="z-20" rowspan="3" :class="classesth">Customer Name</th>
                        <th class="z-20" rowspan="3" :class="classesth">Phone</th>
                        <th class="z-20" rowspan="3" :class="classesth">Address</th>
                        <th class="z-20" rowspan="3" :class="classesth">Place</th>
                        <th class="z-20" rowspan="3" :class="classesth">Sales</th>
                        <th class="z-20" rowspan="3" :class="classesth">Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in customerList" :key="item.id" @click="selectItem(item.id)"
                        :class="[classestd, { 'bg-gray-300 text-white': item.id === selectedId }]">
                        <td :class="classestd">{{ index + 1 }}</td>
                        <td :class="classestd">{{ item.name }}</td>
                        <td :class="classestd">{{ item.phone }}</td>
                        <td :class="classestd">{{ item.address }}</td>
                        <td :class="classestd">{{ item.place }}</td>
                        <td :class="classestd">{{ item.sales }}</td>
                        <td :class="classestd" class="w-[250px]">{{ item.description }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal untuk Create -->
    <ModalComp :isVisible="isModalOpen" @update:isVisible="isModalOpen = $event">
        <CreateCustomer :sales="sales" :residence="residence"/>
    </ModalComp>

    <!-- Modal untuk Edit -->
    <ModalComp :isVisible="isModalOpen2" @update:isVisible="isModalOpen2 = $event">
        <EditCustomer :sales="sales" :residence="residence" :id="selectedId" :data="selectedData"/>
    </ModalComp>
</template>




<script setup>
    import { computed, ref } from 'vue';
    import ModalComp from '../../../components/displayComponent/ModalComp.vue';
    import CreateCustomer from '../../addFragment/sales/createCustomer.vue';
    import EditCustomer from '../../addFragment/sales/editCustomer.vue';

    const classesth = 'bg-blue-300 text-center text-xs border-gray-300 text-table font-medium text-gray-700 uppercase tracking-wider sticky top-[0px] min-w-[120px] shadow-[inset_1px_-1px_1px_white]';
    const classestd = 'p-1 text-xs text-gray-900 text-table text-center min-w-[75px] shadow-[inset_1px_-1px_1px_rgba(128,128,128,0.2)]';

    const selectedId = ref(null);  // To store the selected item ID
    const selectedData = ref(null); // To store the selected item data
    const buttonclasses = 'text-primary-text-light rounded hover:text-primary-text-light-hover sticky top-0 px-2';
    const isModalOpen = ref(false);
    const isModalOpen2 = ref(false);

    const props = defineProps({
        customer: {
            type: Array,
        },
        sales: {
            type: Array,
        },
        residence: {
            type: Array,
        },
    });

    // Computed property to transform props into a more usable format
    const customerList = computed(() => 
        props.customer.map(item => ({
            id: item.id,  // Adding ID here for comparison in selectItem
            name: item.nama_pelanggan,
            address: item.alamat_pelanggan,
            phone: item.no_telepon_pelanggan,
            sales: item.sales.nama_sales,
            place: item.residence.nama_Resident,
            description: item.deskripsi,  // Ensure you include the description
        }))
    );

    // Select an item by its ID
    const selectItem = (id) => {
        selectedId.value = id;
        // Find the selected item from the customer list and store it in selectedData
        selectedData.value = props.customer.find(item => item.id === id);
        console.log('Selected ID:', selectedId.value);
        console.log('Selected Data:', selectedData.value);
    };

    // Create a new sales item (opens modal)
    const createItem = () => {
        isModalOpen.value = true;
    };

    // Edit selected item (opens modal)
    const addItem = () => {
        if (selectedId.value !== null) {
            isModalOpen2.value = true; // Open Edit Modal only if an item is selected
        }
    };

    // Download selected item details
    const downloadItem = () => {
        console.log("Download:", selectedId.value);
        axios.get(`/download/vaksin`, { responseType: 'blob' })
            .then((response) => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `vaksin.xlsx`);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            })
            .catch(error => {
                console.error("Error downloading file:", error);
            });
    };
</script>


<style scoped>
    html,
    body,
    #app {
        height: 100%;
    }

    /* Style untuk scrollbar */
    ::-webkit-scrollbar {
        width: 12px;
        /* Lebar scrollbar untuk vertikal */
        height: 12px;
        /* Tinggi scrollbar untuk horizontal */
    }

    /* Style untuk track */
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    /* Style untuk thumb (bagian geser scrollbar) */
    ::-webkit-scrollbar-thumb {
        background-color: #888;
        /* Warna thumb */
        border-radius: 10px;
        border: 3px solid transparent;
    }

    /* Warna thumb saat dihover */
    ::-webkit-scrollbar-thumb:hover {
        background-color: #555;
    }

    /* Custom Scrollbar untuk bagian tabel */
    .custom-scroll {
        max-height: 500px;
        /* Sesuaikan dengan tinggi tabel yang diinginkan */
        overflow-y: auto;
        /* Scroll vertikal */
        overflow-x: hidden;
        /* Nonaktifkan scroll horizontal */
    }
</style>
