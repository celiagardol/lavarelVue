<script >
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import GastosPorCategoriaGrafico from '@/Components/GastosPorCategoriaGrafico.vue';
export default {
  components: { GastosPorCategoriaGrafico,Head, AuthenticatedLayout},
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


  
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <div class="w-full bg-white grid pl-20 grid grid-cols-3 gap-2">
            <div
                class="h-60 w-full max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
            >
                <a href="#">
                    <h5
                        class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
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
                        </tbody>
                    </table>
                </div>
                <hr />
                <div class="pt-4">
                    <a
                        href="#"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        Ver mas
                        <svg
                            class="w-3.5 h-3.5 ml-2"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 14 10"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9"
                            />
                        </svg>
                    </a>
                </div>
            </div>
            <div
                class="h-60 w-full max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
            >
                <a href="#">
                    <h5
                        class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
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
                        </tbody>
                    </table>
                </div>
                <hr />
                <div class="pt-4">
                    <a
                        href="#"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        Ver mas
                        <svg
                            class="w-3.5 h-3.5 ml-2"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 14 10"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9"
                            />
                        </svg>
                    </a>
                </div>
            </div>
            <div
                class="h-60 w-full max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
            >
                <a href="#">
                    <h5
                        class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
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
                        </tbody>
                    </table>
                </div>
                <hr />
                <div class="pt-4">
                    <a
                        href="#"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        Ver mas
                        <svg
                            class="w-3.5 h-3.5 ml-2"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 14 10"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9"
                            />
                        </svg>
                    </a>
                </div>
            </div>
            <div>
                <GastosPorCategoriaGrafico :gastosPorCategoria="gastosPorCategoria" />
            </div>
        </div>

        <div class="flex flex-row">
            
        </div>

    </AuthenticatedLayout>
</template>
