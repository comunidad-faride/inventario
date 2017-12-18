<?php
//include_once("./funciones_fecha.php");
class CLS_ENTREGAS{
	function frmEntregas(){
		
		$BD = NEW CLS_INVENTARIO;
		$sql = "SELECT * FROM tblTiendas ORDER BY nombreTienda LIMIT 0, 1";
		$recs = $BD->consultagenerica($sql);
		$idtblTienda = $recs[0]["idtblTienda"];
		$accionCMB = "onchange='xajax_cambiarNumFactura(this.value)'";
		$numFactura = $BD->nuevo_id("tblFacturas", "numFactura", "idtblTienda = $idtblTienda");
		$htm = '<form name ="frm" id = "frm"> <div class="container bg-info" style = "border-radius:20px;">
			<div class="row">
				<div class="col-md-12 text-center"> <h2>Entrega de Mercanc&iacute;a</h2> </div>
			</div>
			<div class="row">
			
			<div class="col-md-12">
				<div class="col-md-1 text-right">
					<label style="padding-top:10px"><p>Fecha:</p></label>
				</div>
				<div class="col-md-2" style="margin-left:-20px;">'
					.frm_calendario2("fecha","fecha", "", "id='fecha' class='form-control input-md'" ).
				'</div>
				<div class="col-md-2 text-right"  style="margin-left:-100px;">
					<label style="padding-top:10px; margin-right: -20px" class="text-rigth"><p>Tienda ->:</p></label>
				</div>
				<div class="col-md-4">'
					.frm_comboGenerico("idtblTienda", "nombreTienda", "idtblTienda", "tblTiendas", "cls_inventario", "", " id='idtblTienda' class='form-control' $accionCMB").
				'</div>
				<div class="col-md-1 text-right ">
					<label><p>No. Factura:</p></label>
				</div>
				<div class="col-md-2">'
					.frm_numero("idMovimientos", $numFactura, 6, 6, " id = 'idtblFactura' class='form-control'").
				'</div>
			</div>
			</div>
			<div class="row">';
				$accion = "onkeyup='totalizar()';";
				$formatearsd =  "onblur='this.value = formatear(this.value, 0)'";	
				$formatear =  "onblur='this.value = formatear(this.value, 2)'";  
				$htm .= '<div class= "col-md-8" style="margin-top:-15px;"><table style="background:white" align="center" class="table-hover table-bordered" id="datosFactura">
			<thead>
				<th class="text-center bg-primary" style="padding-left:5px;padding-right:5px;">Item</th>
				<th class="text-center bg-primary">Producto</th>
				<th class="text-center bg-primary">P/U</th>
				<th class="text-center bg-primary">Cantidad</th>
				<th class="text-center bg-primary" style="padding-left:5px;padding-right:5px;">Total</th>
			</thead>
			<tfoot>
				<th colspan="3" class="text-right bg-primary" style="padding-left:5px;padding-right:15px;">TOTALES</th>
				<th id="idSumaProductos"  class="text-right bg-primary" style="padding-left:5px;padding-right:5px;"></th>
				<th id="idSumaBs"  class="text-right bg-primary style="padding-left:5px;padding-right:5px;""></th>
			</tfoot>
			<tbody>';
			
			for($i = 1; $i < 12; $i++){
				$htm .=	'<tr>
					<td class="text-center">'.$i.'</td>
					<td>'
					.frm_comboGenerico("idproducto$i","producto","idproducto","tblproductos","cls_inventario","","class='form-control'").
					'</td>
					<td>'.frm_numero("precio$i","",12,12," $accion $formatear class='form-control' id='precio$i'", 6, 2).'</td>
					<td>'.frm_numero("cantidad$i","",6,6,"$accion $formatearsd class='form-control' id='cantidad$i' ", 6 , 0).'</td>
					<td width="100px" id="totalxProducto'.$i.'"  class="text-right" style="padding-left:5px;padding-right:5px;" ></td>
					</tr>';
			}
			$htm .= '</tbody>	
			</table></div> ';
			$htm .= '<div class="col-md-4 "><br/><br/>'.frm_button("grabar", "Registrar").'<br/><br/>'
					.frm_button("siguiente", "Siguiente", "onclick='blanquear();'").'<br/><br/><br/><br/>'
					.frm_button("imprimir", "IMPRIMIR", "onclick='alert(\" BINGO....\")'").
			'</div></div></frm>';	
			$htm .= '<br/></div>';
			return $htm;
	}
	
	function cambiarNumFactur($idtblTienda){	// Entregas
		$BD = new CLS_INVENTARIO;
		$numFactura = $BD->nuevo_id("tblFacturas", "numFactura", "idtblTienda = $idtblTienda");	
		$xr = new xajaxResponse();
		$xr->assign("idtblFactura", "value", $numFactura);
		return $xr;
	}
	
} 



?>