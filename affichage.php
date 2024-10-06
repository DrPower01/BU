<?php
// Connexion à la base de données MySQL
$host = 'localhost';
$dbname = 'bibliotheque';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Échec de la connexion : " . $e->getMessage());
}

// Récupérer toutes les transactions
$sql = "SELECT * FROM transactions";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Liste des Transactions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
        }

        nav.sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 200px;
            height: 100%;
            background-color: #333;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        nav.sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        nav.sidebar ul li {
            margin: 0;
        }

        nav.sidebar ul li a {
            display: block;
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
        }

        nav.sidebar ul li a:hover {
            background-color: #555;
        }

        .container {
            margin-left: 220px; /* Width of the sidebar + some margin */
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
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
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            margin: 20px;
            float: right; /* Align button to the right */
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <nav class="sidebar">
        <ul>
            <li><a href="modification.php">Modification</a></li>
            <li><a href="Servertemporaire.html">Prêt</a></li>
            <li><a href="affichage.php">Liste des livres</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1>Liste des Transactions</h1>

        <a href="export_excel.php" class="btn">Exporter en Excel</a>

        <table>
    <thead>
        <tr>
            <th>Nom de l'étudiant</th>
            <th>Matricule</th>
            <th>ISBN</th>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Date de Prêt</th>
            <th>Date de Retour</th>
            <th>Status</th>
            <th>Actions</th> <!-- Add this column for actions -->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?= htmlspecialchars($transaction['nom_etudiant']); ?></td>
                <td><?= htmlspecialchars($transaction['matricule_etudiant']); ?></td>
                <td><?= htmlspecialchars($transaction['isbn']); ?></td>
                <td><?= htmlspecialchars($transaction['titre_livre']); ?></td>
                <td><?= htmlspecialchars($transaction['auteur']); ?></td>
                <td><?= htmlspecialchars($transaction['date_pret']); ?></td>
                <td><?= htmlspecialchars($transaction['date_retour']); ?></td>
                <td><?= htmlspecialchars($transaction['status']); ?></td>
                <td>
                    <form action="delete_transaction.php" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $transaction['id']; ?>">
                        <button type="submit" class="btn delete-btn">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    </div>
</body>
</html>
