<template>
    <div class="table-container">
        <!-- Menu buttons -->

        <!-- Table -->
        <table class="divide-y divide-x divide-gray-300 border-collapse">
            <thead class="bg-blue-300 shadow-lg">
                <tr>
                    <!-- ID Column (sticky) -->
                    <th class="md:left-0 bg-blue-300 z-20" rowspan="2" :class="classesth" style="min-width: 150px">
                        Cost Center
                    </th>
                    <!-- Name Column (sticky) -->
                    <th class="md:left-[150px] bg-blue-300 z-20" rowspan="2" :class="classesth">
                        Pen
                    </th>
                    <!-- Action Column (sticky) -->
                    <th class="bg-blue-300" rowspan="2" :class="classesth" style="min-width: 100px">
                        Entry Date
                    </th>
                    <!-- Additional Columns -->
                    <th class="bg-blue-300" rowspan="2" :class="classesth">
                        Last Update
                    </th>
                    <th class="bg-blue-300" colspan="2" :class="classesth">
                        Strain
                    </th>
                    <th class="bg-blue-300" colspan="2" :class="classesth">
                        Entry Population
                    </th>
                    <th class="bg-blue-300" colspan="2" :class="classesth">
                        Last Population
                    </th>
                    <th class="bg-blue-300" colspan="2" :class="classesth">
                        Age
                    </th>
                    <th class="bg-blue-300" rowspan="2" :class="classesth">
                        FCR
                    </th>
                    <th class="bg-blue-300" rowspan="2" :class="classesth" style="min-width: 200px">
                        Laying
                    </th>
                    <th class="bg-blue-300" rowspan="2" :class="classesth">
                        Status
                    </th>
                </tr>
                <tr>
                    <!-- ID Column (sticky) -->
                    <th class="bg-blue-300" :class="classesth2">Female</th>
                    <th class="bg-blue-300" :class="classesth2">Male</th>
                    <th class="bg-blue-300" :class="classesth2">Female</th>
                    <th class="bg-blue-300" :class="classesth2">Male</th>
                    <th class="bg-blue-300" :class="classesth2">Female</th>
                    <th class="bg-blue-300" :class="classesth2">Male</th>
                    <th class="bg-blue-300" :class="classesth2">Days</th>
                    <th class="bg-blue-300" :class="classesth2">Week</th>
                </tr>
            </thead>
            <tbody class="bg-gray-100 divide-y divide-gray-200 custom-scroll">
                <tr v-for="item in data" :key="item.costCenter"
                    :class="[
                        classestd,
                        selectedId === item.costCenter ?
                        'bg-gray-300' :
                        item.status === 'inactive' ?
                        'text-red-950 bg-slate-100' :
                        'bg-white',
                    ]"
                    @click="selectRow(item.costCenter)" class="cursor-pointer">
                    <!-- ID Column (sticky) -->
                    <td class="md:sticky md:left-0"
                        :class="[
                            classestd,
                            selectedId === item.costCenter ?
                            'bg-gray-300' :
                            item.status === 'inactive' ?
                            'text-red-950 bg-slate-100' :
                            'bg-white',
                        ]"
                        style="min-width: 150px">
                        {{ item . costCenter }}
                    </td>

                    <!-- Name Column (sticky) -->
                    <td class="md:sticky md:left-[150px]"
                        :class="[
                            classestd,
                            selectedId === item.costCenter ?
                            'bg-gray-300' :
                            item.status === 'inactive' ?
                            'text-red-950 bg-slate-100' :
                            'bg-white',
                        ]">
                        {{ item . pen }}
                    </td>
                    <td class=" "
                        :class="[
                            classestd,
                            selectedId === item.costCenter ?
                            'bg-gray-300' :
                            item.status === 'inactive' ?
                            'text-red-950 bg-slate-100' :
                            'bg-white',
                        ]">
                        {{ item . entryDate }}
                    </td>
                    <td class=""
                        :class="[
                            classestd,
                            selectedId === item.costCenter ?
                            'bg-gray-300' :
                            item.status === 'inactive' ?
                            'text-red-950 bg-slate-100' :
                            'bg-white',
                        ]">
                        {{ item . lastupdate }}
                    </td>
                    <td class=" "
                        :class="[
                            classestd,
                            selectedId === item.costCenter ?
                            'bg-gray-300' :
                            item.status === 'inactive' ?
                            'text-red-950 bg-slate-100' :
                            'bg-white',
                        ]">
                        {{ item . female_strain }}
                    </td>
                    <td class=""
                        :class="[
                            classestd,
                            selectedId === item.costCenter ?
                            'bg-gray-300' :
                            item.status === 'inactive' ?
                            'text-red-950 bg-slate-100' :
                            'bg-white',
                        ]">
                        {{ item . male_strain }}
                    </td>
                    <td class=" "
                        :class="[
                            classestd,
                            selectedId === item.costCenter ?
                            'bg-gray-300' :
                            item.status === 'inactive' ?
                            'text-red-950 bg-slate-100' :
                            'bg-white',
                        ]">
                        {{ item . female_population }}
                    </td>
                    <td class=""
                        :class="[
                            classestd,
                            selectedId === item.costCenter ?
                            'bg-gray-300' :
                            item.status === 'inactive' ?
                            'text-red-950 bg-slate-100' :
                            'bg-white',
                        ]">
                        {{ item . male_population }}
                    </td>
                    <td class=" "
                        :class="[
                            classestd,
                            selectedId === item.costCenter ?
                            'bg-gray-300' :
                            item.status === 'inactive' ?
                            'text-red-950 bg-slate-100' :
                            'bg-white',
                        ]">
                        {{ item . last_female }}
                    </td>
                    <td class=""
                        :class="[
                            classestd,
                            selectedId === item.costCenter ?
                            'bg-gray-300' :
                            item.status === 'inactive' ?
                            'text-red-950 bg-slate-100' :
                            'bg-white',
                        ]">
                        {{ item . last_male }}
                    </td>
                    <td class=" "
                        :class="[
                            classestd,
                            selectedId === item.costCenter ?
                            'bg-gray-300' :
                            item.status === 'inactive' ?
                            'text-red-950 bg-slate-100' :
                            'bg-white',
                        ]">
                        {{ item . age }}
                    </td>
                    <td class=""
                        :class="[
                            classestd,
                            selectedId === item.costCenter ?
                            'bg-gray-300' :
                            item.status === 'inactive' ?
                            'text-red-950 bg-slate-100' :
                            'bg-white',
                        ]">
                        {{ item . week }}
                    </td>
                    <td class=""
                        :class="[
                            classestd,
                            selectedId === item.costCenter ?
                            'bg-gray-300' :
                            item.status === 'inactive' ?
                            'text-red-950 bg-slate-100' :
                            'bg-white',
                        ]">
                        {{ item . FCR }}
                    </td>
                    <td class=" "
                        :class="[
                            classestd,
                            selectedId === item.costCenter ?
                            'bg-gray-300' :
                            item.status === 'inactive' ?
                            'text-red-950 bg-slate-100' :
                            'bg-white',
                        ]">
                        {{ item . laying }}
                    </td>
                    <td class=""
                        :class="[
                            classestd,
                            selectedId === item.costCenter ?
                            'bg-gray-300' :
                            item.status === 'inactive' ?
                            'text-red-950 bg-slate-100' :
                            'bg-white',
                        ]">
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
        onMounted,
        computed
    } from "vue";

    const selectedId = ref(null);
    const classesth =
        " text-center  text-xs border-gray-300 font-medium text-gray-700 uppercase tracking-wider  sticky top-0 min-w-[80px] shadow-[inset_1px_-1px_1px_white]";
    const classesth2 =
        " text-center  text-xs font-medium border-gray-300 text-gray-700 uppercase tracking-wider  sticky top-[18px] min-w-[80px] shadow-[inset_1px_-1px_1px_white]";

    const classestd =
        "p-1 text-xs border-grey-200 text-gray-900 text-table text-center min-w-[80px] shadow-[inset_1px_-1px_1px_rgba(128,128,128,0.2)]";
    const buttonclasses =
        "border border-grey-700 bg-gray-200 text-primary-text-dark rounded hover:text-primary-text-dark-hover sticky top-0";

    const props = defineProps({
        breeding: {
            type: Array,
        },
    });

    const data = computed(() =>
        props.breeding.map((item) => {
            // Ambil updated_at dari breeding_details jika ada dan valid
            const breedingDetailsUpdatedAt = item.breeding_details?.[0]?.updated_at;
            const itemUpdatedAt = item.updated_at;

            // Fungsi untuk memformat tanggal
            const formatDate = (date) => {
                const parsedDate = new Date(date);
                return !isNaN(parsedDate) ?
                    parsedDate.toISOString().split("T")[0] :
                    null;
            };

            // Tentukan lastupdate
            const lastUpdate =
                formatDate(breedingDetailsUpdatedAt) || formatDate(itemUpdatedAt);

            return {
                costCenter: item.id_breeding,
                pen: item.pen.code_pen,
                entryDate: formatDate(item.created_at),
                lastupdate: lastUpdate || "Invalid Date", // Anda bisa mengatur nilai default sesuai kebutuhan
                female_strain: item.code_ayam_betina,
                male_strain: item.code_ayam_jantan,
                female_population: item.jumlah_betina,
                male_population: item.jumlah_jantan,
                last_female: item.breeding_details?.[0]?.last_female ?? 0,
                last_male: item.breeding_details?.[0]?.last_male ?? 0,
                age: item.age,
                week: Math.floor(item.age / 7),
                FCR: parseFloat(item.fcr.toFixed(2)) ?? 0,
                laying: "",
                status: item.status,
            };
        })
    );

    const emit = defineEmits(["update:selectedId"]);

    const selectRow = (id) => {
        selectedId.value = id;
        emit("update:selectedId", id);
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
