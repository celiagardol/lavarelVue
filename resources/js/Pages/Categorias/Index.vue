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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categorias</h2>
        </template>

        <div class="w-3/3">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                   <PrimaryButton @click = "$event => openModal(1)">
                        <i class="fa-solid fa-plus-circle"></i>Añadir
                    </PrimaryButton>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center overflow-x-auto">
                <table class="w-2/3 table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-2">#</th>
                            <th class="px-2 py-2">CATEGORIA</th>
                            <th class="px-2 py-2"></th>
                            <th class="px-2 py-2"></th>
                        </tr>
                    </thead>  
                   <tbody>
                        <tr v-for="categoria, i in categorias" :key="categoria.id">
                            <td class ="border border-gray-400 px-2 py-2">{{ (i+1) }}</td>
                            <td class ="border border-gray-400 px-2 py-2">{{ categoria.nombre }}</td>
                            <td class ="border border-gray-400 px-2 py-2">
                                <WarningButton 
                                @click="openModal(2,categoria.nombre,categoria.id)">
                                    <i class="fa-solid fa-edit"></i>    
                                </WarningButton>   
                            </td>
                            <td class ="border border-gray-400 px-2 py-2">
                                <DangerButton @click="borrarCategoria(categoria.id,categoria.nombre)">  
                                    <i class = "fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>  
                </table>
            </div>
            <div class="pt-2 pb-10 bg-white grid v-screen place-items-center overflow-x-auto">
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