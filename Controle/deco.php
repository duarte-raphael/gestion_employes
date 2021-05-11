<?php

function deconnexionSession()
{
    session_start();
    unset($_SESSION["nom"]);
    session_destroy();
    header("location: index.php");
}
deconnexionSession();
