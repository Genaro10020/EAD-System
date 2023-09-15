<?php
$hostname = 'localhost';
$database = 'vvnorthc_ghoner5s';
$username = 'root';
$password = '';

$conexion = new mysqli($hostname, $username, $password,$database);

if ($conexion->connect_errno) {
   echo "Error al conectarse con la BD";
}

?>