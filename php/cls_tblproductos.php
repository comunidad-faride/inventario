<?php
	class CLS_TBLPRODUCTOS extends CLS_INVENTARIO{
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
			$this->sqlBase = "SELECT idproducto, producto FROM tblproductos";
			$this->titulo = "PRODUCTOS REGISTRADOS";
	}
//-----------------------------------------------------------------------------------------------------------
	function insertNewRecord($f){
		extract($f);
	//	$producto = utf8_decode($producto);
		$r = $this->tblproductosInsert( $producto);
		return $r;
	}
//-----------------------------------------------------------------------------------------------------------
	function updateRecord($f){
		extract($f);
	//	$producto = utf8_decode($producto);
		$res = $this->tblproductosUpdate($idproducto, $producto);
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function deleteRecord($id){
		$res = $this->tblproductosDelete("idproducto = $id");
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function formAdd(){
		$html = $this->frmtblproductos();
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function formEdit($id){
		$html = $this->frmtblproductos($id);
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function frmtblproductos(){
		$alineacionDerecha = " style='text-align:right' ";
		$numeroReal = " onkeypress='return NumCheck(event, this);'";
		if(func_num_args() > 0){
			$idproducto = func_get_arg(0);
			$records = $this->tblproductosRecords("idproducto = $idproducto");
			foreach($records as $record){
				extract($record);
				$producto = utf8_encode($producto);
			}
			$textoBoton = "Actualizar";
			$accion = "onClick=\"xajax_update('CLS_TBLPRODUCTOS',xajax.getFormValues('frm'))\"";
		}else{
			$pk = "";
			$textoBoton = "Grabar";
			$accion = "onClick=\"xajax_save('CLS_TBLPRODUCTOS',xajax.getFormValues('frm'))\"";
			$producto = '';
			$idproducto=0;
		}
		$htm = "<form id='frm' class='form-horizontal' role='form'>
					".frm_hidden('idproducto', $idproducto)."	
					<div class='form-group'>
						<label for='producto' class='col-md-6'>Nombre del Producto:</label>
						<div class='col-md-6'>".frm_text('producto', $producto, '45', '45 ', ' class="form-control"')."</div>
					</div>	
				
			</form>";
	return $htm;	
	}
//-----------------------------------------------------------------------------------------------------------
	function checkAllData($f,$new = 0){		// Considerar colocar los campos obligatorios en el formulario.
		if(empty($f['producto'])) return "El campo 'Producto' no puede ser nulo.";
		$salida = validarPatron($f['producto'],LETRASYES);
		if( $salida != "") return "El campo 'Producto' $salida";
	 	return 0;
	}
//-----------------------------------------------------------------------------------------------------------
// Nombres de los campos de la consulta.
	function camposBD(){
		$fields = array();
		$fields[] = 'idproducto';	
		$fields[] = 'producto';	
		return $fields;
	}
//-----------------------------------------------------------------------------------------------------------
	function encabezados(){
		$headers = array();
		$headers[] = "Producto";
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
