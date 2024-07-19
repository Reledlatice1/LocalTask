<?php 
$hostname = "mysql-tanukistyles.alwaysdata.net";
$username = "368585";
$password = "46154774";
$database = "tanukistyles_localtask";

$conexion = new mysqli($hostname, $username, $password, $database);
if($conexion->connect_error){
    die("la conexcion a fallado: " . $conexion->connect_error);
}
?>