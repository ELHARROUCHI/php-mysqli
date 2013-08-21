<?php 

$nombre = $_REQUEST['nombre'];

$tamanno = $_FILES['archivo']['size'];  // Tamańo del archivo
$nombreArchivo = $_FILES['archivo']['name'];  // nombre que tenia el archivo cuando lo subio el usuario
$tipoArchivo = $_FILES['archivo']['type']; // tipo del archivo
$nombreTemporal = $_FILES['archivo']['tmp_name']; // nombre con el que se sube al servidor
$error = $_FILES['archivo']['error'];

print("Tamańo: $tamanno <br/>");
print("nombre: $nombreArchivo <br/>");
print("tipoArchivo: $tipoArchivo <br/>");
print("nombre temporal: $nombreTemporal <br/>");

if($error == 0){
	if($tamanno < 50000){
		if($tipoArchivo == "image/gif" || $tipoArchivo == "image/jpeg" || $tipoArchivo=="image/pjpeg"){
			print("TODO CORRECTO");
			$nuevoNombreArchivo = date("j_Y H_i").$nombreArchivo;
			
			
			// guardar la foto en una BD
			
			// abro el archivo (en modo solo lectura y en modo binario)
			$elArchivo = fopen($nombreTemporal,"rb");
			// leo el archivo (pasarlo de disco duro a memoria)
			$contenido = fread($elArchivo,$tamanno);
			// pone \  donde sea necesario
			$contenido = addslashes($contenido);
			// cierro el archivo
			fclose($elArchivo);
			
			

			
			$conexion = mysql_connect("localhost","root","handuGui");
			mysql_selectdb("usuario",$conexion);
			mysql_query("INSERT INTO foto(nombre,archivo,tipo) VALUES('$nombre','$contenido','$tipoArchivo')",$conexion) 
						or die("Error al insertar:".mysql_error($conexion));
			mysql_close($conexion);
			
			
			// esto guarda mi archivo temporal en un archivo situado en el servidor.
			move_uploaded_file($nombreTemporal, "imagenes/$nuevoNombreArchivo");
				
			
		}else{
			print("Error solo puedes subir archivos de tipo gif y jpeg");
		}
	}else{
		print("Error el archivo es muy grande, comprimelo y vuelve a enviarlo.");
	}
}else{
	print("Error al subir el archivo.");
}
?>
