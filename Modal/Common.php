<?php

class Common
{
    function connexion(): void
    {
        $db = new mysqli("127.0.0.1", "rafael", "rafael", "entreprise");
    }
}
