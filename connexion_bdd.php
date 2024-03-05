<?php
// Connexion à la base de données
$serveur = "localhost"; // Adresse du serveur MySQL (généralement localhost)
$utilisateur = "root"; // Nom d'utilisateur MySQL
$motdepasse = "0000"; // Mot de passe MySQL
$base_de_donnees = "cours_cybersecu"; // Nom de la base de données

// Création de la connexion
$connexion = new mysqli($serveur, $utilisateur, $motdepasse, $base_de_donnees);

// Vérifier la connexion
if ($connexion->connect_error) {
    die("Connexion échouée: " . $connexion->connect_error);
}

// Vérifier si le formulaire d'inscription a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['inscription'])) {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Préparer et exécuter la requête d'insertion
    $requete = $connexion->prepare("INSERT INTO utilisateurs (email, mot_de_passe) VALUES (?, ?)");
    $requete->bind_param("ss", $email, $mot_de_passe);

    if ($requete->execute()) {
        echo "Inscription réussie!";
    } else {
        echo "Erreur lors de l'inscription: " . $connexion->error;
    }

    // Fermer la requête
    $requete->close();
}

// Fermer la connexion
$connexion->close();