<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                <livewire:admin.dashboard.overview />

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <livewire:admin.dashboard.sales-trend />
                    <livewire:admin.dashboard.recent-orders />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
