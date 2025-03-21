<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-center items-center bg-orange-600 p-4 rounded-md shadow-md">
            <h2 class="font-semibold text-2xl text-white leading-tight">
                {{ __('Tableau de bord - Client') }}
            </h2>
        </div>
    </x-slot>

    <!-- MENU -->
    <div class="bg-orange-500">
        @include('menu')
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800 text-center">Bonjour, {{ auth()->user()->name }}</h3>
                <p class="text-gray-700 text-center">Explorez nos produits et passez vos commandes en toute simplicité.</p>
            </div>
        </div>
    </div>
</x-app-layout>
