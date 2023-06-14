<?php
// Démarre une session
session_start();

// Vérifie si l'utilisateur est connecté et s'il est l'utilisateur "admin"
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != '1') {
    // L'utilisateur n'est pas connecté ou n'est pas l'utilisateur "admin", le redirige vers la page de connexion
    header("Location: connexion.php");
    exit;
}

// Établit une connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'moduleconnexion');

// Vérifie si la connexion a réussi
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Page d'administration</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
<header>
<img src="logo.png" alt="Logo du site">
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <?php if (isset($_SESSION['login']) && $_SESSION['login'] == 'admin'): ?>
                    <li><a href="admin.php">Administration</a></li>
                <?php endif; ?>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="deconnexion.php">Se déconnecter</a></li>
            </ul>
        </nav>
    </header>
  <div class="container">
    <h1>Liste des utilisateurs</h1>
    <?php
    // Exécute une requête SQL pour récupérer toutes les informations des utilisateurs
    $result = $conn->query("SELECT * FROM utilisateurs");

    // Vérifie si des utilisateurs ont été trouvés
    if ($result->num_rows > 0) {
        // Des utilisateurs ont été trouvés, affiche leurs informations
        echo "<table>";
        echo "<tr><th>ID</th><th>Login</th><th>Email</th><th>Prénom</th><th>Nom</th></tr>";
        while ($user = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($user['id']) . "</td>";
            echo "<td>" . htmlspecialchars($user['login']) . "</td>";
            echo "<td>" . htmlspecialchars($user['email']) . "</td>";
            echo "<td>" . htmlspecialchars($user['prenom']) . "</td>";
            echo "<td>" . htmlspecialchars($user['nom']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        // Aucun utilisateur n'a été trouvé, affiche un message d'erreur
        echo "<p>Aucun utilisateur trouvé.</p>";
    }

    // Ferme la connexion à la base de données
    $conn->close();
    ?>
  </div>
</body>
</html>