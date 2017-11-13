<?php
	header('Content-Type: text/html; charset=iso-8859-1'); 
	session_start();
	date_default_timezone_set('America/Caracas');
//------------------------------------------------------------------------------------------------
	include_once("./php/cls_inventario.php");			//  Archivo con funciones de base de datos
//------------------------------------------------------------------------------------------------
/*	ARCHIVO EN PHP QUE CONTIENE LAS CONSULTAS DE DATOS A MOSTRAR EN EL AUTOCOMPLETADO			*/
//	require_once("./php/fncautoZ9.php");
//------------------------------------------------------------------------------------------------
	include_once("./php/form_items.php");			//  Funciones para el manejo de formularios.
	include_once("./php/funciones_fecha.php");		//  Funciones de fecha.
	include_once("./php/expregulares.php");			//  Función para el manejo de expresiones regulares
	include_once("./php/cls_usuario.php");
	include_once("./php/cls_ventas.php");
//	require_once('./php/xajaxGrid.inc.php');		//  Funciones del CRUD.
//	include_once("./php/funciones.php");
//-----------------------------------------
//		FUNCIONES PARA EL MANEJO DE CORREO ELECTRONICO.
//-----------------------------------------
//	include_once("./php/correo.php");
//-----------------------------------------
//		CLASES PARA EL MANEJO DE CRUD.
//-----------------------------------------
	include_once("./php/cls_tblusuarios.php");			//	Funciones de la case usuario.
	include_once("./php/cls_tblproductos.php");
	include_once("./php/cls_tblformaspago.php");
	include_once("./php/cls_tbltiendas.php");
	include_once("./php/cls_entregas.php");
	include_once("./php/cls_ventas.php");
	include_once("./php/cls_entregas.php");
	include_once("./php/cls_reportes.php");
	
/*	include_once("./php/cls_tbl_tipos_inmuebles.php");
	include_once("./php/cls_tbl_inmuebles.php");
	include_once("./php/cls_tbl_periodos.php");
	include_once("./php/cls_tbl_pagos.php");
	include_once("./php/cls_tbl_recibos.php");*/
/*	include_once("./php/cls_quincenas.php");
	include_once("./php/cls_user.php");
	include_once("./php/cls_tbl_bancos.php");
	include_once("./php/cls_tbl_tipo_movimientos.php");
	include_once("./php/cls_tbl_mov_bancarios.php");
*/
	include_once("./php/funciones_xajax.php");
//-----------------------------------------
//		REGISTRO DE FUNCIONES EN XAJAX.
//-----------------------------------------
	include_once("./php/comun.php");				
//  Funciones básicas de XAJAX.
//------------------------------------------------------------------------------------------------
/**
*	Muestra los datos paginados en el 'contenedor' designado.
*
* @param string	$CLASE		Nombre de la clase que contiene los metodos para mostrar/editar/borrar/agregar registros.
* @param string $divName	Nombre de la capa sobre la cual se ubica la grid.
* @param logico	$edit		Con true agrega boton de edicion en cada registro de la grid; con false no lo muestra.
* @param logico $delete		Coloca/quita (true/false) la opcion para eliminar el registro de la base de datos.
* @param string $ordering   Criterio de ordenamiento.
* @param logico $withNewButton	Coloca o no (true/flase) el botón para agregar un registro sobre la grid.
* @return  La grid con todos los elementos sobre el grid indicado 
*/
function showGrid($CLASE, $divName = "contenedor",  $edit=true, $delete=true, $withNewButton=true){
	$clsDatos = new $CLASE();
	$dtTabla = $clsDatos->consultagenerica($clsDatos->sqlBase);
	$encabezados = $clsDatos->encabezados();
	$campos = $clsDatos->camposBD();
	$n = count($campos);
	$nc = "style='font-weight:bold;text-align:center;' class='alerta'";//background:url(./img/background.jpg)
	$tt = "<tr>";
	foreach($encabezados as $tit){
		$tt .= "<td $nc>$tit</td>";	
	}
	if($edit){
		$tt .= "<td $nc>Editar</td>";
	}
	if($delete){
		$tt .= "<td $nc>Borrar</td>";
	}
	$tt .= "</tr>";
	$htm = "<div class='container'><div class='row fondo_datos radio'><div class='col-md-12 '>";
	$htm .= "<h3 class='text-center' style='margin-top:-3px;'>".$clsDatos->titulo."</h3>";
	$orden = $clsDatos->ordenTabla;
	$atributosCol = $clsDatos->atributosColumnas(); 
	$htm .= "<table $orden id='dataGrid' class='adminlist table table-striped table-bordered dt-responsive' cellspacing='0' width='100%'>";
	$htm .= "<thead>$tt</thed>";
	$htm .= "<tfoot>$tt</tfoot>";
	$htm .= "<tbody>";
	//  Campos a mostrar en la tabla: $clsDatos->
	// Siempre la clave primaria PK será el elemento cero del registro
	foreach($dtTabla as $registro){
		$htm .= "<tr>";
		for($i = 1; $i < $n; $i++){
			$nombreCampo = $campos[$i]; //
			$j = $i-1;
			if(is_numeric($registro[$nombreCampo]) AND strpos($registro[$nombreCampo], ".")){
				$lRegistro = numeroEspanol($registro[$nombreCampo]);	
			}else{
				$lRegistro = $registro[$nombreCampo];
			}
			$htm .= "<td $atributosCol[$j]>$lRegistro</td>";
		}
		$campoPK = $campos[0]; 
		if($edit){
			$htm .= "<td class='text-center'><a href ='#' onclick=\"xajax_edit('$CLASE', $registro[$campoPK]);\" ><img src='./img/edit.png' align='middle' border='0' alt='Editar'/></a></td>";
		}
		if($delete){
			$htm .= "<td class='text-center'><a href ='#' onclick=\"deleteRecord('$CLASE',  $registro[$campoPK]);\" ><img src='./img/trash.png'  align='middle' border='0' alt='Borrarr'/></a></td>";
		}
		$htm .= "</tr>";
	}
	$htm .= "</tbody></table></div></div></div>";
	$objResponse = new xajaxResponse();
	$objResponse->assign($divName, "innerHTML", $htm);
	$objResponse->script("dataGrid('$CLASE')");
	return $objResponse;
}
/**
* Muestra sobre la capa 'contenedor' el formulario para agregar nuevos registros.
*
* @param clase $CLASE	Nombre de la clase donde esta el formulario para agregar nuevos registros.
* @return El formulario sobre la capa 'contenedor' 
*/
function add($CLASE){
	$lCLASE = new $CLASE();
	$titulo = "Agregar registro";  // <-- Set the title for your form.
	$cuerpo1 = "<center>".$lCLASE->formAdd()."</center>";  // <-- Change by your method
	$cuerpo = utf8_encode($cuerpo1);
	$boton1 = "Grabar";
	$boton2 = "Salir";
	$objResponse = new xajaxResponse();
	$accion = "xajax_save('$CLASE',xajax.getFormValues('frm'))";
//  cargamos el formulario en la ventana modal.
	$pos = strpos($cuerpo, "form");
	if($pos === FALSE){
		$objResponse->script("aviso(\"$cuerpo\")");	
	}else{
		$objResponse->script("addModal(\"$titulo\", ".json_encode($cuerpo).", \"alerta\",['$boton1', '$boton2'], ".json_encode($accion)." );");	
		
	}
	return $objResponse;
}

