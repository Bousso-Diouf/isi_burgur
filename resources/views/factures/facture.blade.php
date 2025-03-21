<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture #{{ $commande->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .logo {
            width: 100px;
            display: block;
            margin: auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .info, .summary {
            margin-bottom: 20px;
        }

        .info p, .summary p {
            font-size: 16px;
            margin: 5px 0;
        }

        .info p strong, .summary p strong {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-size: 16px;
        }

        td {
            font-size: 14px;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>
<body>

    <div class="container">
        
        <!-- LOGO + NOM ISI BURGER -->
        <div class="header">
            <img src="{{ public_path('logo.png') }}" alt="ISI Burger Logo" class="logo">
            <h3>ISI BURGER</h3>
        </div>

        <h1>Facture #{{ $commande->id }}</h1>

        <div class="info">
            <p><strong>Client :</strong> {{ $commande->user->name }}</p>
            <p><strong>Total :</strong> {{ number_format($commande->total, 0, ',', ' ') }} FCFA</p>
            <p><strong>Date de commande :</strong> {{ $commande->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <h3>Produits commandés</h3>
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($commande->produits as $produit)
                    <tr>
                        <td>{{ $produit->nom }}</td>
                        <td>{{ $produit->pivot->quantite }}</td>
                        <td>{{ number_format($produit->pivot->prix, 0, ',', ' ') }} FCFA</td>
                        <td>{{ number_format($produit->pivot->total, 0, ',', ' ') }} FCFA</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            <p><strong>Total à payer : {{ number_format($commande->total, 0, ',', ' ') }} FCFA</strong></p>
        </div>

        <div class="footer">
            <p>Merci pour votre commande !</p>
        </div>
    </div>

</body>
</html>