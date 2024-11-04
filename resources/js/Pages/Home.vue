<!-- App.vue -->
<template>

    <!-- <Sidebarnew/> -->
    <DataTable :data="data" class="display border border-black">
        <thead class="display border border-black">
            <tr class="display border border-black">
                <th colspan="2">A</th>
    
            </tr>
            <tr class="display border border-black">
                <th class="display border border-black">A</th>
                <th class="display border border-black" >B</th>
            </tr>
        </thead>
    </DataTable>
    
  
</template>

<script setup>
import Sidebarnew from '../layout/sidebarnew.vue';

import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
 
DataTable.use(DataTablesCore);
 
const data = [
  [1, 2],
  [3, 4],
  [3, 4],
  [3, 4],
  [3, 4],
];



</script>
