@section('title', 'Dashboard')

<x-slot name="header">
    <h2 class="font-semibold text-xl text-neutral-800 dark:text-neutral-200 leading-tight">
        {{ __('Dashboard') }}
    </h2>
</x-slot>

<div class="grid grid-cols-1 gap-5">
    <div>
        <h3 class="text-base font-semibold leading-6">Últimos 30 días</h3>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-8 gap-5">

        <div class="lg:col-span-2">
            <x-card class="w-full">
                <dt class="text-neutral-500 font-medium text-sm">Registros de usuarios</dt>
                <dd class="text-3xl text-neutral-900 tracking-tight font-semibold mt-1">
                    {{ number_format($users_register->count()) }}</dd>
            </x-card>
        </div>

        <div class="lg:col-span-2">
            <x-card class="w-full">
                <dt class="text-neutral-500 font-medium text-sm">Ordenes Completadas</dt>
                <dd class="text-3xl text-neutral-900 tracking-tight font-semibold mt-1">
                    {{ number_format($orders_completed->count()) }}</dd>
            </x-card>
        </div>

        <div class="lg:col-span-2">
            <x-card class="w-full">
                <dt class="text-neutral-500 font-medium text-sm">Productos vendidos</dt>
                <dd class="text-3xl text-neutral-900 tracking-tight font-semibold mt-1">
                    {{ number_format($products_quantity) }}
                </dd>
            </x-card>
        </div>

        <div class="lg:col-span-2">
            <x-card class="w-full h-full ">
                <dt class="text-neutral-500 font-medium text-sm">Ingresos Brutos</dt>
                <dd class="text-2xl text-neutral-900 tracking-tight font-semibold mt-1">
                    @money($revenues)
                </dd>
            </x-card>
        </div>

        <div class="lg:col-span-4 ">
            <x-content>
                <h3 class="title">Registros de usuarios mensual ({{ now()->isoFormat('MMMM') }}) </h3>
                <div class="mt-6 lg:h-96 chart-container " style="position: relative; width:100%">
                    <canvas id="chart-register-users" class="w-full"></canvas>
                </div>
            </x-content>
        </div>
        <div class="lg:col-span-4 ">
            <x-content>
                <h3 class="title">Ventas por categoria </h3>
                <div class="mt-6 lg:h-96 chart-container " style="position: relative; width:100%">
                    <canvas id="chart-order-category" class="w-full"></canvas>
                </div>
            </x-content>

        </div>
        <div class="lg:col-span-6 ">
            <livewire:dashboard.dashboard-payments />
        </div>

        <div class="lg:col-span-2 ">

            <x-content>
                <h3 class="title mb-6">Producto mas vendido </h3>
                @if ($popular_product)
                    <a href="{{ route('product', $popular_product->slug) }}" target="_blank">
                        <div class="w-52 mx-auto">
                            <img src="{{ $popular_product->img }}" alt="" class="w-full rounded-lg">
                        </div>
                        <h4 class=" font-medium mt-4">{{ $popular_product->name }}</h4>
                        <div class="mt-5 font-medium flex justify-between items-center">
                            @money($popular_product->price_offer)
                            <a href="{{ route('product', $popular_product->slug) }}" class="text-indigo-600">Ver</a>
                        </div>
                    </a>
                @else
                    <p class="text-neutral-500 text-xs">no disponible</p>
                @endif
            </x-content>


        </div>

        <div class="lg:col-span-8 ">
            <livewire:dashboard.dashboard-product-out-stock />
        </div>

    </div>


</div>

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartRegisterUsers = document.getElementById('chart-register-users');
        const chartOrderCategory = document.getElementById('chart-order-category');

        const getDaysInMonth = () => {
            let daysCount = new Date(
                new Date().getFullYear(),
                new Date().getMonth() + 1,
                0
            ).getDate();

            return Array.from({
                length: daysCount
            }, (_, i) => i + 1)
        };


        const arrayDaysInMonth = getDaysInMonth();
        new Chart(chartRegisterUsers, {
            type: 'bar',
            data: {
                labels: arrayDaysInMonth,
                datasets: [{
                    label: 'Usuarios Registrados',
                    data: [12, 19, 3, 5, 2, 3, 12, 19, 3, 5, 2, 3],
                    backgroundColor: ['#3b82f6']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(chartOrderCategory, {
            type: 'bar',
            data: {
                labels: @json($product_category->keys()->toArray()),
                datasets: [{
                    label: 'Ventas',
                    data: @json($product_category->values()->toArray()),
                    backgroundColor: ['#3b82f6']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }


        });
    </script>
@endpush
