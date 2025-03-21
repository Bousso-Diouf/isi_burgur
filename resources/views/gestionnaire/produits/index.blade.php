<x-app-layout>
<x-slot name="header">

    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Produits') }}
            </h2>
            
            <a href="{{ route('gestionnaire.produits.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-150">
                Ajouter un produit
            </a>
        </div>
        
        <!-- Barre de recherche -->
        <div class="flex justify-end py-2">
            <form method="GET" action="{{ route('gestionnaire.produits.index') }}">
                <input type="text" name="search" id="search" placeholder="Rechercher un produit..." value="{{ request('search') }}"
                        class="rounded-lg p-2 border border-gray-300">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg ml-2">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        
    </x-slot>
    
    @include('menu')
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="container mx-auto mt-8">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                        <th class="py-3 px-6 text-left">ID</th>
                                        <th class="py-3 px-6 text-left">Nom</th>
                                        <th class="py-3 px-6 text-left">Prix</th>
                                        <th class="py-3 px-6 text-left">Stock</th>
                                        <th class="py-3 px-6 text-left">Image</th>
                                        <th class="py-3 px-6 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @if ($produits->isEmpty())
                                        <tr>
                                            <td colspan="6" class="py-3 px-6 text-center">Aucun produit trouvé</td>
                                        </tr>
                                    @else
                                        @foreach ($produits as $produit)
                                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                                <td class="py-3 px-6">{{ $produit->id }}</td>
                                                <td class="py-3 px-6">{{ $produit->nom }}</td>
                                                <td class="py-3 px-6">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</td>
                                                <td class="py-3 px-6">{{ $produit->stock }}</td>
                                                <td class="py-3 px-6">
                                                    @if($produit->image)
                                                        <img src="{{ asset($produit->image) }}" alt="{{ $produit->nom }}" class="w-16 h-16 object-cover">
                                                    @else
                                                        Pas d'image
                                                    @endif
                                                </td>
                                                <td class="py-3 px-6">
                                                    @if(auth()->user()->role === 'gestionnaire')
                                                        <form action="{{ route('gestionnaire.produits.archiver', $produit->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" class="px-3 py-1 text-white {{ $produit->archived ? 'bg-red-500' : 'bg-green-500' }} rounded">
                                                                {{ $produit->archived ? 'Désarchiver' : 'Archiver' }}
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <a href="{{ route('gestionnaire.produits.edit', $produit->id) }}" class="text-blue-600 hover:text-blue-800">Modifier</a> |
                                                    <form action="{{ route('gestionnaire.produits.destroy', $produit->id) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800">Supprimer</button>
                                                    </form>
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
        </div>
    </div>
</x-app-layout>
