<template>
    <div class="table-container">
        <!-- Menu buttons -->


        <!-- Table -->
        <table class=" divide-y divide-x divide-gray-300">
            <thead class="bg-blue-300">
                <tr>
                    <!-- ID Column (sticky) -->
                    <th class=" md:left-0 bg-blue-300 z-20" rowspan="2" :class="classesth">
                        Cost Center
                    </th>
                    <!-- Name Column (sticky) -->
                    <th class="  md:left-[100px] bg-blue-300 z-20" rowspan="2" :class="classesth">
                        Pen
                    </th>
                    <!-- Action Column (sticky) -->
                    <th class="   bg-blue-300" rowspan="2" :class="classesth" style="min-width: 100px;">
                        Entry Date
                    </th>
                    <!-- Additional Columns -->
                    <th class=" bg-blue-300" rowspan="2" :class="classesth">
                        Last Update
                    </th>
                    <th class=" bg-blue-300" colspan="2" :class="classesth">
                        Strain
                    </th>
                    <th class=" bg-blue-300" colspan="2" :class="classesth">
                        Entry Population
                    </th>
                    <th class=" bg-blue-300" colspan="2" :class="classesth">
                        Last Population
                    </th>
                    <th class=" bg-blue-300" colspan="2" :class="classesth">
                        Age
                    </th>
                    <th class=" bg-blue-300" rowspan="2" :class="classesth">
                        Laying
                    </th>
                    <th class=" bg-blue-300" rowspan="2" :class="classesth">
                        Status
                    </th>
                </tr>
                <tr>
                    <!-- ID Column (sticky) -->
                    <th class=" bg-blue-300" :class="classesth2">
                        Female
                    </th>
                    <th class=" bg-blue-300" :class="classesth2">
                        Male
                    </th>
                    <th class=" bg-blue-300" :class="classesth2">
                        Female
                    </th>
                    <th class=" bg-blue-300" :class="classesth2">
                        Male
                    </th>
                    <th class=" bg-blue-300" :class="classesth2">
                        Female
                    </th>
                    <th class=" bg-blue-300" :class="classesth2">
                        Male
                    </th>
                    <th class=" bg-blue-300" :class="classesth2">
                        Days
                    </th>
                    <th class=" bg-blue-300" :class="classesth2">
                        Week
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-100 divide-y divide-gray-200 custom-scroll">
                <tr v-for="(item, index) in itemsBawah" :key="item.id"
                    :class="{
                        'bg-gray-300': selectedId === item.id,
                        'hover:bg-gray-200': selectedId !== item.id,
                    }"
                    @click="selectRow(item.id)" class="cursor-pointer">

                    <!-- ID Column (sticky) -->
                    <td class="  md:sticky  md:left-0"
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
                        {{ item . id }}
                    </td>

                    <!-- Name Column (sticky) -->
                    <td class="  md:sticky  md:left-[100px]"
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
                        {{ item . name }}
                    </td>

                    <!-- Action Column (sticky) -->
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }"
                        style="min-width: 150px">
                        <button class="text-indigo-600 hover:text-indigo-900">
                            Details
                        </button>
                    </td>

                    <!-- Additional Data Columns -->
                    <td class=""
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
                        Data A</td>
                    <td class=""
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
                        Data B</td>
                    <td class=""
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
                        Data C</td>
                    <td class=""
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
                        Data D</td>
                </tr>

            </tbody>
        </table>
    </div>
</template>

<script setup>
    import {
        ref,
        defineEmits
    } from "vue";

    const selectedId = ref(null);
    const classesth =
        ' text-center  text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-0 min-w-[100px] '
    const classesth2 =
        ' text-center  text-xs font-medium text-gray-700 uppercase tracking-wider sticky top-[18px] min-w-[100px] '

    const classestd = 'p-1 text-xs  border-primary-black text-gray-900 text-center min-w-[100px]'
    const buttonclasses =
        'border border-grey-700 bg-gray-200 text-primary-text-dark rounded hover:text-primary-text-dark-hover sticky top-0'

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
    ]);
    const emit = defineEmits(['update:selectedId']);

    const selectRow = (id) => {
        selectedId.value = id;
        emit('update:selectedId', id);
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
