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
            year: year.value,
            month: month.value
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
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <table>
                                <tr>
                                    <td>
                                        <div>Año</div>
                                        <select name="year" id="year" v-model="form.year">
                                            <option v-for="(item, index) in years" :value="item">{{ item }}</option>
                                        </select>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <div>Mes</div>
                                        <select name="month" id="month" v-model="form.month">
                                            <option v-for="(item, index) in months" :value="item">{{ item }}</option>
                                        </select>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <div>&nbsp;</div>
                                        <PrimaryButton :disabled="loading" class="ml-4" :class="{ 'opacity-25': form.processing }">
                                            Buscar
                                        </PrimaryButton>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div class="p-6 text-gray-900" v-if="rows.length > 0">
                        <h1>
                            <a :href="route('sobres.show', { sobre: ids })" target="_blank">
                                <i class="fa-solid fa-file-pdf"></i> DESCARGAR RECIBO
                            </a>
                        </h1>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
