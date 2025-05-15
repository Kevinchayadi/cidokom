<template>
    <div
        class="flex md:justify-start md:flex-row flex-col sticky top-0 left-0 bg-primary"
    >
        <button :class="buttonclasses" @click="downloadItem">Download</button>
    </div>
    <div
        id="printAble"
        class="row-span-10 bg-gray-100 h-[95vh] overflow-x-auto overflow-y-auto p-0 m-0"
    >
        <div
            class="divide-y divide-x divide-gray-300 border-collapse pb-10 mx-2"
        >
            <div id="printAble">
                <div
                    class="flex flex-col lg:flex-row justify-between items-center p-2"
                >
                    <div>
                        <h1
                            class="font-extrabold text-lg lg:text-2xl py-2"
                            style="text-shadow: 3px 3px 7px rgba(0, 0, 0, 0.5)"
                        >
                            Daily Report {{ startDate === endDate ? 'for ' + startDate : 'from ' + startDate + " to " + endDate }}
                        </h1>
                    </div>
                    <div>
                        <form @submit.prevent="handleSubmit">
                            <div class="flex gap-1">
                                <DateSubmitted v-model="dateNow1" />
                                -
                                <DateSubmitted v-model="dateNow2" />
                                <button
                                    class="w-1/3 bg-slate-200 border border-transparent hover:border-slate-700 transition-all duration-500 rounded-full px-4 mx-2 font-sans"
                                    type="submit"
                                >
                                    search
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <h1>1. Commercial</h1>
                <table>
                    <thead>
                        <tr>
                            <th :class="classesth">No.</th>
                            <th :class="classesth">Kandang</th>
                            <th :class="classesth">Satuan</th>
                            <th :class="classesth">Masuk HI</th>
                            <th :class="classesth">Mati HI</th>
                            <th :class="classesth">Keluar HI</th>
                            <th :class="classesth">Stock Akhir</th>
                            
                        </tr>
                    </thead>
                    <tbody
                        class="bg-gray-100 divide-y divide-gray-200 custom-scroll"
                    >
                        <tr
                            v-for="(item, index) in otherChickenStock"
                            :key="index"
                        >
                            <td :class="classestd">{{ index + 1 }}</td>
                            <td :class="classestd">{{ item.kandang }}</td>
                            <td :class="classestd">{{ item.satuan }}</td>
                            <td :class="classestd">
                                {{ item.masuk_hi || "-" }}
                            </td>
                            <td :class="classestd">
                                {{ item.mati_hi || "-" }}
                            </td>
                            <td :class="classestd">
                                {{ item.keluar_hi || "-" }}
                            </td>
                            <td :class="classestd">{{ item.stock_akhir }}</td>
                            
                        </tr>

                        <tr class="bg-blue-300 font-bold">
                            <td colspan="3" :class="classestd">Sub-total</td>
                            <td :class="classestd">{{ totalStock.masuk }}</td>
                            <td :class="classestd">{{ totalStock.mati }}</td>
                            <td :class="classestd">{{ totalStock.keluar }}</td>
                            <td :class="classestd">
                                {{ totalStock.stock_akhir }}
                            </td>
                           
                        </tr>
                    </tbody>
                </table>

                <br />

                <h1>2. Breeding</h1>
                <table>
                    <thead>
                        <tr>
                            <th :class="classesth">No.</th>
                            <th :class="classesth">Pen</th>
                            <th :class="classesth">Gender</th>
                            <th :class="classesth">Masuk HI</th>
                            <th :class="classesth">Mati HI</th>
                            <th :class="classesth">Keluar HI</th>
                            <th :class="classesth">Stock Akhir</th>
                        </tr>
                    </thead>
                    <tbody
                        class="bg-gray-100 divide-y divide-gray-200 custom-scroll"
                    >
                        <template
                            v-for="(item, index) in groupedData"
                            :key="index"
                        >
                            <tr>
                                <td :class="classestd" rowspan="2">
                                    {{ index + 1 }}
                                </td>
                                <td :class="classestd" rowspan="2">
                                    {{ item.pen }}
                                </td>
                                <td :class="classestd">{{ item.Male }}</td>
                                <td :class="classestd">
                                    {{ item.Male_masuk_hi }}
                                </td>
                                <td :class="classestd">
                                    {{ item.Male_mati_hi }}
                                </td>
                                <td :class="classestd">
                                    {{ item.Male_keluar_hi }}
                                </td>
                                <td :class="classestd">
                                    {{ item.Male_stock_akhir }}
                                </td>
                            </tr>
                            <tr>
                                <td :class="classestd">{{ item.Female }}</td>
                                <td :class="classestd">
                                    {{ item.Female_masuk_hi }}
                                </td>
                                <td :class="classestd">
                                    {{ item.Female_mati_hi }}
                                </td>
                                <td :class="classestd">
                                    {{ item.Female_keluar_hi }}
                                </td>
                                <td :class="classestd">
                                    {{ item.Female_stock_akhir }}
                                </td>
                            </tr>

                            <tr class="bg-gray-300 font-bold">
                                <td colspan="3" :class="classestd">
                                    Sub-total
                                </td>
                                <td :class="classestd">
                                    {{ item.total_masuk }}
                                </td>
                                <td :class="classestd">
                                    {{ item.total_mati }}
                                </td>
                                <td :class="classestd">
                                    {{ item.total_keluar }}
                                </td>
                                <td :class="classestd">
                                    {{ item.total_stock }}
                                </td>
                            </tr>
                        </template>

                        <tr class="bg-yellow-300 font-bold">
                            <td colspan="3" :class="classestd">Grand Total</td>
                            <td :class="classestd">{{ grandTotal.masuk }}</td>
                            <td :class="classestd">{{ grandTotal.mati }}</td>
                            <td :class="classestd">{{ grandTotal.keluar }}</td>
                            <td :class="classestd">
                                {{ grandTotal.stock_akhir }}
                            </td>
                            
                        </tr>
                    </tbody>
                </table>

                <br />

                <h1>3. Egg Production</h1>
                <table>
                    <thead>
                        <tr>
                            <th :class="classesth">Kandang</th>
                            <th :class="classesth">Hari Ini</th>
                            <th :class="classesth">Abnormal</th>
                            <th :class="classesth">Pecah</th>
                            <th :class="classesth">Utuh</th>
                            <th :class="classesth">cost(pcs)</th>
                        </tr>
                    </thead>
                    <tbody
                        class="bg-gray-100 divide-y divide-gray-200 custom-scroll"
                    >
                        <tr v-for="(item, index) in eggHarvesting" :key="index">
                            <td :class="classestd">{{ item.pen }}</td>
                            <td :class="classestd">{{ item.total }}</td>
                            <td :class="classestd">{{ item.abnormal }}</td>
                            <td :class="classestd">{{ item.pecah }}</td>
                            <td :class="classestd">{{ item.utuh }}</td>
                            <td :class="classestd">
                                {{ formatRupiah(item.cost) || "-" }}
                            </td>
                        </tr>

                        <tr class="bg-blue-300 font-bold">
                            <td :class="classestd">
                                Sub-Total Telur Seluruh Kandang
                            </td>
                            <td :class="classestd">{{ totalEggs.total }}</td>
                            <td :class="classestd">{{ totalEggs.abnormal }}</td>
                            <td :class="classestd">{{ totalEggs.pecah }}</td>
                            <td :class="classestd">{{ totalEggs.utuh }}</td>
                            <td :class="classestd">{{ formatRupiah(totalEggs.cost) || "-" }}</td>
                        </tr>
                    </tbody>
                </table>

                <br />
