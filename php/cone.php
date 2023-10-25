<?php
// Direcci��n o IP del servidor MySQL
$host = "localhost";

// Puerto del servidor MySQL
$puerto = "3306";

// Nombre de usuario del servidor MySQL
$usuario = "britishs_usercasinocomedor";
//   $usuario = "root";

// Contrase�0�9a del usuario
$contrasena = "#IojgrwW!N}i";
//   $contrasena = "";

// Nombre de la base de datos
//   $baseDeDatos ="britishs_permisos_test";
$baseDeDatos = "britishs_permisos";


function Conectarse()
{
    global $host, $puerto, $usuario, $contrasena, $baseDeDatos;

    if (!($link = mysqli_connect($host, $usuario, $contrasena))) {
        echo "Error conectando a la base de datos.<br>";
        exit();
    } else {

        //   echo "Listo, estamos conectados.<br>";
    }
    if (!mysqli_select_db($link, $baseDeDatos)) {
        echo "Error seleccionando la base de datos.<br>";
        exit();
    } else {
        // echo "Obtuvimos la base de datos $baseDeDatos sin problema.<br>";
    }
    return $link;
}

?>