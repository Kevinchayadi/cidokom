<template>
    <div class="chart-wrapper flex flex-col overflow-hidden h-[100%]">

        <div class="grid grid-cols-12 gap-4 flex-grow h-[40vh] ">
            <div class="col-span-6 chart-container mt-8  ">
                <highcharts :options="chartPieOptions"></highcharts>
            </div>
            <div
                class="col-span-6 flex d-flex flex-col justify-center align-center flex-column justify-content-center">
                <div class="mx-10 my-4">
                    <h1 class="text-center font-bold text-xl">Breeding Explanation</h1>
                </div>
                <div class="mx-10">
                    <table class="w-[90%]   text-center ">
                        <thead>
                            <tr class="border">
                                <th class=" bg-blue-300 " :class="classesth">No.</th>
                                <th class=" bg-blue-300 " :class="classesth">Pen</th>
                                <th class=" bg-blue-300 " :class="classesth">Live</th>
                                <th class=" bg-blue-300 " :class="classesth">dead</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Menampilkan data yang diambil -->
                            <tr v-for="(data, index) in displayedData" :key="index" class="border">
                                <td :class="classestd">{{ index + 1 }}</td>
                                <!-- Menampilkan index dimulai dari 1 -->
                                <td :class="classestd">{{ data . pen }}</td> <!-- Menampilkan data.pen -->
                                <td :class="classestd">{{ data . live }}</td> <!-- Menampilkan data.live -->
                                <td :class="classestd">{{ data . dead }}</td> <!-- Menampilkan data.dead -->
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Chart di bawah -->
        <div class="chart-container mt-6 w-[95%] h-[50vh] mx-10">
            <highcharts :options="chartOptions"></highcharts>
        </div>
    </div>
</template>

