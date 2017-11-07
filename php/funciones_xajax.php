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
	$ac01 = "onclick=\"xajax_showGrid('CLS_TBL_INMUEBLES');\"";
	$ac02 = "onclick=\"xajax_showGrid('CLS_TBL_TIPOS_INMUEBLES');\"";
	$ac03 = "onclick=\"xajax_showGrid('CLS_TBL_PERIODOS');\"";
	$ac04 = "onclick=\"xajax_showGrid('CLS_TBL_USUARIOS');\"";
	$ac05 = "onclick=\"xajax_showGrid('CLS_TBL_CUENTAS');\"";
	$ac06 = "onclick=\"xajax_showGrid('CLS_TBL_PAGOS');\"";
	$ac07 = "onclick=\"xajax_asignarConXajax('contenedor', 'innerHTML', 'CLS_TBL_PAGOS', 'validarPagos');\"";
	$ac08 = "onclick=\"xajax_showGrid('CLS_TBL_RECIBOS', 'contenedor', false, false, false);\"";
	$htm ="<div id='cssmenu'>
		<ul>
		   	<li class='active has-sub'><a href='#' ><span>Inmuebles</span></a>
		      	<ul>
					<li class='last'><a href='#' $ac01><span>Inmuebles Registrados</span></a></li>
					<li class='last'><a href='#' $ac02 ><span>Tipos de inmuebles</span></a></li>
		      	</ul>
		   	</li>
		   	<li><a href='#' $ac03><span>Alquileres</span></a></li>
		 	<li class='active has-sub'><a href='#'><span>Bancos</span></a>
			   	<ul>
			         <li class='last'><a href='#' $ac05><span>Cuenta(s) de propietario(s)</span></a></li>
			         <li class='last'><a href='#' $ac06><span>Hist&oacute;rico de Pagos</span></a></li>
			   	</ul>
		   	</li>
		    <li><a href='#' $ac08><span>Recibos</span></a></li>
		   	<li><a href='#' $ac04><span>Usuarios</span></a></li>
		   	<li><a href='#' $ac07 ><span>Validar pagos</span></a></li>
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