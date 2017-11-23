<?php
/*
	Validación de patrones:
	argumentos:  
	string 	valor		Cadena de caracteres a evaluar.
	int		i_patron	Entero para indicar el tipo de patrón.  Loa valores son:
		0 =>	Patrón para email.
		1 =>	Patrón para nombres.  Incluye espacios en blanco,  acentos y eñes.
		2 =>	Patrón alfanumérico.  Al igual que (1), admite blancos, acentos y eñes.
		3 =>	Patrón numérico.  Admite tantos dígitos como los indicado en el siguiente argumento.
		4 =>	Patrón alfabético. No admite espacios en blanco pero si acentos y eñes.
		5 =>	Patrón para fechas en formato dd/mm/aaaa.
		6 =>	Patrón numérico con hasta dos decimales. No admite los signos de + o -.
		7 =>	Igual al anterior pero con admisión de los signos de mas o menos.
	int 	digitos		Entero para indicar la cantidad de dígitos que tendrá la cadena a evaluar.
	return string y focaliza en el id pasado por argumento.
*/

define("EMAIL",		0);//  Correo electrónico
define("LETRASYES",	1);//  Letras y espacios en blanco
define("ALFANUMYES",2);//  Alfanumérico y espacios en blanco.
define("DIGITOS", 	3);//  Sólo dígitosq
define("LETRAS",	4);//  Sólo letras
define("FECHA",		5);//  Fechas en formato dd/mm/aaaa
define("REAL",		6);//  Número real con  dos dígitos decimales y coma (,) por separador decimal
define("REAL_SIG",	7);//  Igual al anterior pero con signo
define("ALFANUM",   8);//  Alfanumérico, sin espacios en blanco.
define("ALFNUMCE",  9);//  Alfanumérico con caracteres especiales (), sin espacio en blanco, ´minimo de 8 caracteres
function validarPatron ($valor, $i_patron, $digitos = 2) {
	$arrPatron = array(
	"/^[a-zaA-Z0-9]+([.]{0,1}[_]{0,1}[-]{0,1}[a-zA-Z0-9]+)*[@][a-zA-Z0-9]+[.][a-zA-Z]{2,3}([.][a-zA-Z]{2}){0,1}$/",
	"/^[a-zA-ZÁÉÍÓÚáéíóúñÑ]{2,}([\sa-zA-ZÁÉÍÓÚáéíóúñÑ]{2,})*$/",
	"/^[a-zA-Z0-9ÁÉÍÓÚáéíóúñÑ]{2,}([\sa-zA-Z0-9ÁÉÍÓÚáéíóúñÑ]{1,12})*$/",
	"/^[0-9]{".$digitos."}$/",
	"/^[a-zA-ZÁÉÍÓÚáéíóúñÑ]{1,}$/",
	"/^(0[1-9]|[12][0-9]|3[01])[-\/.](0[1-9]|1[012])[-\/.](19|20)\d\d$/",
	"/^[0-9]+([,]{1}[0-9]{1,2})?$/",
	"/^[\+|-]?\d+(,\d{1,2})?$/",
	"/^([a-zA-ZÁÉÍÓÚáéíóúñÑ1234567890]{4,})$/",
	"/^([@#%$&*()-.!?;<>\w\S]{8,})$/");
	$arrMsg = array(
	"Email inválido.",
	"Solo puede contener letras y espacios en blanco.",
	"Solo admite caracteres alfanuméricos y espacios en blanco.",
	"Solo admite $digitos d&iacute;gitos.",
	"Solo admite caracteres alfab&eacute;ticos",
	"Solo admite fechas en el formato dd/mm/aaaa",
	"Solo admite números con hasta dos (2) decimales con coma (,) como separador decimal",
	"Solo admite números reales (positivos o negativos) con hasta dos (2) decimales",
	"Solo adminte letras y números. No se admiten espacios en blanco. Mínimo de 4 caracteres.",
	"Este campo solo adminte un m&iacute;nimo de 8 caracteres entre letras, n&uacute;meros y los siguientes caracteres especiales: @#%$&*()-.!?;<>");
	$mensaje = "";
	$patron = ($arrPatron[$i_patron]);
	if( !preg_match($patron, $valor) ){
		$mensaje = utf8_decode($arrMsg[$i_patron]);
	}
/*	else{
		echo utf8_decode("$valor: La vaina está buena según el patrón.");
	}*/
	return $mensaje;	
}
//----------------------------------------------------------------------------------

//			PRUEBAS


/*$valor = "delgado@gmail.com";
	echo (validarPatron($valor,EMAIL)."<br/>");
$valor = "caña y patrón";
	echo (validarPatron($valor,LETRASYES)."<br/>");
$valor = "caña patrón y otras vainas como 123445";
	echo (validarPatron($valor,ALFANUMYES)."<br/>");
$valor = "746453";
	echo (validarPatron($valor,DIGITOS,6)."<br/>");	
$valor = "poiqwueráéLASKJDF";
	echo (validarPatron($valor,LETRAS)."<br/>");
$valor = "31/12/2017";
	echo (validarPatron($valor,FECHA)."<br/>");
$valor = "54653,25665";
	echo (validarPatron($valor,REAL)."<br/>");
$valor = "-746453,356";
	echo (validarPatron($valor,REAL_SIG,6)."<br/>");	

 $valor = "ñlka759";
 echo (validarPatron($valor, ALFANUM)."<br/>");/*	
 $valor = "chuchanita*1993";
 echo (validarPatron($valor, ALFNUMCE)."<br/>");*/
 
?>