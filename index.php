<?php
// Démarre une session
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Page d'accueil</title>
  <link rel="stylesheet" href="index.css">
</head>
<body>
<header>
<img src="logo.png" alt="Logo du site">
        <nav>
            <ul>
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == '1'): ?>
                    <li><a href="admin.php">Administration</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profil.php">Profil</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="deconnexion.php">Se déconnecter</a></li>
                <?php endif; ?>

            </ul>
        </nav>
    </header>
  <div class="container">
    <h1>Bienvenue sur notre site</h1>
    <p>Découvrez notre module de connexion</p>
    <div class="button-container">
      <a href="inscription.php" class="button">Inscription</a>
      <a href="connexion.php" class="button">Connexion</a>
    </div>
  </div>
</body>
</html>