<script setup>
    import {
        ref,
        onMounted,
        nextTick
    } from 'vue';
    // import data from 'highcharts';

    const displayedData = ref([{
            pen: 'Pen A',
            live: 150,
            dead: 3
        },
        {
            pen: 'Pen B',
            live: 120,
            dead: 5
        },
        {
            pen: 'Pen C',
            live: 180,
            dead: 2
        },
        {
            pen: 'Pen D',
            live: 200,
            dead: 4
        },
        {
            pen: 'Pen E',
            live: 160,
            dead: 1
        },
        {
            pen: 'Pen F',
            live: 145,
            dead: 6
        },
        {
            pen: 'Pen G',
            live: 170,
            dead: 3
        },
        {
            pen: 'Pen H',
            live: 135,
            dead: 2
        },
        {
            pen: 'Pen I',
            live: 155,
            dead: 0
        },
        {
            pen: 'Pen J',
            live: 190,
            dead: 7
        }
    ]);
    const classesth =
        ' text-center   border-gray-300 font-medium text-gray-700 uppercase tracking-wider   min-w-[80px] shadow-[inset_1px_-1px_1px_white]'

    const classestd =
        'p-1  font-xs text-gray-900 text-center min-w-[80px] shadow-[inset_1px_-1px_1px_rgba(128,128,128,0.2)]'
    // Data harian (7h) - Contoh data dengan interval per jam untuk 7 hari terakhir
    const sevenHourData = [
        ['death chicken', 200, '#4CAF50'],
        ['live chicken', 321, '#FFEB3B'],
        ['reject chicken', 331, '#F44336'],
    ];
    const pie = [
        ['live chicken', 100, '#4CAF50'],
        ['reject chicken', 20, '#FFEB3B'],
        ['dead chicken', 33, '#F44336'],
    ];
    const data1 = [
        ['death chicken', 200],
        ['live chicken', 321],
        ['reject chicken', 331],
        ['reject chicken', 231],
    ];
    const data2 = [
        ['death chicken', 10],
        ['live chicken', 5],
        ['reject chicken', 28],
        ['reject chicken', 38],
    ];
    const data3 = [
        ['death chicken', 11],
        ['live chicken', 32],
        ['reject chicken', 12],
        ['reject chicken', 10],
    ];

    // Data bulanan (1m) - Contoh data bulanan untuk 5 bulan terakhir
    const oneMonthData = [
        [Date.UTC(2024, 0, 1), 50], // Januari
        [Date.UTC(2024, 1, 1), 60], // Februari
        [Date.UTC(2024, 2, 1), 70], // Maret
        [Date.UTC(2024, 3, 1), 80], // April
        [Date.UTC(2024, 4, 1), 90], // Mei
    ];

    // Mendeklarasikan chartOptions dengan Composition API menggunakan ref
    const chartOptions = ref({
        title: {
            text: 'Chick In',
        },
        chart: {
            type: 'line',
            zoomType: 'x',
        },
        xAxis: {
            type: 'datetime',
            title: {
                text: 'Date',
            },
            dateTimeLabelFormats: {
                day: '%e. %b',
                month: '%b %Y',
            },
        },
        yAxis: {
            title: {
                text: 'QTY Chick-in',
            },
        },
        accessibility: {
            enabled: false,
        },
        series: [{
                type: 'bar',
                name: 'Chick In',
                data: data1.map((item, index) => {
                    const startOfWeek = new Date(Date.UTC(2024, 0, 1));
                    const daysOffset = 7 * index;
                    startOfWeek.setUTCDate(startOfWeek.getUTCDate() + daysOffset);
                    return [startOfWeek.getTime(), item[1]];
                }),
                color: '#4CAF50', // Hijau untuk Chick In
            },
            {
                type: 'bar',
                name: 'Reject Chick',
                data: data2.map((item, index) => {
                    const startOfWeek = new Date(Date.UTC(2024, 0, 1));
                    const daysOffset = 7 * index;
                    startOfWeek.setUTCDate(startOfWeek.getUTCDate() + daysOffset);
                    return [startOfWeek.getTime(), item[1]];
                }),
                color: '#FFEB3B', // Kuning untuk Reject Chick
            },
            {
                type: 'bar',
                name: 'Dead Chick',
                data: data3.map((item, index) => {
                    const startOfWeek = new Date(Date.UTC(2024, 0, 1));
                    const daysOffset = 7 * index;
                    startOfWeek.setUTCDate(startOfWeek.getUTCDate() + daysOffset);
                    return [startOfWeek.getTime(), item[1]];
                }),
                color: '#F44336', // Merah untuk Dead Chick
            },
        ],
    });


    const chartPieOptions = ref({
        title: {
            text: 'Breeding Live Stock',
        },
        chart: {
            type: 'line', // Set tinggi chart dalam pixel
            zoomType: 'x',
        },
        accessibility: {
            enabled: false,
        },
        plotOptions: {
            pie: {
                dataLabels: {
                    enabled: true,
                    format: '{point.percentage:.1f}%', // Menampilkan persentase
                    distance: -30, // Menempatkan label lebih dekat ke tengah slice
                    style: {
                        color: 'white', // Warna teks label, bisa disesuaikan
                        fontWeight: 'bold',
                    },
                },
                showInLegend: true,
            }
        },
        series: [{
            type: 'pie',
            name: 'Jumlah Ayam',
            data: pie.map(item => ({
                name: item[0], // Kategori ayam
                y: item[1], // Jumlah ayam
                color: item[2],
            })),
        }],
    });





    // Fungsi untuk mengubah data menjadi 1 bulan (1m)
    const set1mData = () => {
        // Mengubah data chart menjadi bulanan
        chartOptions.value.series[0].data = oneMonthData;
        chartPieOptions.value.series[0].data = oneMonthData.map(item => ({
            name: new Date(item[0]).toLocaleDateString(),
            y: item[1],
        }));

        // Menampilkan data tabel untuk 1m
        displayedData.value = oneMonthData.map((item) => ({
            date: new Date(item[0]).toLocaleDateString(),
            time: '12:00', // Misalkan semua menggunakan jam yang sama
            code: 'code_example',
            type: 'type_example',
            status: 'status_example',
        }));
    };

    // Menangani resize untuk responsivitas
    onMounted(() => {
        nextTick(() => {
            const charts = Highcharts.charts;
            charts.forEach((chart) => {
                chart.reflow(); // Memaksa Highcharts untuk menyesuaikan ukuran grafik
            });
        });
    });

    // Set data awal
    // set7hData();
</script>

<style scoped>
    /* .chart-wrapper {
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    } */

    .toggle-buttons {
        margin-bottom: 20px;
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .grid-cols-12 {
        grid-template-columns: repeat(12, 1fr);
    }

    .chart-container {
        /* margin-top: 20px; */
        /* height: 38vh; */
        max-height: 60vh;
        overflow: hidden;
        position: relative;
    }
</style>
