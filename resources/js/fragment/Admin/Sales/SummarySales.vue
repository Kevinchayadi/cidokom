<template>
    <div class="flex justify-start sticky top-0 left-0 bg-primary">
        <button :class="buttonclasses" @click="downloadItem">Download</button>
    </div>
    <div
        class="row-span-10 bg-gray-100 h-[95vh] overflow-x-auto overflow-y-auto p-5 m-0"
    >
        <!-- Line Chart for Daily Sales -->
        <div class="md:col-span-6 mt-8">
            <highcharts :options="chartLineOptions"></highcharts>
        </div>

        <!-- Flex Container for Tables -->
        <div
            class="tables-container flex flex-col md:flex-row justify-between gap-4 mt-5 mb-2"
        >
        <div>
            <!-- Active Customer Table -->
            <h1 class="text-center font-extrabold">Active Customer</h1>
            <div
                class="table-wrapper flex-1 overflow-auto min-h-[35vh] max-h-[35vh] justify-items-center"
            >
                <table>
                    <thead>
                        <tr>
                            <th :class="classesth">No.</th>
                            <th :class="classesth">Nama Pelanggan</th>
                            <th :class="classesth">Qty</th>
                            <th :class="classesth">Price</th>
                        </tr>
                    </thead>
                    <tbody
                        class="bg-gray-100 divide-y divide-gray-200 custom-scroll"
                    >
                        <tr
                            v-for="(item, index) in recentCustData"
                            :key="index"
                        >
                            <td :class="classestd">{{ index + 1 }}</td>
                            <td :class="classestd">{{ item.nama }}</td>
                            <td :class="classestd">{{ item.qty }}</td>
                            <td :class="classestd">
                                {{ formatRupiah(item.price) }}
                            </td>
                        </tr>
                        <tr
                        class="bg-blue-300 text-center text-xs border-gray-300 text-table font-medium text-gray-700 uppercase"
                        >
                            <td :class="classestd" colspan="2">total</td>
                            <td :class="classestd">{{ grandTotal.total_qty }}</td>
                            <td :class="classestd">{{ formatRupiah(grandTotal.total_harga) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div>
            <!-- Inactive Customer Table -->
            <h1 class="text-center font-extrabold">Inactive Customer</h1>
            <div
                class="table-wrapper flex-1 overflow-auto min-h-[35vh] max-h-[35vh] justify-items-center"
            >
                <table>
                    <thead>
                        <tr>
                            <th :class="classesth">No.</th>
                            <th :class="classesth">Sales</th>
                            <th :class="classesth">Nama Customer</th>
                            <th :class="classesth">Phone</th>
                        </tr>
                    </thead>
                    <tbody
                        class="bg-gray-100 divide-y divide-gray-200 custom-scroll"
                    >
                        <tr
                            v-for="(item, index) in InactiveCustData"
                            :key="index"
                        >
                            <td :class="classestd">{{ index + 1 }}</td>
                            <td :class="classestd">{{ item.umur }}</td>
                            <td :class="classestd">{{ item.kandang }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import formatRupiah from "../../../composables/currency";

// Props definition
const props = defineProps({
    dailySales: {
        type: Array,
        required: true,
    },
    recentCust: {
        type: Array,
        required: true,
    },
    passiveCust: {
        type: Array,
        default: () => [],
    },
});

// Data transformation for line chart
const chartLineOptions = computed(() => {
    return {
        chart: {
            type: "line",
            zoomType: "x",
        },
        title: {
            text: "Daily Sales Quantity",
        },
        xAxis: {
            categories: props.dailySales.map((item) => item.date), // Assuming date format is compatible
            title: {
                text: "Date",
            },
        },
        yAxis: {
            title: {
                text: "Quantity Sold",
            },
        },
        series: [
            {
                name: "Quantity",
                data: props.dailySales.map((item) => item.total_qty),
                color: "#4caf50", // Line color
            },
        ],
    };
});

// Table class for styling
const classesth =
    " bg-blue-300 text-center text-xs border-gray-300 text-table font-medium text-gray-700 uppercase  sticky top-[0px] w-[75px]  md:w-[120px] shadow-[inset_1px_-1px_1px_white]";
const classestd =
    "p-1 text-xs text-gray-900 text-table text-center w-[75px]  md:w-[120px] shadow-[inset_1px_-1px_1px_rgba(128,128,128,0.2)]";
const buttonclasses =
    "  text-primary-text-light rounded hover:text-primary-text-light-hover sticky top-0 px-2";
// Other computed data for tables
const recentCustData = computed(() =>
    (props.recentCust ?? []).map((item) => ({
        nama: item.nama_pelanggan,
        qty: item.total_ayam,
        price: item.total_harga,
    }))
);
const grandTotal = computed(()=>{
    let total_qty = 0;
    let total_harga = 0;
    props.recentCust.forEach((item)=>{
        total_qty += item.total_ayam
        total_harga+=item.total_harga
    })
    return {
        total_qty,
        total_harga
    };
})

const InactiveCustData = computed(() =>
    (props.passiveCust ?? []).map((item) => ({
        nama: item.nama_pelanggan,
        qty: item.total_ayam,
    }))
);

// On mounted lifecycle hook
onMounted(() => {
    console.log(props.recentCust);
    console.log(props.passiveCust);
});
</script>
<style></style>
