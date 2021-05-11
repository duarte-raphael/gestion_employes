<?php

include_once(__DIR__ . "../DAO/UtilisateurDAO.php");

class UtilisateurService extends UtilisateurDAO
{
    function selectAllByNom($nom): Utilisateur
    {
        $UtilisateurDAO = new UtilisateurDAO;
        $Utilisateur = $UtilisateurDAO->selectAllByNom($nom);
        return $Utilisateur;
    }

    function nextId(): int
    {
        $UtilisateurDAO = new UtilisateurDAO;
        $Utilisateur = $UtilisateurDAO->nextId();
        return $Utilisateur;
    }

    function listeNomUser(): array
    {
        $UtilisateurDAO = new UtilisateurDAO;
        $Utilisateur = $UtilisateurDAO->listeNomUser();
        return $Utilisateur;
    }
    function insererUser(Utilisateur $obj): void
    {
        $UtilisateurDAO = new UtilisateurDAO;
        $UtilisateurDAO->insererUser($obj);
    }
}
