<?php

include_once(__DIR__ . "/../Service/EmployeService.php");

session_start();
$objSup = new EmployeService;
if (!$_SESSION['nom']) {
    header('Location: index.php');
}
if (isset($_GET["id"])) {

    $objSup->supprimeEmployes($_GET["id"]);

    header("location: tableau.php");
} else {
    echo "suppression echoué";
}
