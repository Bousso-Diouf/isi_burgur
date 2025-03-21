@extends('layouts.layout')

@section('content')

    <div class="max-w-6xl mx-auto mt-10 p-6 bg-white border border-gray-300 shadow-lg rounded-lg">

        <!-- En-tête avec logo et boutons -->
        @include('header')

        <!-- Titre -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Détails du Produit : {{ $produit->nom }} </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Image du produit -->
            <div class="w-full h-96 bg-gray-100 rounded-md flex items-center justify-center overflow-hidden">
                @if ($produit->image)
                    <img src="{{ asset($produit->image) }}" alt="{{ $produit->nom }}" class="object-cover w-full h-full">
                @else
                    <span class="text-gray-500">Pas d'image disponible</span>
                @endif
            </div>

            <!-- Description du produit -->
            <div class="p-4">
                <p class="text-gray-700 font-bold mt-2">Catégorie : {{ $produit->categorie }}</p>
                <h3 class="font-semibold text-lg text-gray-800">Description</h3>
                <p class="text-gray-700 mt-2">{{ $produit->description }}</p>
                <p class="mt-2 mb-2 font-bold italic {{ $produit->stock === 0 ? 'text-red-500 font-bold' : '' }}">
                    {{ $produit->stock === 0 ? 'Rupture de stock' : $produit->stock . ' produit(s) restant(s)' }}
                </p>
                <h3 class="font-semibold text-lg text-gray-800 mt-5 mb-5"> {{ number_format($produit->prix, 0, ',', '') }} FCFA</h3>
            </div>
        </div>

        <!-- Bouton Ajouter au panier visible seulement si l'utilisateur est connecté -->
        @if ($produit->stock !== 0)
            @auth
                @if(auth()->user()->role === 'client')
                    <form action="{{ route('panier.ajouter', $produit->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="mt-2 inline-block bg-brown-500 hover:bg-brown-600 text-white px-4 py-2 rounded-md text-center w-full">
                            <i class="fas fa-cart-plus"></i> Ajouter au panier
                        </button>
                    </form>
                @endif
            @endauth
        @endif
    </div>

@endsection
