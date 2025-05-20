<template>
    <div class="flex md:flex-row flex-col justify-between sticky top-0 left-0 bg-primary">
        <div class="flex justify-center">
            <button :class="buttonclasses" @click="downloadItem">Download</button>
        </div>
        <div class="my-1">
                
            <form @submit.prevent="handleSubmit">
                <div class="flex gap-1 justify-center">
                    <DateSubmitted v-model="started" />
                    <span class="text-white">-</span>
                    <DateSubmitted v-model="ended" />
                    <button
                        class=" bg-slate-200 border border-transparent hover:border-slate-700 transition-all duration-500 rounded-full px-4 mx-2 font-sans"
                        type="submit"
                    >
                        search
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div
        class="row-span-10 bg-gray-100 h-[95vh] overflow-x-auto overflow-y-auto px-5 m-0"
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
                                <td :class="classestd">
                                    {{ grandTotal.total_qty }}
                                </td>
                                <td :class="classestd">
                                    {{ formatRupiah(grandTotal.total_harga) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                <!-- Inactive Customer Table -->
                <h1 class="text-center font-extrabold">
                    Inactive Customer (In 2 Month)
                </h1>
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
                                <td :class="classestd">{{ item.sales }}</td>
                                <td :class="classestd">{{ item.nama }}</td>
                                <td :class="classestd">{{ item.phone }}</td>
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
import { router } from "@inertiajs/vue3";
import formatRupiah from "../../../composables/currency";
import DateSubmitted from "../../../components/inputComponent/DateSubmitted.vue";
import Search from "../../../components/inputComponent/search.vue";

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
    start: {
        type: String,
    },
    end: {
        type: String,
    },
});

const started = ref(props.start);
const ended = ref(props.end);

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
        tooltip: {
            formatter: function () {
                const qty = this.y;
                const price =
                    props.dailySales[this.point.index]?.total_harga ?? 0;
                return `
            <b> Quantity:</b> ${qty}<br/>
            <b>Revenue:</b> Rp ${price.toLocaleString("id-ID")}`;
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
const handleSubmit = () => {
    console.log(started.value, ended.value)
    router.get("/admin/Sales-Summary",{
        start: started.value,
        end: ended.value,
    })
};
const downloadItem = () => {
    console.log(started.value, ended.value)
    router.get("/download/salesTransaction",{
        start: started.value,
        end: ended.value,
    })
};


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
const grandTotal = computed(() => {
    let total_qty = 0;
    let total_harga = 0;
    props.recentCust.forEach((item) => {
        total_qty += item.total_ayam;
        total_harga += item.total_harga;
    });
    return {
        total_qty,
        total_harga,
    };
});

const InactiveCustData = computed(() =>
    (props.passiveCust ?? []).map((item) => ({
        sales: item.sales.nama_sales,
        nama: item.nama_pelanggan,
        phone: item.no_telepon_pelanggan,
    }))
);

// On mounted lifecycle hook
onMounted(() => {
    console.log(props.recentCust);
    console.log(props.passiveCust);
});
</script>
<style></style>
