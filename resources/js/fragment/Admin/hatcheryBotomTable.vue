<template>
    <div class="table-container">
        <!-- Menu buttons -->


        <!-- Table -->
        <table class=" divide-y divide-x divide-gray-300 border-collapse">
            <thead class="">
                <tr>
                    <!-- ID Column (sticky) -->
                    <th class=" md:left-0  z-20" rowspan="3" :class="classesth">
                        No.
                    </th>
                    <!-- Name Column (sticky) -->
                    <th class="  md:left-[100px]  z-20" rowspan="3" :class="classesth">
                        Date
                    </th>
                    <!-- Action Column (sticky) -->
                    <th class="   "colspan="2" rowspan="2"  :class="classesth" >
                        Begining Population
                    </th>
                    <!-- Additional Columns -->
                    <th colspan="2" rowspan="2" :class="classesth">
                        Last population
                    </th>
                    <th  colspan="4" :class="classesth">
                        depreciation
                    </th>
                    <th  colspan="3"  rowspan="2" :class="classesth">
                        Move
                    </th>
                    <th  colspan="3" rowspan="2" :class="classesth">
                        Recieve
                    </th>
                    <th  colspan="11" rowspan="2" :class="classesth">
                        Egg Production
                    </th>
                    <th colspan="2" rowspan="2" :class="classesth">
                        Feed
                    </th>
                    <th  rowspan="3" :class="classesth">
                        input By
                    </th>
                </tr>
                <tr>
                    <!-- ID Column (sticky) -->
                    <th  colspan="2" :class="classesth2">
                        Female
                    </th>
                    <th  colspan="2" :class="classesth2">
                        Male
                    </th>
                </tr>
                <tr>
                    <th   :class="classesth3">
                        Female
                    </th>
                    <th   :class="classesth3">
                        Male
                    </th><th   :class="classesth3">
                        Female
                    </th>
                    <th   :class="classesth3">
                        Male
                    </th>
                    <!-- ID Column (sticky) -->
                    <th  :class="classesth3">
                        Die
                    </th>
                    <th  :class="classesth3">
                        Reject
                    </th>
                    <th  :class="classesth3">
                        Die
                    </th>
                    <th  :class="classesth3">
                        Reject
                    </th>
                    <th  :class="classesth3">
                        destination
                    </th>
                    <th  :class="classesth3">
                        female
                    </th>
                    <th  :class="classesth3">
                        male
                    </th>
                    <th  :class="classesth3">
                        destination
                    </th>
                    <th  :class="classesth3">
                        female
                    </th>
                    <th  :class="classesth3">
                        male
                    </th>
                    <th  :class="classesth3">
                        morning
                    </th>
                    <th  :class="classesth3">
                        afternoon
                    </th>
                    <th  :class="classesth3">
                        total
                    </th>
                    <th  :class="classesth3">
                        percantage
                    </th>
                    <th  :class="classesth3">
                        cracked
                    </th>
                    <th  :class="classesth3">
                        percantage
                    </th>
                    <th  :class="classesth3">
                        abnormal
                    </th>
                    <th  :class="classesth3">
                        percantage
                    </th>
                    <th  :class="classesth3">
                        sale
                    </th>
                    <th  :class="classesth3">
                        HE
                    </th>
                    <th  :class="classesth3">
                        percantage
                    </th>
                    <th  :class="classesth3">
                        feed(kg)
                    </th><th  :class="classesth3">
                        percantage
                    </th>

                </tr>
            </thead>
            <tbody class="bg-gray-100 divide-y divide-gray-200 custom-scroll">
                <tr v-for="(item, index) in itemsBawah" :key="item.id"
                    :class="{
                        'bg-gray-300': selectedId === item.id,
                        'hover:bg-gray-200': selectedId !== item.id,
                    }"
                    >

                    <!-- ID Column (sticky) -->
                    <td class="  md:sticky  md:left-0"
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item.id, [classestd]: true }">
                        {{ item . id }}
                    </td>

                    <!-- Name Column (sticky) -->
                    <td class="  md:sticky  md:left-[100px]"
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item.id, [classestd]: true }">
                        {{ item . name }}
                    </td>

                    <!-- Action Column (sticky) -->
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item.id, [classestd]: true }"
                        >
                        <button class="text-indigo-600 hover:text-indigo-900">
                            Details
                        </button>
                    </td>

                    <!-- Additional Data Columns -->
                    <td class=""
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100 ': selectedId !== item.id, [classestd]: true }">
                        Data A</td>
                    <td class=""
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item.id, [classestd]: true }">
                        Data B</td>
                    <td class=""
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item.id, [classestd]: true }">
                        Data C</td>
                    <td class=""
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item.id, [classestd]: true }">
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
        ' bg-blue-300 text-center  text-xs border-gray-300 font-medium text-gray-700 uppercase tracking-wider  sticky top-[18px] min-w-[100px] shadow-[inset_1px_-1px_1px_white]'
    const classesth2 =
        ' bg-blue-300 text-center  text-xs font-medium border-gray-300 text-gray-700 uppercase tracking-wider  sticky top-[36px] min-w-[100px] shadow-[inset_1px_-1px_1px_white]'
    const classesth3 =
        ' bg-blue-300 text-center  text-xs font-medium border-gray-300 text-gray-700 uppercase tracking-wider  sticky top-[54px] min-w-[100px] shadow-[inset_1px_-1px_1px_white]'

    const classestd = 'p-1 text-xs  text-gray-900 text-center min-w-[100px]'
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

</script>

<style scoped>

</style>
