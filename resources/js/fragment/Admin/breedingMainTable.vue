<template>
    <div class="flex justify-start sticky top-0 left-0 bg-primary">
        <button :class="[buttonclasses, { 'text-primary-text-light-hover': !selectedId }]" @click="selectItem"
            :disabled="!selectedId">
            Select
        </button>
        <!-- <button :class="[buttonclasses, { 'text-primary-text-light-hover': !selectedId }]" @click="editItem" :disabled="!selectedId">
            Edit
        </button> -->
        <!-- <button :class="[buttonclasses, { 'text-primary-text-light-hover': !selectedId }]" @click="deleteItem" :disabled="!selectedId">
            Delete
        </button> -->
        <button :class="[buttonclasses, { 'text-primary-text-light-hover': !selectedId }]" @click="downloadItem"
            :disabled="!selectedId">
            Download
        </button>
    </div>
    <div class="grid grid-col-12 h-[96vh]">
        <!-- Component Atas -->
        <div class="row-span-2  text-white h-[30vh]  overflow-x-auto overflow-y-auto">
            <!-- <Table  :dataselected="selectedRow" /> -->
            <BreedingHeaderTable @update:selectedId="selectedRow" />
        </div>

        <!-- Component Bawah -->
        <div class="row-span-10 bg-gray-100 h-[70vh]  overflow-x-auto overflow-y-auto p-0 m-0">
            <div
                class="text-xs w-full bg-primary text-primary-text-light z-20 p-0 m-0 text-xxs  border-t-2 border-t-black sticky top-0 left-0">
                dailyReport
            </div>
            <div v-if="showdata === null">
                <p class="text-sm p-1 text-primary-text-light-hover pointer-events-none">select one table!</p>
            </div>
            <div v-else-if="showdata === 1">
                <OnlyTable />
            </div>
            <div v-else>
                loading...
            </div>
            <!-- <h1 class="text-xl font-bold mb-2">Component Bawah</h1> -->

        </div>
    </div>
</template>



<script setup>
    import {
        ref
    } from 'vue';
    // import Table from '../fragment/Table.vue'
    import OnlyTable from '../fragment/OnlyTable.vue';
    import axios from 'axios';
import BreedingHeaderTable from './breedingHeaderTable.vue';

    const selectedId = ref(null);
    const buttonclasses = '  text-primary-text-light rounded hover:text-primary-text-light-hover sticky top-0 px-2'
    const breedingDetail = ref([])
    const showdata = ref(null);
    const selectedRow = (id) => {
        selectedId.value = id;
        console.log("Selected ID dari child:", selectedId.value);
    };

    const selectItem = async () => {
        showdata.value = 0
        console.log(selectedId.value)
        try {
            const response = await axios.get(`/breeding-detail/${selectedId.value}`);
            breedingDetail.value = response.data;
            console.log("Selected data:", breedingDetail.value);
            showdata.value = 1
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    };

    const editItem = () => {
        console.log("Edit:", selectedId.value);
    };

    const deleteItem = () => {
        console.log("Delete:", selectedId.value);
    };

    const downloadItem = () => {
        console.log("Download:", selectedId.value);
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
