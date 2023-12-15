<?php
require_once("dao.php");

$dao = new DAO();
$dao->connexion();

if (isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['id'])) {
    $productId = $_GET['id'];
    $stmt = $dao->bdd->prepare("DELETE FROM t_d_produit WHERE Id_Produit = ?");
    $stmt->execute([$productId]);
}

$dao->disconnect();
?>
