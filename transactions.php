<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Transactions</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your external CSS file -->
    <!-- Optional: Include Bootstrap for styling (uncomment if needed) -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
</head>
<body>
    <nav class="sidebar">
        <ul>
            <li><a href="transaction.php">Modification</a></li>
            <li><a href="fetchbook.php">Pret</a></li>
            <li><a href="affichage.php">Liste des livres</a></li>
        </ul>
    </nav>

    <div class="content">
        <div class="container">
            <h1>Liste des Transactions</h1>

            <a href="export_excel.php" class="btn">Exporter en Excel</a>

            <table>
                <thead>
                    <tr>
                        <th>Matricule</th>
                        <th>ISBN</th>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Date de Prêt</th>
                        <th>Date de Retour</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $transaction): ?>
                        <tr>
                            <td><?= htmlspecialchars($transaction['matricule_etudiant']); ?></td>
                            <td><?= htmlspecialchars($transaction['isbn']); ?></td>
                            <td><?= htmlspecialchars($transaction['titre_livre']); ?></td>
                            <td><?= htmlspecialchars($transaction['auteur']); ?></td>
                            <td><?= htmlspecialchars($transaction['date_pret']); ?></td>
                            <td><?= htmlspecialchars($transaction['date_retour']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
