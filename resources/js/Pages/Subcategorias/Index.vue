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
    subcategorias : {type:Object},
    categorias : {type:Object}

});
const form = useForm({
    nombre:'',
    categoria_id:''
});

const formPage = useForm({});

const onPageClick = (event) => {
    formPage.get(route('subcategorias.index',{page:event}))
}

const openModal = (op, nombre, categoria, subcategoria)=>{
    console.log("abro el modal");
    console.log(op);
    console.log(nombre);
   
    console.log(categoria);
    console.log(subcategoria);
    modal.value = true;
    //aciva el foco del campo nombre
    nextTick(()=> nombreInput.value.focus());
    operation.value = op;
    id.value = subcategoria;
    if(op == 1){
        tittle.value = 'Crear Subcategoria'
    }else{
        tittle.value = 'Editar Subcategoria'
        form.nombre = nombre;
        form.categoria_id = categoria;
    }
} 
const cerrarModal = ()=>{
    modal.value = false;
    form.reset();
}
const save = () =>{
    if(operation.value == 1){
        form.post(route('subcategorias.store'), {
            onSuccess: () =>{ok('Subcategoria creada')}
        });
    }else{
        form.put(route('subcategorias.update',id.value), {
            onSuccess: () =>{ok('Subcategoria modificada')}
        });
    }
}
const ok = (msj) =>{
    form.reset();
    closeModal();
    Swal.fire({title:msj,icon:'success'});
}

const borrarSubcategoria = (id,nombre) =>{
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
            form.delete(route('subcategorias.destroy',id), {onSuccess: ()=>{ok('Subcategoria eliminada')}});
        }
    });
}
</script>

<template>
    <Head title="Subcategorias" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Subcategorias</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                   <PrimaryButton @click = "$event => openModal(1)">
                        <i class="fa-solid fa-plus-circle"></i>Añadir
                    </PrimaryButton>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center overflow-x-auto">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-2">#</th>
                            <th class="px-2 py-2">SUBCATEGORIA</th>
                            <th class="px-2 py-2"></th>
                            <th class="px-2 py-2"></th>

                        </tr>
                    </thead>  
                   <tbody>
                        <tr v-for="subcategoria, i in subcategorias.data" :key="subcategoria.id">
                            <td class ="border border-gray-400 px-2 py-2">{{ (i+1) }}</td>
                            <td class ="border border-gray-400 px-2 py-2">{{ subcategoria.nombre }}</td>
                            <td class ="border border-gray-400 px-2 py-2">
                                <WarningButton 
                                @click="openModal(2,subcategoria.nombre,subcategoria.categoria_id,subcategoria.id)">
                                    <i class="fa-solid fa-edit"></i>    
                                </WarningButton>   
                            </td>
                            <td class ="border border-gray-400 px-2 py-2">
                                <DangerButton @click="borrarSubcategoria(subcategoria.id,subcategoria.nombre)">  
                                    <i class = "fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>  
                </table>
            </div>
            <div class="bg-white grid v-screen place-items-center overflow-x-auto">
                <vueTailwindPagination
                    :current="subcategorias.currentPage"
                    :total="subcategorias.total"
                    :per-page="subcategorias.perPage"
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
           
            <div class="class p-3">
                <InputLabel label="Categoria"></InputLabel>
                <SelectInput id="categoria_id" v-model="form.categoria_id" :options="categorias"
                type="text" class="mt-1 block w-3/4" placeholder="Selecciona una categoria">
                </SelectInput>
                <InputError :message="form.errors.categoria_id" class="mt-2"></InputError>
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