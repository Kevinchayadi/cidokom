<template>
    <div class="flex justify-start sticky top-0 left-0 bg-primary">
        <!-- <button :class="buttonclasses" @click="selectItem">
            Select
        </button> -->
        <button :class="buttonclasses" @click="addItem">
            Add New Admin
        </button>
        <button :class="[buttonclasses, { 'text-primary-text-light-hover': !selectedId }]" @click="editItem" :disabled="!selectedId">
            Edit
        </button>
        <button :class="buttonclasses" @click="downloadItem">
            Download
        </button>
    </div>

    <div class="divide-y divide-x divide-gray-300 border-collapse">
        <table>
            <thead>
                <tr>
                    <th class="md:left-0 z-20" rowspan="3" :class="classesth">No.</th>
                    <th class="md:left-0 z-20" rowspan="3" :class="classesth">Nama Admin</th>
                    <th class="md:left-0 z-20" rowspan="3" :class="classesth">Username</th>
                    <th class="md:left-0 z-20" rowspan="3" :class="classesth">Role</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in adminlist" :key="item.id" @click="selectItem(item.id)"
                    :class="[classestd, { 'bg-gray-300': item.id === selectedId }]">
                    <td :class="classestd">{{ index + 1 }}</td>
                    <td :class="classestd">{{ item.name }}</td>
                    <td :class="classestd">{{ item.username }}</td>
                    <td :class="classestd">{{ item.role }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <ModalComp :isVisible="isModalOpen" @update:isVisible="isModalOpen = $event">
        <AddAdmin :role="role" />
    </ModalComp>
</template>

<script setup>
import { computed, ref } from 'vue';
import ModalComp from '../../../components/displayComponent/ModalComp.vue';
import AddAdmin from '../../addFragment/addAdmin.vue';
import axios, { Axios } from 'axios';
import { router } from '@inertiajs/vue3';

const classesth =
    ' bg-blue-300 text-center text-xs border-gray-300 text-table font-medium text-gray-700 uppercase tracking-wider sticky top-[18px] min-w-[120px] shadow-[inset_1px_-1px_1px_white]';
const classestd =
    'p-1 text-xs text-gray-900 text-table text-center min-w-[75px] shadow-[inset_1px_-1px_1px_rgba(128,128,128,0.2)]';

const selectedId = ref(null);
const isModalOpen = ref(false);
const buttonclasses = 'text-primary-text-light rounded hover:text-primary-text-light-hover sticky top-0 px-2';

const props = defineProps({
    admins: {
        type: Array,
    },
    role: {
        type: Array,
    },
});

// Computed property untuk memproses data dari props
const adminlist = computed(() =>
    props.admins.map((item) => ({
        id: item.id,
        name: item.name,
        username: item.username,
        role: item.role.role,
    }))
);

// Fungsi untuk memilih baris
const selectItem = (id) => {
    selectedId.value = id;
    console.log('Selected ID:', selectedId.value);
};

const editItem = () => {
    console.log('Edit:', selectedId.value);
};

const addItem = () => {
    isModalOpen.value = true;
};

const downloadItem = () => {
    console.log('Download:', selectedId.value);
    // router.get(`/download/admin`)
    axios.get(`/download/admin`, { responseType: 'blob' })
        .then((response) => {
          // Membuat URL objek untuk file binary
          const url = window.URL.createObjectURL(new Blob([response.data]));
          // Membuat elemen <a> untuk mendownload file
          const link = document.createElement('a');
          link.href = url;
          link.setAttribute('download', `admin.xlsx`); // Nama file
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
