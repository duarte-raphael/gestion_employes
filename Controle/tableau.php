<?php
include_once(__DIR__ . "/../Service/EmployeService.php");
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
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <?php
    $obj = new EmployeService;
    $donnees = $obj->selectAllEmploye();
    $tableau = [];


    $tabSup = $obj->listeChef();
    for ($i = 0; $i < sizeof($tabSup); $i++) {
        $tableau[$i] = $tabSup[$i]["sup"];
    }
    $compteur = $obj->compteur();

    ?>

    <div>nombre d'employes ajoutes aujourd'hui : <?php echo $compteur ?></div>
    <a href='ajouter.php'><button class='btn btn-primary'>ajouter un nouveau employé</button></a>
    <hr>
    <a href='deco.php'><button class='btn btn-warning'>deconnexion</button></a>
    <hr>
    <table class="table table-dark table-striped">
        <tr>
            <th>noemp</th>
            <th>nom</th>
            <th>prenom</th>
            <th>emploi</th>
            <th>sup</th>
            <th>embauche</th>
            <th>sal</th>
            <th>comm</th>
            <th>noserv</th>
            <th>date_ajout</th>
            <?php if ($_SESSION["profil"] == "admin") { ?>
                <th>Detail</th>
                <th>modifier</th>
                <th>supprimer</th>
            <?php } ?>
        </tr>
        <?php
        foreach ($donnees as $employe) {
        ?>
            <tr>
                <td><?php echo $employe->getNoemp(); ?></td>
                <td><?php echo $employe->getNom(); ?></td>
                <td><?php echo $employe->getPrenom(); ?></td>
                <td><?php echo $employe->getEmploi(); ?></td>
                <td><?php echo $employe->getSup(); ?></td>
                <td><?php echo $employe->getEmbauche(); ?></td>
                <td><?php echo $employe->getSal(); ?></td>
                <td><?php echo $employe->getComm(); ?></td>
                <td><?php echo $employe->getNoserv(); ?></td>
                <td><?php echo $employe->getDateAjout(); ?></td>
                <?php if ($_SESSION["profil"] == "admin") { ?>
                    <td><a href='#'><button class='btn btn-primary'>detail</button></a></td>
                    <td><a href='form_modif.php?id=<?php echo $employe->getNoemp(); ?>'><button class='btn btn-warning'>Modifier</button></a></td>
                    <td><a href='supprimer.php?id=<?php echo $employe->getNoemp(); ?>'><?php if (!in_array($employe->getNoemp(), $tableau)) { ?><button class='btn btn-danger'>suprimer</button></a><?php } ?></td>
                <?php } ?>
            </tr>

        <?php
            // <?php if (!in_array($employe['noemp'], $tableau)) {
        }

        ?>
    </table>





</body>

</html>