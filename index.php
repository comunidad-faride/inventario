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
		<link rel="stylesheet" href="./css/estilo.css" />
		<?php
			$xajax->printJavascript("xajax/");
		?>
	</head>
	<body>
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
<!--		<script src="./js/awesomplete.min.js" async></script>-->
		<!--<script src="./js/lockr.min.js"></script>-->	<!-- ARCHIVO PARA TRANSFERIR DATOS DE PHP A JAVASCRIPT	-->
		<!--<script src="./js/fncautoZ9.js"></script>-->	<!-- ARCHIVO CON INSTRUCCIONES JQUERY PARA AUTOCOMPLETAR	-->
		<script lang="javascript">
			xajax_asignarConXajax("contenedor", "innerHTML", "CLS_USUARIO", "frmLogin");//	FUNCIONA EXCELENTE  ...
			//xajax_asignarConXajax('contenedor', 'innerHTML', 'CLS_TBLPAGOS', 'resumenPago',10);//	FUNCIONA EXCELENTE  ...
			//xajax_showGrid("CLS_TBLPAGOS");
			//xajax_showGrid("CLS_VENTAS");
		</script>
		<div id='main' class="containery">
			<header>
				<section class="logon">
					<img src="./images/logofaride.png" alt="logo" id="logito">
				</section>
				<section class="empresa">
					<h2 class="c1">
						Creaciones
					</h2>
					<h1>
						Faride
					</h1>
					<h2 class="c3">
						Collections
					</h2>
				</section>
				<div class="parrot">
					<h3>
						Sistema de Control de Tiendas
					</h3>
				</div>
			</header>
			<section class="menu"  style="margin-bottom: -50px">
				<nav id="menu">
					<?php echo menu();?>
				</nav> 
			</section>
			<section class="contenedor" id="contenedor" style="margin:auto" >
			</section>
			<footer>
				&copy; Prof. J. Delgado - Prof. L.Santander (2017)
			</footer>
		</div>
	</body>
</html>