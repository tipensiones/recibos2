<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';

const meses = [
    'ENERO', 'FEBRERO',
    'MARZO', 'ABRIL',
    'MAYO', 'JUNIO',
    'JULIO', 'AGOSTO',
    'SEPTIEMBRE', 'OCTUBRE',
    'NOVIEMBRE', 'DICIEMBRE'
];

const props = defineProps({
    years: Object,
    months: Object,
});

const date = new Date();

const form = useForm({
    year: date.getFullYear(),
    month: meses[date.getMonth()],
});

const rows = ref([]);
const loading = ref(false);
const ids = ref([]);

const submit = () => {
    loading.value = true;
    axios.get(route('sobres.index'), {
        params: {
            year: form.year,
            month: form.month
        }
    }).then(response => {
        loading.value = false;
        rows.value = response.data
        ids.value = response.data.map(a => a['id']);
        console.log(ids);
    }).catch(error => {
        loading.value = false;
        console.log(error);
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
       

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                            <!-- Año -->
                            <div>
                                <label for="year" class="block text-sm font-medium text-gray-700">Año</label>
                                <select id="year" v-model="form.year"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option v-for="(item, index) in years" :key="index" :value="item">{{ item }}</option>
                                </select>
                            </div>

                            <!-- Mes -->
                            <div>
                                <label for="month" class="block text-sm font-medium text-gray-700">Mes</label>
                                <select id="month" v-model="form.month"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option v-for="(item, index) in months" :key="index" :value="item">{{ item }}</option>
                                </select>
                            </div>

                            <!-- Botón -->
                            <div class="flex">
                                <PrimaryButton :disabled="loading" class="w-full justify-center"
                                    :class="{ 'opacity-25': form.processing }">
                                    Buscar
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>

                    <div class="p-6 text-gray-900" v-if="rows.length > 0">
                        <h1 class="text-lg font-semibold">
                            <a :href="route('sobres.show', { sobre: ids })" target="_blank"
                                class="text-red-600 hover:text-red-800 flex items-center gap-2">
                                <i class="fa-solid fa-file-pdf"></i> DESCARGAR RECIBO
                            </a>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
