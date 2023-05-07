@props(['title'])
<div class="pb-8 mb-9 border-b">
    <h3 class="lg:col-span-6 font-semibold text-lg mb-4 text-gray-800 ">{{ $title }}</h3>
    <div>
        {{ $slot }}
    </div>
</div>
