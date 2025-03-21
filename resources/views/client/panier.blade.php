<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Votre Panier') }}
            </h2>
        </div>
    </x-slot>

    <!-- MENU -->
    @include('menu')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Votre Panier</h3>

                @if(session('panier') && count(session('panier')) > 0)
                    <div class="space-y-4">
                        @foreach(session('panier') as $id => $produit)
                            <div class="border-b py-4 flex justify-between items-center">
                                <div>
                                    <p class="font-semibold">{{ $produit['nom'] }}</p>
                                    <p>{{ number_format($produit['prix'], 0, ',', ' ') }} FCFA</p>
                                    <p>Quantité: 
                                        <form method="POST" action="{{ route('panier.mettre_a_jour', $id) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantite" value="{{ $produit['quantite'] }}" min="1" class="w-16 p-2 border border-gray-300 rounded" />
                                            <button type="submit" class="ml-2 text-blue-500 hover:text-blue-700">
                                                Mettre à jour
                                            </button>
                                        </form>
                                    </p>
                                </div>
                                <div>
                                    <form method="POST" action="{{ route('panier.supprimer', $id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <i class="fas fa-trash-alt"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Calcul du total -->
                    <div class="mt-6 flex justify-between items-center">
                        <p class="font-semibold text-lg">Total: 
                            {{ number_format(array_sum(array_map(function ($produit) {
                                return $produit['prix'] * $produit['quantite'];
                            }, session('panier'))), 0, ',', ' ') }} FCFA
                        </p>
                        <button class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600" onclick="openModal()">
                            Passer la commande
                        </button>
                    </div>

                    <!-- Popup de confirmation -->
                    <div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
                        <div class="bg-white p-6 rounded-lg max-w-sm w-full">
                            <h3 class="text-xl font-semibold">Confirmer la commande</h3>
                            <p>Êtes-vous sûr de vouloir passer la commande ?</p>
                            <div class="flex justify-between mt-4">
                                <button onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-black rounded">Annuler</button>
                                <form method="POST" action="{{ route('panier.valider') }}" class="inline-block">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Confirmer</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        function openModal() {
                            document.getElementById('confirmationModal').classList.remove('hidden');
                        }

                        function closeModal() {
                            document.getElementById('confirmationModal').classList.add('hidden');
                        }
                    </script>

                @else
                    <p class="text-gray-500">Votre panier est vide.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>