<?php
/*	include_once("cls_inventario.php");
	include_once("./form_items.php");*/
	class CLS_TBLUSUARIOS extends CLS_INVENTARIO{
	var $sqlBase;
	var $titulo;
	var $ordenTabla = "data-order='[[ 0, \"asc\" ]]'";
//-----------------------------------------------------------------------------------------------------------
//	METODOS SIN CAMBIOS DE NINGUN TIPO
//-----------------------------------------------------------------------------------------------------------
	function getNumRows($filter = null, $content = null){
		if(($filter != null) and ($content != null)){
			$criterio = " $filter like '%$content%'";
			$sql = $this->sqlBase . " WHERE " .$criterio;
		}else{
			$sql = $this->sqlBase;
		}
		$registros = $this->consultagenerica($sql);
		$res = $this->filas; 
		return $res;		
	}
//-----------------------------------------------------------------------------------------------------------
	function getRecordByID($id){
		$sql = $this->sqlBase. " WHERE id = $id";
		foreach($res as $row){}
		return $row;
	}
//-----------------------------------------------------------------------------------------------------------
//	METODOS CON CAMBIOS. DICHOS CAMBIOS; 
//-----------------------------------------------------------------------------------------------------------
	function __construct(){
		parent::__construct();
			$this->sqlBase = "SELECT idUsuario, usuario, clave FROM tblusuarios";
			$this->titulo = "USUARIOS DEL SISTEMA";
	}
//-----------------------------------------------------------------------------------------------------------
	function insertNewRecord($f){
		extract($f);
		//Convertir la fecha de formato ingles o español a formato MYSQL antes de pasarlo a la funcion.
		$r = $this->tblusuariosInsert($usuario, $clave);
		return $r;
	}
//-----------------------------------------------------------------------------------------------------------
	function updateRecord($f){
		extract($f);
		$res = $this->tblusuariosUpdate($idUsuario, $usuario, $clave);
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function deleteRecord($id){
		$res = $this->tblusuariosDelete("idUsuario = $id");
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function formAdd(){
		$html = $this->frmtblusuarios();
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function formEdit($id){
		$html = $this->frmtblusuarios($id);
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function frmtblusuarios(){
		$alineacionDerecha = " style='text-align:right' ";
		$numeroReal = " onkeypress='return NumCheck(event, this);'";
		if(func_num_args() > 0){
			$idUsuario = func_get_arg(0);
			$records = $this->tblusuariosRecords("idUsuario = $idUsuario");
			foreach($records as $record){
				extract($record);
			}
			$textoBoton = "Actualizar";
			$accion = "onClick=\"xajax_update('CLS_TBLUSUARIOS',xajax.getFormValues('frm'))\"";
		}else{
			$pk = "";
			$textoBoton = "Grabar";
			$accion = "onClick=\"xajax_save('CLS_TBLUSUARIOS',xajax.getFormValues('frm'))\"";
			$usuario = '';
			$clave = '';
			$idUsuario = "";
		}
		$htm = "<form id='frm' class='form-horizontal' role='form'>
					".frm_hidden('idUsuario', $idUsuario)."	
					<div class='form-group'>
						<label for='usuario' class='col-md-5'>Usuario:</label>
						<div class='col-md-1 text-right'><i class='fa fa-user'></i></div>
						<div class='col-md-6'>".frm_text('usuario', $usuario, '45', '45 ', ' class="form-control"')."</div>
					</div>	
					<div class='form-group'>
						<label for='clave' class='col-md-5'>Clave:</label>
						<div class='col-md-1 text-right'><i class='fa fa-key'></i></div>
						<div class='col-md-6'>".frm_password('clave', $clave, '32', '32 ', ' class="form-control"')."</div>
					</div>	
				
			</form>";
	return $htm;	
	}
//-----------------------------------------------------------------------------------------------------------
	function checkAllData($f, $new = 0){		// Considerar colocar los campos obligatorios en el formulario.
		if(empty($f['usuario'])) return "El campo 'usuario' no puede ser nulo.";
		$salida = validarPatron($f['usuario'], ALFANUM);
		if($salida != "") return utf8_encode("Usuario:  $salida");
		if(empty($f['clave'])) return "El campo 'clave' no puede ser nulo.";
		$salida = validarPatron($f['clave'], ALFANUM);
		if($salida != "") return utf8_decode("La Clave: $salida");
	 	return 0;
	}
//-----------------------------------------------------------------------------------------------------------
// Nombres de los campos de la consulta.
	function camposBD(){
		$fields = array();
		$fields[] = 'idUsuario';	
		$fields[] = 'usuario';	
		//$fields[] = 'clave';	
		return $fields;
	}
//-----------------------------------------------------------------------------------------------------------
	function encabezados(){
		$headers = array();
		$headers[] = "Usuario";
		/*$headers[] = "Clave";*/
		return $headers;
	}
//-----------------------------------------------------------------------------------------------------------
	function atributosEncabezados(){
		// HTML table: hearders attributes
		$attribsHeader = array();
		$attribsHeader[] = '33';
		/*$attribsHeader[] = '33';*/
		return $attribsHeader;
	}
//-----------------------------------------------------------------------------------------------------------
	function atributosColumnas(){
		// HTML Table: columns attributes
		$attribsCols = array();
		$attribsCols[] = 'nowrap style="text-align:left"';
		/*$attribsCols[] = 'nowrap style="text-align:left"';*/
		return $attribsCols;
	}

//-----------------------------------------------------------------------------------------------------------
}
/*
$clase = new CLS_TBLUSUARIOS;
echo $clase->frmtblusuarios();*/
?>
