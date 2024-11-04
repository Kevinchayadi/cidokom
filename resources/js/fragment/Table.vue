<template>
  <div>
    <!-- Menu buttons -->
    <div class="flex justify-start ">
      <button
        class=" border border-grey-700 mx-1 bg-gray-200  text-primary-text-dark px-2 rounded hover:text-primary-text-dark-hover"
        @click="selectItem"
      >
        Select
      </button>
      <button
        class=" border border-grey-700 mx-1 bg-gray-200  text-primary-text-dark px-2 rounded hover:text-primary-text-dark-hover"
        @click="editItem"
        :disabled="!selectedId"
      >
        Edit
      </button>
      <button
        class=" border border-grey-700 mx-1 bg-gray-200  text-primary-text-dark px-2 rounded hover:text-primary-text-dark-hover"
        @click="deleteItem"
        :disabled="!selectedId"
      >
        Delete
      </button>
      <button
        class=" border border-grey-700 mx-1 bg-gray-200  text-primary-text-dark px-2 rounded hover:text-primary-text-dark-hover"
        @click="downloadItem"
        :disabled="!selectedId"
      >
        Download
      </button>
    </div>

    <!-- Table -->
    <table class=" divide-y divide-gray-300">
      <thead class="bg-blue-300">
        <tr>
          <th
            scope="col"
            class=" left-0 z-20"
            :class="classTR"
          >
            ID
          </th>
          <th
            scope="col"
            class=" left-[80px] z-20"
            :class="classTR"
          >
            Name
          </th>
          <th
            scope="col"
           :class="classTR"
          >
            Action
          </th>
        </tr>
      </thead>
      <tbody class="bg-gray-100 divide-y divide-gray-200">
        <tr
          v-for="(item, index) in items"
          :key="item.id"
          :class="{
            'bg-gray-300': selectedId === item.id,
            'hover:bg-gray-200': selectedId !== item.id,
          }"
          @click="selectRow(item.id)"
          class="cursor-pointer"
        >
          <td class=" sticky left-0" :class="classTD">{{ item.id }}</td>
          <td class=" sticky left-[80px] ":class="classTD">{{ item.name }}</td>
          <td class="" :class="classTD">
            <button class="text-indigo-600 hover:text-indigo-900">Details</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const selectedId = ref(null);

const classTR = 'px-1 text-left  text-xxs text-white font-medium text-gray-700 uppercase tracking-wider sticky top-0  w-[80px]'
const classTD = 'px-1 text-xxs  text-gray-900  w-[80px]'



const items = ref([
  { id: 1, name: 'Item One' },
  { id: 2, name: 'Item Two' },
  { id: 3, name: 'Item Three' },
]);

const selectRow = (id) => {
  selectedId.value = id;
};

const selectItem = () => {
  console.log('Selected:', selectedId.value);
};

const editItem = () => {
  console.log('Edit:', selectedId.value);
};

const deleteItem = () => {
  console.log('Delete:', selectedId.value);
};

const downloadItem = () => {
  console.log('Download:', selectedId.value);
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
