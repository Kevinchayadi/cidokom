<template>
    <div class="table-container">
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-blue-300">
                <tr>
                    <!-- Kolom ID sticky -->
                    <th
                        class="px-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 left-0 bg-blue-300"
                        style="min-width: 100px; z-index: 2"
                    >
                        ID
                    </th>
                    <!-- Kolom Name sticky -->
                    <th
                        class="px-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 left-[100px] bg-blue-300"
                        style="min-width: 200px; z-index: 2"
                    >
                        Name
                    </th>
                    <!-- Kolom Action sticky -->
                    <th
                        class="px-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 left-[300px] bg-blue-300"
                        style="min-width: 150px; z-index: 2"
                    >
                        Action
                    </th>
                    <!-- Kolom tambahan lainnya -->
                    <th
                        class="px-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 bg-blue-300"
                    >
                        Additional 1
                    </th>
                    <th
                        class="px-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 bg-blue-300"
                    >
                        Additional 2
                    </th>
                    <th
                        class="px-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 bg-blue-300"
                    >
                        Additional 3
                    </th>
                    <th
                        class="px-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 bg-blue-300"
                    >
                        Additional 4
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-100 divide-y divide-gray-200 m-0 p-0">
                <tr v-for="(item, index) in itemsBawah" :key="item.id">
                    <!-- Kolom 1-3 sticky -->
                    <td
                        class="p-1 text-xs text-gray-900 sticky left-0 bg-gray-100"
                        style="min-width: 100px"
                    >
                        {{ item.id }}
                    </td>
                    <td
                        class="p-1 text-xs text-gray-900 sticky left-[100px] bg-gray-100"
                        style="min-width: 200px"
                    >
                        {{ item.name }}
                    </td>
                    <td
                        class="p-1 text-xs text-gray-900 sticky left-[300px] bg-gray-100"
                        style="min-width: 150px"
                    >
                        <button class="text-indigo-600 hover:text-indigo-900">
                            Details
                        </button>
                    </td>
                    <td class="p-1 text-xs text-gray-900">Data A</td>
                    <td class="p-1 text-xs text-gray-900">Data B</td>
                    <td class="p-1 text-xs text-gray-900">Data C</td>
                    <td class="p-1 text-xs text-gray-900">Data D</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script setup>
import { ref } from "vue";

const trclasses =
    "px-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 bg-blue-300";
const tdclasses = "p-1 text-xs text-gray-900";

const selectedId = ref(null);
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
