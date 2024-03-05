<?php
require_once "connexion_bdd.php";
?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="media/css/inscription.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
  <script src="media/js/inscription.js" defer></script>
  <title>Inscription - Connexion</title>
</head>

<body>
    <div class="container">
    <div class="logo">
      <i class="fas fa-user"></i>
    </div>

    <div class="tab-body" data-id="connexion">
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="row">
          <i class="far fa-user"></i>
          <input type="email" class="input" placeholder="Adresse Mail" name="email">
        </div>
        <div class="row">
          <i class="fas fa-lock"></i>
          <input placeholder="Mot de Passe" type="password" class="input" name="mot_de_passe">
        </div>
        <a href="#" class="link">Mot de passe oublié ?</a>
        <button class="btn" type="submit">Connexion</button>
      </form>
    </div>

    <div class="tab-body" data-id="inscription">
      <form id="inscriptionForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="row">
          <i class="far fa-user"></i>
          <input type="email" class="input" placeholder="Adresse Mail" name="email">
        </div>
        <div class="row">
          <i class="fas fa-lock"></i>
          <input type="password" class="input" placeholder="Mot de Passe" name="mot_de_passe">
        </div>
        <button class="btn" type="submit">Inscription</button>
      </form>
    </div>

    <div class="tab-footer">
      <a class="tab-link active" data-ref="connexion" href="javascript:void(0)">Connexion</a>
      <a class="tab-link" data-ref="inscription" href="javascript:void(0)">Inscription</a>
      <a class="tab-link" data-ref="accueil" href="index.php">Accueil</a>
    </div>
  </div>
</body>
</html>

<?php

/********************* INSCRIPTION ******************************/

// Vérifier si le formulaire d'inscription a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $mot_de_passe = password_hash($_POST["mot_de_passe"], PASSWORD_DEFAULT);

  
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "cours_cybersecu";

  try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     
      $sql = "INSERT INTO utilisateurs (email, mot_de_passe) VALUES (:email, :mot_de_passe)";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':mot_de_passe', $mot_de_passe);
      $stmt->execute();

      echo "Inscription réussie !";
  } catch(PDOException $e) {
      echo "Erreur : " . $e->getMessage();
  }

  $conn = null;
}

/***************************** CONNEXION ***************************/

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['connexion'])) {
  $email = $_POST["email"];
  $mot_de_passe = $_POST["mot_de_passe"];

  try {
      // Requête pour sélectionner l'utilisateur correspondant à l'email donné
      $sql = "SELECT * FROM utilisateurs WHERE email = :email";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':email', $email);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user) {
          // Vérifier si le mot de passe est correct
          if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
              echo "Connexion réussie!";
              // Vous pouvez également rediriger l'utilisateur vers une autre page ici
          } else {
              echo "Mot de passe incorrect.";
          }
      } else {
          echo "Utilisateur non trouvé.";
      }
  } catch(PDOException $e) {
      echo "Erreur : " . $e->getMessage();
  }
}

$conn = null;
?>