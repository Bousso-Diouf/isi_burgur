<x-alert />

@if(auth()->user()->role === 'client')
    <nav class="bg-blue-600 text-white p-4 shadow-lg">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ route('client.dashboard') }}" class="px-6 py-3 hover:bg-blue-500 rounded-lg transition duration-300 transform hover:scale-105">
                Accueil
            </a>
            <a href="{{ route('panier.index') }}" class="px-6 py-3 hover:bg-blue-500 rounded-lg transition duration-300 transform hover:scale-105">
                Panier
            </a>
            <a href="{{ route('client.commandes') }}" class="px-6 py-3 hover:bg-blue-500 rounded-lg transition duration-300 transform hover:scale-105">
                Mes Commandes
            </a>
            <a href="{{ route('client.factures') }}" class="px-6 py-3 hover:bg-blue-500 rounded-lg transition duration-300 transform hover:scale-105">
                Factures
            </a> <!-- Lien vers les factures -->
        </div>
    </nav>
@elseif (auth()->user()->role === 'gestionnaire')
    <nav class="bg-gray-800 text-white p-4 shadow-lg">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ route('gestionnaire.dashboard') }}" class="px-6 py-3 hover:bg-gray-700 rounded-lg transition duration-300 transform hover:scale-105">
                Dashboard
            </a>
            <a href="{{ route('gestionnaire.produits.index') }}" class="px-6 py-3 hover:bg-gray-700 rounded-lg transition duration-300 transform hover:scale-105">
                Produits
            </a>
            <a href="{{ route('gestionnaire.commandes.index') }}" class="px-6 py-3 hover:bg-gray-700 rounded-lg transition duration-300 transform hover:scale-105">
                Commandes
            </a>
            <!-- <a href="{{ route('gestionnaire.factures.index') }}" class="px-6 py-3 hover:bg-gray-700 rounded-lg transition duration-300 transform hover:scale-105">Factures</a> -->
            <!-- <a href="#" class="px-6 py-3 hover:bg-gray-700 rounded-lg transition duration-300 transform hover:scale-105">Paramètres</a> -->
        </div>
    </nav>
@endif
