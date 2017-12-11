<?php
	class CLS_TBLBANCOS extends CLS_INVENTARIO{
	var $sqlBase;
	var $titulo;
	var $ordenTabla ="data-order='[[ 0, \"asc\" ]]'";
//-----------------------------------------------------------------------------------------------------------
//	METODOS SIN CAMBIOS DE NINGUN TIPO
//-----------------------------------------------------------------------------------------------------------
	function getAllRecords($start, $limit, $order = null){
		if($order == null){
			$sql = $this->sqlBase . " LIMIT $start, $limit ".$_SESSION['ordering'];
		}else{
			$sql = $this->sqlBase . " ORDER BY $order ".$_SESSION['ordering']." LIMIT $start, $limit ";
		}
		$res = $this->consultagenerica($sql);
		return $res;
	}
//---------------------------------------------------------------------------------------------------------	
	function getRecordsFiltered($start, $limit, $filter = null, $content = null, $order = null, $ordering = ""){
		if(($filter != null) and ($content != null)){
			$sql = $this->sqlBase
					." WHERE ".$filter." like '%".$content."%' "
					." ORDER BY ".$order
					." ".$_SESSION['ordering']
					." LIMIT $start, $limit $ordering";
		}
		$res = $this->consultagenerica($sql);
		return $res;
	}
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
	function events($event = null){
		global $login;
		if(LOG_ENABLED){
			$now = date("Y-M-d H:i:s");
			$fd = fopen (FILE_LOG,'a');
			$log = $now." ".$_SERVER["REMOTE_ADDR"] ." - $event \n";
   		fwrite($fd,$log);
   		fclose($fd);
		}
	}
//-----------------------------------------------------------------------------------------------------------
//	METODOS CON CAMBIOS. DICHOS CAMBIOS; 
//-----------------------------------------------------------------------------------------------------------
	function __construct(){
		parent::__construct();
			$this->sqlBase = "SELECT * FROM tblbancos";
			$this->titulo = "BANCOS REGISTRADOS";
	}
//-----------------------------------------------------------------------------------------------------------
	function insertNewRecord($f){
		extract($f);
		//Convertir la fecha de formato ingles o español a formato MYSQL antes de pasarlo a la funcion.
		$r = $this->tblbancosInsert($banco, $tipo_cuenta, $num_cuenta);
		return $r;
	}
//-----------------------------------------------------------------------------------------------------------
	function updateRecord($f){
		extract($f);
		$res = $this->tblbancosUpdate($idbanco, $banco, $tipo_cuenta, $num_cuenta);
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function deleteRecord($id){
		$res = $this->tblbancosDelete("idbanco = $id");
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function formAdd(){
		$html = $this->frmtblbancos();
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function formEdit($id){
		$html = $this->frmtblbancos($id);
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function frmtblbancos(){
		$alineacionDerecha = " style='text-align:right' ";
		$numeroCuenta = " onkeypress='return NumCheck(event, this, 20,0);'";
		if(func_num_args() > 0){
			$idbanco = func_get_arg(0);
			$records = $this->tblbancosRecords("idbanco = $idbanco");
			foreach($records as $record){
				extract($record);
			}
			$textoBoton = "Actualizar";
			$accion = "onClick=\"xajax_update('CLS_TBLBANCOS',xajax.getFormValues('frm'))\"";
		}else{
			$idbanco = 0;
			$textoBoton = "Grabar";
			$accion = "onClick=\"xajax_save('CLS_TBLBANCOS',xajax.getFormValues('frm'))\"";
			$idbanco = 0;
			$banco = '';
			$tipo_cuenta = '';
			$num_cuenta = '';
		}
		$htm = "<form id='frm' >".frm_hidden("idbanco", $idbanco)."
				<table align='center' border='0'>
					<tr><td align='right'><b>Banco</b>:&nbsp;</td><td>".frm_text('banco', $banco, '20', '20 ', 'required')."</td></tr>	
					<tr><td align='right'><b>Tipo cuenta</b>:&nbsp;</td><td>".frm_text('tipo_cuenta', $tipo_cuenta, '20', '10 ', 'required')."</td></tr>	
					<tr><td align='right'><b>Num. cuenta</b>:&nbsp;</td><td>".frm_text('num_cuenta', $num_cuenta, '20', '20 ', "required $numeroCuenta")."</td></tr>	
				</table>	
			</form>";
	return $htm;	
	}
//-----------------------------------------------------------------------------------------------------------
	function checkAllData($f,$new = 0){		// Considerar colocar los campos obligatorios en el formulario.
		//if(empty($f['idbanco'])) return "El campo 'idbanco' no puede ser nulo.";
		if(empty($f['banco'])) return "El campo 'banco' no puede ser nulo.";
		if(empty($f['tipo_cuenta'])) return "El campo 'tipo_cuenta' no puede ser nulo.";
		if(empty($f['num_cuenta'])) return "El campo 'num_cuenta' no puede ser nulo.";
	 	return 0;
	}
//-----------------------------------------------------------------------------------------------------------
	function blanquearCampos(){		//SI ES PARA EL FORMULARIO, SE PUEDE SUSTITUIR POR reset.
		$xr = new xajaxResponse();
		$xr->assign("idbanco","value","");
		$xr->assign("banco","value","");
		$xr->assign("tipo_cuenta","value","");
		$xr->assign("num_cuenta","value","");
		return $xr;
	}
//-----------------------------------------------------------------------------------------------------------
// Nombres de los campos de la consulta.
	function camposBD(){
		$fields = array();
		$fields[] = 'idBanco';	
		$fields[] = 'banco';	
		$fields[] = 'tipo_cuenta';	
		$fields[] = 'num_cuenta';	
		return $fields;
	}
//-----------------------------------------------------------------------------------------------------------
	function encabezados(){
		$headers = array();
		//$headers[] = "idbanco";
		$headers[] = "Banco";
		$headers[] = "Cuenta";
		$headers[] = "Numero de cuenta";
		return $headers;
	}
//-----------------------------------------------------------------------------------------------------------
	function atributosEncabezados(){
		// HTML table: hearders attributes
		$attribsHeader = array();
		//$attribsHeader[] = '25';
		$attribsHeader[] = '25';
		$attribsHeader[] = '25';
		$attribsHeader[] = '25';
		return $attribsHeader;
	}
//-----------------------------------------------------------------------------------------------------------
	function atributosColumnas(){
		// HTML Table: columns attributes
		$attribsCols = array();
		//$attribsCols[] = 'nowrap style="text-align:left"';
		$attribsCols[] = 'nowrap style="text-align:left"';
		$attribsCols[] = 'nowrap style="text-align:left"';
		$attribsCols[] = 'nowrap style="text-align:left"';
		return $attribsCols;
	}
//-----------------------------------------------------------------------------------------------------------
	function ascDesEncabezado($CLASE, $limit, $filter, $content, $divName){
		// HTML Table: If you want ascendent and descendent ordering, set the Header Events.
		$eventHeader = array();
		//$eventHeader[]= 'onClick=\'xajax_showGrid("'.$CLASE.'", 0,'.$limit.',"'.$filter.'","'.$content.'","idbanco","'.$divName.'","ORDERING");return false;\'';
		$eventHeader[]= 'onClick=\'xajax_showGrid("'.$CLASE.'", 0,'.$limit.',"'.$filter.'","'.$content.'","banco","'.$divName.'","ORDERING");return false;\'';
		$eventHeader[]= 'onClick=\'xajax_showGrid("'.$CLASE.'", 0,'.$limit.',"'.$filter.'","'.$content.'","tipo_cuenta","'.$divName.'","ORDERING");return false;\'';
		$eventHeader[]= 'onClick=\'xajax_showGrid("'.$CLASE.'", 0,'.$limit.',"'.$filter.'","'.$content.'","num_cuenta","'.$divName.'","ORDERING");return false;\'';
		return $eventHeader;
	}
//-----------------------------------------------------------------------------------------------------------
	function camposBuscar(){
		// Select Box: fields table.
		$fieldsFromSearch = array();
		//$fieldsFromSearch[] = "idbanco";
		$fieldsFromSearch[] = "banco";
		$fieldsFromSearch[] = "tipo_cuenta";
		$fieldsFromSearch[] = "num_cuenta";
		return $fieldsFromSearch;
	}
//-----------------------------------------------------------------------------------------------------------
	function camposBuscarMostrar(){
		$fieldsFromSearchShowAs = array();
		//$fieldsFromSearchShowAs[] = "IDBANCO";
		$fieldsFromSearchShowAs[] = "BANCO";
		$fieldsFromSearchShowAs[] = "TIPO_CUENTA";
		$fieldsFromSearchShowAs[] = "NUM_CUENTA";
		return	$fieldsFromSearchShowAs;
	}
//-----------------------------------------------------------------------------------------------------------
}
?>
