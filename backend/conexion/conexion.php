<?php
$server = "X.X.X.X";
$user = "xxxxxxx";
$pass = "xxxxxxxxxx";
$bd = "modelo_bd_leidy";

//Creamos la conexión
$conexion = mysqli_connect($server, $user, $pass,$bd) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");
