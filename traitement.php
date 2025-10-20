<?php
$nom = trim($_POST["nom"]);
$email = trim($_POST["email"]);
$message = trim($_POST["message"]);
$sujet = trim($_POST["sujet"]);
$tel = trim($_POST["tel"]); // Ajouté
$erreurs = [];
if ($nom === "") {
    $erreurs[] = "Le nom est obligatoire.";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erreurs[] = "Adresse e-mail invalide.";
}
if (strlen($message) < 10) {
    $erreurs[] = "Le message est trop court (10 caractères minimum).";
}
if ($tel === "") { // Vérification ajoutée
    $erreurs[] = "Le téléphone est obligatoire.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Résultat</title></head>
<body>
<?php if (!empty($erreurs)) : ?>
<h2>■ Erreurs :</h2>
<ul>
<?php foreach ($erreurs as $err) : ?>
<li><?php echo htmlspecialchars($err); ?></li>
<?php endforeach; ?>
</ul>
<?php else : ?>
<h2>■ Message bien reçu :</h2>
<p><strong>Nom :</strong> <?php echo htmlspecialchars($nom); ?></p>
<p><strong>Email :</strong> <?php echo htmlspecialchars($email); ?></p>
<p><strong>Sujet :</strong> <?php echo nl2br(htmlspecialchars($sujet)); ?></p>
<p><strong>Message :</strong> <?php echo nl2br(htmlspecialchars($message)); ?></p>
<p><strong>Téléphone :</strong> <?php echo nl2br(htmlspecialchars($tel)); ?></p>
<?php endif; ?>
</body></html>

<style>
body { font-family: Arial, Helvetica, sans-serif; margin: 2em; }
h1, h2 { color: #1e3a8a; }
ul { color: #b91c1c; }
p { background: #f8fafc; padding: 10px; border-radius: 8px; }
</style>



<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les champs
    $nom     = $_POST['nom'];
    $email   = $_POST['email'];
    $tel     = $_POST['tel'];
    $sujet   = $_POST['sujet'];
    $message = $_POST['message'];

    // Connexion MySQL
    $host = 'localhost';
    $db   = 'formulaire'; // adapte si ta base a un autre nom
    $user = 'root';
    $pass = '';

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die('Erreur connexion base : ' . $conn->connect_error);
    }

    // Échapper pour la sécurité
    $nom     = $conn->real_escape_string($nom);
    $email   = $conn->real_escape_string($email);
    $tel     = $conn->real_escape_string($tel);
    $sujet   = $conn->real_escape_string($sujet);
    $message = $conn->real_escape_string($message);

    // Insertion dans la base
    $sql = "INSERT INTO contacts (nom, email, tel, sujet, message) 
            VALUES ('$nom', '$email', '$tel', '$sujet', '$message')";
    if ($conn->query($sql) === TRUE) {
        echo "Votre message a été enregistré ! Merci.";
    } else {
        echo "Erreur d'enregistrement : " . $conn->error;
    }
    $conn->close();
} else {
    echo "Accès non autorisé.";
}
?>
