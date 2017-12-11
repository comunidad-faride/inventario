<?php
//include_once("./funciones_fecha.php");
class CLS_VENTAS extends CLS_INVENTARIO{
	var $sqlBase;
	var $titulo;
	var $ordenTabla = "data-order='[[ 0, \"desc\" ]]'";
//-----------------------------------------------------------------------------------------------------------
//	METODOS SIN CAMBIOS DE NINGUN TIPO
//-----------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------
	function __construct(){
		parent::__construct();
			$this->sqlBase = "SELECT idFactura, nombreTienda AS tienda, DATE_FORMAT(fecha,  '%d/%c/%Y') as fecha, numFactura, formaPago 
FROM tblfacturas 
INNER JOIN tbltiendas ON tbltiendas.idtblTienda = tblfacturas.idtblTienda 
INNER JOIN tblformaspago ON tblformaspago.idFormaPago = tblfacturas.idFormaPago
WHERE idOpciones=1";
			$this->titulo = "REGISTRO DE VENTAS EN TIENDAS";
	}
//-----------------------------------------------------------------------------------------------------------
	function insertNewRecord($f){
		extract($f);
		//Convertir la fecha de formato ingles o español a formato MYSQL antes de pasarlo a la funcion.
		//  PRIMERO REGISTRAMOS EN LA TABLA tblFacturas
		$fecha = d_ES_MYSQL($fecha);
		$opcion = 1;// 1: Es ventas.
		$comentario = ""; //utf8_encode($comentario);
		$nuevaFactura = $this->nuevo_id("tblfacturas", "idFactura");
		$r = $this->tblfacturasInsert($idtblTienda, $fecha, $numFactura, $opcion, $formaPago, $comentario);
		//  SEGUNDO: REGISTRAMOS EN LA TABLA tbldetalles SI $r = true.
		//  Determinamos el valor del idfactura en tblFacturas
		$n = count($item);
		for($i = 1; $i <= $n; $i++ ){
			// Convertimos las catidades a formato ingles.
			$cantidad_ing = numeroIngles($cantidad[$i]);
			$precio_ing = numeroIngles($precio[$i]);
			if($cantidad_ing != 0 AND $precio_ing != 0){
				$cantidad_ing = -1 * $cantidad_ing;	// Se hace negativo para indicar disminucion de inventario en tienda
				$r = $this->tbldetallesInsert($nuevaFactura, $idproducto[$i], $cantidad_ing, $precio_ing);
			}	
		}
		return $r;
	}
//-----------------------------------------------------------------------------------------------------------
	function updateRecord($f){
		extract($f);
		$fecha = d_ES_MYSQL($fecha);
		$comentario = "";
		$res = $this->tblfacturasUpdate($idFactura, $idtblTienda, $fecha, $numFactura, 1, $formaPago, $comentario);
		// Se borra los registros de la tabla tbldetalles relacionados con la factura 
		$sql = "DELETE FROM tbldetalles WHERE idFactura = $idFactura";
		$res = $this->consultagenerica($sql);
		
		// Ahora se reescribe la factura con los datos suministrados.
		$n = count($item);
		for($i = 1; $i <= $n; $i++ ){
			// Convertimos las catidades a formato ingles.
			$cantidad_ing = numeroIngles($cantidad[$i]);
			$precio_ing = numeroIngles($precio[$i]);
			if($cantidad_ing != 0 AND $precio_ing != 0){
				$cantidad_ing = -1 * $cantidad_ing;	// Se hace negativo para indicar disminucion de inventario en tienda
				$r = $this->tbldetallesInsert($idFactura, $idproducto[$i], $cantidad_ing, $precio_ing);
			}	
		}
		return $r;
	}
//-----------------------------------------------------------------------------------------------------------
	function deleteRecord($id){
		$sql = "DELETE FROM tbldetalles WHERE idFactura = $id";
		$res = $this->consultagenerica($sql);
		$res = $this->tblfacturasDelete("idfactura = $id");
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function formAdd(){
		$html = $this->frmVentas();
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function formEdit($id){
		$html = $this->frmVentas($id);
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	
	function frmVentas(){
		$BD = NEW CLS_INVENTARIO;
		$sql = "SELECT * FROM tbltiendas ORDER BY nombreTienda";
		$recs = $BD->consultagenerica($sql);
		if(count($recs) == 0){
			return "Debe registrar los datos de Las Tiendas antes de realizar este proceso.";
		}
		$nProductos = $BD->numRegistros("tblproductos");	
		if($nProductos == 0){
			return "Debe ingresar los nombres de los Productos antes de realizar este proceso.";
		}	
		if(func_num_args() > 0){
			$idFactura = func_get_arg(0);
			$records = $this->tblfacturasRecords("idFactura = $idFactura");
			foreach($records as $record){
				extract($record);
			}
			$fecha = dMySQL_ES($fecha);
			$textoBoton = "Actualizar";
			$accion = "onClick=\"xajax_update('CLS_VENTAS',xajax.getFormValues('frm'))\"";
			$detalles = $BD->tbldetallesRecords("idfactura = $idFactura ORDER BY idDetalles");
			$items = count($detalles);
			$xx = "x";
			if($idFormaPago == 4){  //Si es credito.
				$sql = "SELECT max(monto) as monto FROM tblpagos WHERE idFactura = $idFactura";
				$rec = $this->consultagenerica($sql);
				$monto = (float) $rec[0]["monto"];	
			}else{
				$monto = "";
			}
			$utf8 = "x";
		}else{
			$utf8 = "";
			$pk = "";
			$textoBoton = "Grabar";
			$accion = "onClick=\"xajax_save('CLS_VENTAS',xajax.getFormValues('frm'))\"";
			$cantidad[1] = '';
			$precio[1] = '';
			$totalxProducto1 = '';
			$fecha = d_US_ES(hoy());
			$idtblTienda = $recs[0]["idtblTienda"];
			$sql = "";
			$numFactura = $BD->nuevo_id("tblFacturas", "numFactura", "idtblTienda = $idtblTienda AND idOpciones=1");
			$items = 1; // Se inicia en 1 en este caso. 
			$xx = "y"; 
			$idFactura = "";
			$idFormaPago = 1;
			$monto = "";
		}

		$accionCMB = "onchange='xajax_cambiarNumFactura(this.value, 1)'";
		$txtidFactura = frm_hidden("idFactura", $idFactura);
		$txtCalendario = frm_calendario2("fecha","fecha", "$fecha", "id='fecha' class='f-c_xx'" );
		$cmbTienda = frm_comboGenerico("idtblTienda", "nombreTienda", "idtblTienda", "tblTiendas", "cls_inventario", "", " id='idtblTienda' class='f-c_xx' $accionCMB", $idtblTienda, $utf8);
		$txtFactura = frm_numero("numFactura", $numFactura, 6, 6, " id = 'numFactura' class='f-c_xx'");
		$htm = '<form name ="frm" id = "frm" style="margin-top:-25px">'.$txtidFactura.' <!--<div class="container bg-success" style = "border-radius:20px;">-->
			<div class="row" >
				<div class="col-md-12 text-center"> <h2>Ventas en Tiendas</h2> </div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="padre">
						<div class="hijo-1">
							<label>Fecha:</label>'.$txtCalendario.'
						</div>
						<div class="hijo-2">
							<label>Tienda:</label>'.$cmbTienda.'
						</div>
						<div class="hijo-3">
							<label>Factura:</label>'.$txtFactura.'
						</div>
					</div>
				</div>
			</div>
			<div class="row">';
				$accion = "onkeyup='totalizar()';";
				$formatearsd =  "onblur='this.value = formatear(this.value, 0)'";	
				$formatear =  "onblur='this.value = formatear(this.value, 2); nuevaFila(\"datosFactura\");'";
				$htm .= '<div class= "col-md-12" style="margin-top:-0px;"><table style="background:white" align="center" class="table-hover table-bordered" id="datosFactura">
			<thead>
				<th class="text-center bg-primary" style="padding-left:5px;padding-right:5px;">Item</th>
				<th class="text-center bg-primary">Producto</th>
				<th class="text-center bg-primary">Cantidad</th>
				<th class="text-center bg-primary">P/U</th>
				<th class="text-center bg-primary" style="padding-left:5px;padding-right:5px;">Total</th>
			</thead>
			
			<tbody>';
			$totalItems = 0;
			$totalAcumulado = 0;
			for($i = 1; $i <= $items; $i++){
				if($xx == "y"){
					$idproducto = "";
					$cantidad = "";
					$precio = "";
					$subtotal = "";
					$totalAcumulado = "";
					$j = 1;
				}else{
					$j = $i -1; 
					$idproducto = $detalles[$j]["idproducto"];
					$cantidad = -1 * $detalles[$j]["cantidad"];
					$totalItems += $cantidad;
					$precio = $detalles[$j]["precioUnitario"];
					$subtotal = ($precio * $cantidad);
					$totalAcumulado += $subtotal;	
				}
				if($subtotal == "" ){
					$txtSubtotal = "";
					$txtTotalAcumulado = "";
				}else{
					$txtSubtotal =  numeroEspanol($subtotal);
					$txtTotalAcumulado = numeroEspanol($totalAcumulado);
				}
				$txtCantidad = ($cantidad == "") ? "" :  numeroEspanol($cantidad, 0);
				$txtPrecio = ($precio == "") ? "" : numeroEspanol($precio,2);				
				$txtSubTotal = frm_text("subtotal[$j]", $txtSubtotal, 15,15, "class='form-control text-right' readonly='true'");
				$txtTotalItems = frm_text("totalItems", $totalItems, 10,15, "class='form-control text-right' readonly='true'");
				$txtTotalAcumulado = frm_text("totalAcumulado", $txtTotalAcumulado , 15,15, "class='form-control text-right' readonly='true'");
				$tag1 = " onkeypress='return NumCheck(event, this, 6, 0);' style='text-align: right' ";
				$tag2 = " onkeypress='return NumCheck(event, this, 6, 2);' style='text-align: right' ";
				$txtCantidad = frm_text("cantidad[$i]", $txtCantidad,6,6,"$tag1 $accion $formatearsd class='form-control' id='cantidad$i' ", 6 , 0);
				$txtPrecio = frm_text("precio[$i]", $txtPrecio,12,12,"$tag2 $accion  $formatear class='form-control' id='precio$i'", 6, 2);
				$cmbidProducto = frm_comboGenerico("idproducto[$i]","producto","idproducto","tblproductos","cls_inventario","","class='form-control' ", $idproducto, $utf8);
				$txtIndice = frm_numero("item[$i]", $i, 2, 2, "class='form-control' id='item$i' readonly='true'", 2, 0);
				$_SESSION["cmbProductos"] = frm_comboGenerico("idproducto[$i]","producto","idproducto","tblproductos","cls_inventario","","class='form-control'", "",  $utf8);
				$htm .=	'<tr id="fila"'.$i.'>
					<td class="text-center" >'.$txtIndice.'</td>
					<td>'
					.$cmbidProducto.
					'</td>
					<td>'.$txtCantidad.'</td>
					<td>'.$txtPrecio.'</td>
					<td width="150px" id="totalxProducto'.$i.'"  class="text-right" style="padding-left:5px;padding-right:5px;" >'.$txtSubTotal.'</td>
					</tr>';
			}
			$htm .= '</tbody>
			<tfoot>
				<th colspan="2" class="text-right bg-primary" style="padding-left:5px;padding-right:15px;">TOTALES</th>
				<th id="idSumaProductos"  class="text-right bg-primary" style="padding-left:5px;padding-right:5px;">'.$txtTotalItems.'</th>
				<th class="text-right bg-primary"></th>
				<th id="idSumaBs"  class="text-right bg-primary" style="padding-left:5px;padding-right:5px;">'.$txtTotalAcumulado.'</th>
			</tfoot>	
			</table>';
			//   AQUI SE DEBE COLOCAR FORMAS DE PAGO...
			$alCambiar = "onchange=\"activaAporte(this.value)\"";
			$cmbFP = frm_comboGenerico("formaPago", "formaPago", "idFormaPago", "tblformaspago", "CLS_INVENTARIO", "", $alCambiar." class='form-control'", $idFormaPago, $utf8);
			$txtAporte = frm_text("monto", $monto, "10", "10", "disabled $tag2 class='form-control' id='idMonto'");
			$htm .= '<br/><div class="row">
					<div class="col-md-3 text-right">Forma de Pago: </div>
				<div class="col-md-3">'.$cmbFP.'</div>
				<div class="col-md-3 text-right">Aporte Inicial:</div>
				<div class="col-md-3">'.$txtAporte.'</div>
				</div>';
			return $htm;
	}
//---------------------------------------------------------------------------------------------------------	
	function cambiarNumFactura($idtblTienda, $idOpcion){	// Ventas
		$BD = new CLS_INVENTARIO;
		$condicion = "idtblTienda = $idtblTienda AND idOpciones = $idOpcion";
		$numFactura = $BD->nuevo_id("tblFacturas", "numFactura", $condicion);	
		$xr = new xajaxResponse();
		$xr->assign("numFactura", "value", $numFactura);
		return $xr;
	}
//---------------------------------------------------------------------------------------------------------	
	function camposTabla($item) {
		if($item == 2){
			$SQL = "SELECT idproducto, producto FROM tblproductos ORDER BY producto";
			$bd = new CLS_INVENTARIO;
			$matriz = $bd->consultagenerica($SQL);
			$atxt_idproducto =  array();
			$atxt_producto =  array();
			foreach($matriz as $record){
				extract($record);
				$atxt_idproducto[] = $idproducto;
				$atxt_producto[] = $producto; 
			}
			$_SESSION["idproducto"] = $atxt_idproducto;
			$_SESSION["producto"] = $atxt_producto;
		}
		$cmbProductos = frm_select("idproducto[$item]", $_SESSION["producto"], $_SESSION["idproducto"], 1,"class='form-control' ");
		$txtIndice = frm_numero("item[$item]", $item, 2, 2, "class='form-control' id='item$item' readonly='true'", 2, 0);
		//$cmbProductos = frm_comboGenerico("idproducto[$item]","producto","idproducto","tblproductos","cls_inventario","","class='form-control' ");
		$accion = "onkeyup='totalizar()';";
		$formatear =  "onblur='this.value = formatear(this.value, 2); nuevaFila(\"datosFactura\");'";
		$precio = frm_numero("precio[$item]","",12,12," $accion $formatear class='form-control' id='precio$item'", 6, 2);
		$formatearsd =  "onblur='this.value = formatear(this.value, 0)'";	
		$cantidad = frm_numero("cantidad[$item]","",6,6,"$accion $formatearsd class='form-control' id='cantidad$item' ", 6 , 0);
		$idCantidad = "cantidad$item";
		$xr = new xajaxResponse();
		$xr->assign("fila$item"."col0","innerHTML", $txtIndice);
		$xr->assign("fila$item"."col1","innerHTML", $cmbProductos);// 
		$xr->assign("fila$item"."col2","innerHTML", $cantidad);
		$xr->assign("fila$item"."col3","innerHTML", $precio);
		$xr->script("document.getElementById('$idCantidad').focus(); activarLimpiaCeros();");
		//$xr->script("activarLimpiaCeros();");
		return $xr;
	}
//-----------------------------------------------------------------------------------------------------------
	function checkAllData($f,$new = 0){		// Considerar colocar los campos obligatorios en el formulario.
		if(empty($f['numFactura'])) return "El campo 'numFactura' no puede ser nulo.";
	 	return 0;
	}
//-----------------------------------------------------------------------------------------------------------
// Nombres de los campos de la consulta.
	function camposBD(){
//		SELECT idFactura, nombreTienda AS tienda, fecha, numfactura AS Factura FROM tblfacturas 
//		INNER JOIN tbltiendas ON tbltiendas.idtblTienda = tblfacturas.idtblTienda
		$fields = array();
		$fields[] = 'idFactura';	
		$fields[] = 'fecha';	
		$fields[] = 'tienda';	
		$fields[] = 'numFactura';	
		$fields[] = 'formaPago';	
		return $fields;
	}
//-----------------------------------------------------------------------------------------------------------
	function encabezados(){
		$headers = array();
		$headers[] = "Fecha";
		$headers[] = "Tienda";
		$headers[] = "Factura";
		$headers[] = "Pagos";
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
		return $attribsHeader;
	}
//-----------------------------------------------------------------------------------------------------------
	function atributosColumnas(){
		// HTML Table: columns attributes
		$attribsCols = array();
		$attribsCols[] = 'nowrap style="text-align:center"';
		$attribsCols[] = 'nowrap style="text-align:left"';
		$attribsCols[] = 'nowrap style="text-align:right"';
		$attribsCols[] = 'nowrap style="text-align:center"';
		return $attribsCols;
	}

//-----------------------------------------------------------------------------------------------------------
	
} 



?>