<!-- 
                <h1>4. Stock Feed</h1>
                <table>
                    <thead>
                        <tr>
                            <th :class="classesth">No.</th>
                            <th :class="classesth">Nama Pakan</th>
                            <th :class="classesth">Satuan</th>
                        </tr>
                    </thead>
                    <tbody
                        class="bg-gray-100 divide-y divide-gray-200 custom-scroll"
                    >
                        <tr v-for="(item, index) in feedStock" :key="index">
                            <td :class="classestd">{{ index + 1 }}</td>
                            <td :class="classestd">{{ item.nama_pakan }}</td>
                            <td :class="classestd">{{ item.qty }}</td>
                        </tr>

                        <tr class="bg-blue-300 font-bold">
                            <td colspan="2" :class="classestd">Sub-total</td>
                            <td :class="classestd">{{ total_pakan }}</td>
                        </tr>
                    </tbody>
                </table> -->
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    breeding: {
        type: Array,
        required: true,
    },
    commercial: {
        type: Array,
        required: true,
    },
    startDate: {
        type: String,
    },
    endDate: {
        type: String,
    },
});
const dateNow1 = ref(props.startDate);
const dateNow2 = ref(props.endDate);

const handleSubmit = () => {
    console.log(dateNow1.value, dateNow2.value)
    router.get("/admin/summary",{
        first: dateNow1.value,
        end: dateNow2.value,
    })
};

