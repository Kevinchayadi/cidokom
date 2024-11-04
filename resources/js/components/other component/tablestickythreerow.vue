<template>
    <!-- <h1 class="text-xl font-bold mb-2">Component Atas</h1> -->
    <div class="table-container">
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-blue-300">
                <tr>

                    <th class="px-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 left-0 bg-blue-300"
                        style="min-width: 100px; z-index: 2;">ID</th>
                    <th class="px-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 left-[100px] bg-blue-300"
                        style="min-width: 200px; z-index: 2;">Data</th>
                    <th class="px-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 left-[300px] bg-blue-300"
                        style="min-width: 150px; z-index: 2;">Action</th>
                    <th
                        class="px-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 bg-blue-300">
                        Additional 1</th>
                    <th
                        class="px-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 bg-blue-300">
                        Additional 2</th>
                    <th
                        class="px-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 bg-blue-300">
                        Additional 3</th>
                    <th
                        class="px-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 bg-blue-300">
                        Additional 4</th>
                </tr>
            </thead>
            <tbody class="bg-blue-400 divide-y  divide-gray-200">
                <tr v-for="(item, index) in itemsAtas" :key="index">

                    <td class=" p-1 text-xs text-white sticky left-0 bg-blue-400" style="min-width: 100px;">
                        {{ index + 1 }}</td>
                    <td class=" p-1 text-xs text-white sticky left-[100px] bg-blue-400" style="min-width: 200px;">
                        {{ item }}</td>
                    <td class=" p-1 text-xs text-white sticky left-[300px] bg-blue-400" style="min-width: 150px;">
                        <button class="text-indigo-600 hover:text-indigo-900">Details</button></td>
                    <td class=" p-1 text-xs text-white">Data A</td>
                    <td class=" p-1 text-xs text-white">Data B</td>
                    <td class=" p-1 text-xs text-white">Data C</td>
                    <td class=" p-1 text-xs text-white">Data D</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    export default {

    }
</script>
<style>

</style>
