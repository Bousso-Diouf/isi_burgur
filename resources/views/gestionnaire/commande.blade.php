<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 text-white p-6 rounded-lg shadow-lg text-center">
            <h2 class="text-2xl font-bold">
                {{ __('📦 Gestion des Commandes') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6">
                <h3 class="text-2xl font-semibold mb-6 text-gray-800 border-b pb-3">📋 Liste des Commandes</h3>

                @foreach($commandes as $commande)
                    <div class="bg-gray-100 p-5 rounded-lg shadow-md flex justify-between items-center mb-4">
                        <div>
                            <p class="text-lg font-semibold text-gray-800">Commande #{{ $commande->id }}</p>
                            <p class="text-gray-600">👤 Client : <span class="font-medium">{{ $commande->user->name }}</span></p>
                            <p class="text-gray-600">
                                🏷️ Statut :
                                <span class="px-3 py-1 text-white text-sm rounded-lg
                                    @if($commande->statut == 'En attente') bg-yellow-500
                                    @elseif($commande->statut == 'En préparation') bg-blue-500
                                    @elseif($commande->statut == 'Prête') bg-green-500
                                    @elseif($commande->statut == 'Payée') bg-purple-600
                                    @endif">
                                    {{ $commande->statut }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <form method="POST" action="{{ route('gestionnaire.commandes.update', $commande->id) }}">
                                @csrf
                                @method('PATCH')
                                <select name="statut" class="px-4 py-2 border border-gray-300 rounded-lg bg-white shadow-sm">
                                    <option value="En attente" @selected($commande->statut == 'En attente')>En attente</option>
                                    <option value="En préparation" @selected($commande->statut == 'En préparation')>En préparation</option>
                                    <option value="Prête" @selected($commande->statut == 'Prête')>Prête</option>
                                    <option value="Payée" @selected($commande->statut == 'Payée')>Payée</option>
                                </select>
                                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-lg shadow-lg mt-2 hover:opacity-80 transition">
                                    ✅ Mettre à jour
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
