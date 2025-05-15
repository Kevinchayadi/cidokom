<template>
    <!-- <div class="overflow-x-auto overflow-y-auto h-screen">

    </div> -->
    <div class="md:flex md:flex-col overflow-x-auto overflow-y-auto h-screen">
        <div class="md:grid md:grid-cols-12 md:gap-4 flex-grow md:max-h-[50vh]">
            <!-- Pie chart container -->
            <div class="md:col-span-6 mt-8">
                <highcharts :options="chartPieOptions"></highcharts>
            </div>

            <div
                class="md:col-span-6 flex flex-col justify-center items-center"
            >
                <div class="mx-10 my-4">
                    <h1 class="text-center font-bold text-xl">
                        Breeding Explanation
                    </h1>
                </div>
                <div class="mx-5 overflow-y-auto max-h-[45vh] md:max-h-[35vh]">
                    <table class="w-[90%] text-center">
                        <thead>
                            <tr class="border">
                                <th class="bg-green-400" :class="classesth">
                                    No.
                                </th>
                                <th class="bg-green-400" :class="classesth">
                                    Pen
                                </th>
                                <th class="bg-green-400" :class="classesth">
                                    Female
                                </th>
                                <th class="bg-green-400" :class="classesth">
                                    Male
                                </th>
                                <th class="bg-green-400" :class="classesth">
                                    Dead
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(data, index) in displayList"
                                :key="index"
                                class="border"
                            >
                                <td :class="classestd">{{ index + 1 }}</td>
                                <td :class="classestd">{{ data.pen }}</td>
                                <td :class="classestd">{{ data.female }}</td>
                                <td :class="classestd">{{ data.male }}</td>
                                <td :class="classestd">{{ data.dead }}</td>
                            </tr>
                            <tr>
                                <td
                                    class="bg-green-200"
                                    colspan="2"
                                    :class="classestd"
                                >
                                    Total
                                </td>
                                <td
                                    class="bg-green-200"
                                    colspan="2"
                                    :class="classestd"
                                >
                                    {{ totalAfkir + totalBreeding }}
                                </td>
                                <td class="bg-green-200" :class="classestd">
                                    {{ totalDeath }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Chart di bawah -->
        <div class="max-h-[50vh] mb-10">
            <highcharts :options="chartOptions"></highcharts>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, nextTick, computed } from "vue";

// Set a default height for the chart containers dynamically (45vh)
const maxChartHeight = window.innerHeight * 0.48;

const props = defineProps({
    totalAfkir: {
        type: Number,
        required: true,
    },
    totalBreeding: {
        type: Number,
        required: true,
    },
    totalDeath: {
        type: Number,
        required: true,
    },
    afkir: {
        type: Array,
        default: () => [],
    },
    breeds: {
        type: Array,
        default: () => [],
    },
    hatchery: {
        type: Array,
        default: () => [],
    },
});

const displayList = computed(() => {
    // Data dari oo
    const breedingData = props.breeds.map((item) => ({
        pen: item.code_pen ?? 0,
        male: item.male ?? 0,
        female: item.female ?? 0,
        dead: item.dead ?? 0,
    }));

    let test = breedingData;

    if (props.afkir != null) {
        const afkirData = {
            pen: "Afkir",
            male: props.afkir.male ?? 0,
            female: props.afkir.female ?? 0,
            dead: props.afkir.male_die + props.afkir.female_die ?? 0,

            // dead: props.afkir.male_out + props.afkir.female_out || 0, // Nilai default 0 jika null
        };
        test = [...breedingData, afkirData];
    }

    // Menggabungkan kedua data
    return test;
    // return [...breedingData, afkirData];
});

const classesth =
    "text-center border-gray-300 font-medium text-gray-700 uppercase tracking-wider min-w-[50px] md:min-w-[80px] shadow-[inset_1px_-1px_1px_white]";
const classestd =
    "p-1 font-xs text-gray-900 text-center min-w-[50px] text-center md:min-w-[80px] shadow-[inset_1px_-1px_1px_rgba(128,128,128,0.2)]";

const pie = [
    ["live chicken", props.totalBreeding, "#4CAF50"],
    ["reject chicken", props.totalAfkir, "#FFEB3B"],
    ["dead chicken", props.totalDeath, "#F44336"],
];
// const formatDate = (date) => {
//     const parsedDate = new Date(date);

