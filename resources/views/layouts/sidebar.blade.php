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
        [
            'title' => 'Reportes',
            'route' => 'home',
            'icon' => 'heroicon-o-chart-pie',
        ],
        [
            'title' => 'Blog',
            'route' => 'home',
            'icon' => 'heroicon-o-newspaper',
        ],
        [
            'title' => 'Paginas',
            'route' => 'home',
            'icon' => 'heroicon-o-view-columns',
        ],
        [
            'title' => 'Marcas',
            'route' => 'home',
            'icon' => 'heroicon-o-tag',
        ],
        [
            'title' => 'Categorias',
            'route' => 'home',
            'icon' => 'heroicon-o-squares-2x2',
        ],
        [
            'title' => 'Targetas de regalos',
            'route' => 'home',
            'icon' => 'heroicon-o-gift-top',
        ],
    
        [
            'title' => 'Pagos',
            'route' => 'home',
            'icon' => 'heroicon-o-currency-dollar',
        ],
    ];
@endphp
<div class="w-72 flex bg-gray-900 z-40">
    <div class="px-6 pb-4 flex flex-col gap-y-6 overflow-y-auto grow ">
        <div class="h-16 flex items-center ">
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
									{{ request()->routeIs($item['route']) ? 'text-white bg-gray-800' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                                    @svg($item['icon'], 'w-6 h-6')
                                    {{ $item['title'] }}</a>
                            </li>
                        @endforeach

                    </ul>
                </li>
                <li>
                    <div class="text-xs font-semibold leading-6 text-gray-400">Blog</div>
                    <ul role="list" class="space-y-1 -mx-2 mt-2">
                        <li>
                            <a href="#"
                                class="font-semibold text-sm leading-6 rounded-md flex gap-x-3 p-2 text-gray-400 hover:text-white hover:bg-gray-800">
                                <span
                                    class="flex w-6 h-6 flex-shrink-0 items-center justify-center rounded-lg border border-gray-700 bg-gray-800 text-xs font-medium ">H</span>
                                <span class="adg">Posts</span></a>
                        </li>
                        <li>
                            <a href="#"
                                class="font-semibold text-sm leading-6 rounded-md flex gap-x-3 p-2 text-gray-400 hover:text-white hover:bg-gray-800">
                                <span
                                    class="flex w-6 h-6 flex-shrink-0 items-center justify-center rounded-lg border border-gray-700 bg-gray-800 text-xs font-medium ">T</span>
                                <span class="adg">Categorias</span></a>
                        </li>
                        <li>
                            <a href="#"
                                class="font-semibold text-sm leading-6 rounded-md flex gap-x-3 p-2 text-gray-400 hover:text-white hover:bg-gray-800">
                                <span
                                    class="flex w-6 h-6 flex-shrink-0 items-center justify-center rounded-lg border border-gray-700 bg-gray-800 text-xs font-medium ">W</span>
                                <span class="adg">Autores</span></a>
                        </li>
                    </ul>
                </li>
                <li class="mt-auto">
                    <a href="#"
                        class="font-semibold text-sm leading-6 rounded-md flex gap-x-3 p-2 text-gray-400 hover:text-white hover:bg-gray-800 -mx-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" aria-hidden="true" class="w-6 h-6 flex-shrink-0 ">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                            </path>
                        </svg>Configuracion</a>
                </li>
            </ul>
        </nav>
    </div>
</div>
