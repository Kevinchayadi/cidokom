<template>
    <div class="flex justify-between sticky px-2 py-1 top-0 left-0 bg-primary">
        <div>
            <button :class="buttonclasses" @click="createItem">Create</button>
            <button
                :class="[
                    buttonclasses,
                    { 'text-primary-text-light-hover': !selectedId },
                ]"
                @click="addItem"
                :disabled="!selectedId"
            >
                Edit
            </button>
            <button :class="buttonclasses" @click="downloadItem">
                Download
            </button>
        </div>
        <div class="flex gap-1 justify-center">
            <Search v-model="search" place="Chicken Type"/>
        </div>
    </div>
    <div
        class="row-span-10 bg-gray-100 h-[95vh] overflow-x-auto overflow-y-auto p-0 m-0"
    >
        <div class="divide-y divide-x divide-gray-300 border-collapse">
            <table>
                <thead>
                    <tr>
                        <th class="z-20" rowspan="3" :class="classesth">No.</th>
                        <th class="z-20" rowspan="3" :class="classesth">
                            Chicken Type
                        </th>
                        <th class="z-20" rowspan="3" :class="classesth">
                            Price
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Add class bg-gray-300 only when item.id matches selectedId -->
                    <tr
                        v-for="(item, index) in chickenList"
                        :key="item.id"
                        @click="selectItem(item.id)"
                        :class="[
                            classestd,
                            { 'bg-gray-300': item.id === selectedId },
                        ]"
                    >
                        <td :class="classestd">
                            {{ index + 1 }}
                        </td>
                        <td :class="classestd">
                            {{ item.ChickenType }}
                        </td>
                        <td :class="classestd">
                            {{ formatRupiah(item.price) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <ModalComp
        :isVisible="isModalOpen"
        @update:isVisible="isModalOpen = $event"
    >
        <CreateChickenSize />
    </ModalComp>

    <ModalComp
        :isVisible="isModalOpen2"
        @update:isVisible="isModalOpen2 = $event"
    >
        <!-- Pass the selected item data to EditChickenSize -->
        <EditChickenSize :item="selectedItem" />
    </ModalComp>
</template>

<script setup>
import { computed, ref, watch } from "vue";
import ModalComp from "../../../components/displayComponent/ModalComp.vue";
import CreateChickenSize from "../../addFragment/sales/createChickenSize.vue";
import EditChickenSize from "../../addFragment/sales/editChickenSize.vue";
import formatRupiah from "../../../composables/currency";
import Search from "../../../components/inputComponent/search.vue";

const classesth =
    "bg-blue-300 text-center text-xs border-gray-300 text-table font-medium text-gray-700 uppercase tracking-wider sticky top-[0px] min-w-[120px] shadow-[inset_1px_-1px_1px_white]";
const classestd =
    "p-1 text-xs text-gray-900 text-table text-center min-w-[75px] shadow-[inset_1px_-1px_1px_rgba(128,128,128,0.2)]";
const buttonclasses =
    "text-primary-text-light rounded hover:text-primary-text-light-hover sticky top-0 px-2";

const selectedId = ref(null); // Selected ID tracking
const selectedItem = ref(null); // Store the selected item
const isModalOpen = ref(false);
const isModalOpen2 = ref(false);

const props = defineProps({
    chicken: {
        type: Array,
    },
});

// Computed property to process the data from props
const originalchickenList = computed(() =>
    props.chicken.map((item) => ({
        ChickenType: item.size,
        price: item.harga,
        id: item.id, // Ensure each item has an id field for comparison
    }))
);

const chickenList = ref([...originalchickenList.value]);

const search = ref("");
watch(search, (newVal) => {
    const keyword = newVal.toLowerCase();
    console.log(keyword);

    if (!keyword) {
        chickenList.value = [...originalchickenList.value];
    } else {
        chickenList.value = originalchickenList.value.filter((item) =>
            item.ChickenType.toLowerCase().includes(keyword)
        );
    }
});

// Function to handle item selection
const selectItem = (id) => {
    selectedId.value = id;
    selectedItem.value = props.chicken.find((item) => item.id === id); // Fetch the selected item by ID
    console.log("Selected ID:", selectedId.value);
    console.log("Selected test:", selectedItem.value);
};

// Handle Create Item modal
const createItem = () => {
    isModalOpen.value = true;
};

// Handle Edit Item modal
const addItem = () => {
    if (selectedId.value) {
        isModalOpen2.value = true; // Only open the modal if an item is selected
    } else {
        alert("Please select an item to edit.");
    }
};

const downloadItem = () => {
    console.log("Download:", selectedId.value);
    axios
        .get(`/download/vaksin`, {
            responseType: "blob",
        })
        .then((response) => {
            // Creating object URL for binary file
            const url = window.URL.createObjectURL(new Blob([response.data]));
            // Create <a> element to trigger file download
            const link = document.createElement("a");
            link.href = url;
            link.setAttribute("download", `vaksin.xlsx`); // File name
            document.body.appendChild(link);
            link.click(); // Trigger the download
            document.body.removeChild(link); // Remove link after clicking
        })
        .catch((error) => {
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

/* Style for custom scrollbar */
::-webkit-scrollbar {
    width: 12px;
    height: 12px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background-color: #888;
    border-radius: 10px;
    border: 3px solid transparent;
}

::-webkit-scrollbar-thumb:hover {
    background-color: #555;
}

.custom-scroll {
    max-height: 500px;
    overflow-y: auto;
    overflow-x: hidden;
}
</style>
