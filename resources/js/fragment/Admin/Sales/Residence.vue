<template>
    <div class="flex justify-start sticky top-0 left-0 bg-primary">
        <button :class="buttonclasses" @click="createItem">
            Create 
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
                            Residence Name
                        </th>
                        <th class="z-20" rowspan="3" :class="classesth">
                            Type
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in residencelist" :key="item.id" @click="selectItem(item)"
                        :class="[classestd, { 'bg-gray-300': item.id === selectedId }]">
                        <td :class="classestd">
                            {{ index + 1 }}
                        </td>
                        <td :class="classestd">
                            {{ item.name }}
                        </td>
                        <td :class="classestd">
                            {{ item.Type }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Create -->
    <ModalComp :isVisible="isModalOpen" @update:isVisible="isModalOpen = $event">
        <CreateResidence />
    </ModalComp>

    <!-- Modal Edit -->
    <ModalComp :isVisible="isModalOpen2" @update:isVisible="isModalOpen2 = $event">
        <EditResidence :id="selectedId" :data="selectedData" />
    </ModalComp>
</template>




<script setup>
    import { computed, ref } from 'vue';
    import ModalComp from '../../../components/displayComponent/ModalComp.vue';
    import CreateResidence from '../../addFragment/sales/createResidence.vue';
    import EditResidence from '../../addFragment/sales/editResidence.vue';

    const classesth = 'bg-blue-300 text-center text-xs border-gray-300 text-table font-medium text-gray-700 uppercase tracking-wider sticky top-[0px] min-w-[120px] shadow-[inset_1px_-1px_1px_white]';
    const classestd = 'p-1 text-xs text-gray-900 text-table text-center min-w-[75px] shadow-[inset_1px_-1px_1px_rgba(128,128,128,0.2)]';

    const selectedId = ref(null);
    const selectedData = ref(null); // Data yang dipilih untuk update
    const buttonclasses = 'text-primary-text-light rounded hover:text-primary-text-light-hover sticky top-0 px-2';
    const breedingDetail = ref([]);
    const isModalOpen = ref(false);
    const isModalOpen2 = ref(false);
    const showdata = ref(null);

    const props = defineProps({
        resident: {
            type: Array,
        }
    });

    // Computed property untuk memproses data dari props
    const residencelist = computed(() =>
        props.resident.map(item => ({
            id: item.id, // Pastikan setiap item memiliki ID unik
            name: item.nama_Resident,
            Type: item.tipe
        }))
    );

    // Fungsi untuk memilih item dan menyimpan data yang dipilih
    const selectItem = (item) => {
        selectedId.value = item.id;
        selectedData.value = item; // Menyimpan seluruh data item yang dipilih
        console.log('Selected ID:', selectedId.value);
        console.log('Selected Data:', selectedData.value);
    };

    const createItem = () => {
        isModalOpen.value = true;
    };

    const addItem = () => {
        if (selectedData.value) {
            isModalOpen2.value = true; // Buka modal edit hanya jika ada data yang dipilih
        }
    };

    const downloadItem = () => {
        console.log("Download:", selectedId.value);
        axios.get(`/download/vaksin`, {
                responseType: 'blob'
            })
            .then((response) => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `vaksin.xlsx`); // Nama file
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
