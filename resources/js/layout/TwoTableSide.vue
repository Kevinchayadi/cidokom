<template>
  <div class="flex flex-col h-screen">
      <!-- Component Atas -->
      <div class="flex-1 bg-blue-500 text-white  overflow-x-auto overflow-y-auto">
          <h1 class="text-xl font-bold mb-2">Component Atas</h1>
          <div class="table-container">
              <table class="min-w-full divide-y divide-gray-300">
                  <thead class="bg-blue-300">
                      <tr>
                          <!-- Kolom 1-3 di bagian atas (sticky baris pertama dan kolom 1-3) -->
                          <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 left-0 bg-blue-300"
                              style="min-width: 100px; z-index: 2;">ID</th>
                          <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 left-[100px] bg-blue-300"
                              style="min-width: 200px; z-index: 2;">Data</th>
                          <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 left-[300px] bg-blue-300"
                              style="min-width: 150px; z-index: 2;">Action</th>
                          <th
                              class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 bg-blue-300">
                              Additional 1</th>
                          <th
                              class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 bg-blue-300">
                              Additional 2</th>
                          <th
                              class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 bg-blue-300">
                              Additional 3</th>
                          <th
                              class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 bg-blue-300">
                              Additional 4</th>
                      </tr>
                  </thead>
                  <tbody class="bg-blue-400 divide-y  divide-gray-200">
                      <tr v-for="(item, index) in itemsAtas" :key="index">
                          <!-- Kolom 1-3 sticky -->
                          <td class="px-6 py-4 text-sm text-white sticky left-0 bg-blue-400"
                              style="min-width: 100px;">{{ index + 1 }}</td>
                          <td class="px-6 py-4 text-sm text-white sticky left-[100px] bg-blue-400"
                              style="min-width: 200px;">{{ item }}</td>
                          <td class="px-6 py-4 text-sm text-white sticky left-[300px] bg-blue-400"
                              style="min-width: 150px;"><button
                                  class="text-indigo-600 hover:text-indigo-900">Details</button></td>
                          <td class="px-6 py-4 text-sm text-white">Data A</td>
                          <td class="px-6 py-4 text-sm text-white">Data B</td>
                          <td class="px-6 py-4 text-sm text-white">Data C</td>
                          <td class="px-6 py-4 text-sm text-white">Data D</td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </div>

      <!-- Component Bawah -->
      <div class="flex-1 bg-gray-100 m-2 overflow-x-auto overflow-y-auto">
          <h1 class="text-xl font-bold mb-2">Component Bawah</h1>
          <div class="table-container">
              <table class="min-w-full divide-y divide-gray-300">
                  <thead class="bg-blue-300">
                      <tr>
                          <!-- Kolom ID sticky -->
                          <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 left-0 bg-blue-300"
                              style="min-width: 100px; z-index: 2;">ID</th>
                          <!-- Kolom Name sticky -->
                          <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 left-[100px] bg-blue-300"
                              style="min-width: 200px; z-index: 2;">Name</th>
                          <!-- Kolom Action sticky -->
                          <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 left-[300px] bg-blue-300"
                              style="min-width: 150px; z-index: 2;">Action</th>
                          <!-- Kolom tambahan lainnya -->
                          <th
                              class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 bg-blue-300">
                              Additional 1</th>
                          <th
                              class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 bg-blue-300">
                              Additional 2</th>
                          <th
                              class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 bg-blue-300">
                              Additional 3</th>
                          <th
                              class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 bg-blue-300">
                              Additional 4</th>
                      </tr>
                  </thead>
                  <tbody class="bg-gray-100 divide-y divide-gray-200">
                      <tr v-for="(item, index) in itemsBawah" :key="item.id">
                          <!-- Kolom 1-3 sticky -->
                          <td class="px-6 py-4 text-sm text-gray-900 sticky left-0 bg-gray-100"
                              style="min-width: 100px;">{{ item . id }}</td>
                          <td class="px-6 py-4 text-sm text-gray-900 sticky left-[100px] bg-gray-100"
                              style="min-width: 200px;">{{ item . name }}</td>
                          <td class="px-6 py-4 text-sm text-gray-900 sticky left-[300px] bg-gray-100"
                              style="min-width: 150px;"><button
                                  class="text-indigo-600 hover:text-indigo-900">Details</button></td>
                          <td class="px-6 py-4 text-sm text-gray-900">Data A</td>
                          <td class="px-6 py-4 text-sm text-gray-900">Data B</td>
                          <td class="px-6 py-4 text-sm text-gray-900">Data C</td>
                          <td class="px-6 py-4 text-sm text-gray-900">Data D</td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</template>



<script setup>
  import {
      ref
  } from 'vue';

  const selectedId = ref(null);
  const itemsAtas = ref([
      'Data 1',
      'Data 2',
      'Data 3',
      'Data 4',
      'Data 5',
      'Data 6', // Lebih dari 5 data, jadi akan menyebabkan scroll
  ]);

  const itemsBawah = ref([{
          id: 1,
          name: 'Item One'
      },
      {
          id: 2,
          name: 'Item Two'
      },
      {
          id: 3,
          name: 'Item Three'
      },
      {
          id: 4,
          name: 'Item Four'
      },
      {
          id: 5,
          name: 'Item Five'
      },
      {
          id: 6,
          name: 'Item Six'
      },
      {
          id: 7,
          name: 'Item Seven'
      },
      {
          id: 8,
          name: 'Item Eight'
      },
      {
          id: 9,
          name: 'Item Nine'
      },
      {
          id: 10,
          name: 'Item Ten'
      },
  ]);

  const selectRow = (id) => {
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
