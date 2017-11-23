<?php
/*	include_once("./cls_inventario.php");
	include_once("./form_items.php");
	include_once("./funciones_fecha.php");*/
class CLS_REPORTES {
		function __construct() {
			
		}
//-----------------------------------------------------------------------------------------------------------
	function frmReportesInventario(){
		$bd = new CLS_INVENTARIO;
		$sql = "SELECT idtblTienda, nombreTienda FROM tbltiendas ORDER BY nombreTienda";
		$mTiendas = $bd->consultagenerica($sql);
		$tiendas = array();
		$tiendas[0] = "Todas";
		$tiendasPK = array();
		$tiendasPK[0] = 0;
		foreach($mTiendas as $tienda){
			$tiendas[] = $tienda["nombreTienda"];
			$tiendasPK[] = $tienda["idtblTienda"];
		}
		$cmbTiendas = frm_comboGenerico("idtblTienda","nombreTienda", "idtblTienda", "tbltiendas", "CLS_INVENTARIO");
		$nc1 = "style='font-weight:bold;text-align:center;' class='alerta1'";
		$nc2 = "style='font-weight:bold;text-align:right;' class='alerta1'";
		//$cmbTiendas2 = frm_list_multi("idtblTienda", 4, $tiendas, $tiendasPK, "", "class='form-control'");
		$cmbTiendas2 = frm_select("idtblTienda",$tiendas, $tiendasPK,0, "class='form-control'");
		$aTiposInventario = array("Anal&iacute;tico", "Resumen");
		$aiTipoInventario = array(0,1);
		$cmbTipMov = frm_select("tipoInventario",$aTiposInventario,$aiTipoInventario,  1,"class='form-control'");
		$bd = new CLS_INVENTARIO;
		$calendario = frm_calendario2("fecha","fecha");
		$calendario1 = frm_calendario2("fecha1","fecha1");
		$calendario2 = frm_calendario2("fecha2","fecha2");
		$medioCalendario = xfrm_medioCalendario("mes","anno");
		$ejecutar = "onclick=\"xajax_reporteFacturas(xajax.getFormValues('frm'))\"";
		$html = "<div class=row><div class='col-md-12  text-center'><h2>REPORTES DE INVENTARIOS</h2></div></div>";
		$html .= "<div class='row'><div class='col-md-6 text-right' >";
		$html .= "<b $nc2>Seleccione la(s) Tienda(s):</b> </div><div class='col-md-6'> $cmbTiendas2</div></div>";
		$html .= "<div class='row'><div class='col-md-6 text-right' ><p $nc2>Tipo de Inventario: </p></div><div class='col-md-6'> $cmbTipMov</div></div>";
		$html .= "<p $nc1>Indique el periodo a mostrar.</p>";
		$html .= "<div class='row' style='margin-bottom:-20px;'> 
				<div class='col-md-4 text-right' id='rX0' style='font-weight:900'> Por-> ".frm_radio("opcion","1","1", "onclick='activaFechas(0)' ")." D&iacute;a </div>";
		$html .= "<div class='col-md-3 text-right' id='rX1'>".frm_radio("opcion","2","", "onclick='activaFechas(1)' ")." Mes</div>";
		$html .= "<div class='col-md-3 text-right' id='rX2'> ".frm_radio("opcion","3","", "onclick='activaFechas(2)' ")." Per&iacute;odo</div>";
		$html .= "</div>";
		$html .= "<div class='row' id='xDia'>
				 	<div class='col-md-12  style='padding-top:10px;'><p $nc1>Seleccione el Dia:$calendario</p> 	</div>
				 </div>";
		$html .= "<div class='row' id='xMes'  style='display:none'>
				 	<div class='col-md-12'>
				 		<center><p $nc1>Seleccione Mes y a&ntilde;o: $medioCalendario</p></center>
				 	</div>
				 </div>";
		$html .= "<div class='row' id='xFechas' style='display:none'>
				 	<div class='col-md-12'>
				 		<center><p $nc1>Seleccione fechas:  Desde $calendario1 hasta $calendario2</p></center>
				 	</div>
				 </div>";		 
		$html .= "<hr/><div class='row'>
				 	<div class='col-md-12'>
				 		<center>".frm_button("reporte", "Mostrar", "$ejecutar class='btn btn-primary btn-lg active' style='margin-bottom:20px;' ")."</center>
				 	</div>
				 </div>";
		$html .= "</div></div>";  
		$htm = "<form id='frm' name='frm' style='margin:auto; padding-left:80px; padding-right:80px' class='frmPagoCredito text-center'>".$html."</form>";
		return $htm;
	}
//-----------------------------------------------------------------------------------------------
	function reporteFacturas($frm){
		extract($frm);
		$fechaInicial = $fecha1;
		$fechaFinal = $fecha2;
		$tiendas = $idtblTienda[0];  // 0: Todas las tiendas; n: Solo la tienda n.
		$tipoReporte = 1; // 0: Entregas; 1: Ventas.
		$numFactura = 0; // 0: Todas; n: Solo esa tienda.
		switch($opcion){
			case 1:
				$fechaInicial = $fechaFinal = $fecha;
				break;
			case 2:
				$fecha1 = "$mes/01/$anno";
				$fechaInicial = d_US_ES($fecha1);
				$fecha2 = dFinMes($fecha1);
				$fechaFinal = d_US_ES($fecha2);
				break;	
			case 3:
				$fechaInicial = $fecha1;
				$fechaFinal = $fecha2;
				break;
		}
//	Validación de consulta.
//-------------------------------------------------------------------------------------------------		
		$pFecha = d_ES_MYSQL($fechaInicial);
		$fFecha = d_ES_MYSQL($fechaFinal);
		$nrFact = 0;//$numFactura;
		$numTienda = $tiendas;
		$bd = new CLS_INVENTARIO;
		//$idOpcion = 1; // 1 para ventas; 0 para entregas.
		if($numTienda==0){
			$fSql = " WHERE idOpciones=$tipoReporte and fecha >= '$pFecha'  and fecha <= '$fFecha'  ORDER BY nombreTienda, numFactura";
		}elseif($nrFact==0){
			$fSql = " WHERE idOpciones=$tipoReporte and fecha >= '$pFecha'  and fecha <= '$fFecha' and tbltiendas.idtblTienda = $numTienda   ORDER BY nombreTienda, numFactura";
		}else{
			$fSql = " WHERE idOpciones=$tipoReporte and numFactura = $nrFact and tbltiendas.idtblTienda = $numTienda ";
		}
		$sql = "SELECT tbltiendas.idtblTienda, nombreTienda,  tblfacturas.idFactura,  DATE_FORMAT(fecha,  '%d/%c/%Y') as fecha , numFactura, idOpciones, 
comentario,idDetalles, producto, cantidad, precioUnitario  FROM tbltiendas  
			INNER JOIN tblfacturas ON tbltiendas.idtblTienda= tblfacturas.idtblTienda  INNER JOIN tbldetalles 
			ON tblfacturas.idFactura = tbldetalles.idFactura INNER JOIN tblproductos ON 
			tblproductos.idproducto=tbldetalles.idproducto $fSql" ;
		$mTiendas = $bd->consultagenerica($sql);
//-------------------------------------------------------------------------------------------------		
		$msg = "";
		$xr = new xajaxResponse();
		if(count($mTiendas) == 0){
			$msg = "No existen datos con las condiciones seleccionadas.";
			$xr->script("aviso(\"$msg\")");	
		}else{
			setcookie("fechaInicial", $fechaInicial,time()+36000);// asignacion de datos a los cookies.
			setcookie("fechaFinal", $fechaFinal,time()+36000);
			setcookie("tiendas", $tiendas, time()+36000);
			setcookie("tipoReporte", $tipoReporte, time()+36000);
			setcookie("numFactura", $numFactura, time()+36000);
			$xr->script("openWindow('Condominio', './php/cls_retventas.php')");  
		}
		return $xr;
	}	
//-----------------------------------------------------------------------------------------------		
	function nombreTiendas() {

		$_SESSION["tiendas"] = $tiendas;
		$_SESSION["tienasPK"] = $tiendasPK; 
		return;
	}	
}
	
/*	$x = new CLS_REPORTES;
	$HTML = $x->frmReportesInventario();
	ECHO $HTML;
	*/
?>