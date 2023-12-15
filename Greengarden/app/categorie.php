<?php
require_once("dao.php");

$dao = new DAO();
$dao->connexion();

session_start();
$categories = $dao->getCategories();

if (isset($_GET["categorie"]) && $_GET["categorie"]) {
    $categorie = $_GET["categorie"];
    $produits = $dao->getProductsByCategory($categorie);
} else {
    $produits = $dao->getAllProducts();
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Catégories</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
</head>

<body>

<header>
        <section class="headerTitle">
            <h1>Greengarden</h1>
        </section>

        <nav>
            <div>
                <a href="index.php">Accueil</a>
                <a href="categorie.php">Catégories</a>
                <a href="produit.php">Tous les produits</a>
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
        <h2>Les catégories</h2>
        <form id="formfiltres" method="get" action="categorie.php">
            <select name="categorie" id="selectcategorie">
                <option value="" <?php if (!isset($_GET["categorie"])) print "selected"; ?>>Toutes les catégories</option>
                <?php foreach ($categories as $row) { ?>
                    <option value="<?= $row["Id_Categorie"]; ?>" <?php if (isset($_GET["categorie"]) && $_GET["categorie"] == $row["Id_Categorie"]) print "selected"; ?>>
                        <?= $row["Libelle"]; ?>
                    </option>
                <?php } ?>
            </select>
        </form>

        <table id="myTable">
            <thead>
                <th>Libelle</th>
                <th>Prix</th>
            </thead>
            <tbody>
                <?php foreach ($produits as $row) { ?>
                    <tr>
                        <td><?= $row["Nom_court"]; ?></td>
                        <td><?= $row["Prix_Achat"]; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; Tayfun GUGLU 2023.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialisation de DataTable
        $('#myTable').DataTable();
    });
        // Formulaire auto sans submit
    $('#selectcategorie').on('change', function() {
            $('#formfiltres').submit();
        });
</script>
</body>
</html>