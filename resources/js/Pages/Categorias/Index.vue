<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';

import { Head,Link,useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
const props = defineProps({
    categorias : {type:Object}
});
const form = useForm({
    id:''
});
const borrarCategoria = (id,nombre) =>{
    const alerta = Swal.mixin({
        buttonsStyling:true
    });
    alerta.fire({
        title: 'Seguro que quieres eliminar ' + nombre + '?',
        icon:'question', showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i> Sí, borrar',
        cancelButtonText:'<i class="fa-solid fa-ban"></i> Cancel'
    }).then((result)=>{
        if(result.isConfirmed) {
            form.delete(route('categorias.destroy',id));
        }
    });
}
</script>

<template>
    <Head title="Categorias" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categorias</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                   <Link :href="route('categorias.create')"
                   :class="'px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xs '">
                    <i class = "fa-solid fa-plus-circule"></i>Añadir
                   </Link>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">CATEGORIA</th>
                            <th class="px-4 py-4"></th>
                            <th class="px-4 py-4"></th>
                        </tr>
                    </thead>  
                    <tbody>
                        <tr v-for="categoria, i in categorias" :key="categoria.id">
                            <td class ="border border-gray-400 px-4 py-4">{{ (i+1) }}</td>
                            <td class ="border border-gray-400 px-4 py-4">{{ categoria.nombre }}</td>
                            <td class ="border border-gray-400 px-4 py-4">
                                <Link :href="route('categorias.edit',categoria.id)"
                                :class="'px-4 py-2 bg-yellow-400 text-white border rounded-md font-semibold text-xs '">
                                    <i class = "fa-solid fa-edit"></i>Editar
                                </Link>    
                            </td>
                            <td class ="border border-gray-400 px-4 py-4">
                                <DangerButton @click="borrarCategoria(categoria.id,categoria.nombre)">  
                                    <i class = "fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>  
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>