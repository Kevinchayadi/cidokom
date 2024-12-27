<template>
    <div class="chart-wrapper flex flex-col overflow-hidden max-h-screen">
        <!-- Tombol Toggle untuk memilih data 7h atau 1m -->
        <div class="toggle-buttons mb-4 flex justify-center gap-4">
            <button @click.prevent="set7hData" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                7h
            </button>
            <button @click.prevent="set1mData" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                1m
            </button>
        </div>

        <!-- Dua chart di atas, masing-masing menggunakan col-6 -->
        <div class="grid grid-cols-12 gap-4 flex-grow">
            <div class="col-span-6 chart-container">
                <highcharts :options="chartPieOptions"></highcharts>
            </div>
            <div class="col-span-6 chart-container">
                <highcharts :options="chartPieOptions"></highcharts>
            </div>
        </div>

        <!-- Chart di bawah -->
        <div class="chart-container mt-4">
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
    import data from 'highcharts';

    // Data harian (7h) - Contoh data dengan interval per jam untuk 7 hari terakhir
    const sevenHourData = [
        [Date.UTC(2024, 0, 1, 0, 0), 2],
        [Date.UTC(2024, 0, 1, 1, 0), 3],
        [Date.UTC(2024, 0, 1, 2, 0), 4],
        [Date.UTC(2024, 0, 1, 3, 0), 5],
        [Date.UTC(2024, 0, 1, 4, 0), 6],
        [Date.UTC(2024, 0, 1, 5, 0), 7],
        [Date.UTC(2024, 0, 1, 6, 0), 8],
        [Date.UTC(2024, 0, 1, 7, 0), 9],
        [Date.UTC(2024, 0, 1, 8, 0), 10],
        [Date.UTC(2024, 0, 1, 9, 0), 11],
        [Date.UTC(2024, 0, 1, 10, 0), 12],
        [Date.UTC(2024, 0, 1, 11, 0), 13],
        [Date.UTC(2024, 0, 1, 12, 0), 14],
        [Date.UTC(2024, 0, 1, 13, 0), 15],
        [Date.UTC(2024, 0, 1, 14, 0), 16],
        [Date.UTC(2024, 0, 1, 15, 0), 17],
        [Date.UTC(2024, 0, 1, 16, 0), 18],
        [Date.UTC(2024, 0, 1, 17, 0), 19],
        [Date.UTC(2024, 0, 1, 18, 0), 20],
        [Date.UTC(2024, 0, 1, 19, 0), 21],
        [Date.UTC(2024, 0, 1, 20, 0), 22],
        [Date.UTC(2024, 0, 1, 21, 0), 23],
        [Date.UTC(2024, 0, 1, 22, 0), 24],
        [Date.UTC(2024, 0, 1, 23, 0), 25],
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
            text: 'Jumlah Ayam per Tanggal',
        },
        chart: {
            type: 'line',
            height: 350, // Set tinggi chart dalam pixel
             // Set lebar chart dalam pixel
            zoomType: 'x',
        },
        xAxis: {
            type: 'datetime',
            title: {
                text: 'Tanggal',
            },
            dateTimeLabelFormats: {
                day: '%e. %b',
                month: '%b %Y',
            },
        },
        yAxis: {
            title: {
                text: 'Jumlah Ayam',
            },
        },
        accessibility: {
            enabled: false,
        },
        series: [{
            type: 'line',
            name: 'Jumlah Ayam',
            data: sevenHourData, // Mulai dengan data 7 jam
        }, ],
    });
    const chartPieOptions = ref({
    title: {
        text: 'Jumlah Ayam per Tanggal',
    },
    chart: {
        type: 'pie',  // Chart type yang sudah benar
        height: 250,  // Set tinggi chart dalam pixel
        zoomType: 'x',  // Zoom type
    },
    accessibility: {
        enabled: false,
    },
    series: [{
        type: 'pie',  // Set ke 'pie' untuk membuat pie chart
        name: 'Jumlah Ayam',
        data: sevenHourData.map(item => ({
            name: data.dateFormat('%e %b %Y', item[0]),  // Tanggal
            y: item[1],        // Jumlah ayam
        })),  // Data untuk pie chart
    }],
});


    // Fungsi untuk mengubah data menjadi 7 jam (7h)
    const set7hData = () => {
        // Mengubah data chart menjadi 7 jam
        chartOptions.value.series[0].data = sevenHourData;
        chartPieOptions.value.series[0].data = sevenHourData.map(item => ({
            name: data.dateFormat('%e %b %Y', item[0]),  // Tanggal
            y: item[1],        // Jumlah ayam
        }));
    };

    // Fungsi untuk mengubah data menjadi 1 bulan (1m)
    const set1mData = () => {
        // Mengubah data chart menjadi bulanan
        chartOptions.value.series[0].data = oneMonthData;
        chartPieOptions.value.series[0].data = oneMonthData.map(item => ({
            name: data.dateFormat('%e %b %Y', item[0]),  // Tanggal
            y: item[1],        // Jumlah ayam
        }));
    };

    // Menangani resize untuk responsivitas
    onMounted(() => {
        nextTick(() => {
            // Memastikan Highcharts dapat menyesuaikan dengan ukuran kontainer
            const charts = Highcharts.charts;
            charts.forEach((chart) => {
                chart.reflow(); // Memaksa Highcharts untuk menyesuaikan ukuran grafik
            });
        });
    });
</script>

<style scoped>
    .chart-wrapper {
        height: 100%;
        display: flex;
        flex-direction: column;
        max-height: 100vh;
        /* Maksimal tinggi 100% viewport */
        overflow: hidden;
        /* Agar tidak keluar dari container */
    }

    .toggle-buttons {
        margin-bottom: 20px;
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    button {
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
    }

    .grid-cols-12 {
        grid-template-columns: repeat(12, 1fr);
    }

    .chart-container {
        margin-top: 20px;
        height: 38vh;
        /* Setiap chart akan memiliki tinggi 40% dari viewport */
        max-height: 40vh;
        /* Batasan maksimal tinggi */
        overflow: hidden;
        /* Agar chart tidak keluar */
        position: relative;
    }


    .grid-cols-12 {
        grid-template-columns: repeat(12, 1fr);
        gap: 16px;
    }

    .mb-4 {
        margin-bottom: 20px;
    }
</style>
