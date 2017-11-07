<?php
	class CLS_TBLFORMASPAGO extends CLS_INVENTARIO{
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
			$this->sqlBase = "SELECT idFormaPago, formaPago FROM tblformaspago";
			$this->titulo = "FORMAS DE PAGO";
	}
//-----------------------------------------------------------------------------------------------------------
	function insertNewRecord($f){
		extract($f);
		//Convertir la fecha de formato ingles o español a formato MYSQL antes de pasarlo a la funcion.
		$r = $this->tblformaspagoInsert( $formaPago);
		return $r;
	}
//-----------------------------------------------------------------------------------------------------------
	function updateRecord($f){
		extract($f);
		$res = $this->tblformaspagoUpdate($idFormaPago, $formaPago);
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function deleteRecord($id){
		$res = $this->tblformaspagoDelete("idFormaPago = $id");
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function formAdd(){
		$html = $this->frmtblformaspago();
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function formEdit($id){
		$html = $this->frmtblformaspago($id);
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function frmtblformaspago(){
		$alineacionDerecha = " style='text-align:right' ";
		$numeroReal = " onkeypress='return NumCheck(event, this);'";
		if(func_num_args() > 0){
			$idFormaPago = func_get_arg(0);
			$records = $this->tblformaspagoRecords("idFormaPago = $idFormaPago");
			foreach($records as $record){
				extract($record);
			}
			$textoBoton = "Actualizar";
			$accion = "onClick=\"xajax_update('CLS_TBLFORMASPAGO',xajax.getFormValues('frm'))\"";
		}else{
			$pk = "";
			$textoBoton = "Grabar";
			$accion = "onClick=\"xajax_save('CLS_TBLFORMASPAGO',xajax.getFormValues('frm'))\"";
			$formaPago = '';
			$idFormaPago = 0;
		}
		$htm = "<form id='frm' class='form-horizontal' role='form'>
					".frm_hidden('idFormaPago', $idFormaPago)."	
					<div class='form-group'>
						<label for='formaPago' class='col-md-6'>Forma de Pago:</label>
						<div class='col-md-6'>".frm_text('formaPago', $formaPago, '20', '20 ', ' class="form-control"')."</div>
					</div>	
					
			</form>";
	return $htm;	
	}
//-----------------------------------------------------------------------------------------------------------
	function checkAllData($f,$new = 0){		// Considerar colocar los campos obligatorios en el formulario.
		if(empty($f['formaPago'])) return "El campo 'Forma de Pago' no puede ser nulo.";
		$salida = validarPatron($f['formaPago'],LETRASYES);
		if( $salida != "") return "El campo 'Forma de pago ' $salida";
	 	return 0;
	}
//-----------------------------------------------------------------------------------------------------------
// Nombres de los campos de la consulta.
	function camposBD(){
		$fields = array();
		$fields[] = 'idFormaPago';	
		$fields[] = 'formaPago';	
		return $fields;
	}
//-----------------------------------------------------------------------------------------------------------
	function encabezados(){
		$headers = array();
		$headers[] = "Forma de Pago";
		return $headers;
	}
//-----------------------------------------------------------------------------------------------------------
	function atributosEncabezados(){
		// HTML table: hearders attributes
		$attribsHeader = array();
		$attribsHeader[] = '50';
		return $attribsHeader;
	}
//-----------------------------------------------------------------------------------------------------------
	function atributosColumnas(){
		// HTML Table: columns attributes
		$attribsCols = array();
		$attribsCols[] = 'nowrap style="text-align:left"';
		return $attribsCols;
	}

//-----------------------------------------------------------------------------------------------------------
}
?>