//     if (isNaN(parsedDate)) return null; // Jika date tidak valid

//     const day = String(parsedDate.getDate()).padStart(2, '0');
//     const month = String(parsedDate.getMonth() + 1).padStart(2,
//     '0'); // Bulan dimulai dari 0, jadi kita tambahkan 1
//     const year = parsedDate.getFullYear().toString().slice(-2); // Ambil 2 digit terakhir dari tahun

//     return `${year}-${month}-${day}`;
// };

const formatDate = (date) => {
    const parsedDate = new Date(date);

    if (isNaN(parsedDate)) return null; // Jika date tidak valid

    // Mengambil tahun, bulan, dan hari dari tanggal
    const year = parsedDate.getUTCFullYear(); // Menggunakan getUTCFullYear untuk tahun UTC
    const month = parsedDate.getUTCMonth(); // Bulan UTC (0-11)
    const day = parsedDate.getUTCDate(); // Hari UTC (1-31)

    // Menggunakan Date.UTC untuk menghasilkan timestamp UTC hanya berdasarkan tanggal
    return Date.UTC(year, month, day); // Bulan dimulai dari 0, jadi langsung bisa digunakan
};
// Ambil data saleable dari hatcheryDetails[0]
// const chickIn = computed(() => {
//     return props.hatchery.map((hatcheryItem) => {
//         const createdAt = hatcheryItem.pull_chicken_date;
//         const saleable = hatcheryItem.hatchery_details?.[0]?.saleable;

//         // Format created_at menjadi dd/mm/yy
//         const formattedDate = createdAt ? formatDate(createdAt) : null;

//         return [formattedDate, saleable];
//     });
// });

// // Ambil data doc_afkir dari hatcheryDetails[0]
// const afkir = computed(() => {
//     return props.hatchery.map((hatcheryItem) => {
//         const createdAt = hatcheryItem.pull_chicken_date;
//         const saleable = hatcheryItem.hatchery_details?.[0]?.doc_afkir;

//         // Format created_at menjadi dd/mm/yy
//         const formattedDate = createdAt ? formatDate(createdAt) : null;

//         return [formattedDate, saleable];
//     });
// });

// // Ambil data (dead_in_egg + explode + Infertile) dari hatcheryDetails[0]
// const death = computed(() => {
//     return props.hatchery.map((hatcheryItem) => {
//         const details = hatcheryItem.hatchery_details?.[0] || {};
//         const createdAt = hatcheryItem.pull_chicken_date;
//         const saleable =
//             (details.dead_in_egg || 0) +
//             (details.explode || 0) +
//             (details.infertile || 0);
//         console.log(details.dead_in_egg, details.explode, details.infertile);
//         // Format created_at menjadi dd/mm/yy
//         const formattedDate = createdAt ? formatDate(createdAt) : null;

//         return [formattedDate, saleable];
//     });
// });
const chickIn = computed(() => {
    return props.hatchery.map((hatcheryItem) => {
        const createdAt = hatcheryItem.pull_chicken_date;
        const saleable = Number(hatcheryItem.hatchery_details?.[0]?.saleable ?? 0);

        const timestamp = createdAt ? new Date(createdAt).getTime() : null;

        return [timestamp, saleable];
    }).filter(item => item[0]); // filter yang null (jika ada)
});

const afkir = computed(() => {
    return props.hatchery.map((hatcheryItem) => {
        const createdAt = hatcheryItem.pull_chicken_date;
        const afkirQty = Number(hatcheryItem.hatchery_details?.[0]?.doc_afkir ?? 0) ;

        const timestamp = createdAt ? new Date(createdAt).getTime() : null;

        return [timestamp, afkirQty];
    }).filter(item => item[0]);
});

const death = computed(() => {
    return props.hatchery.map((hatcheryItem) => {
        const details = hatcheryItem.hatchery_details?.[0] || {};
        const createdAt = hatcheryItem.pull_chicken_date;
        console.log('detail:', details);

        const chickinDeath =
        Number(details.dead_in_egg || 0) +
        Number(details.explode || 0) +
        Number(details.infertile || 0);

        const timestamp = createdAt ? new Date(createdAt).getTime() : null;

        return [timestamp, chickinDeath];
    }).filter(item => item[0]);
});



onMounted(() => {
    console.log(props.hatchery)
    console.log(chickIn.value);
console.log(afkir.value);
console.log(death.value);
});

