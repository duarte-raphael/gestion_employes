<?php


session_start();
if (!$_SESSION['nom']) {
    header('Location: index.php');
}
if (isset($_GET["id"])) {

    supprimeEmployes($_GET["id"]);

    header("location: tableau.php");
} else {
    echo "suppression echoué";
}

function supprimeEmployes($id)
{
    $bdd = mysqli_init();
    mysqli_real_connect($bdd, "127.0.0.1", "rafael", "rafael", "entreprise");
    mysqli_query($bdd, "DELETE FROM employes WHERE noemp = " . $id . ";");
    mysqli_close($bdd);
}
