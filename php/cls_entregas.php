<?php
//include_once("./funciones_fecha.php");
class CLS_ENTREGAS extends CLS_INVENTARIO{
	var $sqlBase;
	var $titulo;
	var $ordenTabla = "data-order='[[ 0, \"desc\" ]]'";
//-----------------------------------------------------------------------------------------------------------
//	METODOS SIN CAMBIOS DE NINGUN TIPO
//-----------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------
	function __construct(){
		parent::__construct();
			$this->sqlBase = "SELECT idFactura, nombreTienda AS tienda, DATE_FORMAT(fecha,  '%d/%c/%Y') as fecha, numFactura FROM tblfacturas 
INNER JOIN tbltiendas ON tbltiendas.idtblTienda = tblfacturas.idtblTienda  WHERE idOpciones = 0";
			$this->titulo = "REGISTRO DE ENVIOS A TIENDAS";
	}
//-----------------------------------------------------------------------------------------------------------
	function insertNewRecord($f){
		extract($f);
		//Convertir la fecha de formato ingles o español a formato MYSQL antes de pasarlo a la funcion.
		//  PRIMERO REGISTRAMOS EN LA TABLA tblFacturas
		$fecha = d_ES_MYSQL($fecha);
		$opcion = 0; // 0 es Entregas
		$comentario = ""; //utf8_encode($comentario);
		$nuevaFactura = $this->nuevo_id("tblfacturas", "idFactura");
		$formaPago = 1;
		$r = $this->tblfacturasInsert($idtblTienda, $fecha, $numFactura, $opcion, $formaPago, $comentario);
		//  SEGUNDO: REGISTRAMOS EN LA TABLA tbldetalles SI $r = true.
		//  Determinamos el valor del idfactura en tblFacturas
		$n = count($item);
		for($i = 1; $i <= $n; $i++ ){
			// Convertimos las catidades a formato ingles.
			$cantidad_ing = numeroIngles($cantidad[$i], 0);
			$precio_ing = numeroIngles($precio[$i]);
			if($cantidad_ing != 0 AND $precio_ing != 0){
				$cantidad_ing = $cantidad_ing;	
				$r = $this->tbldetallesInsert($nuevaFactura, $idproducto[$i], $cantidad_ing, $precio_ing);
				if($r== FALSE) return false;
			}	
		}
		return $r;
	}
//-----------------------------------------------------------------------------------------------------------
	function updateRecord($f){
		extract($f);
		$fecha = d_ES_MYSQL($fecha);
		$comentario = "";
		$formaPago = 0;
		$res = $this->tblfacturasUpdate($idFactura, $idtblTienda, $fecha, $numFactura, 0, $formaPago, $comentario);
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
		$html = $this->frmEntregas();
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function formEdit($id){
		$html = $this->frmEntregas($id);
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	
	function frmEntregas(){
		$BD = NEW CLS_INVENTARIO;
		$sql = "SELECT * FROM tblTiendas ORDER BY nombreTienda LIMIT 0, 1";
		$recs = $BD->consultagenerica($sql);
		if(count($recs) == 0){
			return "Debe registrar los datos de Las Tiendas antes de realizar este proceso";
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
		}else{
			$pk = "";
			$textoBoton = "Grabar";
			$accion = "onClick=\"xajax_save('CLS_VENTAS',xajax.getFormValues('frm'))\"";
			$cantidad[1] = '';
			$precio[1] = '';
			$totalxProducto1 = '';
			$idtblTienda = 0;
			$fecha = d_US_ES(hoy());
			$idtblTienda = $recs[0]["idtblTienda"];
			$numFactura = $BD->nuevo_id("tblFacturas", "numFactura", "idtblTienda = $idtblTienda AND idOpciones= 0");
			$items = 1; // Se inicia en 1 en este caso. 
			$xx = "y"; 
			$idFactura = "";
		}

		$accionCMB = "onchange='xajax_cambiarNumFactura(this.value, 0)'";
		$txtidFactura = frm_hidden("idFactura", $idFactura);
		$htm = '<form name ="frm" id = "frm">'.$txtidFactura.' <!--<div class="container bg-success" style = "border-radius:20px;">-->
			<div class="row">
				<div class="col-md-12 text-center"> <h2>Env&iacute;os a  Tiendas</h2> </div>
			</div>
			<div class="row">
			
			<div class="col-md-12">
				<div class="col-md-1 text-right">
					<label style="padding-top:10px"><p>Fecha:</p></label>
				</div>
				<div class="col-md-2" >'
					.frm_calendario2("fecha","fecha", "$fecha", "id='fecha' class='form-control input-md'" ).
				'</div>
				<div class="col-md-2 text-right">
					<label style="padding-top:10px; margin-right: -20px" class="text-rigth"><p>Tienda:</p></label>
				</div>
				<div class="col-md-3">'
					.frm_comboGenerico("idtblTienda", "nombreTienda", "idtblTienda", "tblTiendas", "cls_inventario", "", " id='idtblTienda' class='form-control' $accionCMB", $idtblTienda).
				'</div>
				<div class="col-md-2 text-right ">
					<label><p>No. Factura:</p></label>
				</div>
				<div class="col-md-2">'
					.frm_numero("numFactura", $numFactura, 6, 6, " id = 'numFactura' class='form-control'").
				'</div>
			</div>
			</div>
			<div class="row">';
				$accion = "onkeyup='totalizar()';";
				$formatearsd =  "onblur='this.value = formatear(this.value, 0)'";	
				$formatear =  "onblur='this.value = formatear(this.value, 2); nuevaFila(\"datosFactura\");'";
				$htm .= '<div class= "col-md-12" style="margin-top:-15px;"><table style="background:white" align="center" class="table-hover table-bordered" id="datosFactura">
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
					$cantidad = $detalles[$j]["cantidad"];
					$totalItems += $cantidad;
					//$cantidad = numeroEspanol($cantidad);
					$precio = $detalles[$j]["precioUnitario"];
					//$precio = numeroEspanol($cantidad);	
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
				
				$txtIndice = frm_numero("item[$i]", $i, 2, 2, "class='form-control' id='item$i' readonly='true'", 2, 0);
				$htm .=	'<tr id="fila"'.$i.'>
					<td class="text-center" >'.$txtIndice.'</td>
					<td>'
					.frm_comboGenerico("idproducto[$i]","producto","idproducto","tblproductos","cls_inventario","","class='form-control' ", $idproducto).
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

			$htm .= '</frm><br/></div>';
			return $htm;
	}

//---------------------------------------------------------------------------------------------------------	
	function camposTabla($item) {
		$txtIndice = frm_numero("item[$item]", $item, 2, 2, "class='form-control' id='item$item' readonly='true'", 2, 0);
		$cmbProductos = frm_comboGenerico("idproducto[$item]","producto","idproducto","tblproductos","cls_inventario","","class='form-control' ");
		$accion = "onkeyup='totalizar()';";
		$formatear =  "onblur='this.value = formatear(this.value, 2); nuevaFila(\"datosFactura\");'";
		$tag2 = " onkeypress='return NumCheck(event, this, 6, 2);' style='text-align: right' ";
		$precio = frm_numero("precio[$item]","",12,12," $accion $tag2 $formatear class='form-control' id='precio$item'", 6, 2);
		$formatearsd =  "onblur='this.value = formatear(this.value, 0)'";	
		$tag1 = " onkeypress='return NumCheck(event, this, 6, 0);' style='text-align: right' ";
		$cantidad = frm_numero("cantidad[$item]","",6,6,"$accion $tag1 $formatearsd class='form-control' id='cantidad$item' ", 6 , 0);
		$idCantidad = "cantidad$item";
		$xr = new xajaxResponse();
		$xr->assign("fila$item"."col0","innerHTML", $txtIndice);
		$xr->assign("fila$item"."col1","innerHTML", $cmbProductos);
		$xr->assign("fila$item"."col2","innerHTML", $cantidad);
		$xr->assign("fila$item"."col3","innerHTML", $precio);
		$xr->script("document.getElementById('$idCantidad').focus()");
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
		/*$fields[] = 'opcion';	*/
		/*$fields[] = 'comentario';*/	
		return $fields;
	}
//-----------------------------------------------------------------------------------------------------------
	function encabezados(){
		$headers = array();
	//	$headers[] = "idFactura";
		$headers[] = "Fecha";
		$headers[] = "Tienda";
		$headers[] = "Factura";
		return $headers;
	}
//-----------------------------------------------------------------------------------------------------------
	function atributosEncabezados(){
		// HTML table: hearders attributes
		$attribsHeader = array();
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
		return $attribsCols;
	}

//-----------------------------------------------------------------------------------------------------------
	
} 



?>