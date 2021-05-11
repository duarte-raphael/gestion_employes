<?php

class Utilisateur
{
    private $id;
    private $nom;
    private $hash_password;
    private $profil;

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nom
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */
    public function setNom(string $nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of hash_password
     */
    public function getHash_password(): string
    {
        return $this->hash_password;
    }

    /**
     * Set the value of hash_password
     *
     * @return  self
     */
    public function setHash_password(string $hash_password)
    {
        $this->hash_password = $hash_password;

        return $this;
    }

    /**
     * Get the value of profil
     */
    public function getProfil(): string
    {
        return $this->profil;
    }

    /**
     * Set the value of profil
     *
     * @return  self
     */
    public function setProfil(string $profil)
    {
        $this->profil = $profil;

        return $this;
    }
}
