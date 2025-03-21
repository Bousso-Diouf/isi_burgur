<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Détails de la Commande') }} #{{ $commande->id }}
            </h2>
        </div>
    </x-slot>

    <!-- MENU -->
    @include('menu')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Détails de la Commande</h3>

                <div class="border-b py-4 mb-4">
                    <p class="font-semibold">Commande #{{ $commande->id }}</p>
                    <p class="text-sm text-gray-500">Statut : {{ $commande->statut }}</p>
                    <p class="text-sm text-gray-500">Date : {{ $commande->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <div>
                    <h4 class="text-lg font-semibold">Produits Commandés</h4>
                    <table class="min-w-full mt-2 table-auto">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left">Produit</th>
                                <th class="px-4 py-2 text-left">Quantité</th>
                                <th class="px-4 py-2 text-left">Prix Unitaire</th>
                                <th class="px-4 py-2 text-left">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commande->produits as $produit)
                                <tr>
                                    <td class="px-4 py-2">{{ $produit->nom }}</td>
                                    <td class="px-4 py-2">{{ $produit->pivot->quantite }}</td>
                                    <td class="px-4 py-2">{{ number_format($produit->pivot->prix, 0, ',', ' ') }} FCFA</td>
                                    <td class="px-4 py-2">{{ number_format($produit->pivot->quantite * $produit->pivot->prix, 0, ',', ' ') }} FCFA</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex justify-between items-center">
                    <p class="font-semibold text-lg">Total de la commande : {{ number_format($commande->total, 0, ',', ' ') }} FCFA</p>
                </div>

                <div class="mt-4">
                    <a href="{{ route('client.dashboard') }}" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Retour au Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>