<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="media/css/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css" integrity="sha384-BY+fdrpOd3gfeRvTSMT+VUZmA728cfF9Z2G42xpaRkUGu2i3DyzpTURDo5A6CaLK" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Les retards de la SNCF</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Les Retards SNCF</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" href="#">Les derniers retards</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" href="inscription.php">Inscription - Connexion</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <section class="section_retard">
            <h2>Retards actuels</h2>
            <p>Voici les dernières informations sur les retards actuels :</p>
            <?php
                // Simulation de retards (à remplacer par des données réelles)
                $retards = [
                    ['Train 1234', 'Paris - Marseille', '20 minutes'],
                    ['Train 5678', 'Lyon - Bordeaux', '30 minutes'],
                    ['Train 9101', 'Lille - Toulouse', '45 minutes']
                ];

                // Affichage des retards
                foreach ($retards as $retard) {
                    echo "<p>{$retard[0]} de {$retard[1]} avec un retard de {$retard[2]}.</p>";
                }
            ?>
        </section>
        <section class="section_causes">
            <h2>Causes probables</h2>
            <p>Les retards peuvent être causés par divers facteurs, tels que :</p>
            <ul>
                <li>Mauvaises conditions météorologiques</li>
                <li>Problèmes techniques</li>
                <li>Grèves</li>
                <li>Travaux sur les voies</li>
                <li>Surcharge de trafic</li>
            </ul>
        </section>
        <section class="section_contact">
            <h2>Contact</h2>
            <p>Si vous avez des questions ou des préoccupations, vous pouvez contacter le service client de la SNCF :</p>
            <ul>
                <li>Téléphone : 01 23 45 67 89</li>
                <li>Email : serviceclient@sncf.fr</li>
            </ul>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Les retards de la SNCF. Tous droits réservés.</p>
    </footer>
</body>
</html>
