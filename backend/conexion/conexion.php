<?php
$server = "172.16.7.75";
$user = "Architect03";
$pass = "@DM1N1STR4D0R2016";
$bd = "modelo_bd_leidy";

//Creamos la conexión
$conexion = mysqli_connect($server, $user, $pass,$bd) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");