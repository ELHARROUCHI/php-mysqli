<?php
$id = $_REQUEST['id'];
$conexion = mysql_connect("localhost","root","handuGui");
mysql_selectdb("usuario",$conexion);
$filas = mysql_query("select * from foto where id = $id", $conexion);
$numeroFilas = mysql_num_rows($filas);
	$fila = mysql_fetch_array($filas);
	$nombre = $fila['nombre'];
	$archivo = $fila['archivo'];
	$tipo = $fila['tipo'];
	
	//$archivo = addslashes($archivo);
	header("Content-type: $tipo");
	
	print($archivo);

?>
