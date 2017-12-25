<?php
/*	include_once("./cls_inventario.php");
	include_once("./funciones_fecha.php");
	include_once("./form_items.php");*/
	class CLS_TBLPAGOS extends CLS_INVENTARIO{
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
			$this->sqlBase = "SELECT idPago, nombreTienda,tblpagos.idFactura, numFactura, DATE_FORMAT(tblpagos.fecha,  '%d/%c/%Y') AS fecha, tblpagos.referencia, 
				tblpagos.monto, confirmado FROM tblpagos
				INNER join tblfacturas ON tblpagos.idFactura = tblfacturas.idFactura
				INNER JOIN tbltiendas ON tblfacturas.idtblTienda = tbltiendas.idtblTienda
                INNER JOIN tblpagos2 ON tblfacturas.idFactura = tblpagos2.idFactura
				WHERE idFormaPago = 4 AND idOpciones = 1 ";
			$this->titulo = "Pagos de Facturas a Cr&eacute;dito";
	}
//-----------------------------------------------------------------------------------------------------------
	function insertNewRecord($f){
		extract($f);
		//Convertir la fecha de formato ingles o español a formato MYSQL antes de pasarlo a la funcion.
		$fecha = d_ES_MYSQL($fecha);
		// Necestio el valor de idFactura.
		$r = $this->tblpagosInsert($idFactura, $fecha, $referencia, $monto, $confirmado);
		return $r;
	}
