<template>
    <div class="flex justify-start sticky top-0 left-0 bg-primary">
        <button :class="buttonclasses" @click="selectItem">
            Select
        </button>
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
    <div class="row-span-10 bg-gray-100 h-[95vh]  overflow-x-auto overflow-y-auto p-0 m-0">
        <div class="divide-y divide-x divide-gray-300 border-collapse  pb-10">
                <table>
                    <thead>
                        <tr>
                            <th class=" z-20"  :class="classesth">
                                No.
                        </th>
                            <th class=" z-20"  :class="classesth">
                                pen
                        </th>
                            <th class=" z-20"  :class="classesth">
                                male Chicken
                        </th>
                            <th class=" z-20"  :class="classesth">
                               Female Chicken
                        </th>
                        
                            <th class=" z-20"  :class="classesth">
                                male feed
                        </th>
                            <th class=" z-20"  :class="classesth">
                               Female feed
                        </th>
                        
                            <th class=" z-20"  :class="classesth">
                                male come
                        </th>
                            <th class=" z-20"  :class="classesth">
                               Female come
                        </th>
                        
                            <th class=" z-20"  :class="classesth">
                                male out
                        </th>
                            <th class=" z-20"  :class="classesth">
                               Female out
                        </th>
                        
                            <th class=" z-20"  :class="classesth">
                               date
                        </th>
    
                            
                        </tr>
                    </thead>
                    <tbody tbody class="bg-gray-100 divide-y divide-gray-200 custom-scroll">
                        <tr v-for="(item, index) in data" :key="item.id">
                            <td :class="classestd">
                                {{ index +1 }}
                            </td>
                            <td :class="classestd">
                                {{ item.pen }}
                            </td>
                            <td :class="classestd">
                                {{ item.male }}
                            </td>
                            <td :class="classestd">
                                {{ item.female }}
                            </td>
                            <td :class="classestd">
                                {{ item.feed_male }}
                            </td>
                            <td :class="classestd">
                                {{ item.feed_female }}
                            </td>
                            <td :class="classestd">
                                {{ item.male_come }}
                            </td>
                            <td :class="classestd">
                                {{ item.female_come }}
                            </td>
                            <td :class="classestd">
                                {{ item.male_out }}
                            </td>
                            <td :class="classestd">
                                {{ item.female_out }}
                            </td>
                            <td :class="classestd">
                                {{ item.date }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                
            </div>

    </div>


   
    
</template>



<script setup>
    import {
        computed,
        ref
    } from 'vue';

    const classesth =
        ' bg-blue-300 text-center  text-xs border-gray-300 text-table font-medium text-gray-700 uppercase tracking-wider  sticky top-[0px] min-w-[120px] shadow-[inset_1px_-1px_1px_white]'
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
        afkir: {
            type: Array,
        }
    })
    const formatDate = (date) => {
            const parsedDate = new Date(date);
            return !isNaN(parsedDate) ? parsedDate.toISOString().split('T')[0] : null;
        };
    const data = computed(() =>
    props.afkir.map(item => ({
        pen: item.pen.code_pen,
        male: item.male,
        female: item.female,
        feed_male: item.feed_male,
        feed_female: item.feed_female,
        male_come:item.male_come,
        female_come: item.female_come,
        male_out: item.male_out,
        female_out: item.female_out,
        date: formatDate(item.created_at),
    }))
);

    const selectedData = ref([]);

    const selectItem = async () => {
        showdata.value = 0
        console.log(selectedId.value)
        const item = props.breeding.find(b => b.id_breeding === selectedId.value);
        

    };

    const editItem = () => {
        console.log("Edit:", selectedId.value);
    };

    const deleteItem = () => {
        console.log("Delete:", selectedId.value);
    };

    const downloadItem = () => {
        console.log("Download:", selectedId.value);
        axios.get(`/download/breeding-Quaratine`, { responseType: 'blob' })
        .then((response) => {
          // Membuat URL objek untuk file binary
          const url = window.URL.createObjectURL(new Blob([response.data]));
          // Membuat elemen <a> untuk mendownload file
          const link = document.createElement('a');
          link.href = url;
          link.setAttribute('download', `BreedingQuaratine.xlsx`); // Nama file
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
        overflow-x: auto;
        /* Nonaktifkan scroll horizontal */
    }


</style>
