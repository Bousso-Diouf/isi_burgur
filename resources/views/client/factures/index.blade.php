<x-app-layout>

    <!-- MENU -->
    @include('menu')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Mes Factures</h2>

                @if ($factures->isEmpty())
                    <p class="text-gray-500">Vous n'avez pas encore de factures.</p>
                @else
                    <div class="bg-white p-6 shadow-lg rounded-lg overflow-hidden">
                        <table class="w-full table-auto text-sm text-left">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700">
                                    <th class="p-3 font-semibold text-left">Commande ID</th>
                                    <th class="p-3 font-semibold text-left">Montant Total</th>
                                    <th class="p-3 font-semibold text-left">Date d'Émission</th>
                                    <th class="p-3 font-semibold text-left">Télécharger</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($factures as $facture)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="p-3 text-gray-800">{{ $facture->commande_id }}</td>
                                        <td class="p-3 text-gray-800">{{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA</td>
                                        <td class="p-3 text-gray-800">{{ $facture->date_emission->format('d/m/Y') }}</td>
                                        <td class="p-3">
                                            <a href="{{ asset($facture->facture_path) }}" target="_blank" 
                                            class="text-blue-500 hover:text-blue-600 font-medium">
                                                Télécharger la facture
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>