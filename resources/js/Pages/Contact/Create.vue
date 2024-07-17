<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import FileInput from '@/Components/FileInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';


const initialValues = {
    name: '',
    phone: '',
    avatar: null,
    privacity: 'Private'
}

const form = useForm(initialValues)

const onSelectAvatar = (e) => {
    const files = e.target.files;
    if (files.length) {
        form.avatar = files[0]
    }
    console.log(form.avatar)
}

const submit = () => {
    form.post(route('contact.store'))
    // console.log("No recarga la pagina")
}

</script>

<template>

    <Head title="Lista" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Crear Contactos
                </h2>

                <Link :href="route('contact.index')">
                Lista de Contactos
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form class="w-1/3 py-5 space-y-3" @submit.prevent="submit">
                        <div>
                            <InputLabel for="name" value="Name" />

                            <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name"
                                autocomplete="name" placeholder="Diguite Nombre" />

                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                        <div>
                            <InputLabel for="phone" value="Phone" />

                            <TextInput id="phone" type="text" class="mt-1 block w-full" v-model="form.phone"
                                placeholder="Diguite Numero de Telefono" />

                            <InputError class="mt-2" :message="form.errors.phone" />
                        </div>

                        <div>
                            <InputLabel for="avatar" value="Imagen" />

                            <FileInput name="avatar" @change="onSelectAvatar" />

                            <InputError class="mt-2" :message="form.errors.avatar" />
                        </div>

                        <div>
                            <InputLabel for="privacity" value="Privacidad" />

                            <select name="privacity" id="privacity" v_model="form.privacity"
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="public">Publico</option>
                                <option value="private">Privado</option>
                            </select>

                            <InputError class="mt-2" :message="form.errors.privacity" />
                        </div>
                        <div class="flex justify-center">
                            <PrimaryButton>
                                Crear Contacto
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
