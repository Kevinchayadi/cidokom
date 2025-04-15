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
                        <th class="z-20" rowspan="3" :class="classesth">
                            No.
                        </th>
                        <th class="z-20" rowspan="3" :class="classesth">
                            Sales Name
                        </th>
                        <th class="z-20" rowspan="3" :class="classesth">
                            Discount
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in sales" :key="item.id" @click="selectItem(item.id)"
                        :class="[classestd, { 'bg-gray-300': item.id === selectedId }]">
                        <td :class="classestd">
                            {{ index + 1 }}
                        </td>
                        <td :class="classestd">
                            {{ item.Name }}
                        </td>
                        <td :class="classestd">
                            {{ formatRupiah(item.disc) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Create -->
    <ModalComp :isVisible="isModalOpen" @update:isVisible="isModalOpen = $event">
        <CreateCustHandle />
    </ModalComp>

    <!-- Modal for Edit, passing selected data -->
    <ModalComp :isVisible="isModalOpen2" @update:isVisible="isModalOpen2 = $event">
        <EditCustHandler :selectedId="selectedId" :selectedData="selectedData" />
    </ModalComp>
</template>

<script setup>
import { computed, ref } from 'vue';
import ModalComp from '../../../components/displayComponent/ModalComp.vue';
import CreateCustHandle from '../../addFragment/sales/createCustHandle.vue';
import EditCustHandler from '../../addFragment/sales/editCustHandler.vue';
import axios from 'axios';
import formatRupiah from '../../../composables/currency';

const classesth =
    'bg-blue-300 text-center text-xs border-gray-300 text-table font-medium text-gray-700 uppercase tracking-wider sticky top-[0px] min-w-[120px] shadow-[inset_1px_-1px_1px_white]';

const classestd =
    'p-1 text-xs text-gray-900 text-table text-center min-w-[75px] shadow-[inset_1px_-1px_1px_rgba(128,128,128,0.2)]';

const selectedId = ref(null);
const selectedData = ref({});
const buttonclasses = 'text-primary-text-light rounded hover:text-primary-text-light-hover sticky top-0 px-2';
const isModalOpen = ref(false);
const isModalOpen2 = ref(false);

const props = defineProps({
    sales: {
        type: Array,
        required: true,
    }
});

// Computed property to process data from props
const sales = computed(() =>
    props.sales.map(item => ({
        Name: item.nama_sales,
        disc: item.diskon,
        id: item.id
    }))
);

const selectItem = (id) => {
    selectedId.value = id;
    // Find the selected item based on ID
    selectedData.value = props.sales.find(item => item.id === id);

};

const createItem = () => {
    isModalOpen.value = true;
};

const addItem = () => {
    if (selectedId.value) {
        isModalOpen2.value = true;
    } else {
        alert("Please select a sales item to edit.");
    }
};

const downloadItem = () => {
    if (selectedId.value) {
        axios.get(`/download/vaksin/${selectedId.value}`, {
            responseType: 'blob'
        })
            .then((response) => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `vaksin-${selectedId.value}.xlsx`); // File name
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            })
            .catch(error => {
                console.error("Error downloading file:", error);
            });
    } else {
        alert("Please select a sales item to download.");
    }
};
</script>

<style scoped>
html,
body,
#app {
    height: 100%;
}

/* Style for scrollbar */
::-webkit-scrollbar {
    width: 12px;
    /* Vertical scrollbar width */
    height: 12px;
    /* Horizontal scrollbar height */
}

/* Style for track */
::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

/* Style for thumb (scrollable part) */
::-webkit-scrollbar-thumb {
    background-color: #888;
    border-radius: 10px;
    border: 3px solid transparent;
}

/* Thumb color on hover */
::-webkit-scrollbar-thumb:hover {
    background-color: #555;
}

/* Custom Scrollbar for the table */
.custom-scroll {
    max-height: 500px;
    overflow-y: auto;
    overflow-x: hidden;
}
</style>