const data1 = [
    ["death chicken", 200],
    ["live chicken", 321],
    ["reject chicken", 331],
    ["reject chicken", 231],
];

const data2 = [
    ["death chicken", 10],
    ["live chicken", 5],
    ["reject chicken", 28],
    ["reject chicken", 38],
];

const data3 = [
    ["death chicken", 11],
    ["live chicken", 32],
    ["reject chicken", 12],
    ["reject chicken", 10],
];

const chartPieOptions = ref({
    title: {
        text: "Breeding Live Stock",
    },
    chart: {
        type: "pie",
        height: maxChartHeight,
    },
    accessibility: {
        enabled: false,
    },
    plotOptions: {
        pie: {
            dataLabels: {
                enabled: true,
                format: "{point.percentage:.1f}%",
                distance: 10,
                style: {
                    color: "white",
                    fontWeight: "bold",
                },
            },
            showInLegend: true,
        },
    },
    series: [
        {
            type: "pie",
            name: "Jumlah Ayam",
            data: pie.map((item) => ({
                name: item[0],
                y: item[1],
                color: item[2],
            })),
        },
    ],
});


const updowndate = 4 * 24 * 3600 * 1000;

const allDates = [
  ...chickIn.value,
  ...afkir.value,
  ...death.value,
].map(item => {
  const date = new Date(item[0]);
  date.setUTCHours(0, 0, 0, 0);
  return date.getTime();
});

const minDate = Math.min(...allDates) - updowndate
const maxDate = Math.max(...allDates) +updowndate


const chartOptions = ref({
    title: {
        text: "Chick In",
    },
    chart: {
        type: "line",
        zoomType: "x",
        height: maxChartHeight,
    },
    xAxis: {
        type: "datetime",
        reversed: true,
        title: {
            text: "Date",
        },
        min: minDate,
        max: maxDate,
        tickInterval: 7 * 24 * 3600 * 1000,
        dateTimeLabelFormats: {
            day: "%e %b", // 1 Jan, 2 Jan, dst
            week: "%e %b",
            month: "%b %Y",
            year: "%Y",
        },
    },
    yAxis: {
        title: {
            text: "QTY Chick-in",
        },
    },
    accessibility: {
        enabled: false,
    },
    plotOptions: {
        series: {
            // pointPadding: 0.5, // Mengatur jarak antar bar
            groupMargin: 2, // Jarak antar grup
        },
    },
    plotOptions: {
        series: {
            grouping: true, // Pastikan dibutuhkan jika Anda menggunakan bar yang dikelompokkan
            pointPadding: 0.1, // Jarak antar bar
            groupPadding: 0.05, // Jarak antar grup bar
            borderWidth: 0, // Jika ingin menghilangkan border
            dataLabels: {
                enabled: true, // Jika Anda ingin menampilkan label data
            },
            // Mengatur lebar bar (opsional)
            minPointLength: 1, // Ini menentukan lebar minimum bar
        },
    },
    series: [
    {
        type: "bar",
        name: "Chick In",
        data: chickIn.value.map((item) => {
            console.log("Chick In Data:", item);
            return [item[0], item[1]];
        }),
        color: "#4CAF50",
    },
    {
        type: "bar",
        name: "Reject Chick",
        data: afkir.value.map((item) => {
            console.log("Afkir Data:", item);
            return [item[0], item[1]];
        }),
        color: "#FFEB3B",
    },
    {
        type: "bar",
        name: "Dead Chick",
        data: death.value.map((item) => {
            console.log("Death Data:", item);
            return [item[0], item[1]];
        }),
        color: "#F44336",
    },
    ],
});


</script>

<style scoped>
/* Mengatur tinggi chart */
.chart-container1 {
    max-height: 50vh;
    /* Menurunkan tinggi chart menjadi 35% dari viewport height */
    overflow: hidden;
    /* Menghindari overflow */
    width: 100%;
    /* Set chart width to 100% dari kontainer */
}

.chart-container {
    max-height: 55vh;
    /* Menurunkan tinggi chart menjadi 35% dari viewport height */
    overflow: hidden;
    /* Menghindari overflow */
    width: 100%;
    /* Set chart width to 100% dari kontainer */
}

/* Agar tinggi chart mengikuti kontainer dengan baik */
.highcharts-container {
    height: 100% !important;
    /* Menjamin chart menggunakan 100% tinggi kontainer */
}
</style>
