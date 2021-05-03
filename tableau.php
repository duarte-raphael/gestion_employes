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
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <?php

    $donnees = selectAllEmploye();

    $tableau = [];

    $tabSup = listeChef();

    for ($i = 0; $i < sizeof($tabSup); $i++) {
        $tableau[$i] = $tabSup[$i]["sup"];
    }
    $compteur = compteur();

    ?>

    <div>nombre d'employes ajoutes aujourd'hui : <?php echo $compteur[0] ?></div>
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
                <td><?php echo $employe['noemp']; ?></td>
                <td><?php echo $employe['nom']; ?></td>
                <td><?php echo $employe['prenom']; ?></td>
                <td><?php echo $employe['emploi']; ?></td>
                <td><?php echo $employe['sup']; ?></td>
                <td><?php echo $employe['embauche']; ?></td>
                <td><?php echo $employe['sal']; ?></td>
                <td><?php echo $employe['comm']; ?></td>
                <td><?php echo $employe['noserv']; ?></td>
                <td><?php echo $employe['date_ajout']; ?></td>
                <?php if ($_SESSION["profil"] == "admin") { ?>
                    <td><a href='#'><button class='btn btn-primary'>detail</button></a></td>
                    <td><a href='form_modif.php?id=<?php echo $employe["noemp"]; ?>'><button class='btn btn-warning'>Modifier</button></a></td>
                    <td><a href='supprimer.php?id=<?php echo $employe['noemp']; ?>'><?php if (!in_array($employe['noemp'], $tableau)) { ?><button class='btn btn-danger'>suprimer</button></a><?php } ?></td>
                <?php } ?>
            </tr>

        <?php
            // <?php if (!in_array($employe['noemp'], $tableau)) {
        }

        ?>
    </table>





</body>

</html>
<?php

function selectAllEmploye()
{
    $db = new mysqli("127.0.0.1", "rafael", "rafael", "entreprise");
    $stmt = $db->prepare("SELECT * FROM employes;");
    $stmt->execute();
    $rs = $stmt->get_result();
    $d = $rs->fetch_all(MYSQLI_ASSOC);
    $db->close();
    return $d;
}

function listeChef()
{
    $db = new mysqli("127.0.0.1", "rafael", "rafael", "entreprise");
    $stmt = $db->prepare("SELECT DISTINCT sup FROM employes;");
    $stmt->execute();
    $rs = $stmt->get_result();
    $tabSup = $rs->fetch_all(MYSQLI_ASSOC);
    $db->close();
    return $tabSup;
}

function compteur()
{
    $db = new mysqli("127.0.0.1", "rafael", "rafael", "entreprise");
    $stmt = $db->prepare("SELECT COUNT(date_ajout) FROM employes WHERE date_ajout = DATE_FORMAT(SYSDATE(),'%Y-%m-%d');");
    $stmt->execute();
    $rs = $stmt->get_result();
    $compteur = $rs->fetch_array(MYSQLI_NUM);
    $db->close();
    return $compteur;
}
