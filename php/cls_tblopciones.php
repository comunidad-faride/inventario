<?php
	class CLS_TBLOPCIONES extends CLS_INVENTARIO{
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
			$this->sqlBase = "SELECT idOpciones, opcion FROM tblopciones";
			$this->titulo = "OPCIONES PARA FACTURAS";
	}
//-----------------------------------------------------------------------------------------------------------
	function insertNewRecord($f){
		extract($f);
		//Convertir la fecha de formato ingles o español a formato MYSQL antes de pasarlo a la funcion.
		$r = $this->tblopcionesInsert( $opcion);
		return $r;
	}
//-----------------------------------------------------------------------------------------------------------
	function updateRecord($f){
		extract($f);
		$res = $this->tblopcionesUpdate($idOpciones, $opcion);
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function deleteRecord($id){
		$res = $this->tblopcionesDelete("idOpciones = $id");
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function formAdd(){
		$html = $this->frmtblopciones();
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function formEdit($id){
		$html = $this->frmtblopciones($id);
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function frmtblopciones(){
		$alineacionDerecha = " style='text-align:right' ";
		$numeroReal = " onkeypress='return NumCheck(event, this);'";
		if(func_num_args() > 0){
			$idOpciones = func_get_arg(0);
			$records = $this->tblopcionesRecords("idOpciones = $idOpciones");
			foreach($records as $record){
				extract($record);
			}
			$textoBoton = "Actualizar";
			$accion = "onClick=\"xajax_update('CLS_TBLOPCIONES',xajax.getFormValues('frm'))\"";
		}else{
			$pk = "";
			$textoBoton = "Grabar";
			$accion = "onClick=\"xajax_save('CLS_TBLOPCIONES',xajax.getFormValues('frm'))\"";
			$idOpciones = 0;
			$opcion = '';
		}
		$txt_idOpciones = frm_hidden("idOpciones", $idOpciones); 
		$htm = "<form id='frm' class='form-horizontal' role='form'>$txt_idOpciones
					<div class='form-group'>
						<label for='opcion' class='col-md-6 text-right'>Opci&oacute;n: </label>
						<div class='col-md-6'>".frm_text('opcion', $opcion, '45', '45 ', ' class="form-control"')."</div>
					</div>	
			</form>";
	return $htm;	
	}
//-----------------------------------------------------------------------------------------------------------
	function checkAllData($f,$new = 0){		// Considerar colocar los campos obligatorios en el formulario.
		//if(empty($f['idOpciones'])) return "El campo 'idOpciones' no puede ser nulo.";
		if(empty($f['opcion'])) return "El campo 'opcion' no puede ser nulo.";
		$salida = validarPatron($f['opcion'],LETRASYES);
		if( $salida != "") return "El campo 'Opci&oacute;n ' $salida";
	 	return 0;
	}
//-----------------------------------------------------------------------------------------------------------
// Nombres de los campos de la consulta.
	function camposBD(){
		$fields = array();
		$fields[] = 'idOpciones';	
		$fields[] = 'opcion';	
		return $fields;
	}
//-----------------------------------------------------------------------------------------------------------
	function encabezados(){
		$headers = array();
		//$headers[] = "idOpciones";
		$headers[] = "OPCION";
		return $headers;
	}
//-----------------------------------------------------------------------------------------------------------
	function atributosEncabezados(){
		// HTML table: hearders attributes
		$attribsHeader = array();
		//$attribsHeader[] = '50';
		$attribsHeader[] = '50';
		return $attribsHeader;
	}
//-----------------------------------------------------------------------------------------------------------
	function atributosColumnas(){
		// HTML Table: columns attributes
		$attribsCols = array();
		//$attribsCols[] = 'nowrap style="text-align:left"';
		$attribsCols[] = 'nowrap style="text-align:left"';
		return $attribsCols;
	}

//-----------------------------------------------------------------------------------------------------------
}
?>
