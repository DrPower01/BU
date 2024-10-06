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

// Récupérer les données du formulaire
$nom = $_POST['nom'];
$matricule = $_POST['matricule'];
$isbn = $_POST['isbn'];
$date_pret = $_POST['date_pret'];
$date_retour = $_POST['date_retour'];
$status = $_POST['status'];

// Appel à l'API Google Books pour obtenir les informations sur le livre
$google_books_api_url = "https://www.googleapis.com/books/v1/volumes?q=isbn:$isbn";
$response = file_get_contents($google_books_api_url);
$book_data = json_decode($response, true);

if (isset($book_data['items'][0])) {
    $book_info = $book_data['items'][0]['volumeInfo'];

    // Extraire les informations du livre
    $titre_livre = $book_info['title'];
    $auteur = isset($book_info['authors']) ? implode(', ', $book_info['authors']) : 'Inconnu';

    // Insérer les informations dans la base de données
    $sql = "INSERT INTO transactions (matricule_etudiant, isbn, titre_livre, auteur, nom_etudiant, status, date_pret, date_retour)
            VALUES (:matricule_etudiant, :isbn, :titre_livre, :auteur, :nom_etudiant, :status, :date_pret, :date_retour)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':matricule_etudiant' => $matricule,
        ':isbn' => $isbn,
        ':titre_livre' => $titre_livre,
        ':auteur' => $auteur,
        ':nom_etudiant' => $nom,
        ':status' => $status,
        ':date_pret' => $date_pret,
        ':date_retour' => $date_retour
    ]);

    echo "<h2>Informations du livre ajoutées à la base de données :</h2>";
    echo "Nom de l'étudiant : $nom<br>";
    echo "Matricule : $matricule<br>";
    echo "Titre : $titre_livre<br>";
    echo "Auteur : $auteur<br>";
    echo "ISBN : $isbn<br>";
    echo "Date de prêt : $date_pret<br>";
    echo "Date de retour : $date_retour<br>";
} else {
    echo "Livre non trouvé pour l'ISBN $isbn.";
}
?>

<!-- Button to go to affichage.php -->
<a href="affichage.php" class="btn">Voir la liste des transactions</a>

<style>
    .btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        margin-top: 20px; /* Add some space above the button */
    }

    .btn:hover {
        background-color: #0056b3;
    }
</style>
