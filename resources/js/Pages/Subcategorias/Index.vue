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
const iconoSeleccionado = ref(null);


const props = defineProps({
    subcategorias : {type:Object},
    categorias : {type:Object},
    iconos : {type:Object}

});
const form = useForm({
    nombre:'',
    categoria_id:'',
    icon:''
});

const formPage = useForm({});

const onPageClick = (event) => {
    formPage.get(route('subcategorias.index',{page:event}))
}

const openModal = (op, nombre, categoria_id, subcategoria, icono)=>{
    modal.value = true;
    //aciva el foco del campo nombre
    nextTick(()=> nombreInput.value.focus());
    operation.value = op;
    console.log(subcategoria);
    id.value = subcategoria;
    console.log(categoria_id);
    if(op == 1){
        tittle.value = 'Crear Subcategoria'
    }else{
        tittle.value = 'Editar Subcategoria'
        form.nombre = nombre;
        form.categoria_id = categoria_id;
        form.icon = icono;
    }
} 
const cerrarModal = ()=>{
    modal.value = false;
    form.reset();
}
const save = () =>{
    if(operation.value == 1){
        console.log(form);
        form.post(route('subcategorias.store'), {
            onSuccess: () =>{ok('Subcategoria creada')}
        });
    }else{
        console.log(id.value);
        form.put(route('subcategorias.update',id.value), {
            onSuccess: () =>{ok('Subcategoria modificada')}
        });
    }
}
const ok = (msj) =>{
    form.reset();
    cerrarModal();
    Swal.fire({title:msj,icon:'success'});
}


const seleccionarIcono = (icono) => {
    console.log(icono.nombre);
    iconoSeleccionado.value = toString(icono.nombre);
    form.icon = icono.nombre;
};

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
<style>
.icon-table {
  width: 100%;
  border-collapse: collapse;
}

.icon-table td {
  padding: 10px;
  text-align: center;
}

.icon-table i {
  font-size: 24px;
  margin: 5px;
}

</style>
<template>

    <Head title="Subcategorias" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Subcategorias </h2>
            
        </template>

        <div class="w-3/3">
        </div>
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
                        <tr v-for="subcategoria, i in subcategorias.data" :key="subcategoria.id" class="hover:bg-blue-100">
                        <td class="p-3">{{ (i+1) }}</td>
                        <td class="p-3 flex items-center">  
                            <div>
                                <i :class="[subcategoria.icon]"></i>
                                <span class="ml-4">{{ subcategoria.nombre }}</span>
                            </div> 
                        </td>
                        
                        <td class="p-3">                           
                            <i class="fa-solid fa-edit text-blue-500 hover:text-blue-700 cursor-pointer pr-2" @click="openModal(2, subcategoria.nombre, subcategoria.categoria_id, subcategoria.id, subcategoria.icon)"></i>
                            <i class="fa-solid fa-trash text-gray-500 hover:text-gray-700 cursor-pointer" @click="borrarSubcategoria(subcategoria.id, subcategoria.nombre)"></i>
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
            <div class="p-3 mt-6 flex items-center">
                <TextInput id="nombre" ref="nombreInput" v-model="form.nombre" type="text" class="mt-1 block w-3/4" placeholder="Nombre"></TextInput>
                <InputError :message="form.errors.nombre" class="mt-2"></InputError>
                <i :class="[form.icon]" class="ml-4 text-2xl text-gray-500"></i>
            </div>

            <div class="class p-3">
                <InputLabel label="Categoria"></InputLabel>
                <SelectInput id="categoria_id" v-model="form.categoria_id" :options="categorias"
                type="text" class="mt-1 block w-3/4" placeholder="Selecciona una categoria">
                </SelectInput>
                <InputError :message="form.errors.categoria_id" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <h3>Selecciona un icono:</h3>
                <table class="icon-table">
                    <tbody>
                        <tr>
                            <td v-for="icono in iconos.slice(0, 5)" :key="icono.nombre">
                                <i :class="[icono.nombre]" @click="seleccionarIcono(icono)"></i>
                            </td>
                        </tr>
                        <tr>
                            <td v-for="icono in iconos.slice(5, 10)" :key="icono.nombre">
                                <i :class="[icono.nombre]" @click="seleccionarIcono(icono)"></i>

                            </td>
                        </tr>
                        <tr>
                            <td v-for="icono in iconos.slice(10, 15)" :key="icono.nombre">
                                <i :class="[icono.nombre]" @click="seleccionarIcono(icono)"></i>
                            </td>
                        </tr>
                        <tr>
                            <td v-for="icono in iconos.slice(15, 20)" :key="icono.nombre">
                                <i :class="[icono.nombre]" @click="seleccionarIcono(icono)"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>

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