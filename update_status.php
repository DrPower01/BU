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

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Préparer et exécuter la requête SQL pour mettre à jour le statut
    $sql = "UPDATE transactions SET status = :status WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['status' => $status, 'id' => $id]);

    // Redirection vers la page des transactions après mise à jour
    header("Location: transactions.php");
    exit;
} else {
    // Si la méthode n'est pas POST, rediriger vers la page des transactions
    header("Location: transactions.php");
    exit;
}
?>
