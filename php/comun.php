<?php
	//session_start();

	/*define("LOG_ENABLED", 0); // Enable debuggin
	define("FILE_LOG", "/tmp/xajaxDebug.log");  // File to debug.
	define("ROWSXPAGE", 5); // Number of rows show it per page.
	define("MAXROWSXPAGE", 10);  // Total number of rows show it when click on "Show All" button.
*/

//	INICIO DE LA CLASE XAJAX.	
	require ('./xajax/xajax_core/xajax.inc.php');
	$xajax = new xajax();
//	$xajax->setFlag("debug", true);
	$xajax->setCharEncoding("ISO-8859-1");
//	$xajax->configure("language","es");

//   funciones comunes de la clase xajaxgrid.
	$xajax->register(XAJAX_FUNCTION,"showGrid");
	$xajax->register(XAJAX_FUNCTION,"add");
	$xajax->register(XAJAX_FUNCTION,"edit");
	$xajax->register(XAJAX_FUNCTION,"show");
	$xajax->register(XAJAX_FUNCTION,"delete");
	$xajax->register(XAJAX_FUNCTION,"save");
	$xajax->register(XAJAX_FUNCTION,"update");
//-----------------------------------------------------------------------------------------------
//	Otras funciones XAJAX...
//-----------------------------------------------------------------------------------------------	
	$xajax->register(XAJAX_FUNCTION, 'asignarConXajax');
	$xajax->register(XAJAX_FUNCTION, array("validaUsuario", "CLS_USUARIO","validaUsuario"),"cls_tblusuario.php");
	$xajax->register(XAJAX_FUNCTION, array("cambiaClave", "CLS_USUARIO","cambiaClave"),"cls_tblusuario.php");
	$xajax->register(XAJAX_FUNCTION, array("cambiarNumFactura", "CLS_VENTAS","cambiarNumFactura"),"cls_ventas.php");
	$xajax->register(XAJAX_FUNCTION, array("camposTabla", "CLS_VENTAS","camposTabla"),"cls_ventas.php");
	$xajax->register(XAJAX_FUNCTION, array("pagoCredito", "CLS_TBLPAGOS","pagoCredito"),"cls_tblpagos.php");
	
/*	
	$xajax->register(XAJAX_FUNCTION,"autocompletar");
	$xajax->register(XAJAX_FUNCTION,"funcion_lenta");	
*/	
	$xajax->processRequest();
	
?>
