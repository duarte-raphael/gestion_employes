<?php

class Common
{
    function connexion()
    {
        $db = new mysqli("127.0.0.1", "rafael", "rafael", "entreprise");
        return $db;
    }
}
