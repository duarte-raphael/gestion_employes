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
        $donnees = selectAllById($_GET["id"]);
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

        if ($_POST["comm"] == "") {
            $commission = "null";
        } else {
            $commission = $_POST["comm"];
        }

        if (!$isThereError) {
            updateEmploye($_POST, $commission);

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

<?php
// pas encore mo
function updateEmploye($tab, $comm)
{
    $db = mysqli_init();
    mysqli_real_connect($db, "127.0.0.1", "rafael", "rafael", "entreprise");
    $stmt = $db->prepare("UPDATE employes SET 
nom = ?,
prenom = ?,
emploi = ?,
sup = ?,
embauche = ?,
sal = ?,
comm = ?,
noserv = ?
WHERE noemp = ?;");
    $stmt->bind_param(
        "isssisddi",
        $tab["nom"],
        $tab["prenom"],
        $tab["emploi"],
        $tab["sup"],
        $tab["embauche"],
        $tab["sal"],
        $comm,
        $tab["noserv"],
        $tab["id"]
    );
    $stmt->execute();
    mysqli_close($db);
}

function selectAllById($id)
{
    $db = new mysqli("127.0.0.1", "rafael", "rafael", "entreprise");
    $stmt = $db->prepare("SELECT * from employes where noemp = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $rs = $stmt->get_result();
    $tabNom = $rs->fetch_array(MYSQLI_ASSOC);
    $db->close();
    return $tabNom;
}
