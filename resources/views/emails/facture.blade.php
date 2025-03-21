<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre facture - Commande #{{ $commande->id }}</title>
</head>
<body>
    <h1>Bonjour {{ $commande->user->name }}</h1>
    <p>Votre commande #{{ $commande->id }} est prête et nous avons généré la facture associée.</p>
    <p>Vous pouvez la télécharger en pièce jointe.</p>
    <p>Cordialement, <br> L'équipe ISI BURGER</p>
</body>
</html>