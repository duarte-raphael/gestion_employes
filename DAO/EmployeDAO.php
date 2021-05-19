<?php

include_once(__DIR__ . "/../Modal/Employe.php");
include_once(__DIR__ . "/Common.php");

class EmployeDAO extends Common
{
    function supprimeEmployes(int $id): void
    {
        $db = $this->connexion();
        $stmt = $db->prepare("DELETE FROM employes WHERE noemp = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $db->close();
    }

    function selectAllEmploye(): array
    {
        $db = $this->connexion();
        $stmt = $db->prepare("SELECT * FROM employes;");
        $stmt->execute();
        $rs = $stmt->get_result();
        $data = $rs->fetch_all(MYSQLI_ASSOC);
        $tabEmploye = [];
        foreach ($data as $ligne) {
            $employe = new Employe;
            $employe->setNoemp($ligne["noemp"]);
            $employe->setNom($ligne["nom"]);
            $employe->setPrenom($ligne["prenom"]);
            $employe->setEmploi($ligne["emploi"]);
            $employe->setSup($ligne["sup"]);
            $employe->setEmbauche($ligne["embauche"]);
            $employe->setSal($ligne["sal"]);
            $employe->setComm($ligne["comm"]);
            $employe->setNoserv($ligne["noserv"]);
            $employe->setDateAjout($ligne["date_ajout"]);
            $tabEmploye[] = $employe;
        }
        $db->close();
        return $tabEmploye;
    }

    function listeChef(): array
    {
        $db = $this->connexion();
        $stmt = $db->prepare("SELECT DISTINCT sup FROM employes;");
        $stmt->execute();
        $rs = $stmt->get_result();
        $tabSup = $rs->fetch_all(MYSQLI_ASSOC);
        $db->close();
        return $tabSup;
    }

    function compteur(): int
    {
        $db = $this->connexion();
        $stmt = $db->prepare("SELECT COUNT(date_ajout) FROM employes WHERE date_ajout = DATE_FORMAT(SYSDATE(),'%Y-%m-%d');");
        $stmt->execute();
        $rs = $stmt->get_result();
        $compteur = $rs->fetch_array(MYSQLI_NUM);
        $db->close();
        return $compteur[0];
    }

    function updateEmploye(Employe $obj, int $id): void
    {
        $db = $this->connexion();
        $nom = $obj->getNom();
        $prenom = $obj->getPrenom();
        $emploi = $obj->getEmploi();
        $sup = $obj->getSup();
        $embauche = $obj->getEmbauche();
        $sal = $obj->getSal();
        $comm = $obj->getComm();
        $noserv = $obj->getNoserv();
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
            "sssisddii",
            $nom,
            $prenom,
            $emploi,
            $sup,
            $embauche,
            $sal,
            $comm,
            $noserv,
            $id
        );
        $stmt->execute();
        mysqli_close($db);
    }

    function selectAllById(int $id): Employe
    {
        $db = $this->connexion();
        $stmt = $db->prepare("SELECT * from employes where noemp = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $rs = $stmt->get_result();
        $tabNom = $rs->fetch_array(MYSQLI_ASSOC);
        $obj = new Employe;
        $obj->setNoemp($tabNom["noemp"]);
        $obj->setNom($tabNom["nom"]);
        $obj->setPrenom($tabNom["prenom"]);
        $obj->setEmploi($tabNom["emploi"]);
        $obj->setSup($tabNom["sup"]);
        $obj->setEmbauche($tabNom["embauche"]);
        $obj->setSal($tabNom["sal"]);
        $obj->setComm($tabNom["comm"]);
        $obj->setNoserv($tabNom["noserv"]);
        $db->close();
        return $obj;
    }

    function maxNoemp(): int
    {
        $db = $this->connexion();
        $stmt = $db->prepare("SELECT max(noemp) FROM employes;");
        $stmt->execute();
        $rs = $stmt->get_result();
        $data = $rs->fetch_array(MYSQLI_NUM);
        $nextId = $data[0] + 1;
        $db->close();
        return $nextId;
    }

    function insererEmp(Employe $obj): void
    {
        $db = $this->connexion();
        $idMax = $this->maxNoemp();
        $nom = $obj->getNom();
        $prenom = $obj->getPrenom();
        $emploi = $obj->getEmploi();
        $sup = $obj->getSup();
        $embauche = $obj->getEmbauche();
        $sal = $obj->getSal();
        $comm = $obj->getComm();
        $noserv = $obj->getNoserv();
        $stmt = $db->prepare("INSERT INTO employes (noemp, nom, prenom, emploi, sup, embauche, sal, comm, noserv) 
        VALUES (?,?,?,?,?,?,?,?,?);");
        $stmt->bind_param(
            "isssisddi",
            $idMax,
            $nom,
            $prenom,
            $emploi,
            $sup,
            $embauche,
            $sal,
            $comm,
            $noserv
        );
        $stmt->execute();
        $db->close();
    }
}
