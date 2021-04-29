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

    <?php

    $isThereError = false;
    $messages = [];
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $bdd = mysqli_init();
        mysqli_real_connect($bdd, "127.0.0.1", "rafael", "rafael", "entreprise");
        $result = mysqli_query($bdd, "SELECT * from employes where noemp =" . $id . ";");
        $donnees = mysqli_fetch_array($result, MYSQLI_ASSOC);
    }
    if (!empty($_POST)) {
        if (
            !isset($_POST["nom"]) || empty($_POST["nom"]) || !preg_match("#^[a-z-\s]*$#i", $_POST["nom"])
        ) {
            $isThereError = true;
            $messages[] = "Erreur de saisie dans nom";
        }
        if (
            !isset($_POST["prenom"]) || empty($_POST["prenom"]) || !preg_match("#^[a-z-\s]*$#i", $_POST["prenom"])
        ) {
            $isThereError = true;
            $messages[] = "Erreur de saisie dans prènom";
        }
        if (
            !isset($_POST["emploi"]) || empty($_POST["emploi"]) || !preg_match("#^[a-z-\s]*$#i", $_POST["emploi"])
        ) {
            $isThereError = true;
            $messages[] = "Erreur de saisie dans prènom";
        }

        if (
            !isset($_POST["embauche"]) || empty($_POST["embauche"]) || !preg_match("#^[0-9]{4}-[0-9]{2}-[0-9]{2}$#", $_POST["embauche"])
        ) {
            $isThereError = true;
            $messages[] = "Erreur de saisie dans la date d'embauche";
        }
        if (
            !isset($_POST["sal"]) || empty($_POST["sal"]) || !preg_match("#^[0-9]*.[0-9]{2}$#", $_POST["sal"])
        ) {
            $isThereError = true;
            $messages[] = "Erreur de saisie dans salaire";
        }
        if (
            !isset($_POST["comm"]) || !preg_match("#^[0-9]*.[0-9]{2}$|^[0-9]{2}$|^$|^[0-9]*$|^[0-9]$#", $_POST["comm"])
        ) {
            $isThereError = true;
            $messages[] = "Erreur de saisie dans la commission";
        }


        if (!$isThereError) {
            $bdd = mysqli_init();
            mysqli_real_connect($bdd, "127.0.0.1", "rafael", "rafael", "entreprise");
            $requette = "UPDATE employes SET 
    nom = '" . $_POST["nom"] . "',
    prenom = '" . $_POST["prenom"] . "',
    emploi = '" . $_POST["emploi"] . "',
    sup = " . $_POST["sup"] . ",
    embauche = '" . $_POST["embauche"] . "',
    sal = " . $_POST["sal"] . ",
    comm = " . $_POST["comm"] . ",
    noserv = " . $_POST["noserv"] . "
    WHERE noemp = " . $_POST["id"] . ";";
            var_dump($requette);
            var_dump($_POST);
            mysqli_query($bdd, $requette);
            mysqli_close($bdd);
            header("location: tableau.php");
        }
    }
    if (isset($_GET["noemp"]) || $isThereError) {

        if ($isThereError) {
            foreach ($messages as $message) {
                echo $message;
            }
        }
    }


    ?>
    <form action="" method="POST">
        <input type="hidden" readonly class="form-control" name="id" value="<?php echo $donnees['noemp']; ?>" hidden>
        <input type="text" class="form-control" name="nom" value="<?php echo $isThereError ? $_POST["nom"] : $donnees['nom']; ?>" placeholder="modifier nom">
        <input type="text" class="form-control" name="prenom" value="<?php echo $isThereError ? $_POST["prenom"] : $donnees['prenom']; ?>" placeholder="modifier prenom">
        <input type="text" class="form-control" name="emploi" value="<?php echo $isThereError ? $_POST["emploi"] : $donnees['emploi']; ?>" placeholder="modifier emploi">
        <input type="number" class="form-control" name="sup" value="<?php echo $isThereError ? $_POST["sup"] : $donnees['sup']; ?>" placeholder="modifier sup">
        <input type="date" class="form-control" name="embauche" value="<?php echo  $isThereError ? $_POST["embauche"] : $donnees['embauche']; ?>" placeholder="modifier embauche">
        <input type="number" class="form-control" name="sal" value="<?php echo $isThereError ? $_POST["sal"] : $donnees['sal']; ?>" placeholder="modifier salaire">
        <input type="float" class="form-control" name="comm" value="<?php echo $isThereError ? $_POST["comm"] : $donnees['comm']; ?>" placeholder="modifier commission">
        <input type="number" class="form-control" name="noserv" value="<?php echo $isThereError ? $_POST["noserv"] : $donnees['noserv']; ?>" placeholder="modifier noserv">
        <input type="submit" class="btn btn-success" value="Soumettre">
    </form>


</body>

</html>