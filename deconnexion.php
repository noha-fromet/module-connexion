<?php
// Démarre une session
session_start();

// Déconnecte l'utilisateur en supprimant les variables de session
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Déconnexion</title>
    <link rel="stylesheet" href="profil.css">
</head>
<body>
    <header>
        <img src="logo.png" alt="Logo du site">
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="connexion.php">Se connecter</a></li>
                <li><a href="inscription.php">Créer un compte</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Déconnexion</h1>

        <p>Vous avez été déconnecté avec succès.</p>
    </main>
</body>
</html>
