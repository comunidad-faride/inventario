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
		$tiendasPK = array();
		foreach($mTiendas as $tienda){
			$tiendas[] = $tienda["nombreTienda"];
			$tiendasPK[] = $tienda["idtblTienda"];
		}
		$cmbTiendas = frm_comboGenerico("idtblTienda","nombreTienda", "idtblTienda", "tbltiendas", "CLS_INVENTARIO");
		
		$cmbTiendas2 = frm_list_multi("idtblTienda", 4, $tiendas, $tiendasPK, "", "class='form-control'");
		$aTiposInventario = array("Anal&iacute;tico", "Resumen");
		$aiTipoInventario = array(0,1);
		$cmbTipMov = frm_select("tipoInventario",$aTiposInventario,$aiTipoInventario,  1,"class='form-control'");
		$bd = new CLS_INVENTARIO;
		$calendario = frm_calendario2("fecha","fecha","","class='form-control'");
		$calendario1 = frm_calendario2("fecha1","fecha1");
		$calendario2 = frm_calendario2("fecha2","fecha2");
		$medioCalendario = xfrm_medioCalendario("mes","anno");
		$ejecutar = "onclick=\"xajax_reporteBancario(xajax.getFormValues('frm'))\"";
		$html = "<div class=row><div class='col-md-12  text-center'><h2>REPORTES DE INVENTARIOS</h2></div></div>";
		$html .= "<div class='row'><div class='col-md-6 text-right'>";
		$html .= "<b>Seleccione la(s) Tienda(s):</b> </div><div class='col-md-6'> $cmbTiendas2</div></div>";
		$html .= "<div class='row'><div class='col-md-6 text-right' style='padding-top:10px'><b>Tipo de Inventario: </b></div><div class='col-md-6'> $cmbTipMov</div></div>";
		$html .= "<h3>Indique el periodo a mostrar.</h3>";
		$html .= "<div class='row' style='margin-bottom:-20px;'> 
				<div class='col-md-4 text-right' id='rX0' style='font-weight:900'> Por-> ".frm_radio("opcion","1","1", "onclick='activaFechas(0)' ")." D&iacute;a </div>";
		$html .= "<div class='col-md-3 text-right' id='rX1'>".frm_radio("opcion","2","", "onclick='activaFechas(1)' ")." Mes</div>";
		$html .= "<div class='col-md-3 text-right' id='rX2'> ".frm_radio("opcion","3","", "onclick='activaFechas(2)' ")." Per&iacute;odo</div>";
		$html .= "</div>";
		$html .= "<div class='row' id='xDia'>
				 	<div class='col-md-6 text-right' style='padding-top:10px;'><b>Seleccione el Dia:</div><div class='col-md-4'></b> $calendario	</div>
				 </div>";
		$html .= "<div class='row' id='xMes'  style='display:none'>
				 	<div class='col-md-12'>
				 		<center><b>Seleccione Mes y a&ntilde;o:</b> $medioCalendario</center>
				 	</div>
				 </div>";
		$html .= "<div class='row' id='xFechas' style='display:none'>
				 	<div class='col-md-12'>
				 		<center><b>Seleccione fechas: <i>Desde</i></b> $calendario1; <b><i>hasta </i></b>$calendario2</center>
				 	</div>
				 </div>";		 
		$html .= "<hr/><div class='row'>
				 	<div class='col-md-12'>
				 		<center>".frm_button("reporte", "Mostrar", $ejecutar )."</center>
				 	</div>
				 </div></br></br>";
		$html .= "</div></div>";  
		$htm = "<form id='frm' style='margin:auto; padding-left:100px; padding-right:100px' class='cajita text-center'>".$html."</form>";
		return $htm;
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