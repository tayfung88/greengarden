<?php
require_once("dao.php");

$dao = new DAO();
$dao->connexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Récupérer l'utilisateur depuis la base de données
    $stmt = $dao->bdd->prepare("SELECT * FROM t_d_user WHERE Login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur existe et si le mot de passe est correct
    if ($user && password_verify($password, $user['Password'])) {
        // Démarrez la session et stockez les informations de l'utilisateur
        session_start();
        $_SESSION['user'] = $user;

        // Rediriger l'utilisateur vers la page d'accueil ou toute autre page souhaitée
        header("Location: index.php");
        exit;
    } else {
        $error_message = "Nom d'utilisateur ou mot de passe incorrect";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        h2 {
            text-align: center;
        }

        main {
            flex: 1; /* Occupe l'espace restant */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Greengarden</h1>
        <nav>
            <div>
                <a href="index.php">Accueil</a>
                <a href="categorie.php">Catégories</a>
                <a href="produit.php">Tous les produits</a>
                <a href="#">Panier</a>
            </div>
        <nav>
    </header>

    <main>
        <form method="post" action="connexion.php">
            <h2>Connexion</h2>
            <?php if (isset($error_message)) : ?>
                <p style="color: red;"><?= $error_message ?></p>
            <?php endif; ?>
            <label for="login">Nom d'utilisateur:</label>
            <input type="text" name="login" required>

            <label for="password">Mot de passe:</label>
            <input type="password" name="password" required>

            <input type="submit" value="Se connecter">
        </form>
    </main>

    <footer>
        <p>&copy; Tayfun GUGLU 2023.</p>
    </footer>
</body>
</html>
</html>
