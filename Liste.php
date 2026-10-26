<?php
require_once "Connexion.php";

if (isset($_POST["enregistrer"])) {

    $nom = trim($_POST["nom_agent"] ?? "");
    $objet = trim($_POST["objet"] ?? "");
    $date = $_POST["date_reunion"] ?? "";

    if ($nom !== "" && $objet !== "" && $date !== "") {

        $requete = $pdo->prepare(
            "INSERT INTO demandes
            (nom_agent, objet, date_reunion)
            VALUES (:nom, :objet, :date)"
        );

        $requete->execute([
            ":nom" => $nom,
            ":objet" => $objet,
            ":date" => $date
        ]);

        echo "Demande enregistrée avec succès !";

    } else {
        echo "Veuillez remplir tous les champs.";
    }
}

$requete = $pdo->query(
    "SELECT * FROM demandes ORDER BY id ASC"
);

$demandes = $requete->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des demandes</title>
</head>
<body>
    <h2>Liste des demandes enregistrées</h2>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Nom de l'agent</th>
            <th>Objet</th>
            <th>Date de réunion</th>
            <th>Action</th>
        </tr>
        
<?php foreach ($demandes as $demande) { ?>
    <tr>
        <td><?= (int) $demande["id"] ?></td>

        <td>
            <?= htmlspecialchars($demande["nom_agent"]) ?>
        </td>

        <td>
            <?= htmlspecialchars($demande["objet"]) ?>
        </td>

        <td>
            <?= date("d/m/Y", strtotime($demande["date_reunion"])) ?>
        </td>

        <td>
            
<a href="Modifier.php?id=<?= (int) $demande["id"] ?>">
    Modifier
</a>

<form action="Supprimer.php" method="POST" style="display:inline;">
    <input type="hidden" name="id" value="<?= (int) $demande["id"] ?>">
    <button type="submit">Supprimer</button>
</form>

        </td>
    </tr>
<?php } ?>


    </table>

    <p>
        <a href="Formulaire.php">Ajouter une autre demande</a>
    </p>

</body>
</html>