const totalEggs = computed(() => {
    let total = 0;
    let abnormal = 0;
    let pecah = 0;
    let utuh = 0;
    let biaya = 0;
    let cost = 0;

    props.breeding.forEach((item) => {
        if (item) {
            // Hanya proses jika item tidak null
            total += (item.egg || 0);
            abnormal += item.abnormal || 0;
            pecah += item.broken || 0;
            utuh += item.HE || 0;
            biaya += item.cost || 0;
        }
    });
    cost = biaya/utuh;

    return {
        total,
        abnormal,
        pecah,
        utuh,
        cost
    };
});

const eggHarvesting = computed(() => {
    return props.breeding.map((item) => {
        if (!item) {
            // Jika item null, kembalikan nilai default
            return {
                pen: "-",
                total: 0,
                abnormal: 0,
                pecah: 0,
                utuh: 0,
                cost: "-",
            };
        }
        return {
            pen: item.code_pen,
            total: (item.egg || 0),
            abnormal: item.abnormal || 0,
            pecah: item.broken || 0,
            utuh: item.HE || 0,
            cost: (item.cost/item.HE) ||0,
        };
    });
});

const grandTotal = computed(() => {
    let masuk = 0;
    let mati = 0;
    let keluar = 0;
    let stock_akhir = 0;

    props.breeding.forEach((item) => {
        if (item) {
            // Hanya proses jika item tidak null
            masuk +=
                Number(item.female_come || 0) +
                Number(item.male_come || 0);
            mati += Number(item.female_die || 0) + Number(item.male_die || 0);
            keluar +=
                Number(item.female_out || 0) + Number(item.male_out || 0);
            stock_akhir += Number(item.last_male || 0) + Number(item.last_female || 0);
        }
    });

    return {
        masuk,
        mati,
        keluar,
        stock_akhir,
    };
});

const groupedData = computed(() => {
    return props.breeding.map((item) => {
        if (!item) {
            // Jika item null, kembalikan nilai default
            return {
                age: "-",
                pen: "-",
                Male: "MALE",
                Male_masuk_hi: 0,
                Male_mati_hi: 0,
                Male_keluar_hi: 0,
                Male_stock_akhir: 0,
                Female: "FEMALE",
                Female_masuk_hi: 0,
                Female_mati_hi: 0,
                Female_keluar_hi: 0,
                Female_stock_akhir: 0,
                total_masuk: 0,
                total_mati: 0,
                total_keluar: 0,
                total_stock: 0,
                FcR: "-",
            };
        }
        return {
            age: "-",
            pen: item.code_pen,
            Male: "MALE",
            Male_masuk_hi: item.male_come || 0,
            Male_mati_hi: item.male_die || 0,
            Male_keluar_hi: item.male_out || 0,
            Male_stock_akhir: item.last_male || 0,
            Female: "FEMALE",
            Female_masuk_hi: item.female_come || 0,
            Female_mati_hi: item.female_die || 0,
            Female_keluar_hi: item.female_out || 0,
            Female_stock_akhir: item.last_female || 0,
            total_masuk:
                Number(item.male_come || 0) +
                Number(item.female_come || 0),
            total_mati: Number(item.female_die || 0) + Number(item.male_die || 0),
            total_keluar:
                Number(item.female_out || 0) + Number(item.male_out || 0),
            total_stock: Number(item.last_male || 0) + Number(item.last_female || 0),
           
        };
    });
});

