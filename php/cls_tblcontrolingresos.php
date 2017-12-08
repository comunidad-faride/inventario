<?php
	class CLS_TBLCONTROLINGRESOS extends CLS_INVENTARIO{
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
			$this->sqlBase = "SELECT idcontrol, nombreTienda, DATE_FORMAT(fecha,  '%d/%c/%Y') as fecha 
				FROM tblcontrolingresos
				INNER JOIN 	tbltiendas ON tbltiendas.idtblTienda = tbltiendas.idtblTienda";
			$this->titulo = "CONTROL DE INGRESOS";
	}
//-----------------------------------------------------------------------------------------------------------
	function insertNewRecord($f){
		extract($f);
		//Convertir la fecha de formato ingles o español a formato MYSQL antes de pasarlo a la funcion.
		$idcontrol = $this->nuevo_id("tblcontrolingresos","idcontrol");
		$fecha = d_ES_MYSQL($fecha);
		$r = $this->tblcontrolingresosInsert( $idtblTienda, $fecha, "");
		$idcontrol = $_SESSION['idcontrol'];
		if($r){
			$nBancos = count($idBanco);
			$nMovimientos = count($idmovimiento);
			for($i = 0; $i < $nBancos; $i++){
				for($j = 0; $j < $nMovimientos; $j++){
					if($monto[$j][$i] != ""){
						$sql_monto = numeroIngles($monto[$j][$i]);
						$res = $this->tblingresosInsert($idBanco[$i], $idmovimiento[$j], $idcontrol, $sql_monto);
					}
				}
			}
		}
		return $r;
	}
//-----------------------------------------------------------------------------------------------------------
	function nuevoRegistro_tblingresos($formulario){
		extract($formulario);
		
	}
