<?php

require_once("dao.php");

$dao = new DAO();
$dao->connexion();

$allProducts = $dao->getAllProducts();

$dao->disconnect();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
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
            <h2>Tous les Produits</h2>
            <table id="productTable" class="display">
                <thead>
                    <tr>
                        <th>Details</th>
                        <th>Nom Court</th>
                        <th>Ref. Fournisseur</th>
                        <th>Photo</th>
                        <th>Prix Achat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allProducts as $product) : ?>
                        <tr>
                            <td>
                                <a href="product-details.php?id=<?= $product['Id_Produit'] ?>">
                                    <?= $product['Nom_Long'] ?>
                                </a>
                            </td>
                            <td><?= $product['Nom_court'] ?></td>
                            <td><?= $product['Ref_fournisseur'] ?></td>
                            <td><?= $product['Photo'] ?></td>
                            <td><?= $product['Prix_Achat'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; Tayfun GUGLU 2023.</p>
    </footer>
    <script>
        $(document).ready(function() {
            $('#productTable').DataTable();
        });
    </script>
</body>
</html>
