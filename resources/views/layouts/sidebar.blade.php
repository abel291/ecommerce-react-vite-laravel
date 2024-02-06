@php
    $navigation_1 = [
        [
            'title' => 'Home',
            'route' => 'dashboard.home',
            'icon' => 'heroicon-m-home',
        ],
        [
            'title' => 'Usuarios',
            'route' => 'dashboard.users',
            'icon' => 'heroicon-m-user-circle',
        ],
        [
            'title' => 'Productos',
            'route' => 'dashboard.products',
            'icon' => 'heroicon-m-archive-box',
        ],
        // [
        //     'title' => 'Reportes',
        //     'route' => 'home',
        //     'icon' => 'heroicon-m-chart-pie',
        // ],

        // [
        //     'title' => 'Paginas',
        //     'route' => 'dashboard.pages',
        //     'icon' => 'heroicon-m-view-columns',
        // ],
        [
            'title' => 'Banners',
            'route' => 'dashboard.banners',
            'icon' => 'heroicon-m-photo',
        ],
        // [
        //     'title' => 'Marcas',
        //     'route' => 'dashboard.brands',
        //     'icon' => 'heroicon-m-tag',
        // ],
        [
            'title' => 'Categorias',
            'route' => 'dashboard.categories',
            'icon' => 'heroicon-m-squares-2x2',
        ],
        [
            'title' => 'Codigos de descuento',
            'route' => 'dashboard.discount-codes',
            'icon' => 'heroicon-m-ticket',
        ],

        [
            'title' => 'Pedidos',
            'route' => 'dashboard.orders',
            'icon' => 'heroicon-m-banknotes',
        ],
    ];

    $navigation_2 = [
        [
            'title' => 'Post',
            'route' => 'dashboard.posts',
            'icon' => 'heroicon-m-newspaper',
        ],
        [
            'title' => 'Autores',
            'route' => 'dashboard.authors',
            'icon' => 'heroicon-m-pencil',
        ],
    ];
    $navigation_3 = [
        [
            'title' => 'Setting',
            'route' => 'dashboard.settings',
            'icon' => 'heroicon-m-cog-6-tooth',
        ],
    ];
@endphp
<div class="w-72 flex bg-neutral-900 z-40 ">
    <div class=" flex flex-col overflow-y-auto w-full gap-y-3 ">
        <div class="flex items-center gap-[13px] px-6 py-3">
            <x-application-logo class="block w-auto fill-current text-white dark:text-neutral-200" />
        </div>
        <nav class="flex flex-col flex-1 divide-y divide-neutral-600/10">
            <x-sidebar.sidebar-list :list-navigation="$navigation_1" />

            <div class="grow">
                <x-sidebar.sidebar-list title="Blog" :list-navigation="$navigation_2" />
            </div>

            <x-sidebar.sidebar-list :list-navigation="$navigation_3" />
        </nav>
        {{-- <nav class="flex flex-col flex-1">
            <ul role="list" class="flex flex-col  gap-y-7 flex-1">
                <li>
                    <ul role="list" class="space-y-1 -mx-2">
                        @foreach ($navigation_1 as $item)
                            <li>
                                <a href="{{ route($item['route']) }}"
                                    class="font-semibold text-sm leading-6 rounded-md flex gap-x-3 p-2
									{{ request()->routeIs($item['route'] . '*') ? 'text-white bg-neutral-800' : 'text-neutral-400 hover:text-white hover:bg-neutral-800' }}">
                                    @svg($item['icon'], 'w-6 h-6')
                                    {{ $item['title'] }}
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </li>

                <li>
                    <div class="text-xs font-semibold leading-6 text-neutral-400">Blog</div>
                    <ul role="list" class="space-y-1 -mx-2">
                        @foreach ($navigation_2 as $item)
                            <li>
                                <a href="{{ route($item['route']) }}"
                                    class="font-semibold text-sm leading-6 rounded-md flex gap-x-3 p-2
											{{ request()->routeIs($item['route'] . '*') ? 'text-white bg-neutral-800' : 'text-neutral-400 hover:text-white hover:bg-neutral-800' }}">
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
									{{ request()->routeIs('dashboard.settings' . '*') ? 'text-white bg-neutral-800' : 'text-neutral-400 hover:text-white hover:bg-neutral-800' }}">
                                @svg('heroicon-m-cog-6-tooth', 'w-6 h-6 flex-shrink-0')
                                Ajustes
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav> --}}
    </div>
</div>
