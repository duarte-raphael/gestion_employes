<?php

include_once(__DIR__ . "../Modal/Utilisateur.php");
include_once(__DIR__ . "/../Modal/Common.php");

class UtilisateurDAO
{
    function selectAllByNom($nom): Utilisateur
    {
        $db = new mysqli("127.0.0.1", "rafael", "rafael", "entreprise");
        $stmt = $db->prepare("SELECT * FROM utilisateur WHERE nom = ?");
        $stmt->bind_param("s", $nom);
        $stmt->execute();
        $rs = $stmt->get_result();
        $dataUtilisateur = $rs->fetch_array(MYSQLI_ASSOC);
        $obj = new Utilisateur;
        $obj->setId($dataUtilisateur["id"]);
        $obj->setNom($dataUtilisateur["nom"]);
        $obj->setHash_password($dataUtilisateur["hash_password"]);
        $obj->setProfil($dataUtilisateur["profil"]);
        $db->close();
        return $obj;
    }

    function nextId(): int
    {
        $db = new mysqli("127.0.0.1", "rafael", "rafael", "entreprise");
        $stmt = $db->prepare("SELECT max(id) FROM utilisateur;");
        $stmt->execute();
        $rs = $stmt->get_result();
        $data = $rs->fetch_array(MYSQLI_NUM);
        $nextId = $data[0] + 1;
        $db->close();
        return $nextId;
    }

    function listeNomUser(): array
    {
        $db = new mysqli("127.0.0.1", "rafael", "rafael", "entreprise");
        $stmt = $db->prepare("SELECT DISTINCT nom FROM utilisateur;");
        $stmt->execute();
        $rs = $stmt->get_result();
        $tabNom = $rs->fetch_array(MYSQLI_ASSOC);
        $db->close();
        return $tabNom;
    }
    function insererUser(Utilisateur $obj): void
    {
        $db = new mysqli("127.0.0.1", "rafael", "rafael", "entreprise");
        $id = $this->nextId();
        $nom = $obj->getNom();
        $mdpHash = $obj->getHash_password();
        $stmt = $db->prepare("INSERT INTO utilisateur (id, nom, hash_password) 
    VALUES (?, ?, ?);");
        $stmt->bind_param("iss", $id, $nom, $mdpHash);
        $stmt->execute();
        $db->close();
    }
}
