<x-app-layout>
    <x-slot name="header">
        <div class="bg-blue-700 text-white p-6 rounded-lg shadow-lg text-center">
            <h2 class="text-2xl font-bold">
                {{ __('📊 Tableau de Bord - Gestionnaire') }}
            </h2>
        </div>
    </x-slot>

    @include('menu')

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <!-- Section des statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Commandes du jour -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-700 p-6 rounded-xl shadow-lg text-white text-center">
                    <h3 class="text-lg font-semibold">📦 Commandes du jour</h3>
                    <p class="text-5xl font-extrabold mt-2">{{ $nombreCommandesDuJour }}</p>
                </div>

                <!-- Commandes payées -->
                <div class="bg-gradient-to-br from-green-500 to-green-700 p-6 rounded-xl shadow-lg text-white text-center">
                    <h3 class="text-lg font-semibold">💰 Commandes payées</h3>
                    <p class="text-5xl font-extrabold mt-2">{{ $nombreCommandesPayees }}</p>
                </div>

                <!-- Recettes journalières -->
                <div class="bg-gradient-to-br from-yellow-500 to-orange-600 p-6 rounded-xl shadow-lg text-white text-center">
                    <h3 class="text-lg font-semibold">💵 Recettes journalières</h3>
                    <p class="text-5xl font-extrabold mt-2">{{ number_format($recettesJournalieres, 0, ',', ' ') }} FCFA</p>
                </div>
            </div>

            <!-- Section des Graphiques -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
                <!-- Graphique Commandes par Mois -->
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-800">📊 Commandes par mois</h3>
                    <canvas id="chartCommandes" class="mt-4"></canvas>
                </div>

                <!-- Graphique Produits par Catégorie -->
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-800">📊 Produits vendus par catégorie</h3>
                    <canvas id="chartProduitsParCategorie" class="mt-4"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('chartCommandes').getContext('2d');
        var chartCommandes = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($moisLabels),
                datasets: [{
                    label: 'Nombre de commandes par mois',
                    data: @json($commandesData),
                    backgroundColor: 'rgba(30, 144, 255, 0.6)',
                    borderColor: 'rgba(30, 144, 255, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        var ctxProduits = document.getElementById('chartProduitsParCategorie').getContext('2d');
        var chartProduitsParCategorie = new Chart(ctxProduits, {
            type: 'line',
            data: {
                labels: @json($moisLabel),
                datasets: [
                    {
                        label: 'Burgers',
                        data: @json($chartData['Burgers']),
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.3)',
                        fill: true
                    },

                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</x-app-layout>