//-----------------------------------------------------------------------------------------------------------
	function updateRecord($f){
		extract($f);
		$res = $this->tblpagosUpdate($idPago, $idFactura, $fecha, $referencia, $monto, $confirmado);
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function deleteRecord($id){
		$res = $this->tblpagosDelete("idPago = $id");
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function formAdd(){
		$html = $this->frmtblpagos();
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function formEdit($id){
		$html = $this->frmtblpagos($id);
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function frmtblpagos(){
		$alineacionDerecha = " style='text-align:right' ";
		$numeroReal = " onkeypress='return NumCheck(event, this);'";
		if(func_num_args() > 0){
			$idPago = func_get_arg(0);
			$records = $this->tblpagosRecords("idPago = $idPago");
			foreach($records as $record){
				extract($record);
			}
			$sql = "SELECT numFactura FROM tblfacturas INNER JOIN tblpagos ON tblfacturas.idFactura = tblpagos.idFactura WHERE idpago = $idPago";
			$rec = $this->consultagenerica($sql);
			$numFactura = $rec[0]['numFactura'];
			$textoBoton = "Actualizar";
			$accion = "onClick=\"xajax_update('CLS_TBLPAGOS',xajax.getFormValues('frm'))\"";
			
		}else{
			$pk = "";
			$textoBoton = "Grabar";
			$accion = "onClick=\"xajax_save('CLS_TBLPAGOS',xajax.getFormValues('frm'))\"";
			$idPago = 0;
			$numFactura = 0;
			$fecha = date('d/m/Y');
			$referencia = '';
			$confirmado = '';
			$monto = "";
		}
		$txt_idPago = frm_hidden("idPago", $idPago);
		$cmbTienda = frm_comboGenerico("idtblTienda", "nombreTienda", "idtblTienda", "tblTiendas","CLS_INVENTARIO");
		$arrConfirmadoVer = ARRAY("SI", "NO");
		$arrConfirmadoGravar = ARRAY("S", "N");
		$cmbConfirmado = frm_select("confirmado", $arrConfirmadoVer, $arrConfirmadoGravar, "S", 'class="form-control"');
		$htm = "<form id='frm' class='form-horizontal' role='form'>$txt_idPago
					<div class='form-group'>
						<label for='idtblTiendca' class='col-md-6'>Tienda:</label>
						<div class='col-md-6'>".$cmbTienda."</div>
					</div>
					<div class='form-group'>
						<label for='idFactura' class='col-md-6'>Numero de Factura:</label>
						<div class='col-md-6'>".frm_numero('numFactura', $numFactura, '10', '10',  ' class="form-control"')."</div>
					</div>	
					<div class='form-group'>
						<label for='fecha' class='col-md-6'>fecha</label>
						<div class='col-md-6'>".
						frm_calendario2('fecha','fecha' ,$fecha, 'id="fecha"  required  class="form-control"')."</div>
					</div>	
					<div class='form-group'>
						<label for='referencia' class='col-md-6'>referencia</label>
						<div class='col-md-6'>".frm_text('referencia', $referencia, '10', '10 ', 'class="form-control"')."</div>
					</div>	
					<div class='form-group'>
						<label for='monto' class='col-md-6'>monto</label>
						<div class='col-md-6'>".frm_numero('monto', $monto, '10', '10',  ' class="form-control"', 8, 2)."</div>
					</div>	
					<div class='form-group'>
						<label for='confirmado' class='col-md-6'>confirmado</label>
						<div class='col-md-6'>".$cmbConfirmado."</div>
					</div>
			</form>";
	return $htm;	
	}
//-----------------------------------------------------------------------------------------------------------
	function checkAllData($f,$new = 0){		// Considerar colocar los campos obligatorios en el formulario.
		if(empty($f['numFactura'])) return "El campo 'Numero de Factura' no puede ser nulo.";
		if(empty($f['fecha'])) return "El campo 'Fecha' no puede ser nulo.";
		if(empty($f['referencia'])) return "El campo 'Referencia' no puede ser nulo.";
		if(empty($f['monto'])) return "El campo 'Monto' no puede ser nulo.";
		//if(empty($f['confirmado'])) return "El campo 'Confirmado' no puede ser nulo.";
	 	return 0;
	}
//-----------------------------------------------------------------------------------------------------------
// Nombres de los campos de la consulta.
	function camposBD(){
		$fields = array();
		$fields[] = 'idPago';	
		$fields[] = 'nombreTienda';	
		$fields[] = 'numFactura';	
		$fields[] = 'fecha';	
		$fields[] = 'monto';	
		$fields[] = 'confirmado';	
		return $fields;
	}
//-----------------------------------------------------------------------------------------------------------
	function encabezados(){
		$headers = array();
		$headers[] = "Tienda";
		$headers[] = "Factura";
		$headers[] = "Fecha de Pago";
		$headers[] = "Monto";
		$headers[] = "Confirmado";
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
		return $attribsHeader;
	}
//-----------------------------------------------------------------------------------------------------------
	function atributosColumnas(){
		// HTML Table: columns attributes
		$attribsCols = array();
		$attribsCols[] = 'nowrap style="text-align:left"';
		$attribsCols[] = 'nowrap style="text-align:center"';
		$attribsCols[] = 'nowrap style="text-align:center"';
		$attribsCols[] = 'nowrap style="text-align:right"';
		$attribsCols[] = 'nowrap style="text-align:center"';
		return $attribsCols;
	}

//-----------------------------------------------------------------------------------------------------------
	function resumenPago($idFactura){
		$rec = $this->tblFacturasRecords("idFactura = $idFactura");
		foreach($rec as $registro){
			extract($registro);
		}
		$fecha = dMySQL_ES($fecha);
		$sql = "SELECT nombreTienda FROM tbltiendas INNER JOIN tblfacturas ON  
			tbltiendas.idtblTienda = tblfacturas.idtblTienda WHERE idfactura = $idFactura";
		$registros = $this->consultagenerica($sql);
		$nombreTienda = $registros[0]["nombreTienda"];
		$sql = "SELECT SUM(producto) AS monto FROM (SELECT -1*precioUnitario*cantidad as producto from tbldetalles
where idfactura = $idFactura) AS T";
		$registros = $this->consultagenerica($sql);
		$montoTotalFactura = $registros[0]["monto"];
		$montoFactura = $registros[0]["monto"];
		$sql = "SELECT * FROM tblPagos where idfactura = $idFactura ORDER BY fecha";
		$recorPagos = $this->consultagenerica($sql);
		$diferencia = $montoFactura;
		$nc = "style='font-weight:bold;text-align:center;' class='alerta'";
		$header = "<thead>
				<tr>
					<th $nc>FECHA</th>
					<th $nc>CONFIRMADO</th>
					<th $nc>MONTO</th>
					<th $nc>DIFERENCIA</th>
				</tr>
			</thead>";

		if(count($recorPagos) == 0){
			$body = "<tbody>
						<tr>
							<td colspan='4' style='text-align:center'>NO HA REALIZADO NINGUN PAGO A&uacute;N</td>
						</tr>
					</tbody>";
		}else{
			$body = "<tbody>";
			foreach($recorPagos as $registro){
				extract($registro);
				$fecha = dMySQL_ES($fecha);
				$pagado = numeroEspanol($monto);
				$diferencia = $montoFactura - $monto;
				$es_diferencia = numeroEspanol($diferencia);
				$body= "<tr>
					<td align='center'>$fecha</td>
					<td align='center'>$confirmado</td>
					<td align='right'>$pagado</td>
					<td align='right'>$es_diferencia</td>
				</tr>";
				$montoFactura = $diferencia;
			}
			$body .= "</tbody>"; 
		}
		$txtidFactura = frm_hidden("idFactura",$idFactura);		
		$htm = '<div class="frmPagoCredito"><form name="frm" id="frm">'.$txtidFactura.'
		
		<div class="row fondo_datos radio" style="margin-top:-20px;">
			<div class="col-md-12 text-center">
				<h3 ><b>Control de pago de Cr&eacute;ditos</b></h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-center">
				<p> <strong>Tienda</strong> '.$nombreTienda.'</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 text-center">
				<p> <strong>Fecha:</strong>'.$fecha.'</p>
			</div>
			<div class="col-md-4"  style="text-align:right">
				<p> <strong>Factura:</strong>'.$numFactura.'</p>
			</div>
			<div class="col-md-4"  style="text-align:right">
				<p> <strong>Monto:  </strong>'.numeroEspanol($montoTotalFactura).'</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12"><th></div>
		</div>';
		$foot =" <tfoot>
					<tr>
						<td colspan='3' $nc >MONTO PENDIENTE POR PAGAR:</td>
						<td align='right' $nc>".numeroEspanol($montoFactura)."</td>
					</tr>
			</tfoot>";
			
		$tabla = "<table id='dataGrid'  class='adminlist table table-striped table-bordered dt-responsive' align='center'>$header $foot $body</table>";
		$htm .= '<div class="row">
			<div class="col-md-12">'.
				$tabla
			.'</div>
		</div>';
		$item1 = frm_radio("pago[]", $diferencia, $diferencia ,"onclick=\"document.getElementById('idMonto').value='';\"  ");
		$accion = " onfocusin=\"document.getElementById('otroMonto').checked = 1\"";
		$item2 = frm_radio("pago[]", "", $diferencia, "id='otroMonto' onclick=\"document.getElementById('idMonto').focus();\" ");
		$hoy = d_US_ES(hoy());
		$CLASE = "CLS_TBLPAGOS";
		$accionBtn = "xajax_pagoCredito(xajax.getFormValues('frm'))";
		$btnGrabar = "onclick=\"$accionBtn\"";
		$txtCalendario = frm_calendario2("fecha","fecha", $hoy, "id='fecha' class='f-c_xx'" );
		$txtMonto = frm_numero("monto", "", 11,11, $accion." id='idMonto'",  8,2);
		
		if($diferencia > 0){
			$htm .='<div class="row">
					<div class="col-md-7 text-center">Monto a cancelar: &nbsp;&nbsp; '.$item1.'&nbsp; Pago Total.  Bs. '.numeroEspanol($diferencia).'</div>
					<div class="col-md-5 text-center">'.$item2.'  Otro monto:  '.$txtMonto.'</div>
				</div>
				<div class="row">
					<div class="col-md-6 text-center">Fecha de pago: '.$txtCalendario.'</div>
				</div>
				<div class="row">
					<br/>
					<div class="col-md-12 text-center">'.frm_button("grabar", "REGISTRAR PAGO", "class='btn btn-primary btn-lg active' style='margin-bottom:20px;' $btnGrabar ").'</div>
				</div></form>
				</div>			
			';
		}	
		return $htm;
	}
	
	
//-----------------------------------------------------------------------------------------------------------
	function pagoCredito($frm){
		extract($frm);	
		$xr = new xajaxResponse();
		if($monto == "" and $pago[0] == 0){
			$msg = "Debe registrar monto de pago.  Elegir pago parcial o total.  En pago parcial, indique el monto.";
		}else{
			if($monto == ""){
				$pagado = $pago[0];
			}else{
				$pagado = numeroIngles($monto);	
			}
			$inventario = new CLS_INVENTARIO;
			$fecha = d_ES_MYSQL($fecha);
			$r = $inventario->tblpagosInsert($idFactura, $fecha, "", $pagado, "N");
			if($r){
				$msg = "Registro grabado.";
			}else{
				$msg = "El registro no se pudo grabar. ";
			}	 
		}
		$xr->script("aviso(\"$msg\")");
		return $xr;
	}
//-----------------------------------------------------------------------------------------------------------
	

}
/*	$bd = new CLS_TBLPAGOS();
	$resumen = $bd->resumenPago(10);
	echo($resumen);
*/
?>
