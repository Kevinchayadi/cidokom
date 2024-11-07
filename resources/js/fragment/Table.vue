<template>
  <div class="table-container">
      <!-- Menu buttons -->


      <!-- Table -->
      <table class=" divide-y divide-x divide-gray-300">
          <thead class="bg-blue-300">
              <tr>
                  <!-- ID Column (sticky) -->
                  <th
                      class=" md:left-0 bg-blue-300"
                      :class="classesth"
                      style="min-width: 100px; z-index: 2">
                      ID
                  </th>
                  <!-- Name Column (sticky) -->
                  <th
                      class="  md:left-[100px] bg-blue-300"
                      :class="classesth"
                      style="min-width: 200px; z-index: 2">
                      Name
                  </th>
                  <!-- Action Column (sticky) -->
                  <th
                      class="  md:left-[300px] bg-blue-300"
                      :class="classesth"
                      style="min-width: 150px; z-index: 2">
                      Action
                  </th>
                  <!-- Additional Columns -->
                  <th class=" bg-blue-300"
                      :class="classesth">
                      Additional 1
                  </th>
                  <th class=" bg-blue-300"
                      :class="classesth">
                      Additional 2
                  </th>
                  <th class=" bg-blue-300"
                      :class="classesth">
                      Additional 3
                  </th>
                  <th class=" bg-blue-300"
                      :class="classesth">
                      Additional 4
                  </th>
                  <th class=" bg-blue-300"
                      :class="classesth">
                      Additional 1
                  </th>
                  <th class=" bg-blue-300"
                      :class="classesth">
                      Additional 2
                  </th>
                  <th class=" bg-blue-300"
                      :class="classesth">
                      Additional 3
                  </th>
                  <th class=" bg-blue-300"
                      :class="classesth">
                      Additional 4
                  </th>
                  <th class=" bg-blue-300"
                      :class="classesth">
                      Additional 1
                  </th>
                  <th class=" bg-blue-300"
                      :class="classesth">
                      Additional 2
                  </th>
                  <th class=" bg-blue-300"
                      :class="classesth">
                      Additional 3
                  </th>
                  <th class=" bg-blue-300"
                      :class="classesth">
                      Additional 4
                  </th>
              </tr>
          </thead>
          <tbody class="bg-gray-100 divide-y divide-gray-200 custom-scroll">
              <tr
  v-for="(item, index) in itemsBawah"
  :key="item.id"
  :class="{
      'bg-gray-300': selectedId === item.id,
      'hover:bg-gray-200': selectedId !== item.id,
  }"
  @click="selectRow(item.id)"
  class="cursor-pointer">
  
  <!-- ID Column (sticky) -->
  <td
      class="  md:sticky  md:left-0"
      :class="{'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id,  [classestd]: true}"
      style="min-width: 100px">
      {{ item.id }}
  </td>

  <!-- Name Column (sticky) -->
  <td
      class="  md:sticky  md:left-[100px]"
      :class="{'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id,  [classestd]: true}"
      style="min-width: 200px">
      {{ item.name }}
  </td>

  <!-- Action Column (sticky) -->
  <td
      class="  md:sticky  md:left-[300px]"
      :class="{'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id,  [classestd]: true}"
      style="min-width: 150px">
      <button class="text-indigo-600 hover:text-indigo-900">
          Details
      </button>
  </td>

  <!-- Additional Data Columns -->
  <td class="" :class="{'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id,  [classestd]: true}">Data A</td>
  <td class="" :class="{'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id,  [classestd]: true}">Data B</td>
  <td class="" :class="{'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id,  [classestd]: true}">Data C</td>
  <td class="" :class="{'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id,  [classestd]: true}">Data D</td>
</tr>

          </tbody>
      </table>
  </div>
</template>

<script setup>
import { ref } from "vue";

const selectedId = ref(null);
const classesth = ' text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 min-w-[100px]'

const classestd = 'p-1 text-xs text-gray-900 min-w-[100px]'
const buttonclasses = 'border border-grey-700 bg-gray-200 text-primary-text-dark rounded hover:text-primary-text-dark-hover sticky top-0'

const itemsBawah = ref([
  { id: 1, name: 'Item One' },
  { id: 2, name: 'Item Two' },
  { id: 3, name: 'Item Three' },
  { id: 1, name: 'Item One' },
  { id: 2, name: 'Item Two' },
  { id: 3, name: 'Item Three' },
  { id: 1, name: 'Item One' },
  { id: 2, name: 'Item Two' },
  { id: 3, name: 'Item Three' },
  { id: 1, name: 'Item One' },
  { id: 2, name: 'Item Two' },
  { id: 3, name: 'Item Three' },
  { id: 1, name: 'Item One' },
  { id: 2, name: 'Item Two' },
  { id: 3, name: 'Item Three' },
]);

const selectRow = (id) => {
  selectedId.value = id;
};

const selectItem = () => {
  console.log("Selected:", selectedId.value);
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

/* Custom Scrollbar for the table */
.custom-scroll {
  max-height: 500px;
  overflow-y: auto;
  overflow-x: auto;
}
</style>
