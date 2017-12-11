<?php
	class CLS_TBLTIPOMOVBAN extends CLS_INVENTARIO{
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
			$this->sqlBase = "SELECT idtipomovimiento, movimiento_bancario FROM tbltipomovban";
			$this->titulo = "TIPOS DE MOVIMIENTOS BANCARIOS Y EFECTIVO";
	}
//-----------------------------------------------------------------------------------------------------------
	function insertNewRecord($f){
		extract($f);
		//Convertir la fecha de formato ingles o español a formato MYSQL antes de pasarlo a la funcion.
		$r = $this->tbltipomovbanInsert($movimiento_bancario);
		return $r;
	}
//-----------------------------------------------------------------------------------------------------------
	function updateRecord($f){
		extract($f);
		$res = $this->tbltipomovbanUpdate($idtipomovimiento, $movimiento_bancario);
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function deleteRecord($id){
		$res = $this->tbltipomovbanDelete("idtipomovimiento = $id");
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function formAdd(){
		$html = $this->frmtbltipomovban();
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function formEdit($id){
		$html = $this->frmtbltipomovban($id);
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function frmtbltipomovban(){
		$alineacionDerecha = " style='text-align:right' ";
		$numeroReal = " onkeypress='return NumCheck(event, this);'";
		if(func_num_args() > 0){
			$idtipomovimiento = func_get_arg(0);
			$records = $this->tbltipomovbanRecords("idtipomovimiento = $idtipomovimiento");
			foreach($records as $record){
				extract($record);
			}
			$textoBoton = "Actualizar";
			$accion = "onClick=\"xajax_update('CLS_TBLTIPOMOVBAN',xajax.getFormValues('frm'))\"";
		}else{
			$pk = "";
			$textoBoton = "Grabar";
			$accion = "onClick=\"xajax_save('CLS_TBLTIPOMOVBAN',xajax.getFormValues('frm'))\"";
			$idtipomovimiento = 0;
			$movimiento_bancario = '';
		}
		$txtid = frm_hidden('idtipomovimiento', $idtipomovimiento);
		$htm = "<form id='frm' class='form-horizontal' role='form'>$txtid
					<!--<div class='form-group'>
						<label for='idtipomovimiento' class='col-md-6'>idtipomovimiento</label>
						<div class='col-md-6'>".frm_numero('idtipomovimiento', $idtipomovimiento, '10', '10',  ' class="form-control"')."</div>
					</div>-->	
					
					<div class='form-group'>
						<label for='movimiento_bancario' class='col-md-6'>Movimiento bancario<br/>o Efectivo</label>
						<div class='col-md-6'>".frm_text('movimiento_bancario', $movimiento_bancario, '45', '45 ', ' class="form-control"')."</div>
					</div>	
			</form>";
	return $htm;	
	}
//-----------------------------------------------------------------------------------------------------------
	function checkAllData($f,$new = 0){		// Considerar colocar los campos obligatorios en el formulario.
/*		if(empty($f['idtipomovimiento'])) return "El campo 'idtipomovimiento' no puede ser nulo.";*/
		if(empty($f['movimiento_bancario'])) return "El campo 'movimiento_bancario' no puede ser nulo.";
	 	return 0;
	}
//-----------------------------------------------------------------------------------------------------------
// Nombres de los campos de la consulta.
	function camposBD(){
		$fields = array();
		$fields[] = 'idtipomovimiento';	
		$fields[] = 'movimiento_bancario';	
		return $fields;
	}
//-----------------------------------------------------------------------------------------------------------
	function encabezados(){
		$headers = array();
		//$headers[] = "idtipomovimiento";
		$headers[] = "Tipo de movimiento";
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
