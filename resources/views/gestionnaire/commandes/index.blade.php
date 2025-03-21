<x-app-layout>
    @include('menu')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6">
                <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 text-white p-4 rounded-lg shadow-md">
                    📦 Toutes les commandes
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full bg-white shadow-md rounded-lg border border-gray-200">
                        <thead>
                        <tr class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-left">
                            <th class="p-4">#</th>
                            <th class="p-4">Client</th>
                            <th class="p-4">Total</th>
                            <th class="p-4">Statut</th>
                            <th class="p-4">Date</th>
                            <th class="p-4">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if ($commandes->isEmpty())
                            <tr>
                                <td colspan="6" class="py-6 px-4 text-center text-gray-500">Aucune commande trouvée</td>
                            </tr>
                        @else
                            @foreach ($commandes as $commande)
                                <tr class="border-b bg-gray-100 hover:bg-gray-200 transition">
                                    <td class="p-4">{{ $commande->id }}</td>
                                    <td class="p-4 font-semibold text-gray-700">{{ $commande->user->name }}</td>
                                    <td class="p-4 font-semibold text-green-600">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</td>
                                    <td class="p-4">
                                            <span class="px-3 py-1 text-white text-sm rounded-lg
                                                @if($commande->statut == 'En attente') bg-yellow-500
                                                @elseif($commande->statut == 'En préparation') bg-blue-500
                                                @elseif($commande->statut == 'Prête') bg-green-500
                                                @elseif($commande->statut == 'Payée') bg-purple-600
                                                @endif">
                                                {{ $commande->statut }}
                                            </span>
                                    </td>
                                    <td class="p-4 text-gray-600">{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="p-4">
                                        <a href="{{ route('gestionnaire.commandes.show', $commande->id) }}"
                                           class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-4 py-2 rounded-lg shadow-md hover:opacity-80 transition">
                                            🔍 Voir
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
