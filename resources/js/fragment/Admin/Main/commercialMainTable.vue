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
            <CommercialHeaderTable @update:selectedId="selectedRow" 
            :commercial="commercial" />
        </div>

        <!-- Component Bawah -->
        <div class="row-span-10 bg-gray-100 h-[62vh]  overflow-x-auto overflow-y-auto p-0 m-0">
            <div
                class="text-xs w-full bg-primary pl-2 text-primary-text-light z-20 p-0 m-0 text-xxs  border-t-2 border-t-black sticky top-0 left-0">
                Daily Report
            </div>
            <div v-if="showdata === null">
                <p class="text-sm p-1 text-primary-text-light-hover pointer-events-none">select one table!</p>
            </div>
            <div v-else-if="showdata === 1">
                <!-- <OnlyTable /> -->
                <CommercialBottomTable :selectedData="selectedData" /> 
            </div>
            <div v-else>
                <!-- loading... -->
                <!-- <CommercialBottomTable /> -->
            </div>
            <!-- <h1 class="text-xl font-bold mb-2">Component Bawah</h1> -->

        </div>
    </div>
</template>



<script setup>
    import {
        ref
    } from 'vue';

    import axios, { Axios } from 'axios';

import CommercialHeaderTable from './commercialHeaderTable.vue';
import CommercialBottomTable from './commercialBottomTable.vue';

    const selectedId = ref(null);
    const buttonclasses = '  text-primary-text-light rounded hover:text-primary-text-light-hover sticky top-0 px-2'
    const breedingDetail = ref([])
    const showdata = ref(null);
    const selectedRow = (id) => {
        selectedId.value = id;
        console.log("Selected ID dari child:", selectedId.value);
    };
    
    const props =  defineProps({
        commercial: {
            type: Array,
            required: true
        }
    })
    const selectedData = ref([]);
    const selectItem = async () => {
        showdata.value = 0
        console.log(selectedId.value)
        const item = props.commercial.find(b => b.id_commercial === selectedId.value);
        if (item) {
            selectedData.value = item; // Menyimpan data yang ditemukan ke selectedData
            console.log("Selected data:", selectedData.value);
            setTimeout(() => {
            showdata.value = 1;  
        }, 500);
        } else {
            console.error("No data found for id_breeding:", selectedId.value);
        }
        // showdata.value = 0
        // console.log(selectedId.value)
        // try {
        //     const response = await axios.get(`/breeding-detail/${selectedId.value}`);
        //     breedingDetail.value = response.data;
        //     console.log("Selected data:", breedingDetail.value);
        //     showdata.value = 1
        // } catch (error) {
        //     console.error("Error fetching data:", error);
        // }
    };

    const editItem = () => {
        console.log("Edit:", selectedId.value);
    };

    const deleteItem = () => {
        console.log("Delete:", selectedId.value);
    };

    const downloadItem = () => {
        console.log("Download:", selectedId.value);
        // router.get(`/download/commercial/${selectedId.value}`)
        axios.get(`/download/commercial/${selectedId.value}`, { responseType: 'blob' })
        .then((response) => {
          // Membuat URL objek untuk file binary
          const url = window.URL.createObjectURL(new Blob([response.data]));
          // Membuat elemen <a> untuk mendownload file
          const link = document.createElement('a');
          link.href = url;
          link.setAttribute('download', `commercial.xlsx`); // Nama file
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
