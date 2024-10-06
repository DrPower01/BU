<?php
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

// Fetch all transactions
$sql = "SELECT * FROM transactions";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Set headers to download file
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=transactions.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Print table headers
echo "Matricule\tISBN\tTitre\tAuteur\tDescription\tDate de Prêt\tDate de Retour\n";

// Print table rows
foreach ($transactions as $transaction) {
    echo $transaction['matricule_etudiant'] . "\t" .
         $transaction['isbn'] . "\t" .
         $transaction['titre_livre'] . "\t" .
         $transaction['auteur'] . "\t" .
         $transaction['description'] . "\t" .
         $transaction['date_pret'] . "\t" .
         $transaction['date_retour'] . "\n";
}
?>
