<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import WarningButton from '@/Components/WarningButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { Head,useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { nextTick,ref } from 'vue';
import vueTailwindPagination from '@ocrv/vue-tailwind-pagination';

const nombreInput = ref(null);
const modal = ref(false);
const tittle = ref('');
const operation = ref(1);
const id = ref('');

const props = defineProps({
    categorias : {type:Object}

});
const form = useForm({
    nombre:''
});

const formPage = useForm({});

const onPageClick = (event) => {
    formPage.get(route('categorias.index',{page:event}))
}

const openModal = (op, nombre, categoria)=>{
    console.log("abro el modal");
    console.log(op);
    console.log(nombre);
   
    console.log(categoria);
  
    modal.value = true;
    //aciva el foco del campo nombre
    nextTick(()=> nombreInput.value.focus());
    operation.value = op;
    id.value = categoria;
    if(op == 1){
        tittle.value = 'Crear Categoria'
    }else{
        tittle.value = 'Editar Categoria'
        form.nombre = nombre;
    }
} 
const cerrarModal = ()=>{
    modal.value = false;
    form.reset();
}
const save = () =>{
    if(operation.value == 1){
        form.post(route('categorias.store'), {
            onSuccess: () =>{ok('categoria creada')}
        });
    }else{
        form.put(route('categorias.update',id.value), {
            onSuccess: () =>{ok('Categoria modificada')}
        });
    }
}
const ok = (msj) =>{
    form.reset();
    cerrarModal();
    Swal.fire({title:msj,icon:'success'});
}

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
            form.delete(route('categorias.destroy',id), {onSuccess: ()=>{ok('Categoria eliminada')}});
        }
    });
}
</script>

<template>
    <Head title="Categorias" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight pr-10">Categorias</h2>
                
            </div>
        </template>
        <div class ="w-1/3 pl-10 pt-10">
            <div class="bg-white grid v-screen  overflow-x-auto">
               
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-blue-500 text-white">
                        <th class="p-3 text-left"></th>
                        <th class="p-3 text-left"></th>
                        <th class="p-3 text-right">                            
                            <i class="fa-solid fa-plus fa-2xl text-white hover:text-green-700 cursor-pointer pr-2" @click="openModal(1)"></i>
                        </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="categoria, i in categorias" :key="categoria.id" class="hover:bg-blue-100">
                        <td class="p-3">{{ (i+1) }}</td>
                        <td class="p-3">{{ categoria.nombre }}</td>
                        <td class="p-3">
                            <i class="fa-solid fa-edit text-blue-500 hover:text-blue-700 cursor-pointer pr-2" @click="openModal(2, categoria.nombre, categoria.id)"></i>
                            <i class="fa-solid fa-trash text-gray-500 hover:text-gray-700 cursor-pointer" @click="borrarCategoria(categoria.id, categoria.nombre)"></i>
                        </td>
                        </tr>
                    </tbody>
                </table>



            </div>
            <div v-if="categorias.lenght > 10" class="pt-2 pb-10 bg-white grid v-screen place-items-start overflow-x-auto">
                <vueTailwindPagination
                    :current="categorias.currentPage"
                    :total="categorias.total"
                    :per-page="categorias.perPage"
                    @page-changed="$event => onPageClick($event)"
                ></vueTailwindPagination>
            </div>
        </div>
        <Modal :show="modal" @close="cerrarModal">
            <h2 class="p-3 text-lg font.medium text-hray-900">{{ tittle }}</h2>
            <div class="class p-3 mt-6">
                <InputLabel for="nombre" value="Nombre"></InputLabel>
                <TextInput id="nombre" ref="nombreInput" v-model="form.nombre" type="text" class="mt-1 block w-3/4" placeholder="Nombre"></TextInput>
                <InputError :message="form.errors.nombre" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <PrimaryButton :disabled="form.processing" @click="save"> 
                    <i class="fa-solid fa-save"></i>Guardar
                </PrimaryButton>    
            </div>
            <div class="p-3 flex justify-end">
                <SecondaryButton class="ml-3" :disabled="form.processing" @click="cerrarModal">
                Cancelar
                </SecondaryButton>
            </div>

        </Modal>
    </AuthenticatedLayout>
</template>