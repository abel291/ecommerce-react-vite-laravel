<div x-data="{ show: false, title: 'Mensaje de confirmación', subtitle: '' }"
    @notification.window="  
		
		title = $event.detail.title;
		subtitle = $event.detail.subtitle; 

		setTimeout(() => {
			show = true;
		}, 500);
		
		setTimeout(() => {
			show = false;
		}, 5000);

	">
    <div class="fixed top-6 right-6 z-50 max-w-sm w-full" x-cloak x-show="show" x-transition.duration.500ms>
        <div id="toast-success"
            class="w-full p-4 text-gray-700 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 "
            role="alert">
            <div class="flex items-start">
                <div>
                    <x-heroicon-o-check-circle class="h-6 w-6 text-green-400" />
                    <span class="sr-only">Check icon</span>
                </div>
                <div class="pt-0.5 ml-3 grow text-sm">
                    <div class="font-medium text-gray-900 " x-text="title"></div>
                    <div x-show="subtitle" class="text-gray-500 mt-1" x-html="subtitle" x-show="subtitle"></div>

                </div>
                <button type="button" x-on:click="show=false" data-dismiss-target="#toast-success" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5 text-gray-400 focus:outline-none" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

@if (session()->has('success'))
    <div x-data="" x-init="$dispatch('notification', { title: '{{ session('success') }}' })"></div>
@endif
