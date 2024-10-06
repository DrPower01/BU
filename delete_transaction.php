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

// Vérifier si l'ID est passé
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Requête pour supprimer la transaction
    $sql = "DELETE FROM transactions WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    // Rediriger vers la page de liste des transactions après la suppression
    header("Location: affichage.php");
    exit();
} else {
    echo "ID non fourni.";
}
?>
