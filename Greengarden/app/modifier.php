<?php
require_once("dao.php");

$dao = new DAO();
$dao->connexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier'])) {
    $productId = $_POST['produit_id'];
    $nomCourt = $_POST['nom_court'];
    $nomLong = $_POST['nom_long'];
    $refFournisseur = $_POST['ref_fournisseur'];
    $photo = $_POST['photo'];
    $prixAchat = $_POST['prix_achat'];
    $categorieId = $_POST['categorie_id'];

    $stmt = $dao->bdd->prepare("UPDATE t_d_produit SET Nom_court = ?, Nom_long = ?, Ref_fournisseur = ?, Photo = ?, Prix_Achat = ?, Id_Categorie = ? WHERE Id_Produit = ?");
    $stmt->execute([$nomCourt, $nomLong, $refFournisseur, $photo, $prixAchat, $categorieId, $productId]);
} elseif (isset($_GET['action']) && $_GET['action'] === 'modifier' && isset($_GET['id'])) {
    $productId = $_GET['id'];
    $stmt = $dao->bdd->prepare("SELECT * FROM t_d_produit WHERE Id_Produit = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}

$dao->disconnect();
?>
