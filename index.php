<?php
	include_once("./php/servidor.php");
?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximun-scale=1, minimun-scale=1">
		<meta name="INVENTARIO 2017" content="INVENTARIO 2017">
		<title>Control de Ventas en Tiendas</title>
		<!--  AGREGAR ICONO EN LA PESTAÑA DEL NAVEGADOR         -->	
		<link href='./images/favicon.ico' rel='shortcut icon' type='image/x-icon'>
		<!--    ARCHIVOS DE ESTILOS                     -->
		<link rel="stylesheet" href="./css/estilos.css" />
		<?php
			$xajax->printJavascript("xajax/");
		?>
	</head>
	<body >
	<!--	ARCHIVOS JAVASCRIPT   -->	
		<script src="./js/cargando.js"></script>
		<script src="./js/jquery-1.12.3.min.js"></script>	<!--  ARCHIVO BASE DE JQUERY  -->  
		<script src='./js/jquery.dataTables.min.js'></script>
		<script src="./js/bootstrap.min.js"></script>
		<script src="./js/dataTables.buttons.min.js"></script> 	
		<script src='./js/dataTables.responsive.min.js'></script>
		<script src="./js/dataGrid.js"></script>
		<script src="./js/modal.js"></script>      										
		<script src='./js/scw.js'></script>		<!--	Funciones para mostrar calendario.	-->
		<script src="./js/script.js"></script>
		<script src="./js/funciones.js"></script>
		<script src="./js/awesomplete.min.js" async></script>										
		<script src="./js/lockr.min.js"></script>	<!-- ARCHIVO PARA TRANSFERIR DATOS DE PHP A JAVASCRIPT	-->
		<script src="./js/fncautoZ9.js"></script>	<!-- ARCHIVO CON INSTRUCCIONES JQUERY PARA AUTOCOMPLETAR	-->	
		<script lang="javascript"> 
			//xajax_showGrid('CLS_TBLUSUARIOS');
			//xajax_asignarConXajax("contenedor", "innerHTML", "CLS_USUARIO", "frmLogin");// FUNCIONA EXCELENTE  ..	
			//xajax_asignarConXajax("contenedor", "innerHTML", "CLS_USUARIO", "frmCambioClave");
			//xajax_showGrid('CLS_TBLPRODUCTOS');
			//xajax_showGrid('CLS_TBLFORMASPAGO');
			//xajax_showGrid('CLS_TBLTIENDAS');
			//xajax_asignarConXajax("contenedor", "innerHTML", "CLS_ENTREGAS", "frmEntregas");
			//xajax_showGrid('CLS_VENTAS');
			//xajax_showGrid('CLS_ENTREGAS');
			// FALLA xajax_asignarConXajax("contenedor", "innerHTML", "CLS_VENTAS", "frmVentas");
			//xajax_asignarConXajax("contenedor", "innerHTML", "CLS_REPORTES", "frmReportesInventario");
			xajax_asignarConXajax("contenedor", "innerHTML", "CLS_TBLTIENDAS", "resumenTienda", 4);
		</script>
		<div id='main' class="container">
			<header><h1>Control de Ventas en Tiendas</h1></header>
			<div class="parrot">	</div>
		    <nav id="menu"><?php echo menu();?>	</nav>
		    <section id="contenedor">
		    
		    </section>
			<footer>&copy; Prof. J. R. Delgado Errade.  Octubre de 2017</footer>
		</div>
	</body>
</html>