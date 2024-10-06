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

// Requête SQL pour récupérer toutes les transactions
$sql = "SELECT id, nom_etudiant, matricule_etudiant, isbn, titre_livre, auteur, status, date_pret, date_retour FROM transactions";
$stmt = $pdo->query($sql);
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
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
            padding: 5px 10px;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px; /* Added border-radius for buttons */
            transition: background-color 0.3s; /* Smooth transition */
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
        <h2>Modification</h2>

        <table>
            <thead>
                <tr>
                    <th>Nom de l'étudiant</th>
                    <th>Matricule</th>
                    <th>ISBN</th>
                    <th>Titre du livre</th>
                    <th>Auteur</th>
                    <th>Statut</th>
                    <th>Date de prêt</th>
                    <th>Date de retour</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction): ?>
                <tr>
                    <td><?php echo htmlspecialchars($transaction['nom_etudiant']); ?></td>
                    <td><?php echo htmlspecialchars($transaction['matricule_etudiant']); ?></td>
                    <td><?php echo htmlspecialchars($transaction['isbn']); ?></td>
                    <td><?php echo htmlspecialchars($transaction['titre_livre']); ?></td>
                    <td><?php echo htmlspecialchars($transaction['auteur']); ?></td>
                    <td>
                        <form action="update_status.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $transaction['id']; ?>">
                            <select name="status">
                                <option value="pret" <?php echo ($transaction['status'] == 'pret') ? 'selected' : ''; ?>>Prêt</option>
                                <option value="rendu" <?php echo ($transaction['status'] == 'rendu') ? 'selected' : ''; ?>>Rendu</option>
                            </select>
                            <button type="submit" class="btn">Modifier</button>
                        </form>
                    </td>
                    <td><?php echo htmlspecialchars($transaction['date_pret']); ?></td>
                    <td><?php echo htmlspecialchars($transaction['date_retour']); ?></td>
                    <td><a href="edit_transaction.php?id=<?php echo $transaction['id']; ?>" class="btn">Modifier</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
