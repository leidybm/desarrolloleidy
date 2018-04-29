<?php

include '../conexion/conexion.php';

if (isset($_GET['parametro']) && $_GET['parametro'] == 'consul1') {
    $sql = "SELECT * FROM modelo_bd_leidy.itinerario";
    mysqli_set_charset($conexion, "utf8");

    if (!$result = mysqli_query($conexion, $sql))
        die();

    $clientes = array();

    while ($row = mysqli_fetch_array($result)) {
        $idtrayectos = $row['idtrayectos'];
        $ciudad_origen = $row['ciudad_origen'];
        $ciudad_destino = $row['ciudad_destino'];
        $fecha_salida = $row['fecha_salida'];
        $duracion = $row['duracion'];


        $clientes[] = array('idtrayectos' => $idtrayectos, 'ciudad_origen' => $ciudad_origen, 'ciudad_destino' => $ciudad_destino,
            'fecha_salida' => $fecha_salida, 'duracion' => $duracion);
    }


    $close = mysqli_close($conexion)
            or die("Ha sucedido un error inexperado en la desconexion de la base de datos");



    $json_string = json_encode($clientes, JSON_UNESCAPED_UNICODE);
    echo $json_string;
} else if (isset($_GET['parametro']) && $_GET['parametro'] == 'consul2') {
    $sql = "SELECT * FROM modelo_bd_leidy.ciudades";
    mysqli_set_charset($conexion, "utf8");
    if (!$result = mysqli_query($conexion, $sql))
        die();

    $clientes = array();

    while ($row = mysqli_fetch_array($result)) {
        $idciudades = $row['idciudades'];
        $nombre = $row['nombre'];



        $clientes[] = array('idciudades' => $idciudades, 'nombre' => $nombre);
    }


    $close = mysqli_close($conexion)
            or die("Ha sucedido un error inexperado en la desconexion de la base de datos");



    $json_string = json_encode($clientes, JSON_UNESCAPED_UNICODE);
    echo $json_string;
} else if (isset($_POST['parametro']) && $_POST['parametro'] == 'consul3') {

    $ciu_origen = $_POST['ciu_origen'];
    $ciu_destino = $_POST['ciu_destino'];
    $fechA = $_POST['fecha'];

    $consul = mysqli_query($conexion, "SELECT * FROM modelo_bd_leidy.trayectos where ciudad_origen='$ciu_origen' and ciudad_destino='$ciu_destino' and date(fecha_salida)='$fechA'");
    $can = mysqli_num_rows($consul);
    $trayecto = mysqli_fetch_array($consul);

    if ($can == 0) {
        echo "msm_tg6";
    } else {
        $idtrayectos = $trayecto['idtrayectos'];

        $sql = "SELECT estado,count(estado) as cantidad FROM modelo_bd_leidy.puestos_vuelo where idtrayectos=$idtrayectos";
        mysqli_set_charset($conexion, "utf8");
        if (!$result = mysqli_query($conexion, $sql))
            die();

        $clientes = array();

        while ($row = mysqli_fetch_array($result)) {
            $estado = $row['estado'];
            $cantidad = $row['cantidad'];

            $clientes[] = array('estado' => $estado, 'cantidad' => $cantidad, 'idtrayectos' => $idtrayectos);
        }

        $close = mysqli_close($conexion)
                or die("Ha sucedido un error inexperado en la desconexion de la base de datos");



        $json_string = json_encode($clientes, JSON_UNESCAPED_UNICODE);
        echo $json_string;
    }
} else if (isset($_POST['parametro']) && $_POST['parametro'] == 'consul4') {

$edad=$_POST['edad'];
$idtrayecto=$_POST['idtrayecto'];
    
    
  $consul=mysqli_query($conexion,"SELECT * FROM modelo_bd_leidy.descuento where edad=$edad");  
  $can=  mysqli_num_rows($consul);
  $trayecto = mysqli_fetch_array($consul); 
  
  if($can==0){
      echo "msm_tg6";
  }else{
  $descuento=$trayecto['descuento'];
      
  $sql = "SELECT * FROM modelo_bd_leidy.categorias_trayectos where idtrayectos='$idtrayecto'"; 
   mysqli_set_charset($conexion, "utf8");
   if(!$result = mysqli_query($conexion, $sql)) die();
   
   $clientes = array(); 

 while($row = mysqli_fetch_array($result)) 
{ 
    $valor = $row['valor'];

    $clientes[] = array('valor'=>$valor,'descuento'=>$descuento); 

}
   
$close = mysqli_close($conexion)
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
  


$json_string = json_encode($clientes, JSON_UNESCAPED_UNICODE);
echo $json_string;  
    
}
}
?>