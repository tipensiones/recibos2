<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    username: '',
    password: '',
    remember: false,
    'g-recaptcha-response': '', // aquí guardamos el token
});

const recaptchaId = ref(null);

// callback global que Google llama
window.onRecaptchaVerified = (token) => {
    form['g-recaptcha-response'] = token;
};

// Función para renderizar o resetear reCAPTCHA
const renderRecaptcha = () => {
    if (window.grecaptcha) {
        // Si ya existe, resetear
        if (recaptchaId.value !== null) {
            window.grecaptcha.reset(recaptchaId.value);
        } else {
            // Renderizamos el widget por primera vez
            recaptchaId.value = window.grecaptcha.render(document.querySelector('#recaptcha-container'), {
                sitekey: '6LfNx9IrAAAAABce5hUKdSF6dnK1jx_TFpGVDssz',
                callback: 'onRecaptchaVerified',
            });
        }
    }
};

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
            form['g-recaptcha-response'] = '';
            renderRecaptcha(); // Reset al enviar
        },
    });
};

// Cuando el componente se monta, renderizamos el reCAPTCHA
onMounted(() => {
    // Esperamos a que el script de Google cargue
    if (window.grecaptcha) {
        renderRecaptcha();
    } else {
        // Si el script aún no cargó, esperar a que se cargue
        const script = document.createElement('script');
        script.src = 'https://www.google.com/recaptcha/api.js?onload=onRecaptchaLoadCallback&render=explicit';
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);

        // Callback que Google llamará al cargar el script
        window.onRecaptchaLoadCallback = () => {
            renderRecaptcha();
        };
    }
});
</script>

<template>
<GuestLayout>
    <Head title="Log in" />

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
    </div>

    <form @submit.prevent="submit">
        <div>
            <InputLabel for="username" value="Username" />
            <TextInput
                id="username"
                type="text"
                class="mt-1 block w-full"
                v-model="form.username"
                required
                autofocus
                autocomplete="username"
            />
            <InputError class="mt-2" :message="form.errors.username" />
        </div>

        <div class="mt-4">
            <InputLabel for="password" value="Password" />
            <TextInput
                id="password"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password"
                required
                autocomplete="current-password"
            />
            <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <!-- reCAPTCHA dinámico -->
        <div class="mt-4" id="recaptcha-container"></div>
        <InputError class="mt-2" :message="form.errors['g-recaptcha-response']" />

        <div class="flex items-center justify-end mt-4">
            <Link
                v-if="canResetPassword"
                :href="route('password.request')"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
                ¿Olvidaste tu contraseña?
            </Link>

            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Ingresar
            </PrimaryButton>
        </div>
    </form>
</GuestLayout>
</template>
