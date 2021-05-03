<?php

if (
    isset($_POST["noemp"]) && isset($_POST["nom"]) && isset($_POST["prenom"]) &&
    isset($_POST["emploi"]) && isset($_POST["sup"]) && isset($_POST["embauche"]) && isset($_POST["sal"]) &&
    isset($_POST["comm"]) && isset($_POST["noserv"])
) {
    $nextId = maxNoemp();

    if ($_POST["comm"] == "") {
        $commission = "null";
    } else {
        $commission = $_POST["comm"];
    }
    insererEmp($_POST,  $commission, $nextId);

    header("location: tableau.php");
} else {
    echo "erreur de saisie";
}

function maxNoemp()
{
    $bdd = mysqli_init();
    mysqli_real_connect($bdd, "127.0.0.1", "rafael", "rafael", "entreprise");
    $findNextId = "SELECT max(noemp) FROM employes;";
    $max = mysqli_query($bdd, $findNextId);
    $data = mysqli_fetch_array($max, MYSQLI_NUM);
    $nextId = $data[0] + 1;
    mysqli_free_result($max);
    mysqli_close($bdd);
    return $nextId;
}

function insererEmp($tab, $comm, $Id)
{
    $bdd = mysqli_init();
    mysqli_real_connect($bdd, "127.0.0.1", "rafael", "rafael", "entreprise");
    $requette = "INSERT INTO employes (noemp, nom, prenom, emploi, sup, embauche, sal, comm, noserv) 
    VALUES (" . $Id . ", 
    '" . $tab["nom"] . "',
    '" . $tab["prenom"] . "',
    '" . $tab["emploi"] . "',
    " . $tab["sup"] . ",
    '" . $tab["embauche"] . "',
    " . $tab["sal"] . ",
    " . $comm . ",
    " . $tab["noserv"] . ");";
    mysqli_query($bdd, $requette);
    mysqli_close($bdd);
}
