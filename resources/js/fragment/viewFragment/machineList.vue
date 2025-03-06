<template>
    <div class="w-full d-flex">
      <FormButton name="Create new Cage" @click="createForm" class="text-sm mb-2"/>
      
      <table class="w-full">
        <tbody>
          <tr v-for="data in machinelist" :key="data.id" class="w-full border-b border-b-white">
            <td class="text-sm md:text-xl font-bold  text-primary-text-light">{{ data.name }}</td>
            <td class="text-sm md:text-xl font-bold  text-primary-text-light">{{ data.kapasitas }}</td>
            
          </tr>
        </tbody>
      </table>
    </div>
      
    </template>
  <script setup>
  import { router } from '@inertiajs/vue3';
  import { Inertia } from '@inertiajs/inertia';
  import FormButton from '../../components/inputComponent/FormButton.vue';
  import { computed } from 'vue';
  
  // Menerima props dari komponen induk
  const props = defineProps({
    machine: {
      type: Array,
      default: () => [],
      required: true
    }
  });
  
  // Computed property untuk memproses data dari props
  const machinelist = computed(() =>
    props.machine.map(item => ({
      id: item.id,
      name: item.machine_name,
      kapasitas: item.kapasitas
    }))
  );
  
  
  const detail = (id) => {
    console.log(`Detail button clicked for machine with ID: ${id}`);
    router.get(`/user/pen/${id}`)
  
  };
  
  
  // Fungsi untuk membuka form tambah machine
  const createForm = () => {
    console.log('Add new button clicked');
    router.get('/user/machine/create')
  };
  
  </script>
    