/**
* Muestra sobre la capa 'contenedor' el formulario para EDITAR registros.	//  A futuro considerar colocar variable la identificacion de la capa.
*
* @param string  $CLASE	Nombre de la clase donde esta el formulario para editar los registros.
* @param entero	 $id    Valor que identifica el registro a ser editado.
* @return El formulario sobre la capa 'contenedor' 
*/
function edit($CLASE, $id){
// Edit zone
	$lCLASE = new $CLASE();
	$titulo = "Editar Registro"; 	// <-- Set the title for your form.
    $cuerpo = "<center>".$lCLASE->formEdit($id)."</center>"; 			
    $boton1 = "Grabar";
    $boton2 = "Salir";
   	$accion = "xajax_update('$CLASE',xajax.getFormValues('frm'))";
	$objResponse = new xajaxResponse();
//  cargamos el formulario en la ventana modal.	
	$objResponse->script("addModal(\"$titulo\", ".json_encode($cuerpo).", \"alerta\",['$boton1', '$boton2'], ".json_encode($accion)." )");

	return $objResponse;
}
/**
* Muestra sobre la capa 'contenedor' el formulario para agregar nuevos registros.
*
* @param string $CLASE	Nombre de la clase donde esta el registro a ser borrado.
* @param integer $id    Valor del identificador del registro a ser borrado
* @return El formulario sobre la capa 'contenedor' 
*/
function delete($CLASE, $id){
	$lCLASE = new $CLASE();
	$x = $lCLASE->deleteRecord($id);
	$objResponse = new xajaxResponse();
	if($x){
		$mensaje = "<p>Registro Eliminado</p>";
		$objResponse->script("xajax_showGrid('$CLASE')");
	}else{
		$mensaje = "<p>El Registro no pudo ser Eliminado.</p>";
	}
	$objResponse->script("aviso(" . json_encode($mensaje).  ")"); 
	return $objResponse;
}

/**
* Funcion que graba un nuevo registo en la base de datos.
*
* @param string $CLASE	Nombre de la clase donde esta el formulario para agregar nuevos registros.
* @param array	$f      Arreglo que contiene todos los datos del formulario a ser grabados.
* @return  Un objeto xajax response indicando si se graba o no el registro. 
*/
function save($CLASE, $f){
	$LCLASE = new $CLASE();
	$objResponse = new xajaxResponse();
	$message = $LCLASE->checkAllData($f,1); // <-- Change by your method
	if(!$message){
		$respOk = $LCLASE->insertNewRecord($f); // <-- Change by your method
		if($respOk){
			$objResponse->script("xajax_showGrid('$CLASE')");
			$mensaje = "Se ha agregado un nuevo registro";
			$objResponse->script("cerrarModal(formModal);");
		}else{
			$mensaje = "El registro no se pudo agregar.";
		}
	}else{
		$mensaje = $message;
	}
	$objResponse->script("aviso(\"$mensaje\")");
	return $objResponse;
}
/**
* Funcion que graba un registo corregido en la base de datos.
*
* @param string $CLASE	Nombre de la clase donde esta el formulario para agregar nuevos registros.
* @param array	$f      Arreglo que contiene todos los datos del formulario a ser grabados.
* @return  Un objeto xajax response indicando si se graba o no el registro. 
*/
function update($CLASE, $f){
	$LCLASE = new $CLASE();
	$objResponse = new xajaxResponse();
	$mensaje = $LCLASE->checkAllData($f); // <-- Change by your method
	if(!$mensaje){
		$respOk = $LCLASE->updateRecord($f); // <-- Change by your method
		if($respOk){
			$objResponse->script("xajax_showGrid('$CLASE')");
			$objResponse->script("cerrarModal(formModal);");
			$mensaje = "Se ha actualizado un registro.";
		}else{
			$mensaje = "NO se pudo actualizar el registro";
		}
	} 
	$objResponse->script("aviso(". json_encode($mensaje).")");
	return $objResponse;
}


?>
