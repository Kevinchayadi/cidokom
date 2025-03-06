<template>
    <div class="flex flex-col justify-center items-center md:h-screen">
        <div class="flex justify-center items-center mb-2">
            <img src="../../../../public/img/logo.png" alt="" class="w-60">
        </div>
        <nav class="space-y-2 m-2 md:h-full align-center items-start overflow-auto pb-10">

            <div v-for="data in routes" :key="data.path">
                <Link :href="data.path" :class="classes">{{ data . name . toUpperCase() }}</Link>
            </div>
            <div class="relative">
                <button @click="maintoggleDropdown"
                class="mt-2 space-y-2 text-primary-text-light hover:text-primary-text-light-hover">
                <span
                :class="['font-bold', 'transition-transform duration-300 ease-in-out', maindropdownVisible ? 'rotate-90' :
                            ''
                        ]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                           style="transform: rotate(270deg)" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg> </span>
                    MAIN TRANSACTION
                </button>
                
                <!-- Collapse content with smooth transition -->
                <div
                :class="['mt-2 ml-10 space-y-2 overflow-hidden transition-all duration-300 ease-in-out', maindropdownVisible ?
                        'max-h-[500px]' : 'max-h-0'
                    ]">
                    <div v-for="data in MainRoute" :key="data.path">
                        <Link :href="data.path" :class="classes">{{ data . name . toUpperCase() }}</Link>
                    </div>
                </div>
            </div>
            <div class="relative">
                <button @click="saletoggleDropdown"
                    class="mt-2 space-y-2 text-primary-text-light hover:text-primary-text-light-hover">
                    <span
                        :class="['font-bold', 'transition-transform duration-300 ease-in-out', saledropdownVisible ? 'rotate-90' :
                            ''
                        ]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        style="transform: rotate(270deg)" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg> </span>
                    SALES TRANSACTION
                </button>
            
                <!-- Collapse content with smooth transition -->
                <div
                    :class="['mt-2 ml-10 space-y-2 overflow-hidden transition-all duration-300 ease-in-out',  saledropdownVisible ?
                        'max-h-[500px]' : 'max-h-0'
                    ]">
                    <div v-for="data in SalesRoute" :key="data.path">
                        <Link :href="data.path" :class="classes">{{ data . name . toUpperCase() }}</Link>
                    </div>
                </div>
            </div>
            <div class="relative">
                <button @click="oprtoggleDropdown"
                    class="mt-2 space-y-2 text-primary-text-light hover:text-primary-text-light-hover">
                    <span
                        :class="['font-bold', 'transition-transform duration-300 ease-in-out', oprdropdownVisible ? 'rotate-90' :
                            ''
                        ]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        style="transform: rotate(270deg)" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg> </span>
                    OPERATION CHICKEN
                </button>
            
                <!-- Collapse content with smooth transition -->
                <div
                    :class="['mt-2 ml-10 space-y-2 overflow-hidden transition-all duration-300 ease-in-out',  oprdropdownVisible ?
                        'max-h-[500px]' : 'max-h-0'
                    ]">
                    <div v-for="data in oprRoute" :key="data.path">
                        <Link :href="data.path" :class="classes">{{ data . name . toUpperCase() }}</Link>
                    </div>
                </div>
            </div>
            <div >
                <Link :href="route('admin.logout')" :class="classes">LOGOUT</Link>
            </div>
            
        </nav>
    </div>
</template>


<script setup>
    import {
        Link
    } from "@inertiajs/vue3";
    import {
        computed,
        ref
    } from "vue";
    import {
        route
    } from "ziggy-js";
    import { useStore } from "vuex";

    const store = useStore();

    const routes = ref([{
            name: 'Dashboard',
            path: route('admin.dashboard')
        },
        {
            name: 'Operation Sumary',
            path: route('admin.sumary')
        },
        {
            name: 'Sales Sumary',
            path: route('admin.salesSummary')
        }
    ]);
    const MainRoute = ref([
        {
            name: 'Breeding',
            path: route('admin.breeding')
        },
        {
            name: 'Hatchery',
            path: route('admin.hatchery')
        },
        {
            name: 'Commercial',
            path: route('admin.commercial')
        },
        {
            name: 'Reject',
            path: route('admin.afkir')
        },
        {
            name: 'Breeding Quarantine',
            path: route('admin.breeding.karantina')
        },
        {
            name: 'Commercial Quarantine',
            path: route('admin.commercial.karantina')
        }
    ]);

    const oprRoute = ref([{
            name: 'Admin',
            path: route('admin.Admin')
        },
        {
            name: 'Chicken',
            path: route('admin.chicken')
        },
        {
            name: 'Cage',
            path: route('admin.kandang')
        },
        {
            name: 'Pen',
            path: route('admin.pen')
        },
        {
            name: 'Feed',
            path: route('admin.pakan')
        },
        {
            name: 'Vaccine',
            path: route('admin.vaksin')
        },
        {
            name: 'Vaccine schedule',
            path: route('admin.vaksin.schedule')
        }
    ]);
    const SalesRoute = ref([{
            name: 'Sales Transaction',
            path: route('admin.sales')
        },
        {
            name: 'Customer',
            path: route('admin.Customer')
        },
        {
            name: 'Residence',
            path: route('admin.Residence')
        },
        {
            name: 'Chicken Type',
            path: route('admin.ChickenSize')
        },
        {
            name: 'Sales',
            path: route('admin.CustHandle')
        },
    ]);

    const saledropdownVisible = computed(() => store.getters['Sidebar/getSaleDropdownVisible']);
  const maindropdownVisible = computed(() => store.getters['Sidebar/getMainDropdownVisible']);
  const oprdropdownVisible = computed(() => store.getters['Sidebar/getOprDropdownVisible']);

  const saletoggleDropdown = () => {
    store.dispatch('Sidebar/toggleSaleDropdown');
  };

  const maintoggleDropdown = () => {
    store.dispatch('Sidebar/toggleMainDropdown');
  };
  const oprtoggleDropdown = () => {
    store.dispatch('Sidebar/toggleOprDropdown');
  };

    const classes = "text-primary-text-light hover:text-primary-text-light-hover w-full";
</script>


<style scoped>
    /* Styling untuk tombol dropdown */
    button {
        display: flex;
        /* justify-content: center; */
        /* align-items: center; */
        transition: transform 0.3s ease;
        /* Animasi rotasi */
    }
    nav::-webkit-scrollbar {
    display: none;
}

    /* Styling untuk link dalam dropdown */
    div.mt-2.space-y-2>a {
        display: block;
        padding: 10px;
        background-color: #f9fafb;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

    /* Efek hover untuk link dropdown */
    div.mt-2.space-y-2>a:hover {
        background-color: #e5e7eb;
    }

    /* Animasi rotasi */
    .rotate-90 {
        transform: rotate(90deg);
    }

    /* Mengatur animasi collapse (smooth) */
    .max-h-0 {
        max-height: 0;
        padding: 0;
    }



    /* Menambahkan animasi pada transisi untuk collapse */
    .transition-all {
        transition: all 0.3s ease;
    }
</style>
