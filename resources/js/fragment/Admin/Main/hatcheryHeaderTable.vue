<template>
    <div class="table-container">
        <!-- Menu buttons -->


        <!-- Table -->
        <table class=" divide-y divide-x divide-gray-300 border-collapse">
            <thead class="bg-blue-300 shadow-lg">
                <tr>
                    <!-- ID Column (sticky) -->
                    <th class=" md:left-0 bg-blue-300 z-20"  :class="classesth"style="min-width: 150px;">
                        Cost Center
                    </th>
                    <!-- Name Column (sticky) -->
                    <th class="  md:left-[150px] bg-blue-300 z-20"  :class="classesth">
                        Pen
                    </th>
                    <!-- Action Column (sticky) -->
                    <th class="   bg-blue-300"  :class="classesth" >
                        Machine Name
                    </th>
                    <!-- Additional Columns -->
                    <th class=" bg-blue-300"  :class="classesth">
                       setting date
                    </th>
                    <th class=" bg-blue-300"  :class="classesth">
                        candling date
                    </th>
                    <th class=" bg-blue-300"  :class="classesth">
                        pull chicken date
                    </th>
                    <th class=" bg-blue-300"  :class="classesth" style="min-width: 370px;">
                        remark
                    </th>
                    <th class=" bg-blue-300"  :class="classesth">
                        input by
                    </th>
                    
                    <th class=" bg-blue-300"  :class="classesth">
                        Status
                    </th>
                </tr>

            </thead>
            <tbody class="bg-gray-100 divide-y divide-gray-200 custom-scroll">
                <tr v-for="item in data" :key="item.costCenter"
                    :class="{
                        'bg-gray-300': selectedId === item.costCenter,
                        'hover:bg-gray-200': selectedId !== item.costCenter,
                    }"
                    @click="selectRow(item.costCenter)" class="cursor-pointer">

                    <!-- ID Column (sticky) -->
                    <td class="  md:sticky  md:left-0"
                        :class="{ 'bg-gray-300': selectedId === item.costCenter, 'bg-white border border-gray-100': selectedId !== item.costCenter, [classestd]: true }" style="min-width: 150px;">
                        {{ item . costCenter }}
                    </td>

                    <!-- Name Column (sticky) -->
                    <td class="  md:sticky  md:left-[150px]"
                        :class="{ 'bg-gray-300': selectedId === item.costCenter, 'bg-white border border-gray-100': selectedId !== item.costCenter, [classestd]: true }">
                        {{ item . pen }}
                    </td>

                    <!-- Action Column (sticky) -->
                    <td class=" "
                        :class="{ 'bg-gray-300': selectedId === item.costCenter, 'bg-white border border-gray-100': selectedId !== item.costCenter, [classestd]: true }"
                        >
                        {{ item . machine }}
                        
                    </td>

                    <!-- Additional Data Columns -->
                    <td class=""
                        :class="{ 'bg-gray-300': selectedId === item.costCenter, 'bg-white border border-gray-100 ': selectedId !== item.costCenter, [classestd]: true }">
                        {{ item . settingDate }}
                    </td>
                    <td class=""
                        :class="{ 'bg-gray-300': selectedId === item.costCenter, 'bg-white border border-gray-100 ': selectedId !== item.costCenter, [classestd]: true }">
                        {{ item . candlingDate }}
                    </td>
                    <td class=""
                        :class="{ 'bg-gray-300': selectedId === item.costCenter, 'bg-white border border-gray-100 ': selectedId !== item.costCenter, [classestd]: true }">
                        {{ item . pullChickenDate }}
                    </td>
                    <td class=""
                        :class="{ 'bg-gray-300': selectedId === item.costCenter, 'bg-white border border-gray-100 ': selectedId !== item.costCenter, [classestd]: true }">
                        {{ item . remark }}
                    </td>
                    <td class=""
                        :class="{ 'bg-gray-300': selectedId === item.costCenter, 'bg-white border border-gray-100 ': selectedId !== item.costCenter, [classestd]: true }">
                        {{ item . inputBy }}
                    </td>
                    <td class=""
                        :class="{ 'bg-gray-300': selectedId === item.costCenter, 'bg-white border border-gray-100 ': selectedId !== item.costCenter, [classestd]: true }">
                        {{ item . status }}
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
        ' text-center  text-xs border-gray-300 font-medium text-gray-700 uppercase tracking-wider  sticky top-0 min-w-[110px] shadow-[inset_1px_-1px_1px_white]'
    const classesth2 =
        ' text-center  text-xs font-medium border-gray-300 text-gray-700 uppercase tracking-wider  sticky top-[18px] min-w-[110px] shadow-[inset_1px_-1px_1px_white]'

    const classestd = 'p-1 text-xs  text-gray-900 text-center min-w-[100px] shadow-[inset_1px_-1px_1px_rgba(128,128,128,0.2)]'
    const buttonclasses =
        'border border-grey-700 bg-gray-200 text-primary-text-dark rounded hover:text-primary-text-dark-hover sticky top-0'
    const props = defineProps({
        hatchery:{
            type: Array
        }
    })
    const data = computed(()=>
        props.hatchery.map(item =>({
            costCenter : item.id_hatchery,
            pen: item.pen?.code_pen ?? 'ALL',
            machine: item.machine.machine_name,
            settingDate : item.setting_date,
            candlingDate : item.candling_date,
            pullChickenDate : item.pull_chicken_date,
            remark : '',
            inputBy : item.inputBy,
            status : item.status

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
