<?php

include_once(__DIR__ . "/../Service/EmployeService.php");

if (
    isset($_POST["noemp"]) && isset($_POST["nom"]) && isset($_POST["prenom"]) &&
    isset($_POST["emploi"]) && isset($_POST["sup"]) && isset($_POST["embauche"]) && isset($_POST["sal"]) &&
    isset($_POST["comm"]) && isset($_POST["noserv"])
) {
    $objService = new EmployeService;
    $nextId = $objService->maxNoemp();

    if ($_POST["comm"] == "") {
        $commission = null;
    } else {
        $commission = $_POST["comm"];
    }
    $objPost = new Employe;
    $objPost->setNoemp($nextId);
    $objPost->setNom($_POST["nom"]);
    $objPost->setPrenom($_POST["prenom"]);
    $objPost->setEmploi($_POST["emploi"]);
    $objPost->setEmbauche($_POST["embauche"]);
    $objPost->setSup($_POST["sup"]);
    $objPost->setSal($_POST["sal"]);
    $objPost->setComm($commission);
    $objPost->setNoserv($_POST["noserv"]);
    $objService->insererEmp($objPost);

    header("location: tableau.php");
} else {
    echo "erreur de saisie";
}
