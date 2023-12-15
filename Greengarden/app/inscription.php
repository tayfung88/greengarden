<?php
require_once("dao.php");

$dao = new DAO();
$dao->connexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Spécifier manuellement Id_UserType à 1 pour les clients
    $userType = 1;

    // Insérer les données dans la base de données
    $stmt = $dao->bdd->prepare("INSERT INTO t_d_user (Id_UserType, Login, Password) VALUES (?, ?, ?)");
    $stmt->execute([$userType, $login, $password]);

    // Rediriger l'utilisateur vers la page de connexion
    header("Location: connexion.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
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
    
    <form method="post" action="inscription.php">
    <h2>Inscription</h1>
        <label for="login">Nom d'utilisateur:</label>
        <input type="text" name="login" required>

        <label for="password">Mot de passe:</label>
        <input type="password" name="password" required>

        <input type="submit" value="S'inscrire">
    </form>
    </main>

    <footer>
        <p>&copy; Tayfun GUGLU 2023.</p>
    </footer>
</body>
</html>
