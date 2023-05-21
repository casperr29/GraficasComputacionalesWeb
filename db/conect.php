<?php

function conectar()
{

    $user = "root";
    $pass = "root";
    $server = "localhost";
    $db = "CRAZY_RAZER_DB";
    $con = mysqli_connect($server, $user, $pass, $db) or die("Error al conectar a la base de datos" . mysqli_error($con));

    return $con;
}
