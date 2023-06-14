<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <link rel="stylesheet" href="connexion.css">
</head>
<body>
    <header>
        <img src="logo.png" alt="Logo du site">
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="inscription.php">Créer un compte</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Connexion</h1>
        <?php

// Vérifie si le formulaire a été soumis
if (isset($_POST['login']) && isset($_POST['password'])) {
    // Récupère les données du formulaire
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Valide les données saisies par l'utilisateur
    if (empty($login) || empty($password)) {
        // Les champs sont vides, affiche un message d'erreur
        echo "<p>Tous les champs sont requis.</p>";
    } else {
        // Les données sont valides, nettoie les données saisies par l'utilisateur
        $login = htmlspecialchars($login);

        // Établit une connexion à la base de données
        $conn = new mysqli('localhost', 'root', '', 'moduleconnexion');

        // Vérifie si la connexion a réussi
        if ($conn->connect_error) {
            die("La connexion à la base de données a échoué: " . $conn->connect_error);
        }

        // Prépare une requête SQL pour récupérer l'utilisateur avec le login saisi
        $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE login = ?");
        $stmt->bind_param("s", $login);

        // Exécute la requête
        $stmt->execute();

        // Récupère le résultat de la requête
        $result = $stmt->get_result();

        // Vérifie si un utilisateur a été trouvé
        if ($result->num_rows > 0) {
            // Un utilisateur a été trouvé, vérifie si le mot de passe saisi est correct
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Le mot de passe est correct, crée une session pour l'utilisateur et le redirige vers la page de profil
                session_start();
                $_SESSION['user_id'] = $user['id'];
                header("Location: profil.php");
                exit;
            } else {
                // Le mot de passe est incorrect, affiche un message d'erreur
                echo "<p>Le login ou le mot de passe est incorrect.</p>";
            }
        } else {
            // Aucun utilisateur n'a été trouvé avec le login saisi, affiche un message d'erreur
            echo "<p>Le login ou le mot de passe est incorrect.</p>";
        }

        // Ferme la requête préparée et la connexion à la base de données
        $stmt->close();
        $conn->close();
    }
}
?>

            <form action="connexion.php" method="post">

            <label for="login">Login :</label>
            <input type="text" name="login" id="login" required>

            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>

            <input type="submit" value="Se connecter">
        </form>
    </main>
</body>
</html>
