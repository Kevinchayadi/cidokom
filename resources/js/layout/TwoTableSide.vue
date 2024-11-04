<template>
    <div class="grid grid-col-12 h-[96vh]">
        <!-- Component Atas -->
        <div class="row-span-2  text-white  overflow-x-auto overflow-y-auto">
            <Table  :dataselected="selectedRow" />
        </div>

        <!-- Component Bawah -->
        <div class="row-span-10 bg-gray-100  overflow-x-auto overflow-y-auto p-0 m-0">
            <div
                class="text-xs w-full bg-primary text-primary-text-light z-20 p-0 m-0 text-xxs  border-t-2 border-t-black sticky top-0 left-0">
                dailyReport
            </div>
            <!-- <h1 class="text-xl font-bold mb-2">Component Bawah</h1> -->
            <OnlyTable />

        </div>
    </div>
</template>



<script setup>
    import {
        ref
    } from 'vue';
    import Table from '../fragment/Table.vue'
    import OnlyTable from '../fragment/OnlyTable.vue';

    const selectedId = ref(null);


    const selectedRow = (id) => {
        selectedId.value = id;
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
