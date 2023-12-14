<?php
// Démarrez la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="css/style.css"> 
</head>

<body>
    <header>
        <section class="headerTitle">
            <h1>Greengarden</h1>
        </section>

        <nav>
            <div>
                <a href="#">Accueil</a>
                <a href="#">Catégories</a>
                <a href="#">Tous les produits</a>
                <a href="#">Panier</a>
            </div>
            <div>
                <?php
                if (isset($_SESSION['user'])) {
                    $user = $_SESSION['user'];
                    echo "Bonjour, {$user['Login']}!<br><a href='deconnexion.php'>Se déconnecter</a>";
                } else {
                    echo "<a href='connexion.php'>Se connecter</a> <a href='inscription.php'>S'inscrire</a>";
                }
                ?>
            </div>
        </nav>
    </header>

    <main>
        <section>
            <h2>Bienvenue</h2>
        </section>
    </main>

    <footer>
        <p>&copy; Tayfun GUGLU 2023.</p>
    </footer>
</body>

</html>