<template>
    <div class="table-container">
        <!-- Menu buttons -->


        <!-- Table -->
        <table class=" divide-y divide-x divide-gray-300 border-collapse">
            <thead class="">
                <tr>
                    <!-- ID Column (sticky) -->
                    <th class=" md:left-0  z-20" rowspan="2" :class="classesth">
                        No.
                    </th>
                    <!-- Name Column (sticky) -->
                    <th class="  md:left-[100px]  z-20" rowspan="2" :class="classesth">
                        Date
                    </th>
                    <!-- Action Column (sticky) -->
                    <th class="   " rowspan="2" :class="classesth">
                        Begining Population
                    </th>
                    <!-- Additional Columns -->
                    <th rowspan="2" :class="classesth">
                        Last population
                    </th>
                    <th colspan="3" :class="classesth">
                        depreciation
                    </th>
                    <th colspan="2" :class="classesth">
                        Move
                    </th>
                    <th colspan="2" :class="classesth">
                        Receive
                    </th>
                    <th colspan="3" :class="classesth">
                        Feed
                    </th>
                    <th rowspan="2" :class="classesth">
                        Input by
                    </th>
                    <th rowspan="2" :class="classesth">
                        vaksin
                    </th>
                </tr>
                <tr>
                    <!-- ID Column (sticky) -->
                    <th :class="classesth2">
                        die
                    </th>
                    <th :class="classesth2">
                        afkir
                    </th>
                    <th :class="classesth2">
                        panen
                    </th>
                    <th :class="classesth2">
                        move to
                    </th>
                    <th :class="classesth2">
                        total move
                    </th>
                    <th :class="classesth2">
                        receive from
                    </th>
                    <th :class="classesth2">
                        total receive
                    </th>
                    <th :class="classesth2">
                        total feed
                    </th>
                    <th :class="classesth2">
                        percantage
                    </th>
                    <th :class="classesth2">
                        feed name
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
                        {{ item.date  }}
                    </td>

                    <!-- Action Column (sticky) -->
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                        
                            {{ selectedData.entry_population }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                        
                            {{ selectedData.last_population }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                        
                            {{ item.die }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                        
                            {{ item.afkir }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                        
                            {{ item.panen }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                        
                            {{ item.moveTo }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                        
                            {{ item.totalMove }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                        
                            {{ item.receiveFrom }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                        
                            {{ item.totalReceive }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                        
                            {{ item.totalFeed }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                        
                            {{ item.percentage }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                        
                            {{ item.feedName }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                        
                            {{ item.inputBy }}
                    </td>
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white border border-gray-100': selectedId !== item
                                .id, [classestd]: true }">
                        
                            {{ item.vaksin }}
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
        computed,
        onMounted
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

    const detailData = ref(props.selectedData.commercial_details ?? [])

    onMounted(() => {
        console.log(detailData.value);
    })

    const data = computed(() =>
        detailData.value.map(item => ({
            date: new Date(item.created_at).toISOString().split('T')[0],
            beginningPopulation: item.beginningPopulation,
            lastPopulation: item.lastPopulation,
            die: item.depreciation_die,
            afkir: item.depreciation_afkir,
            panen: item.depreciation_panen,
            moveTo: item.move_to,
            totalMove: item.total_move,
            receiveFrom: item.receive_from,
            totalReceive: item.total_receive,
            totalFeed: item.feed,
            percentage: (((item.feed * 1000) / item.last_population)).toFixed(2) + ' gr',
            feedName: item.feed_name,
            inputBy: item.inputBy,
            vaksin:''
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
