<?php

include_once(__DIR__ . "/../DAO/EmployeDAO.php");

class EmployeService extends EmployeDAO
{

    public function selectAllEmploye(): array
    {
        $EmployeDAO = new EmployeDAO;
        $Employe = $EmployeDAO->selectAllEmploye();
        return $Employe;
    }

    public function insererEmp(Employe $obj): void
    {
        $objDAO = new EmployeDAO;
        $objDAO->insererEmp($obj);
    }

    function updateEmploye(Employe $obj, int $id): void
    {
        $objDAO = new EmployeDAO;
        $objDAO->updateEmploye($obj, $id);
    }

    function supprimeEmployes(int $id): void
    {
        $objSup = new EmployeDAO;
        $objSup->supprimeEmployes($id);
    }

    function listeChef(): array
    {
        $EmployeDAO = new EmployeDAO;
        $Employe = $EmployeDAO->listeChef();
        return $Employe;
    }

    function compteur(): int
    {
        $EmployeDAO = new EmployeDAO;
        $Employe = $EmployeDAO->compteur();
        return $Employe;
    }

    function selectAllById(int $id): Employe
    {
        $EmployeDAO = new EmployeDAO;
        $Employe = $EmployeDAO->selectAllById($id);
        return $Employe;
    }

    function maxNoemp(): int
    {
        $EmployeDAO = new EmployeDAO;
        $Employe = $EmployeDAO->maxNoemp();
        return $Employe;
    }
}
