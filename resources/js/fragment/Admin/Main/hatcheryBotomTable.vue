<template>
    <div class="table-container">
        <!-- Menu buttons -->


        <!-- Table -->
        <table class=" divide-y divide-x divide-gray-300 border-collapse">
            <thead class="">
                <tr>
                    <!-- ID Column (sticky) -->
                    <th class=" md:left-0  z-20" rowspan="2":class="classesth">
                        No.
                    </th>
                    <!-- Name Column (sticky) -->
                    <th class="  md:left-[100px]  z-20" rowspan="2" :class="classesth">
                        Total setting
                    </th>
                    <!-- Action Column (sticky) -->
                    <th class="   "colspan="2" :class="classesth">
                        infertile
                    </th>
                    <!-- Additional Columns -->
                    <th colspan="2" :class="classesth">
                        explode
                    </th>
                    <th colspan="2" :class="classesth">
                        hatcher
                    </th>
                    <th colspan="2" :class="classesth">
                        dead in egg
                    </th>
                    <th colspan="2" :class="classesth">
                        hatchability
                    </th>
                    <th colspan="2" :class="classesth">
                        doc afkir
                    </th>
                    <th colspan="2" :class="classesth">
                        saleable
                    </th>
                    <th rowspan="2" :class="classesth">
                        input By
                    </th>
                </tr>
                <tr>
                    <th :class="classesth2">
                        total
                    </th>
                    <th :class="classesth2">
                        percentage
                    </th>
                    <th :class="classesth2">
                        total
                    </th>
                    <th :class="classesth2">
                        percentage
                    </th>
                    <th :class="classesth2">
                        total
                    </th>
                    <th :class="classesth2">
                        percentage
                    </th>
                    <th :class="classesth2">
                        total
                    </th>
                    <th :class="classesth2">
                        percentage
                    </th>
                    <th :class="classesth2">
                        total
                    </th>
                    <th :class="classesth2">
                        percentage
                    </th>
                    <th :class="classesth2">
                        total
                    </th>
                    <th :class="classesth2">
                        percentage
                    </th>
                    <th :class="classesth2">
                        total
                    </th>
                    <th :class="classesth2">
                        percentage
                    </th>

                </tr>
            </thead>
            <tbody class="bg-gray-100 divide-y divide-gray-200 custom-scroll">
                <tr v-for="(item, index) in data" :key="index"
                    :class="{
                        'bg-gray-300': selectedId === item.id,
                        'hover:bg-gray-200': selectedId !== item.id,
                    }">

                    <!-- ID Column (sticky) -->
                    <td class="  md:sticky  md:left-0"
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                        {{ index+1 }}
                    </td>

                    <!-- Name Column (sticky) -->
                    <td class="  md:sticky  md:left-[100px]"
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                        {{ item . totalSetting }}
                    </td>

                    <!-- Action Column (sticky) -->
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                            {{ item.infertileTotal }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                            {{ item.infertilePercentage }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                            {{ item.explodeTotal }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                            {{ item.explodePercentage }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                            {{ item.hatcherTotal }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                            {{ item.hatcherPercentage }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                            {{ item.deadInEggTotal }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                            {{ item.deadInEggPercentage }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                            {{ item.hatchabilityTotal }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                            {{ item.hatchabilityPercentage }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                            {{ item.docAfkirTotal }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                            {{ item.docAfkirPercentage }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                            {{ item.saleableTotal }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                            {{ item.saleablePercentage }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                            {{ item.inputBy }}
                    </td>
                    
                   
                    
                </tr>

            </tbody>
        </table>
    </div>
</template>

<script setup>
    import {
        ref,
        defineEmits,
        computed
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

    const props = defineProps({
        selectedData: {
            type: Object,
            defaults: []
        }
    })
    const detailData = ref(props.selectedData.hatchery_details??[]);
    const data = computed(() =>
    detailData.value.map(item => ({
        totalSetting: item.total_setting,
        infertileTotal: item.infertile,
        infertilePercentage: ((item.infertile / item.total_setting) * 100).toFixed(2) + '%',
        explodeTotal: item.explode,
        explodePercentage: ((item.explode / item.total_setting) * 100).toFixed(2) + '%',
        hatcherTotal: item.hatcher,
        hatcherPercentage:((item.hatcher / item.total_setting) * 100).toFixed(2) + '%',
        deadInEggTotal: item.dead_in_egg,
        deadInEggPercentage:((item.dead_in_egg / item.total_setting) * 100).toFixed(2) + '%',
        hatchabilityTotal: item.hatchability,
        hatchabilityPercentage: ((item.hatchability / item.total_setting) * 100).toFixed(2) + '%',
        docAfkirTotal: item.doc_afkir,
        docAfkirPercentage: ((item.doc_afkir / item.total_setting) * 100).toFixed(2) + '%',
        saleableTotal: item.saleable,
        saleablePercentage: ((item.saleable / item.total_setting) * 100).toFixed(2) + '%',    inputBy: item.inputBy
    })))

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
