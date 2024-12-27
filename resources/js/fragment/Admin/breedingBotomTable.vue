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
                    <th class="md:left-[75px] z-20" rowspan="3" :class="classesth">
                        Date
                    </th>
                    <!-- Action Column (sticky) -->
                    <th class="md:left-[150px] z-20"colspan="2" rowspan="2"  :class="classesth" >
                        Begining Population
                    </th>
                    <!-- Additional Columns -->
                    <th class="md:left-[300px] z-20" colspan="2" rowspan="2" :class="classesth">
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
                    <th  colspan="12" rowspan="2" :class="classesth">
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
                    <th class="md:left-[150px] z-20"  :class="classesth3">
                        Female
                    </th>
                    <th class="md:left-[225px] z-20"  :class="classesth3">
                        Male
                    </th>
                    <th class="md:left-[300px] z-20"  :class="classesth3">
                        Female
                    </th>
                    <th class="md:left-[375px] z-20"  :class="classesth3">
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
                        percentage
                    </th>
                    <th  :class="classesth3">
                        cracked
                    </th>
                    <th  :class="classesth3">
                        percentage
                    </th>
                    <th  :class="classesth3">
                        abnormal
                    </th>
                    <th  :class="classesth3">
                        percentage
                    </th>
                    <th  :class="classesth3">
                        sale
                    </th>
                    <th  :class="classesth3">
                        percentage
                    </th>
                    <th  :class="classesth3">
                        HE
                    </th>
                    <th  :class="classesth3">
                        percentage
                    </th>
                    <th  :class="classesth3">
                        feed(kg)
                    </th><th  :class="classesth3">
                        percentage
                    </th>

                </tr>
            </thead>
            <tbody class="bg-gray-100 divide-y divide-gray-200 custom-scroll">
                <tr v-for="(item, index) in data" :key="index"
    :class="{
        'bg-gray-300': selectedId === item.id,
        'hover:bg-gray-200': selectedId !== item.id,
    }"
>
    <!-- Iteration Column (Index) -->
    <td class="md:sticky md:left-0"
        :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ index + 1 }}
    </td>

    <!-- Data Columns -->
    <td
    class="md:sticky md:left-[75px]"
     :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.date }}
    </td>
    <td 
     class="md:sticky md:left-[150px]"
    :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ selectedData.jumlah_betina }}
    </td>
    <td 
     class="md:sticky md:left-[225px]"
    :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ selectedData.jumlah_jantan }}
    </td>
    <td 
     class="md:sticky md:left-[300px]"
    :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.last_female }}
    </td>
    <td 
     class="md:sticky md:left-[375px]"
    :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.last_male }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.female_die }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.female_reject }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.male_die }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.male_reject }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.move_destination }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.move_female }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.move_male }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.receive_destination }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.receive_female }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.receive_male }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.egg_morning }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.egg_afternoon }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.total }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.egg_percentage }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.cracked }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.cracked_percentage }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.abnormal }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.abnormal_percentage }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.sale }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.sale_percentage }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.he }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.he_percentage }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.feed }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
        {{ item.feed_percentage }}
    </td>
    <td :class="{ 'bg-gray-300': selectedId === item.id, 'bg-white': selectedId !== item.id, [classestd]: true }">
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
        computed,
        watch,
        onMounted
    } from "vue";

    const selectedId = ref(null);
    const classesth =
        ' bg-blue-300 text-center  text-xs border-gray-300 text-table font-medium text-gray-700 uppercase tracking-wider  sticky top-[18px] min-w-[75px] shadow-[inset_1px_-1px_1px_white]'
    const classesth2 =
        ' bg-blue-300 text-center  text-xs font-medium text-table border-gray-300 text-gray-700 uppercase tracking-wider  sticky top-[36px] min-w-[75px] shadow-[inset_1px_-1px_1px_white]'
    const classesth3 =
        ' bg-blue-300 text-center  text-xs font-medium text-table border-gray-300 text-gray-700 uppercase tracking-wider  sticky top-[54px] min-w-[75px] shadow-[inset_1px_-1px_1px_white]'

    const classestd = 'p-1 text-xs  text-gray-900 text-table text-center min-w-[75px] shadow-[inset_1px_-1px_1px_rgba(128,128,128,0.2)]'
    const buttonclasses =
        'border border-grey-700 bg-gray-200 text-primary-text-dark rounded hover:text-primary-text-dark-hover sticky top-0'

    const props = defineProps({
        selectedData:{
            type: Object,
            defaults: []
        }
    })

    const detailData = ref(props.selectedData.breeding_details??[])

    onMounted(()=>{
        console.log(detailData.value);
    })

    const data = computed(() =>
    detailData.value.map(item => ({
        date: new Date(item.created_at).toISOString().split('T')[0],
        last_female: item.last_female,
        last_male: item.last_male,
        female_die: item.female_die,
        female_reject: item.female_reject,
        male_die: item.male_die,
        male_reject: item.male_reject,
        destination: item.destination,
        move_destination: item.move_to,
        move_female: item.total_female_move,
        move_male: item.total_male_move,
        receive_destination: item.receive_from,
        receive_female: item.total_female_receive,
        receive_male: item.total_male_receive,
        egg_morning: item.egg_morning,
        egg_afternoon: item.egg_afternoon,
        total: item.egg_afternoon + item.egg_morning,
        egg_percentage: ((item.egg_afternoon + item.egg_morning) / item.last_female * 100).toFixed(2) + '%',
        cracked: item.broken,
        cracked_percentage: parseFloat(((item.broken /(item.egg_afternoon + item.egg_morning)) * 100).toFixed(2)) + '%',
        abnormal: item.abnormal,
        abnormal_percentage: ((item.abnormal / (item.egg_afternoon + item.egg_morning)) * 100).toFixed(2) + '%',
        sale: item.sale,
        sale_percentage: ((item.sale / (item.egg_afternoon + item.egg_morning)) * 100).toFixed(2) + '%',
        he: item.total_egg,
        he_percentage: ((item.total_egg / (item.egg_afternoon + item.egg_morning)) * 100).toFixed(2) + '%',
        feed: item.feed + ' kg',
        feed_percentage: (((item.feed) / (item.last_female + item.last_male)) ).toFixed(2) + ' %',
        inputBy: item.inputBy
    }))
);

    

</script>

<style scoped>

</style>
