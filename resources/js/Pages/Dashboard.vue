<script >
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import GastosPorCategoriaGrafico from '@/Components/GastosPorCategoriaGrafico.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

export default {
  components: { GastosPorCategoriaGrafico,Head, AuthenticatedLayout,PrimaryButton},
  props: {
        gastosPorCategoria: { type: Object },
        cuentasConSaldo: { type: Object },
        totalSaldo: { type: Number },
        movimientos: { type: Object },
      },
  data() {
    return {

    }

  },
  methods:{
    navigateCuentas(){
        console.log("ir a cuentas");
    },
    navigateCategorias(){
        console.log("ir a categorias");
    },
    navigateMovimientosPendientes(){
        console.log("ir a movimientos Pendientes");
    }
  }
}

</script>
<style>
    i{
        color:blue;
    }
    i:hover {
        color: rgb(84, 84, 156); /* Cambia el color al pasar el cursor sobre el ícono */
    }
</style>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h1 class="font-bold text-xl text-blue-700 leading-tight">
                
            </h1>
        </template>
        <div class="w-full bg-white grid pl-20 grid grid-cols-3 gap-2">
            <div
                class="h-60 w-full max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
            >
                <a href="#">
                    <h5
                        class="mb-2 text-2xl font-bold tracking-tight text-blue-700 dark:text-white"
                    >
                        Resumen de tu situación
                    </h5>
                </a>
                <div class="h-28">
                    <table class="w-full">
                        <tbody>
                            <tr v-for="cuenta in cuentasConSaldo.slice(0, 2)" :key="index">
                                <td class="px-4 py-2">{{ cuenta.nombre }}</td>
                                <td class="px-4 py-2">{{ cuenta.saldo }}€</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2">Saldo Total</td>
                                <td class="px-4 py-2">{{ totalSaldo }}€</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2"></td>
                                <td class="px-4 py-4 flex items-center justify-end">
                                    <i  class="fa-solid fa-arrow-right-long fa-2xl" @click="navigateCuentas()"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr />
            </div>
           
            <div
                class="h-60 w-full max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
            >
                <a href="#">
                    <h5
                        class="mb-2 text-2xl font-bold tracking-tight text-blue-700 dark:text-white"
                    >
                        Gastos por categoría
                    </h5>
                </a>
                <div class="h-28">
                    <table class="w-full">
                        <tbody>
                            <tr v-for="(categoria, index) in gastosPorCategoria.slice(0, 3)" :key="index">
                                <td class="px-4 py-2">
                                    {{ categoria.nombre }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ categoria.total }}€
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2"></td>
                                <td class="px-4 py-4 flex items-center justify-end">
                                    <i  class="fa-solid fa-arrow-right-long fa-2xl" @click="navigateCategorias()"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr />
                
            </div>
            <div
                class="h-60 w-full max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
            >
                <a href="#">
                    <h5
                        class="mb-2 text-2xl font-bold tracking-tight text-blue-700 dark:text-white"
                    >
                        Proximos pagos
                    </h5>
                </a>
                <div class="h-28">
                    <table class="w-full">
                        <tbody>
                            
                            <tr v-for="movimiento in movimientos.slice(0, 3)" :key="index">
                                <td class="px-4 py-2">
                                    {{ movimiento.concepto }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ movimiento.fecha }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ movimiento.importe }}€
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-4 flex items-center justify-end" v-if="movimientos.lenght > 0">
                                    <i  class="fa-solid fa-arrow-right-long fa-2xl" @click="navigateMovimientosPendientes()"></i>
                                </td>
                                <td  v-else>
                                    <h3>No hay movmientos pendientes</h3>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr />

            </div>
            <div>
                <GastosPorCategoriaGrafico :gastosPorCategoria="gastosPorCategoria" />
            </div>
        </div>

        <div class="flex flex-row">
            
        </div>

    </AuthenticatedLayout>
</template>
