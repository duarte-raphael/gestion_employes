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
    $db = new mysqli("127.0.0.1", "rafael", "rafael", "entreprise");
    $stmt = $db->prepare("SELECT max(noemp) FROM employes;");
    $stmt->execute();
    $rs = $stmt->get_result();
    $data = $rs->fetch_array(MYSQLI_NUM);
    $nextId = $data[0] + 1;
    $db->close();
    return $nextId;
}

//pas reussi encore
function insererEmp($tab, $comm, $Id)
{
    $db = new mysqli("127.0.0.1", "rafael", "rafael", "entreprise");
    $stmt = $db->prepare("INSERT INTO employes (noemp, nom, prenom, emploi, sup, embauche, sal, comm, noserv) 
    VALUES (?,?,?,?,?,?,?,?,?);");
    $stmt->bind_param(
        "isssisddi",
        $Id,
        $tab["nom"],
        $tab["prenom"],
        $tab["emploi"],
        $tab["sup"],
        $tab["embauche"],
        $tab["sal"],
        $comm,
        $tab["noserv"]
    );
    $stmt->execute();
    $db->close();
}
