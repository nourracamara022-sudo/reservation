
<?php
require_once "Connexion.php";

$id = isset($_POST["id"])
    ? (int) $_POST["id"]
    : (int) ($_GET["id"] ?? 0);

if ($id <= 0) {
    die("Identifiant de demande invalide.");
}

$requete = $pdo->prepare(
    "SELECT id, nom_agent, objet, date_reunion
     FROM demandes
     WHERE id = :id"
);
$requete->execute([":id" => $id]);
$demande = $requete->fetch(PDO::FETCH_ASSOC);

if (!$demande) {
    die("Demande introuvable.");
}

$nom = $demande["nom_agent"];
$objet = $demande["objet"];
$date = $demande["date_reunion"];
$message = "";

if (isset($_POST["modifier"])) {

    $nom = trim($_POST["nom_agent"] ?? "");
    $objet = trim($_POST["objet"] ?? "");
    $date = $_POST["date_reunion"] ?? "";

    if ($nom === "" || $objet === "" || $date === "") {

        $message = "Veuillez remplir tous les champs.";

    } else {

        $requete = $pdo->prepare(
            "UPDATE demandes
             SET nom_agent = :nom,
                 objet = :objet,
                 date_reunion = :date
             WHERE id = :id"
        );

        $requete->execute([
            ":nom" => $nom,
            ":objet" => $objet,
            ":date" => $date,
            ":id" => $id
        ]);

        header("Location: Liste.php");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une demande</title>
</head>
<body>

    <h2>Modifier une demande de réunion</h2>

    <p>
        <strong>Identifiant :</strong>
        <?= (int) $demande["id"] ?>
    </p>

    <?php if ($message !== "") { ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php } ?>

    
<form action="Modifier.php" method="POST">

    <input type="hidden" name="id"
           value="<?= (int) $demande["id"] ?>">

    <label for="nom_agent">Nom de l'agent :</label>
    <input
        type="text"
        id="nom_agent"
        name="nom_agent"
        value="<?= htmlspecialchars($nom, ENT_QUOTES, 'UTF-8') ?>"
        required
    >

    <br><br>

    <label for="objet">Objet de la réunion :</label>
    <input
        type="text"
        id="objet"
        name="objet"
        value="<?= htmlspecialchars($objet, ENT_QUOTES, 'UTF-8') ?>"
        required
    >

    <br><br>

    <label for="date_reunion">Date de la réunion :</label>
    <input
        type="date"
        id="date_reunion"
        name="date_reunion"
        value="<?= htmlspecialchars($date, ENT_QUOTES, 'UTF-8') ?>"
        required
    >

    <br><br>

    <button type="submit" name="modifier">
        Enregistrer les modifications
    </button>

</form>


    <p><a href="Liste.php">Retour à la liste</a></p>

</body>
</html>