const totalStock = computed(() => {
    let masuk = 0;
    let mati = 0;
    let keluar = 0;
    let stock_akhir = 0;

    props.commercial.forEach((item) => {
        if (item) {
            // Hanya proses jika item tidak null
            masuk += item.come || 0;
            mati += item.die || 0;
            keluar += Number(item.sale || 0) + Number(item.out || 0);
            stock_akhir += item.last_stock || 0;
        }
    });

    return {
        masuk,
        mati,
        keluar,
        stock_akhir,
    };
});

const otherChickenStock = computed(() => {
    return props.commercial.map((item) => {
        if (!item) {
            // Jika item null, kembalikan nilai default
            return {
                umur: "-",
                kandang: "-",
                satuan: "QTY",
                masuk_hi: 0,
                mati_hi: 0,
                keluar_hi: 0,
                stock_akhir: 0,
                FcR: "-",
            };
        }
        return {
            umur: "-",
            kandang: item.code_pen,
            satuan: "QTY",
            masuk_hi: item.come || 0,
            mati_hi: item.die || 0,
            keluar_hi: Number(item.sale || 0) + Number(item.out || 0),
            stock_akhir: item.last_stock || 0,
        };
    });
});

import { jsPDF } from "jspdf"; // Mengimpor jsPDF
import html2canvas from "html2canvas"; // Mengimpor html2canvas
import InputFragment from "../../../components/InputFragment.vue";
import DateSubmitted from "../../../components/inputComponent/DateSubmitted.vue";
import formatRupiah from "../../../composables/currency";

const downloadItem = () => {
    const element = document.getElementById("printAble"); // Ambil elemen dengan ID 'printAble'

    if (!element) {
        console.error("Elemen dengan ID 'printAble' tidak ditemukan");
        return; // Hentikan jika elemen tidak ditemukan
    }

    // Menggunakan html2canvas untuk menangkap screenshot dari elemen
    html2canvas(element)
        .then((canvas) => {
            const imgData = canvas.toDataURL("image/png"); // Mengonversi canvas menjadi gambar PNG
            const doc = new jsPDF();

            // Menambahkan gambar ke PDF
            doc.addImage(imgData, "PNG", 10, 10, 180, 160); // Menambahkan gambar dengan posisi dan ukuran yang diinginkan
            doc.save("data.pdf"); // Menyimpan PDF
        })
        .catch((error) => {
            console.error("Error saat menangkap elemen:", error);
        });
};

const classesth =
    " bg-blue-300 text-center  text-xs border-gray-300 text-table font-medium text-gray-700 uppercase tracking-wider  sticky top-[0px] min-w-[120px] shadow-[inset_1px_-1px_1px_white]";
const classesth2 =
    " bg-blue-300 text-center  text-xs font-medium text-table border-gray-300 text-gray-700 uppercase tracking-wider  sticky top-[36px] min-w-[120px] shadow-[inset_1px_-1px_1px_white]";
const classesth3 =
    " bg-blue-300 text-center  text-xs font-medium text-table border-gray-300 text-gray-700 uppercase tracking-wider  sticky top-[54px] min-w-[120px] shadow-[inset_1px_-1px_1px_white]";

const classestd =
    "p-1 text-xs  text-gray-900 text-table text-center min-w-[75px] shadow-[inset_1px_-1px_1px_rgba(128,128,128,0.2)]";

const buttonclasses =
    "  text-primary-text-light rounded hover:text-primary-text-light-hover sticky top-0 px-2";
</script>

<style scoped>
@media print {
    table {
        width: 100%;
        table-layout: fixed; /* Agar lebar tabel terjaga */
        overflow-x: auto; /* Menyediakan scroll horizontal jika tabel terlalu lebar */
    }

    th,
    td {
        word-wrap: break-word;
        padding: 4px;
    }

    .sticky {
        position: static !important; /* Menghindari sticky header yang mengganggu */
    }
}
</style>
