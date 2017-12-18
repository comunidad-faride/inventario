<?php
// Get current directory
echo getcwd() . "<br>";

// Change directory
chdir("../");

// Get current directory
echo getcwd();

	$directorio = array();
	$archivo = array();
	$carpeta = "D:/wamp/www/";
	chdir("D:/wamp/www/");
	$d = dir(getcwd());
	
	echo "Handle: " . $d->handle . "<br>";
	echo "Path: " . $d->path . "<br>";
	while (($file = $d->read()) !== false){ 
		if(is_dir($file)){
	//		echo "Directorio: $file<br>";
			$directorio[] = $file;
		}else{
	//  		echo "<b>Archivo: " . $file . "</b><br>"; 
	  		$archivo[] = $file;
		}
	} 
	
	$d->close(); 
	
	/*	$n = count($directorio);
	echo "Lista de $n Directorio(s)<br/>";
	for($i=0; $i<$n; $i++ ){
		echo $directorio[$i]."<br/>";
	}*/
	
	$n = count($archivo);
	echo "<br/><b>Lista de $n archivos en la carpeta $carpeta</b><br/>";
	for($i=0; $i<$n; $i++ ){
		echo $archivo[$i]."<br/>";
	}
?>