<?php
	class CLS_TBLFACTURAS extends CLS_INVENTARIO{
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
			$this->sqlBase = "SELECT idFactura, idtblTienda, fecha, numFactura, opcion, comentario FROM tblfacturas";
			$this->titulo = "";
	}
//-----------------------------------------------------------------------------------------------------------
	function insertNewRecord($f){
		extract($f);
		//Convertir la fecha de formato ingles o español a formato MYSQL antes de pasarlo a la funcion.
		$r = $this->tblfacturasInsert($idFactura, $idtblTienda, $fecha, $numFactura, $opcion, $comentario);
		return $r;
	}
//-----------------------------------------------------------------------------------------------------------
	function updateRecord($f){
		extract($f);
		$res = $this->tblfacturasUpdate($idFactura, $idtblTienda, $fecha, $numFactura, $opcion, $comentario);
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function deleteRecord($id){
		$res = $this->tblfacturasDelete("idFactura = $id");
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function formAdd(){
		$html = $this->frmtblfacturas();
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function formEdit($id){
		$html = $this->frmtblfacturas($id);
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function frmtblfacturas(){
		$alineacionDerecha = " style='text-align:right' ";
		$numeroReal = " onkeypress='return NumCheck(event, this);'";
		if(func_num_args() > 0){
			$idFactura = func_get_arg(0);
			$records = $this->tblfacturasRecords("idFactura = $idFactura");
			foreach($records as $record){
				extract($record);
			}
			$textoBoton = "Actualizar";
			$accion = "onClick=\"xajax_update('CLS_TBLFACTURAS',xajax.getFormValues('frm'))\"";
		}else{
			$pk = "";
			$textoBoton = "Grabar";
			$accion = "onClick=\"xajax_save('CLS_TBLFACTURAS',xajax.getFormValues('frm'))\"";
			$idFactura = 0;
			$idtblTienda = 0;
			$fecha = date('d/m/Y');
			$numFactura = 0;
			$opcion = '';
			$comentario = '';
		}
		$htm = "<form id='frm' class='form-horizontal' role='form'>
					<div class='form-group'>
						<label for='idFactura' class='col-md-6'>idFactura</label>
						<div class='col-md-6'>".frm_numero('idFactura', $idFactura, '10', '10',  ' class="form-control"')."</div>
					</div>	
					<div class='form-group'>
						<label for='idtblTienda' class='col-md-6'>idtblTienda</label>
						<div class='col-md-6'>".frm_numero('idtblTienda', $idtblTienda, '10', '10',  ' class="form-control"')."</div>
					</div>	
					<div class='form-group'>
						<label for='fecha' class='col-md-6'>fecha</label>
						<div class='col-md-6'>".frm_calendario('fecha','fecha' ,$fecha, 'id='fecha'  required  class='form-control')."</div>
					</div>	
					<div class='form-group'>
						<label for='numFactura' class='col-md-6'>numFactura</label>
						<div class='col-md-6'>".frm_numero('numFactura', $numFactura, '10', '10',  ' class="form-control"')."</div>
					</div>	
					<div class='form-group'>
						<label for='opcion' class='col-md-6'>opcion</label>
						<div class='col-md-6'>".frm_text('opcion', $opcion, '1', '1 ', ' class="form-control"')."</div>
					</div>	
					<div class='form-group'>
						<label for='comentario' class='col-md-6'>comentario</label>
						<div class='col-md-6'>".frm_text('comentario', $comentario, '45', '45 ', ' class="form-control"')."</div>
					</div>	
			</form>";
	return $htm;	
	}
//-----------------------------------------------------------------------------------------------------------
	function checkAllData($f,$new = 0){		// Considerar colocar los campos obligatorios en el formulario.
/*		if(empty($f['idFactura'])) return "El campo 'idFactura' no puede ser nulo.";
		if(empty($f['idtblTienda'])) return "El campo 'idtblTienda' no puede ser nulo.";
		if(empty($f['fecha'])) return "El campo 'fecha' no puede ser nulo.";*/
		if(empty($f['numFactura'])) return "El campo 'numFactura' no puede ser nulo.";
		if(empty($f['opcion'])) return "El campo 'opcion' no puede ser nulo.";
		if(empty($f['comentario'])) return "El campo 'comentario' no puede ser nulo.";
	 	return 0;
	}
//-----------------------------------------------------------------------------------------------------------
// Nombres de los campos de la consulta.
	function camposBD(){
		$fields = array();
		$fields[] = 'idFactura';	
		$fields[] = 'idtblTienda';	
		$fields[] = 'fecha';	
		$fields[] = 'numFactura';	
		/*$fields[] = 'opcion';	*/
		/*$fields[] = 'comentario';*/	
		return $fields;
	}
//-----------------------------------------------------------------------------------------------------------
	function encabezados(){
		$headers = array();
		$headers[] = "idFactura";
		$headers[] = "idtblTienda";
		$headers[] = "fecha";
		$headers[] = "numFactura";
		$headers[] = "opcion";
		$headers[] = "comentario";
		return $headers;
	}
//-----------------------------------------------------------------------------------------------------------
	function atributosEncabezados(){
		// HTML table: hearders attributes
		$attribsHeader = array();
		$attribsHeader[] = '17';
		$attribsHeader[] = '17';
		$attribsHeader[] = '17';
		$attribsHeader[] = '17';
		$attribsHeader[] = '17';
		$attribsHeader[] = '17';
		return $attribsHeader;
	}
//-----------------------------------------------------------------------------------------------------------
	function atributosColumnas(){
		// HTML Table: columns attributes
		$attribsCols = array();
		$attribsCols[] = 'nowrap style="text-align:left"';
		$attribsCols[] = 'nowrap style="text-align:left"';
		$attribsCols[] = 'nowrap style="text-align:left"';
		$attribsCols[] = 'nowrap style="text-align:left"';
		$attribsCols[] = 'nowrap style="text-align:left"';
		$attribsCols[] = 'nowrap style="text-align:left"';
		return $attribsCols;
	}

//-----------------------------------------------------------------------------------------------------------
}
?>
