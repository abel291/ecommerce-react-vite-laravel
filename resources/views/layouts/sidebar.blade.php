@php
    $navigations_1 = [
        [
            'title' => 'Home',
            'route' => 'dashboard.home',
            'icon' => 'heroicon-o-home',
        ],
        [
            'title' => 'Usuarios',
            'route' => 'dashboard.users',
            'icon' => 'heroicon-o-user-circle',
        ],
        [
            'title' => 'Productos',
            'route' => 'dashboard.products',
            'icon' => 'heroicon-o-archive-box',
        ],
        // [
        //     'title' => 'Reportes',
        //     'route' => 'home',
        //     'icon' => 'heroicon-o-chart-pie',
        // ],
    
        // [
        //     'title' => 'Paginas',
        //     'route' => 'dashboard.pages',
        //     'icon' => 'heroicon-o-view-columns',
        // ],
        [
            'title' => 'Banners',
            'route' => 'dashboard.banners',
            'icon' => 'heroicon-o-photo',
        ],
        [
            'title' => 'Marcas',
            'route' => 'dashboard.brands',
            'icon' => 'heroicon-o-tag',
        ],
        [
            'title' => 'Categorias',
            'route' => 'dashboard.categories',
            'icon' => 'heroicon-o-squares-2x2',
        ],
        [
            'title' => 'Codigos de descuento',
            'route' => 'dashboard.discount-codes',
            'icon' => 'heroicon-o-currency-dollar',
        ],
    
        [
            'title' => 'Pedidos',
            'route' => 'dashboard.orders',
            'icon' => 'heroicon-o-banknotes',
        ],
    ];
    
    $navigation_2 = [
        [
            'title' => 'Post',
            'route' => 'dashboard.posts',
            'icon' => 'heroicon-o-newspaper',
        ],
        [
            'title' => 'Autores',
            'route' => 'dashboard.authors',
            'icon' => 'heroicon-o-pencil',
        ],
    ];
@endphp
<div class="w-72 flex bg-gray-900 z-40">
    <div class="px-6 pb-4 flex flex-col gap-y-6 overflow-y-auto grow ">
        <div class="h-16 shrink-0 flex items-center ">
            <x-application-logo class="block h-8 w-auto fill-current text-white dark:text-gray-200" />
        </div>
        <nav class="flex flex-col flex-1">
            <ul role="list" class="flex flex-col  gap-y-7 flex-1">
                <li>
                    <ul role="list" class="space-y-1 -mx-2">
                        @foreach ($navigations_1 as $item)
                            <li>
                                <a href="{{ route($item['route']) }}"
                                    class="font-semibold text-sm leading-6 rounded-md flex gap-x-3 p-2  
									{{ request()->routeIs($item['route'] . '*') ? 'text-white bg-gray-800' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                                    @svg($item['icon'], 'w-6 h-6')
                                    {{ $item['title'] }}
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </li>

                <li>
                    <div class="text-xs font-semibold leading-6 text-gray-400">Blog</div>
                    <ul role="list" class="space-y-1 -mx-2">
                        @foreach ($navigation_2 as $item)
                            <li>
                                <a href="{{ route($item['route']) }}"
                                    class="font-semibold text-sm leading-6 rounded-md flex gap-x-3 p-2  
											{{ request()->routeIs($item['route'] . '*') ? 'text-white bg-gray-800' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                                    @svg($item['icon'], 'w-6 h-6')
                                    {{ $item['title'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="mt-auto">
                    <ul role="list" class="space-y-1 -mx-2">
                        <li>
                            <a href="{{ route('dashboard.settings') }}"
                                class="font-semibold text-sm leading-6 rounded-md flex gap-x-3 p-2  
									{{ request()->routeIs('dashboard.settings' . '*') ? 'text-white bg-gray-800' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                                @svg('heroicon-o-cog-6-tooth', 'w-6 h-6 flex-shrink-0')
                                Ajustes
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
