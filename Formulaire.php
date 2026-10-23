<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Enregistrer une demande</h2>

    <form action="Liste.php" method="POST">

        <label>Nom de l'agent :</label>
        <input type="text" name="nom_agent" required>
        <br><br>

        <label>Objet de la réunion :</label>
        <input type="text" name="objet" required>
        <br><br>

        <label>Date de la réunion :</label>
        <input type="date" name="date_reunion" required>
        <br><br>

        <button type="submit" name="enregistrer">
            Enregistrer
        </button>
</form>
</body>
</html>