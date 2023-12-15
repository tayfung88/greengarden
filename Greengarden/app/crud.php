<?php
require_once("dao.php");

$dao = new DAO();
$dao->connexion();

// Traitement de l'ajout d'un produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $nomCourt = $_POST['nom_court'];
    $nomLong = $_POST['nom_long'];
    $refFournisseur = $_POST['ref_fournisseur'];
    $photo = $_POST['photo']; 
    $prixAchat = $_POST['prix_achat'];
    $categorieId = $_POST['categorie_id'];

    // Ajout du produit
    $stmt = $dao->bdd->prepare("INSERT INTO t_d_produit (Nom_court, Nom_Long, Ref_fournisseur, Photo, Prix_Achat, Id_Categorie) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nomCourt, $nomLong, $refFournisseur, $photo, $prixAchat, $categorieId]);
}

// Traitement de la modification d'un produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier'])) {
    $productId = $_POST['produit_id'];
    $nomCourt = $_POST['nom_court'];
    $nomLong = $_POST['nom_long'];
    $refFournisseur = $_POST['ref_fournisseur'];
    $photo = $_POST['photo']; 
    $prixAchat = $_POST['prix_achat'];
    $categorieId = $_POST['categorie_id'];

    // Modification du produit
    $stmt = $dao->bdd->prepare("UPDATE t_d_produit SET Nom_court = ?, Nom_long = ?, Ref_fournisseur = ?, Photo = ?, Prix_Achat = ?, Id_Categorie = ? WHERE Id_Produit = ?");
    $stmt->execute([$nomCourt, $nomLong, $refFournisseur, $photo, $prixAchat, $categorieId, $productId]);
}

// Traitement de la suppression d'un produit
if (isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Suppression du produit
    $stmt = $dao->bdd->prepare("DELETE FROM t_d_produit WHERE Id_Produit = ?");
    $stmt->execute([$productId]);
}

// Récupération de la liste des produits
$stmt = $dao->bdd->prepare("SELECT * FROM t_d_produit");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$dao->disconnect();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CRUD Produits</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="css/style.css"> 
</head>
<body>
    <header>
        <section class="headerTitle">
            <h1>Greengarden - CRUD Produits</h1>
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
        <section>
            <h2>Gestion des Produits</h2>

            <!-- Formulaire d'ajout de produit -->
            <form method="post" action="crud.php">
                <h3>Ajouter un Produit</h3>
                <label for="nom_court">Nom Court :</label>
                <input type="text" name="nom_court" required>
                <label for="nom_long">Nom Long :</label>
                <input type="text" name="nom_long" required>
                <label for="ref_fournisseur">Réf. Fournisseur :</label>
                <input type="text" name="ref_fournisseur" required>
                <label for="photo">Photo :</label>
                <input type="text" name="photo" required>
                <label for="prix_achat">Prix Achat :</label>
                <input type="number" name="prix_achat" required>
                <label for="categorie_id">ID Catégorie :</label>
                <input type="number" name="categorie_id" required>
                <button type="submit" name="ajouter">Ajouter</button>
            </form>

            <!-- Liste des produits -->
            <table id="productTable" class="display">
                <thead>
                    <tr>
                        <th>Nom Court</th>
                        <th>Nom Long</th>
                        <th>Réf. Fournisseur</th>
                        <th>Photo</th>
                        <th>Prix Achat</th>
                        <th>ID Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) : ?>
                        <tr>
                            <td><?= $product['Nom_court'] ?></td>
                            <td><?= $product['Nom_Long'] ?></td>
                            <td><?= $product['Ref_fournisseur'] ?></td>
                            <td><?= $product['Photo'] ?></td>
                            <td><?= $product['Prix_Achat'] ?></td>
                            <td><?= $product['Id_Categorie'] ?></td>
                            <td>
                                <a href="crud.php?action=modifier&id=<?= $product['Id_Produit'] ?>">Modifier</a>
                                <a href="crud.php?action=supprimer&id=<?= $product['Id_Produit'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php
            // Formulaire de modification de produit
            if (isset($_GET['action']) && $_GET['action'] === 'modifier' && isset($_GET['id'])) {
                $productId = $_GET['id'];
                $stmt = $dao->bdd->prepare("SELECT * FROM t_d_produit WHERE Id_Produit = ?");
                $stmt->execute([$productId]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <form method="post" action="crud.php">
                <h3>Modifier le Produit</h3>
                <input type="hidden" name="produit_id" value="<?= $productId ?>">
                <label for="nom_court">Nom Court :</label>
                <input type="text" name="nom_court" value="<?= $product['Nom_court'] ?>" required>
                <label for="nom_long">Nom Long :</label>
                <input type="text" name="nom_long" value="<?= $product['Nom_long'] ?>" required>
                <label for="ref_fournisseur">Réf. Fournisseur :</label>
                <input type="text" name="ref_fournisseur" value="<?= $product['Ref_fournisseur'] ?>" required>
                <label for="photo">Photo :</label>
                <input type="text" name="photo" value="<?= $product['Photo'] ?>" required>
                <label for="prix_achat">Prix Achat :</label>
                <input type="number" name="prix_achat" value="<?= $product['Prix_Achat'] ?>" required>
                <label for="categorie_id">ID Catégorie :</label>
                <input type="number" name="categorie_id" value="<?= $product['Id_Categorie'] ?>" required>
                <button type="submit" name="modifier">Modifier</button>
            </form>
            <?php
            }
            ?>
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
