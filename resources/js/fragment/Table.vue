<template>
    <div>
      <!-- Menu buttons -->
      <div class="flex justify-start space-x-4 mb-4">
        <button
          class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
          @click="selectItem"
        >
          Select
        </button>
        <button
          class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600"
          @click="editItem"
          :disabled="!selectedId"
        >
          Edit
        </button>
        <button
          class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
          @click="deleteItem"
          :disabled="!selectedId"
        >
          Delete
        </button>
        <button
          class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
          @click="downloadItem"
          :disabled="!selectedId"
        >
          Download
        </button>
      </div>
  
      <!-- Table -->
      <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-blue-300">
          <tr>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider"
            >
              ID
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider"
            >
              Name
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider"
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
            <td class="px-6 py-4 text-sm text-gray-900">{{ item.id }}</td>
            <td class="px-6 py-4 text-sm text-gray-900">{{ item.name }}</td>
            <td class="px-6 py-4 text-sm text-gray-900">
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
  