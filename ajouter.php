<?php
session_start();
if (!$_SESSION['nom']) {
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>modifier employé</title>
</head>

<body>

    <form action="requet-ajout.php" method="POST">
        <input type="hidden" readonly class="form-control" name="noemp">
        <input type=" text" class="form-control" name="nom" placeholder="modifier nom">
        <input type="text" class="form-control" name="prenom" placeholder="modifier prenom">
        <input type="text" class="form-control" name="emploi" placeholder="modifier emploi">
        <input type="number" class="form-control" name="sup" placeholder="modifier sup">
        <input type="date" class="form-control" name="embauche" placeholder="modifier embauche">
        <input type="number" class="form-control" name="sal" placeholder="modifier salaire">
        <input type="number" class="form-control" name="comm" placeholder="modifier commission">
        <input type="number" class="form-control" name="noserv" placeholder="modifier noserv">
        <input type="submit" class="btn btn-success" value="Soumettre">
    </form>


</body>

</html>