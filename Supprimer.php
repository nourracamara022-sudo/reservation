
<?php
require_once "Connexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: Liste.php");
    exit;
}

$id = (int) ($_POST["id"] ?? 0);

if ($id <= 0) {
    die("Identifiant de demande invalide.");
}

$requete = $pdo->prepare(
    "DELETE FROM demandes WHERE id = ?"
);

$requete->execute([$id]);

header("Location: Liste.php");
exit;
