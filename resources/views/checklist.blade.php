
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checklist APD') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <livewire:apc-checklist />
    </div>
</x-app-layout>
