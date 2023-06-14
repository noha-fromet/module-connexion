<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <link rel="stylesheet" href="inscription.css">
</head>
<body>
    <header>
        <img src="logo.png" alt="Logo du site">
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="connexion.php">Se connecter</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Création de compte</h1>
<?php
// Démarre une session
session_start();
// Vérifie si le formulaire a été soumis
if (isset($_POST['login']) && isset($_POST['email']) && isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['password']) && isset($_POST['password_confirm'])) {
    // Récupère les données du formulaire
    $login = $_POST['login'];
    $email = $_POST['email'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Valide les données saisies par l'utilisateur
    if (empty($login) || empty($email) || empty($prenom) || empty($nom) || empty($password) || empty($password_confirm)) {
        // Les champs sont vides, affiche un message d'erreur
        echo "Tous les champs sont requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // L'adresse e-mail n'est pas valide, affiche un message d'erreur
        echo "L'adresse e-mail saisie n'est pas valide.";
    } elseif ($password != $password_confirm) {
        // Les mots de passe ne correspondent pas, affiche un message d'erreur
        echo "Les mots de passe ne correspondent pas.";
    } else {
        // Les données sont valides, nettoie les données saisies par l'utilisateur
        $login = htmlspecialchars($login);
        $email = htmlspecialchars($email);
        $prenom = htmlspecialchars($prenom);
        $nom = htmlspecialchars($nom);

        // Établit une connexion à la base de données
        $conn = new mysqli('localhost', 'root', '', 'moduleconnexion');

        // Vérifie si la connexion a réussi
        if ($conn->connect_error) {
            die("La connexion à la base de données a échoué: " . $conn->connect_error);
        }

        // Prépare une requête SQL pour insérer les données dans la table "utilisateurs"
        $stmt = $conn->prepare("INSERT INTO utilisateurs (login, email, prenom, nom, password) VALUES (?, ?, ?, ?, ?)");
        if ($stmt === false) {
            exit('Failed to prepare SQL query: ' . $conn->error);
        }

        // Hachage du mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Liaison des paramètres
        $stmt->bind_param("sssss", $login, $email, $prenom, $nom, $hashed_password);

        // Exécution de la requête
        if ($stmt->execute()) {
            // Les données ont été insérées avec succès, redirige l'utilisateur vers la page de connexion
            header("Location: connexion.php");
            exit;
        } else {
            // Une erreur s'est produite lors de l'insertion des données, affiche un message d'erreur
            echo "Une erreur s'est produite lors de l'inscription. Veuillez réessayer. Erreur: " . htmlspecialchars($stmt->error);
        }

        // Ferme la requête préparée et la connexion à la base de données
        $stmt->close();
        $conn->close();
    }
}
?>

            <form action="inscription.php" method="post">

            <label for="login">Login :</label>
            <input type="text" name="login" id="login" required>

            <label for="email">Email :</label>
            <input type="email" name="email" id="email" required>

            <label for="prenom">Prénom :</label>
            <input type="text" name="prenom" id="prenom" required>

            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" required>

            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>

            <label for="password_confirm">Confirmation du mot de passe :</label>
            <input type="password" name="password_confirm" id="password_confirm" required>

            <input type="submit" value="Créer">
        </form>
    </main>
</body>
</html>
