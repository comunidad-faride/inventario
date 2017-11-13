<?php
//		funciones_xajax.php
//		Prof. José R. Delgado E. 
//			Julio de 2015.

//-----------------------------------------------------------------------
/**
*ESTABLECE UN VALOR O PROPIEDAD DE UN OBJETO CON XAJAX. 
*
*@param 	string 	$idElemento Identificacion (id) del elemento que sera afectado por la funcion.
*@param 	string 	$atributo	nombre del atributo HTML que recibira la funcion.
*@param 	string 	$funcion 	Nombre de la funcion que se ejecutara
*@param 	string 	$parFun		Argumentos que recibira la funcion.
*@return 	Ejecuta la clase xajaxResponse sobre el elemento identificado.	
*/		
	function asignarConXajax($idElemento, $atributo, $clase = NULL, $funcion = "" , $parFun = NULL){
		// por mejorar cuando es en el mètodo de una clase se tienen muchos argumentos.
		if($parFun==NULL AND $clase == NULL){
			$resultado = $funcion();
		}else{
			if($clase == NULL){
				if(!is_array($parFun)){
					$resultado = $funcion($parFun);
				}else{
					$resultado = $funcion($parFun);
				}
			}else{
				$lClase = new $clase();
				if($parFun == NULL){
					$resultado = $lClase->$funcion();
				}
				if(!is_array($parFun)){
					$resultado = $lClase->$funcion($parFun);
				}else{
					//El argumento es un arreglo...
				}
			}
		}
		$xr = new xajaxResponse();
		$xr->assign($idElemento, $atributo, $resultado);
		return $xr; 	
	}	
		
function menu(){
	$ac01 = "onclick=\"xajax_showGrid('CLS_ENTREGAS');\"";
	$ac02 = "onclick=\"xajax_showGrid('CLS_TBLPRODUCTOS');\"";
	$ac03 = "onclick=\"xajax_showGrid('CLS_VENTAS');\"";
	$ac04 = "onclick=\"xajax_showGrid('CLS_TBLUSUARIOS');\"";
	$ac05 = "onclick=\"xajax_showGrid('CLS_TBL_CUENTAS');\"";
	$ac06 = "onclick=\"xajax_showGrid('CLS_TBL_PAGOS');\"";
	$ac07 = "onclick=\"xajax_asignarConXajax('contenedor', 'innerHTML', 'CLS_REPORTES', 'frmReportesInventario');\"";
	$ac08 = "onclick=\"xajax_showGrid('CLS_TBLPRODUCTOS');\"";
	$ac09 = "onclick=\"xajax_showGrid('CLS_TBLTIENDAS');\"";
	$ac11 = "onclick=\"xajax_showGrid('CLS_TBLFORMASPAGO');\"";
	$ac10 = "onclick=\"xajax_asignarConXajax('contenedor', 'innerHTML', 'CLS_USUARIO', 'frmCambioClave', 'fulano');\"";
	$htm ="<div id='cssmenu'>
		<ul>
		   	<li class='active has-sub'><a href='#' ><span>F&aacute;brica</span></a>
		      	<ul>
					<li class='last'><a href='#' $ac01><span>Env&iacute;os</span></a></li>
					<!--<li class='last'><a href='#' ><span>Estad&iacute;stica</span></a></li>-->
					<!--<li class='last'><a href='#' ><span>Reportes</span></a></li>-->
		      	</ul>
		   	</li>
		 	<li class='active has-sub'><a href='#'><span>Tiendas</span></a>
			   	<ul>
			         <li class='last'><a href='#' $ac03><span>Ventas</span></a></li>
			         <!--<li class='last'><a href='#' ><span>Ajustes</span></a></li>
		   			 <li><a href='#'  ><span>Validar pagos</span></a></li>-->
		   			 <li><a href='#' $ac07 ><span>Reportes</span></a></li>
			   	</ul>
		   	</li>
		   	<li class='active has-sub'><a href='#'><span>Cat&aacute;logos</span></a>
			   	<ul>
			        <li class='last'><a href='#' $ac11><span>Formas de pago</span></a></li>
			        <li class='last'><a href='#' $ac08><span>Productos</span></a></li>
			        <li class='last'><a href='#' $ac09><span>Tiendas</span></a></li>
			        <li class='last'><a href='#' $ac04><span>Usuarios</span></a></li>
			        <li class='last'><a href='#' $ac10><span>Cambio de clave</span></a></li>
			   	</ul>
		   	</li>
		</ul>
		</div>";
		return $htm;
}	
	
function funcion_lenta(){
	sleep(3);
	$objResponse = new xajaxResponse();
	$objResponse->Assign("capa_cargando","innerHTML","Finalizado");
//	$objResponse->script("document.getElementById('transparente').style='display:none'");
	return $objResponse;
}
	
	
?>