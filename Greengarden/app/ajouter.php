<?php
require_once("dao.php");

$dao = new DAO();
$dao->connexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $nomCourt = $_POST['nom_court'];
    $nomLong = $_POST['nom_long'];
    $refFournisseur = $_POST['ref_fournisseur'];
    $photo = $_POST['photo'];
    $prixAchat = $_POST['prix_achat'];
    $categorieId = $_POST['categorie_id'];

    $stmt = $dao->bdd->prepare("INSERT INTO t_d_produit (Nom_court, Nom_Long, Ref_fournisseur, Photo, Prix_Achat, Id_Categorie) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nomCourt, $nomLong, $refFournisseur, $photo, $prixAchat, $categorieId]);
}

$dao->disconnect();
?>
