<template>
    <div class="flex justify-start sticky top-0 left-0 bg-primary">
        <!-- <button :class="buttonclasses" @click="selectItem">
            Select
        </button> -->
        <!-- <button :class="[buttonclasses, { 'text-primary-text-light-hover': !selectedId }]" @click="editItem" :disabled="!selectedId">
            Edit
        </button> -->
        <!-- <button :class="[buttonclasses, { 'text-primary-text-light-hover': !selectedId }]" @click="deleteItem" :disabled="!selectedId">
            Delete
        </button> -->
        <button  :class="buttonclasses" @click="downloadItem"
            >
            Download
        </button>
    </div>
    <div class="divide-y divide-x divide-gray-300 border-collapse">
            <table>
                <thead>
                    <tr>
                        <th class=" md:left-0  z-20" rowspan="3" :class="classesth">
                        No.
                    </th>
                        <th class=" md:left-0  z-20" rowspan="3" :class="classesth">
                            nama kandang
                    </th>
                        <th class=" md:left-0  z-20" rowspan="3" :class="classesth">
                           jenis kandang
                    </th>
                        <!-- <th class=" md:left-0  z-20" rowspan="3" :class="classesth">
                            lokasi kandang
                    </th>
                        <th class=" md:left-0  z-20" rowspan="3" :class="classesth">
                            Strain Female
                    </th> -->
                        
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in kandanglist" :key="item.id">
                        <td :class="classestd">
                            {{ item.id }}
                        </td>
                        <td :class="classestd">
                            {{ item.name }}
                        </td>
                        <td :class="classestd">
                            {{ item.jenis }}
                        </td>
                    </tr>
                </tbody>
            </table>
            
        </div>
    
</template>



<script setup>
    import {
        computed,
        ref
    } from 'vue';

    const classesth =
        ' bg-blue-300 text-center  text-xs border-gray-300 text-table font-medium text-gray-700 uppercase tracking-wider  sticky top-[18px] min-w-[120px] shadow-[inset_1px_-1px_1px_white]'
    const classesth2 =
        ' bg-blue-300 text-center  text-xs font-medium text-table border-gray-300 text-gray-700 uppercase tracking-wider  sticky top-[36px] min-w-[120px] shadow-[inset_1px_-1px_1px_white]'
    const classesth3 =
        ' bg-blue-300 text-center  text-xs font-medium text-table border-gray-300 text-gray-700 uppercase tracking-wider  sticky top-[54px] min-w-[120px] shadow-[inset_1px_-1px_1px_white]'

    const classestd = 'p-1 text-xs  text-gray-900 text-table text-center min-w-[75px] shadow-[inset_1px_-1px_1px_rgba(128,128,128,0.2)]'

    const selectedId = ref(null);
    const buttonclasses = '  text-primary-text-light rounded hover:text-primary-text-light-hover sticky top-0 px-2'
    const breedingDetail = ref([])
    const showdata = ref(null);

    const props = defineProps({
        kandang: {
            type: Array,

        }
});

// Computed property untuk memproses data dari props
const kandanglist = computed(() =>
  props.kandang.map(item => ({
    id: item.id,
    name: item.nama_kandang,
    jenis: item.jenis_kandang
  }))
);

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
