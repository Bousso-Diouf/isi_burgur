<!-- En-tête avec logo et boutons -->
<div class="flex justify-between items-center mb-6 m-3">
    <!-- Logo cliquable -->
    <div>
        <a href="{{ url('/') }}">
            <x-application-logo class="w-20 h-20" />
        </a>
    </div>

    <!-- Boutons Connexion / Inscription ou Profil / Déconnexion -->
    <div class="flex space-x-4">
        @guest
            <!-- Boutons visibles si l'utilisateur n'est pas connecté -->
            <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100">
                Connexion
            </a>
            <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Inscription
            </a>
        @else
            <!-- Icône Panier avec nombre -->
            <div class="relative">
                @auth
                    @if(auth()->user()->role === 'client')
                        <a href="{{ route('panier.index') }}">
                            <!-- Icône Panier -->
                            <i class="fas fa-shopping-cart text-2xl text-gray-800"></i>
                            <!-- Badge du nombre d'articles -->
                            @php
                                $panier = session()->get('panier', []);
                                $quantiteTotal = array_sum(array_column($panier, 'quantite'));
                            @endphp
                            @if($quantiteTotal > 0)
                                <span class="absolute top-1/2 left-1/2 -translate-x-1/9 -translate-y-1/4 text-xs bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center">{{ $quantiteTotal }}</span>
                            @endif
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Boutons visibles si l'utilisateur est connecté -->
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                Profil <i class="fas fa-user"></i>
            </a>

            <!-- Formulaire de déconnexion -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-black text-2xl hover:text-gray-700 transition duration-300">
                    <i class="fas fa-sign-out-alt"></i> <!-- Icône de déconnexion -->
                </button>
            </form>
        @endguest
    </div>
</div>
