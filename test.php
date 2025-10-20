<?php
$host = 'localhost';
$db   = 'catalogue_pc';
$user = 'root';     // Par défaut en local
$pass = '';         // (souvent vide en local)

// Connexion MySQLi
$conn = new mysqli($host, $user, $pass, $db);

// Vérification de la connexion
if ($conn->connect_error) {
    die('Erreur de connexion à la base : ' . $conn->connect_error);
}
echo 'Connexion réussie !<br>';

// Insertion d'un PC dans la table "catalogue_pc"
$sql = "INSERT INTO catalogue_pc (nom, cpu, gpu, ram, prix) 
        VALUES ('PC Gamer Fighter', 'Intel Core i5', 'RTX 5060 Ti', '16 Go', 1349.90)";
if ($conn->query($sql) === TRUE) {
    echo "Nouvel ordinateur ajouté !<br>";
} else {
    echo "Erreur lors de l'ajout : " . $conn->error . "<br>";
}

// Récupération de tous les PC enregistrés
$result = $conn->query("SELECT * FROM catalogue_pc");
while($row = $result->fetch_assoc()) {
    echo $row['nom'] . ' - ' . $row['prix'] . ' €<br>';
}

// Fermeture de la connexion
$conn->close();
?>
