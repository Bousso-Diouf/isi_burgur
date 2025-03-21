<x-app-layout>
    <x-alert />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6">
                <h2 class="text-3xl font-bold text-center text-white bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 p-4 rounded-lg shadow-md">
                    📦 Détails de la commande #{{ $commande->id }}
                </h2>

                <!-- Détails de la commande -->
                <div class="bg-gradient-to-r from-gray-100 to-gray-200 p-6 shadow-md rounded-lg mt-6">
                    <p class="text-lg"><strong>👤 Client :</strong> {{ $commande->user->name }}</p>
                    <p class="text-lg"><strong>💰 Total :</strong> {{ number_format($commande->total, 0, ',', ' ') }} FCFA</p>
                    <p class="text-lg"><strong>📌 Statut :</strong>
                        <span class="px-3 py-1 text-white text-sm rounded-lg
                            @if($commande->statut == 'En attente') bg-yellow-500
                            @elseif($commande->statut == 'En préparation') bg-blue-500
                            @elseif($commande->statut == 'Prête') bg-green-500
                            @elseif($commande->statut == 'Payée') bg-purple-600
                            @endif">
                            {{ $commande->statut }}
                        </span>
                    </p>
                    <p class="text-lg"><strong>📅 Date :</strong> {{ $commande->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <!-- Produits commandés -->
                <h3 class="text-2xl font-bold mt-6 text-gray-800">🛒 Produits commandés</h3>

                <div class="overflow-x-auto">
                    <table class="w-full bg-white shadow-md rounded-lg mt-4 border border-gray-200">
                        <thead>
                        <tr class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                            <th class="p-4 text-left">Produit</th>
                            <th class="p-4 text-left">Quantité</th>
                            <th class="p-4 text-left">Prix unitaire</th>
                            <th class="p-4 text-left">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($commande->produits as $produit)
                            <tr class="border-b bg-gray-100 hover:bg-gray-200 transition">
                                <td class="p-4">{{ $produit->nom }}</td>
                                <td class="p-4">{{ $produit->pivot->quantite }}</td>
                                <td class="p-4 font-semibold text-green-600">{{ number_format($produit->pivot->prix, 0, ',', ' ') }} FCFA</td>
                                <td class="p-4 font-semibold text-gray-800">{{ number_format($produit->pivot->total, 0, ',', ' ') }} FCFA</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Modification du statut -->
                @if ($commande->statut !== 'Payée' && $commande->statut !== 'Annulée')
                    <form action="{{ route('gestionnaire.commandes.update_statut', $commande->id) }}" method="POST" class="mt-6 bg-white p-6 shadow-md rounded-lg">
                        @csrf
                        @method('PATCH')
                        <label for="statut" class="block font-semibold mb-2 text-gray-700">📌 Modifier le statut :</label>
                        <div class="flex items-center space-x-3">
                            <select name="statut" id="statut" class="border rounded px-4 py-2 bg-gray-100 text-gray-700">
                                <option value="En attente" {{ $commande->statut == 'En attente' ? 'selected' : '' }}>En attente</option>
                                <option value="En préparation" {{ $commande->statut == 'En préparation' ? 'selected' : '' }}>En préparation</option>
                                <option value="Prête" {{ $commande->statut == 'Prête' ? 'selected' : '' }}>Prête</option>
                                <option value="Payée">Payée</option>
                            </select>
                            <button type="submit" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:opacity-80 text-white px-4 py-2 rounded-lg shadow-md">
                                ✅ Mettre à jour
                            </button>
                        </div>
                    </form>

                    <!-- Annulation de la commande -->
                    <form action="{{ route('gestionnaire.commandes.annuler', $commande->id) }}" method="POST" class="mt-4">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="bg-gradient-to-r from-red-500 to-pink-600 hover:opacity-80 text-white px-4 py-2 rounded-lg shadow-md">
                            ❌ Annuler la commande
                        </button>
                    </form>
                @else
                    <p class="text-red-600 font-semibold mt-4 bg-gray-100 p-4 rounded-lg shadow-md">
                        ⚠️ Cette commande est {{ $commande->statut }} et ne peut plus être modifiée.
                    </p>
                @endif

                <a href="{{ route('gestionnaire.commandes.index') }}"
                   class="mt-6 inline-block bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow-md transition">
                    ⬅️ Retour
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
