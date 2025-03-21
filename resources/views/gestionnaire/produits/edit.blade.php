<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier le produit') }}
        </h2>

        <x-alert></x-alert>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('gestionnaire.produits.update', $produit->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6">

                            <div class="flex flex-col">
                                <label for="nom" class="text-sm font-semibold">Nom du produit</label>
                                <input type="text" name="nom" id="nom" value="{{ old('nom', $produit->nom) }}" class="mt-1 p-2 border border-gray-300 rounded-lg" required>
                            </div>

                            <div class="flex flex-col">
                                <label for="prix" class="text-sm font-semibold">Prix (FCFA)</label>
                                <input type="number" name="prix" id="prix" value="{{ old('prix', $produit->prix) }}" class="mt-1 p-2 border border-gray-300 rounded-lg" required>
                            </div>

                            <div class="flex flex-col">
                                <label for="categorie" class="text-sm font-semibold">Catégorie</label>
                                <select name="categorie" id="categorie" class="mt-1 p-2 border border-gray-300 rounded-lg" required>
                                    <option value="Burgers" {{ old('categorie', $produit->categorie) == 'Burgers' ? 'selected' : '' }}>Burgers</option>
                                    <option value="Boissons" {{ old('categorie', $produit->categorie) == 'Boissons' ? 'selected' : '' }}>Boissons</option>
                                    <option value="Desserts" {{ old('categorie', $produit->categorie) == 'Desserts' ? 'selected' : '' }}>Desserts</option>
                                </select>
                            </div>

                            <div class="flex flex-col">
                                <label for="stock" class="text-sm font-semibold">Stock</label>
                                <input type="number" name="stock" id="stock" value="{{ old('stock', $produit->stock) }}" class="mt-1 p-2 border border-gray-300 rounded-lg" required>
                            </div>

                            <div class="flex flex-col">
                                <label for="image" class="text-sm font-semibold">Image du produit (facultatif)</label>
                                <input type="file" name="image" id="image" class="mt-1 p-2 border border-gray-300 rounded-lg">
                                @if($produit->image)
                                    <img src="{{ asset($produit->image) }}" alt="{{ $produit->nom }}" class="mt-2 w-full max-w-md">
                                @endif
                            </div>

                            <div class="flex flex-col">
                                <label for="description" class="text-sm font-semibold">Description</label>
                                <textarea name="description" id="description" rows="4" class="mt-1 p-2 border border-gray-300 rounded-lg" required>{{ old('description', $produit->description) }}</textarea>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-150">Mettre à jour le produit</button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
