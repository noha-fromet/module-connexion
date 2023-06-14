<?php
// Démarre une session
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // L'utilisateur n'est pas connecté, le redirige vers la page de connexion
    header("Location: connexion.php");
    exit;
}

// Établit une connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'moduleconnexion');

// Vérifie si la connexion a réussi
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué: " . $conn->connect_error);
}

// Vérifie si le formulaire a été soumis
if (isset($_POST['email']) && isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['password']) && isset($_POST['password_confirm'])) {
    // Récupère les données du formulaire
    $email = $_POST['email'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Valide les données saisies par l'utilisateur
    if (empty($email) || empty($prenom) || empty($nom)) {
        // Les champs sont vides, affiche un message d'erreur
        echo "<p>Tous les champs sont requis.</p>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // L'adresse e-mail n'est pas valide, affiche un message d'erreur
        echo "<p>L'adresse e-mail saisie n'est pas valide.</p>";
    } elseif (!empty($password) && $password != $password_confirm) {
        // Les mots de passe ne correspondent pas, affiche un message d'erreur
        echo "<p>Les mots de passe ne correspondent pas.</p>";
    } else {
        // Les données sont valides, met à jour les informations de l'utilisateur dans la base de données

        // Prépare une requête SQL pour mettre à jour les informations de l'utilisateur
        if (empty($password)) {
            $stmt = $conn->prepare("UPDATE utilisateurs SET email = ?, prenom = ?, nom = ? WHERE id = ?");
            $stmt->bind_param("sssi", $email, $prenom, $nom, $_SESSION['user_id']);
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE utilisateurs SET email = ?, prenom = ?, nom = ?, password = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $email, $prenom, $nom, $hashed_password, $_SESSION['user_id']);
        }

        // Exécute la requête
        if ($stmt->execute()) {
            // Les informations ont été mises à jour avec succès, affiche un message de confirmation
            echo "<p>Vos informations ont été mises à jour avec succès.</p>";
        } else {
            // Une erreur s'est produite lors de la mise à jour des informations, affiche un message d'erreur
            echo "<p>Une erreur s'est produite lors de la mise à jour de vos informations. Veuillez réessayer.</p>";
        }
        // Ferme la requête préparée
        $stmt->close();
    }
}

// Prépare une requête SQL pour récupérer les informations de l'utilisateur
$stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);

// Exécute la requête
$stmt->execute();

// Récupère le résultat de la requête
$result = $stmt->get_result();

// Vérifie si un utilisateur a été trouvé
if ($result->num_rows > 0) {
    // Un utilisateur a été trouvé, récupère ses informations
    $user = $result->fetch_assoc();
} else {
    // Aucun utilisateur n'a été trouvé, affiche un message d'erreur
    echo "<p>Une erreur s'est produite. Veuillez réessayer.</p>";
}

// Ferme la requête préparée et la connexion à la base de données
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil</title>
    <link rel="stylesheet" href="profil.css">
</head>
<body>
    <header>
        <img src="logo.png" alt="Logo du site">
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == '1'): ?>
                    <li><a href="admin.php">Administration</a></li>
                <?php endif; ?>
                <li><a href="deconnexion.php">Se déconnecter</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Profil</h1>

        <?php
        // Vérifie si le formulaire a été soumis
        if (isset($_POST['email']) && isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['password']) && isset($_POST['password_confirm'])) {
            // Récupère les données du formulaire
            $email = $_POST['email'];
            $prenom = $_POST['prenom'];
            $nom = $_POST['nom'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            // Valide les données saisies par l'utilisateur
            if (empty($email) || empty($prenom) || empty($nom)) {
                // Les champs sont vides, affiche un message d'erreur
                echo "<p>Tous les champs sont requis.</p>";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // L'adresse e-mail n'est pas valide, affiche un message d'erreur
                echo "<p>L'adresse e-mail saisie n'est pas valide.</p>";
            } elseif (!empty($password) && $password != $password_confirm) {
                // Les mots de passe ne correspondent pas, affiche un message d'erreur
                echo "<p>Les mots de passe ne correspondent pas.</p>";
            } else {
                // Les données sont valides, met à jour les informations de l'utilisateur dans la base de données

                // Prépare une requête SQL pour mettre à jour les informations de l'utilisateur
                if (empty($password)) {
                    $stmt = $conn->prepare("UPDATE utilisateurs SET email = ?, prenom = ?, nom = ? WHERE id = ?");
                    $stmt->bind_param("sssi", $email, $prenom, $nom, $_SESSION['user_id']);
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE utilisateurs SET email = ?, prenom = ?, nom = ?, password = ? WHERE id = ?");
                    $stmt->bind_param("ssssi", $email, $prenom, $nom, $hashed_password, $_SESSION['user_id']);
                }

                // Exécution de la requête
                if ($stmt->execute()) {
                    // Les informations ont été mises à jour avec succès, affiche un message de confirmation
                    echo "<p>Vos informations ont été mises à jour avec succès.</p>";
                } else {
                    // Une erreur s'est produite lors de la mise à jour des informations, affiche un message d'erreur
                    echo "<p>Une erreur s'est produite lors de la mise à jour de vos informations. Veuillez réessayer.</p>";
                }

                // Ferme la requête préparée
                $stmt->close();
            }
        }
        ?>

        <form action="profil.php" method="post">
            <div>
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div>
                <label for="prenom">Prénom :</label>
                <input type="text" name="prenom" id="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>" required>
            </div>
            <div>
                <label for="nom">Nom :</label>
                <input type="text" name="nom" id="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
            </div>
            <div>
                <label for="password">Nouveau mot de passe (laisser vide pour ne pas changer) :</label>
                <input type="password" name="password" id="password">
            </div>
            <div>
                <label for="password_confirm">Confirmation du nouveau mot de passe :</label>
                <input type="password" name="password_confirm" id="password_confirm">
            </div>

            <input type="submit" value="Mettre à jour">
        </form>
    </main>
</body>
</html>
