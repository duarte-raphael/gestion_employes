<?php

$isThereError = false;
$msg = [];
if (!empty($_POST["nom"]) && !empty($_POST["hash_password"])) {

    $dataUtilisateur = selectAllByNom($_POST["nom"]);


    if (password_verify($_POST["hash_password"], $dataUtilisateur["hash_password"])) {
        session_start();
        $_SESSION["nom"] = $dataUtilisateur["nom"];
        $_SESSION["profil"] = $dataUtilisateur["profil"];
        header("location: tableau.php");
    } else {
        $isThereError = true;
        $msg[] = "Erreur de connexion. ";
    }
} else {
    $isThereError = true;
    $msg[] = "veuillez remplir les champs";
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>sign in</title>
</head>

<body>
    <?php
    if ($isThereError) {
        echo $msg[0];
    }
    ?>
    <div class="container">
        <form action="" method="post" class="formulaire">
            <h1>Connexion</h1>
            <div class="form-group row">
                <label for="nom" class="col-sm-5 col-form-label">Pseudo</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="nom" placeholder="pseudo" name="nom" style="width: 80%; ">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-5 col-form-label">Mot de passe</label>
                <div class="col-sm-7">
                    <input type="password" class="form-control" id="inputPassword" name="hash_password" placeholder="Password" style="width: 80%;">
                </div>
            </div>
            <input type="submit" class="btn btn-success" value="Soumettre">
        </form>
    </div>


</body>

</html>
<?php

function selectAllByNom($nom)
{
    $db = new mysqli("127.0.0.1", "rafael", "rafael", "entreprise");
    $stmt = $db->prepare("SELECT * FROM utilisateur WHERE nom = ?");
    $stmt->bind_param("s", $nom);
    $stmt->execute();
    $rs = $stmt->get_result();
    $dataUtilisateur = $rs->fetch_array(MYSQLI_ASSOC);
    $db->close();
    return $dataUtilisateur;
}
