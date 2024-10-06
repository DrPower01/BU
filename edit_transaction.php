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

// Vérifier si l'ID de la transaction est passé dans l'URL
if (!isset($_GET['id'])) {
    die("ID de transaction non spécifié.");
}

$id = $_GET['id'];

// Récupérer les données de la transaction
$sql = "SELECT * FROM transactions WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$transaction = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$transaction) {
    die("Transaction non trouvée.");
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Transaction</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .form-container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Modifier Transaction</h2>
    <form action="update_transaction.php" method="post">
        <input type="hidden" name="id" value="<?php echo $transaction['id']; ?>">

        <div class="form-group">
            <label for="nom_etudiant">Nom de l'étudiant</label>
            <input type="text" name="nom_etudiant" id="nom_etudiant" value="<?php echo htmlspecialchars($transaction['nom_etudiant']); ?>" required>
        </div>

        <div class="form-group">
            <label for="matricule_etudiant">Matricule</label>
            <input type="text" name="matricule_etudiant" id="matricule_etudiant" value="<?php echo htmlspecialchars($transaction['matricule_etudiant']); ?>" required>
        </div>

        <div class="form-group">
            <label for="isbn">ISBN</label>
            <input type="text" name="isbn" id="isbn" value="<?php echo htmlspecialchars($transaction['isbn']); ?>" required>
        </div>

        <div class="form-group">
            <label for="titre_livre">Titre du livre</label>
            <input type="text" name="titre_livre" id="titre_livre" value="<?php echo htmlspecialchars($transaction['titre_livre']); ?>" required>
        </div>

        <div class="form-group">
            <label for="auteur">Auteur</label>
            <input type="text" name="auteur" id="auteur" value="<?php echo htmlspecialchars($transaction['auteur']); ?>" required>
        </div>

        <div class="form-group">
            <label for="status">Statut</label>
            <select name="status" id="status">
                <option value="pret" <?php echo ($transaction['status'] == 'pret') ? 'selected' : ''; ?>>Prêt</option>
                <option value="rendu" <?php echo ($transaction['status'] == 'rendu') ? 'selected' : ''; ?>>Rendu</option>
            </select>
        </div>

        <div class="form-group">
            <label for="date_pret">Date de prêt</label>
            <input type="date" name="date_pret" id="date_pret" value="<?php echo htmlspecialchars($transaction['date_pret']); ?>" required>
        </div>

        <div class="form-group">
            <label for="date_retour">Date de retour</label>
            <input type="date" name="date_retour" id="date_retour" value="<?php echo htmlspecialchars($transaction['date_retour']); ?>" required>
        </div>

        <button type="submit" class="btn">Mettre à jour</button>
    </form>
</div>

</body>
</html>
