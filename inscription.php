<?php
session_start();

if (!isset($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // génération du token
}

?>

<html lang="fr">

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
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <a href="#" class="link">Mot de passe oublie ?</a>
        <button class="btn" type="submit" name="connexion">Connexion</button>
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
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <button class="btn" type="submit" name="inscription">Inscription</button>
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['inscription'])) {
  // vérifier si le token CSRF est présent et correspond à celui stocké coté serveur
  if (!empty($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];

    $salt = bin2hex(random_bytes(16)); // génération d'un salt aléatoire
    $mot_de_passe_sale = $mot_de_passe . $salt; // création du mot de passe salé
    $mot_de_passe_hashe = password_hash($mot_de_passe_sale, PASSWORD_BCRYPT); //hachage du mdp salé

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cours_cybersecu";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // var_dump($mot_de_passe_hashe);
        // exit;
        $sql = "INSERT INTO utilisateurs (email, mot_de_passe) VALUES (:email, :mot_de_passe_hashe)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mot_de_passe_hashe', $mot_de_passe_hashe);
        $stmt->execute();

        // echo "Inscription reussie !";
        // message inutile puisque ça redirige mais je le garde pour voir ou est l'inscription réussie:)
        header("location: http://localhost/Mars/cours_cybersecu/html/inscription_reussie.html");
        exit;
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }else{
    echo "Tentative de CSRF détectée lors de l'inscription.";
    exit;
  }
}

/***************************** CONNEXION ***************************/

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['connexion'])) {
  // vérifier si le token CSRF est présent et correspond à celui stocké coté serveur
  if (!empty($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
      $email = $_POST["email"];
      $mot_de_passe = $_POST["mot_de_passe"];

      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "cours_cybersecu";

      try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          // requete pour selectionner l'utilisateur correspondant à l'email donné
          $sql = "SELECT * FROM utilisateurs WHERE email = :email";
          $stmt = $conn->prepare($sql);
          $stmt->bindParam(':email', $email);
          $stmt->execute();
          $user = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($user) {
              // Creer le mdp salé avec le salt de l'utilisateur
              // $mot_de_passe_sale = $mot_de_passe . $user['salt'];

              // vérifier si le mdp est correct
              if (password_verify($mot_de_passe, $user['mot_de_passe'])) { // $mot_de_passe_sale ??
                  // echo "Connexion reussie!";
                  // message inutile puisque ça redirige mais je le garde pour voir ou est la connexion réussie:)
                  header("location: http://localhost/Mars/cours_cybersecu/html/connexion_reussie.html"); // redirige vers index.php quand la connexion est réussie
                  exit;
              } else {
                  echo "Mot de passe incorrect.";
              }
          } else {
              echo "Utilisateur non trouvé.";
          }
      } catch(PDOException $e) {
          echo "Erreur : " . $e->getMessage();
      }
      $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  } else {
      echo "Tentative de CSRF détectée lors de la connexion.";
      exit;
  }
}

// génère et stocke un nouveau token
// $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>