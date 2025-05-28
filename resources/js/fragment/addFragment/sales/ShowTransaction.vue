<template>
    <div class="w-[80%]">
        <Headers :tittle="`Sales Transaction from ${selectData.nama_pelanggan}`" />
        <table>
                <thead>
                    <tr>
                        <th class="z-20 w-[35px]"  :class="classesth">No.</th>
                        <th class="z-20 w-[150px]"  :class="classesth">
                            Date
                        </th>
                        <th class="z-20 w-[45px]"  :class="classesth">qty</th>
                        <th class="z-20 w-[75px]"  :class="classesth">
                            price
                        </th>
                        <th class="z-20 w-[75px]"  :class="classesth">
                            discount
                        </th>
                        <th class="z-20 w-[100px]"  :class="classesth">
                            Total Price
                        </th>
                        <th :class="classesth" class="z-20 w-[350px]"   >
                            description
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(item, index) in Data"
                        :key="item.id"
                        :class="[
                            classestd
                        ]"
                    >
                        <td :class="classestd">{{ index + 1 }}</td>
                        <td :class="classestd">{{ item.date }}</td>
                        <td :class="classestd">{{ item.qty }}</td>
                        <td :class="classestd">
                            {{ formatRupiah(item.price) }}
                        </td>
                        <td :class="classestd">
                            {{ formatRupiah(item.discount) }}
                        </td>
                        <td :class="classestd">
                            {{ formatRupiah(item.total) }}
                        </td>
                        <td :class="classestd" class="w-[250px]">
                            {{ item.desc }}
                        </td>
                    </tr>
                </tbody>
            </table>
    </div>
</template>

<script setup>
    import { computed, onMounted, ref } from 'vue';
    import { router } from '@inertiajs/vue3';
    import Headers from '../../../components/Headers.vue';
import formatRupiah from '../../../composables/currency';


    const props = defineProps({
        salesData: { type: Array },
        selectData:{type:Object}
    });
    onMounted(()=>{
        console.log(props.selectData);
    })

    const Data = computed(() =>
    props.salesData.map((item) => ({
        date: item.tanggal_Penjualan,
        chickenSize: item.chicken_size.size,
        qty: item.jumlah_ayam,
        price: item.harga,
        discount: item.diskon,
        total: item.total_harga,
        desc: item.description,
        sales: item.customers.sales.nama_sales,
        id: item.id, // Tambahkan ID untuk referensi
    }))
);

const classesth =
    "bg-blue-300 text-center text-xs border-gray-300 text-table font-medium text-gray-700 uppercase tracking-wider sticky top-[0px]  shadow-[inset_1px_-1px_1px_white]";
const classestd =
    "p-1 text-xs text-gray-900 text-table text-center shadow-[inset_1px_-1px_1px_rgba(128,128,128,0.2)]";
 

   

</script>

<style scoped></style>