//-----------------------------------------------------------------------------------------------------------
	function updateRecord($f){
		extract($f);
		$fecha = d_ES_MYSQL($fecha);
		$comentario = "";
		$res = $this->tblcontrolingresosUpdate($idcontrol, $idtblTienda, $fecha, $comentario);
		// Se eliminar los registros de tblingresos antes de registralos de nuevo.
		$res = $this->tblingresosDelete("idcontrol = $idcontrol");
		if($res){
			$nBancos = count($idBanco);
			$nMovimientos = count($idmovimiento);
			for($i = 0; $i < $nBancos; $i++){
				for($j = 0; $j < $nMovimientos; $j++){
					if($monto[$j][$i] != ""){
						$sql_monto = numeroIngles($monto[$j][$i]);
						$res = $this->tblingresosInsert($idBanco[$i], $idmovimiento[$j], $idcontrol, $sql_monto);
					}
				}
			}
		}
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function deleteRecord($id){
		$res = $this->tblcontrolingresosDelete("idtblTienda = $id");
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function formAdd(){
		$_SESSION['idcontrol'] = $this->nuevo_id("tblcontrolingresos","idcontrol");
		$html = $this->frmtblcontrolingresos();//frmtblcontrolingresos
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function formEdit($id){
		$html = $this->frmtblcontrolingresos($id);
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	/*function frmtblcontrolingresos(){
		$alineacionDerecha = " style='text-align:right' ";
		$numeroReal = " onkeypress='return NumCheck(event, this);'";
		if(func_num_args() > 0){
			$idtblTienda = func_get_arg(0);
			$records = $this->tblcontrolingresosRecords("idtblTienda = $idtblTienda");
			foreach($records as $record){
				extract($record);
			}
			$utf8 = "x";
		}else{
			$utf8 = "";
			$pk = "";
			$idcontrol = 0;
			$idtblTienda = 0;
			$fecha = date('d/m/Y');
			$comentario = '';
		}
		
	return $htm;	
	}*/
//-----------------------------------------------------------------------------------------------------------
	function checkAllData($f,$new = 0){		// Considerar colocar los campos obligatorios en el formulario.
		//if(empty($f['idcontrol'])) return "El campo 'idcontrol' no puede ser nulo.";
		if(empty($f['idtblTienda'])) return "El campo 'idtblTienda' no puede ser nulo.";
		if(empty($f['fecha'])) return "El campo 'fecha' no puede ser nulo.";
		//if(empty($f['comentario'])) return "El campo 'comentario' no puede ser nulo.";
	 	return 0;
	}
//-----------------------------------------------------------------------------------------------------------
// Nombres de los campos de la consulta.
	function camposBD(){
		$fields = array();
		$fields[] = 'idcontrol';	
		$fields[] = 'nombreTienda';	
		$fields[] = 'fecha';	
		//$fields[] = 'comentario';	
		return $fields;
	}
//-----------------------------------------------------------------------------------------------------------
	function encabezados(){
		$headers = array();
		//$headers[] = "No. Control";
		$headers[] = "Tienda";
		$headers[] = "Fecha";
		//$headers[] = "comentario";
		return $headers;
	}
//-----------------------------------------------------------------------------------------------------------
	function atributosEncabezados(){
		// HTML table: hearders attributes
		$attribsHeader = array();
		//$attribsHeader[] = '25';
		$attribsHeader[] = '25';
		$attribsHeader[] = '25';
		//$attribsHeader[] = '25';
		return $attribsHeader;
	}
//-----------------------------------------------------------------------------------------------------------
	function atributosColumnas(){
		// HTML Table: columns attributes
		$attribsCols = array();
		//$attribsCols[] = 'nowrap style="text-align:left"';
		$attribsCols[] = 'nowrap style="text-align:left"';
		$attribsCols[] = 'nowrap style="text-align:left"';
		//$attribsCols[] = 'nowrap style="text-align:left"';
		return $attribsCols;
	}

//-----------------------------------------------------------------------------------------------------------
	function frmtblcontrolingresos(){
		$bancosRec = $this->tblbancosRecords("1", "banco");
		if(func_num_args() > 0){
			$idcontrol = func_get_arg(0);
			$records = $this->registrosConsultados($idcontrol);
			$bancos = $this->bancosRegistros($idcontrol);
			$bancosDif = $this->bancosOff($bancosRec, $bancos);
			$utf8 = "x";
			$sw = TRUE;
		}else{
			$sw = FALSE;
			$utf8 = "";
			$pk = "";
			$idcontrol = 0;
			$idtblTienda = 0;
			$fecha = date('d/m/Y');
			$comentario = '';
			$bancos = array(1, 2, 3);
		}
		$fila0 = "<tr>";
		$fila0 .= "<th id='fc0' class='bg-success text-center'>BANCOS</th>";
	//========================================================================
	//  Ahora registro los bancos.  Si son de nuevo registro o de edición.
		if($sw){// Edicion
			$nBancos = count($bancos);
			$k = 0;
			for($i = 0; $i < 3; $i++){
				if(isset($bancos[$i]["idBanco"])){
					$j = $bancos[$i]["idBanco"];
				}else{
					$j = $bancosDif[$k]["idBanco"];
					$k++; 
				}
				$cmbBanco[$i] = frm_comboGenerico("idBanco[$i]", "banco", "idBanco", "tblbancos", "cls_inventario", "", " id='idBanco[$i]' class='form-control'", $j);
				$fila0 .= "<td>$cmbBanco[$i]</td>";
			}
		}else{
			for($i = 0; $i<3; $i++){
				$cmbBanco[$i] = frm_comboGenerico("idBanco[$i]", "banco", "idBanco", "tblbancos", "cls_inventario", "", " id='idBanco[$i]' class='form-control'", $bancosRec[$i]["idBanco"]);
				$fila0 .= "<td>$cmbBanco[$i]</td>";
			} 	
		}			
	//=========================================================================	
		
		$fila0 .= "<th  class='bg-success text-center' >TOTALES</th>";
		$n = $this->numRegistros("tbltipomovban");
		$sql = "SELECT * from tbltipomovban ORDER BY movimiento_bancario";
		$rectbltipomovban = $this->consultagenerica($sql);
		$idtipomovimiento = array();
		$txtMonto = array();
		$txtTotal = array();
		$sumaFila = array();
		$sumaCol = array();
		$sumaTotal =0;
		for($i = 0; $i < $n; $i++){
			$idBanco = $tipoMovimientoBancario = $rectbltipomovban[$i]['idtipomovimiento'];
			$idtipomovimiento[$i] = frm_hidden("idmovimiento[$i]", $tipoMovimientoBancario);
			$fila = "<tr><td class='bg-success'>".$idtipomovimiento[$i].$rectbltipomovban[$i]['movimiento_bancario']."</td>";
			$sumaFila[$i] = 0;
			for($j = 0; $j < 3; $j++){				
				$id = "id = \"f".$i."c".$j."\"";
				$montoIngreso = "";
				if($sw == TRUE){
					if($j <= $nBancos - 1){
						$montoIngreso = $this->montoConsultado($idcontrol, $bancos[$j]["idBanco"], $rectbltipomovban[$i]['idtipomovimiento']);
					}
				}else{
					$montoIngreso = "";
				}
				if(!isset($sumaCol[$j])){
					$sumaCol[$j] = 0;
				}
				if($montoIngreso != ""){
					$sumaFila[$i] += $montoIngreso;
					$sumaCol[$j] += $montoIngreso; 
				}else{
					$sumaFila[$i] += 0;
					$sumaCol[$j] += 0; 	
				}
				if(is_numeric($montoIngreso)){
					$montoIngreso = numeroEspanol($montoIngreso);
				}else{
					$montoIngreso = "";	
				}
				$txtMonto[$i][$j] = frm_numero("monto[$i][$j]", $montoIngreso, 13, 13,"class='form-control' $id", 10, 2);
				$fila .= "<td>".$txtMonto[$i][$j]."</td>";
			}
			$txtTotal[$i] = frm_text("total[$i]", numeroEspanol($sumaFila[$i]), 13, 13,"readonly class='form-control text-right bg-success' id=total$i");
			$fila .=  "<td>".$txtTotal[$i]."</td> </tr>";
			$fila0 .= $fila;
		}
		$fila = "<tr><th  class='text-center bg-success'>TOTALES</th>";
		$totales = array();
		for($i = 0; $i < 4; $i++){
			if($i<3){
				$sumaTotal += $sumaCol[$i];
			}else{
				$sumaCol[3] = $sumaTotal;
			}
			
			$txtTotales[$i] = frm_text("totales[$i]", numeroEspanol($sumaCol[$i]), 13,13,"id='totales[$i]' readonly class='form-control text-right bg-success' ");
			//$txtTotales[$i] = (is_numeric($txtTotales[$i])) ? numeroEspanol($txtTotales[$i]): "";
			$fila .= "<th class='text-right bg-success'>".$txtTotales[$i]."</th>";
		}
		$fila .= "</tr>";
		$fila0 .= $fila;
		$htm = "<div ><table class='table-hover table-bordered'>$fila0</table></div>";
			$idtblTienda = 1;
		$fecha = d_US_ES(hoy());
		$cmbidtblTienda = frm_comboGenerico("idtblTienda", "nombreTienda", "idtblTienda", "tblTiendas", "cls_inventario", "", " id='idtblTienda' class='form-control'", $idtblTienda, $utf8);
		$html = '<form name ="frm" id = "frm" class="container">
			<div class="row">
				<div class="col-md-12 text-center"> <h2>Ingresos por Tiendas</h2> </div>
			</div>
			<div class="row">
			<div class="col-md-12">
				<div class="col-md-2 col-md-offset-1 text-right">
					<label style="padding-top:10px"><p>Fecha:</p></label>
				</div>
				<div class="col-md-2" >'
					.frm_calendario2("fecha","fecha", "$fecha", "id='fecha' class='form-control input-md'" ).
				'</div>
				<div class="col-md-2 text-right">
					<label style="padding-top:10px; margin-right: -20px" class="text-rigth"><p>Tienda:</p></label>
				</div>
				<div class="col-md-3">'
					.$cmbidtblTienda.
				'</div>
			</div>
			</div>';
		$html .= '<div class="row"><div class="col-md-10 col-md-offset-1">'. $htm.'</div></div><br/></form>';
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function registrosConsultados($idcontrol){
		$sql = "SELECT tblingresos.idBanco, banco, tblingresos.idtipomovimiento, movimiento_bancario, montoIngreso 
			FROM tblingresos
			INNER JOIN tblbancos ON tblbancos.idBanco = tblingresos.idBanco
			INNER JOIN tbltipomovban ON tbltipomovban.idtipomovimiento = tblingresos.idtipomovimiento
			WHERE idcontrol = $idcontrol
			ORDER BY banco, movimiento_bancario";	
		$recsMontos = $this->consultagenerica($sql);
		return $recsMontos;
	}
//-----------------------------------------------------------------------------------------------------------
	function bancosRegistros($idcontrol){
		$sql = "SELECT distinct tblingresos.idBanco, banco
			FROM tblingresos
			INNER JOIN tblbancos ON tblbancos.idBanco = tblingresos.idBanco
			INNER JOIN tbltipomovban ON tbltipomovban.idtipomovimiento = tblingresos.idtipomovimiento
			WHERE idcontrol = $idcontrol
            order by banco";
        $recBancos = $this->consultagenerica($sql);
        return $recBancos;    	
	}	
//---------------------------------------------------------------------------------------------------
	function tiposMovRegistros($idcontrol){
		
	}
//---------------------------------------------------------------------------------------------------
	function matrizVacia($nTiposMov){
		$matriz = array();
		for($i = 0; $i < $nTiposMov; $i++){
			for($j = 0; $j < 3; $j++){
				$matriz[$i][$j] = "";
			}
		}	
		return $matriz;	
	}
//-------------------------------------------------------------------------
 function montoConsultado($idControl, $idBanco, $idTipoMovimiento){
        $sqlconsulta = "SELECT montoIngreso FROM tblingresos WHERE idBanco = $idBanco AND idtipomovimiento = $idTipoMovimiento AND idcontrol = $idControl";
        $result = $this->consultagenerica($sqlconsulta);
        $valor = isset($result[0]["montoIngreso"])?$result[0]["montoIngreso"]:"";
        if(is_numeric($valor)){
            return $valor;
        }else{
            return "";
        }
     }
//-------------------------------------------------------------------------	
	function bancosOff($bancosRec, $bancos){
		$matriz = array();
		$nBR = count($bancosRec);
		$nB = count($bancos);
		$fila = 0; 
		for($i = 0; $i < $nBR; $i++){
			$n = 0;
			for($j = 0; $j < $nB; $j++){
				if($bancosRec[$i]["idBanco"] == $bancos[$j]["idBanco"]){
					$n = 1;
					break;	
				}
			}
			if($n == 0){
				$matriz[$fila]["idBanco"] = $bancosRec[$i]["idBanco"]; 
				$fila++;
			}	
		}
		return $matriz; 
	}
//-------------------------------------------------------------------------	
}
?>
