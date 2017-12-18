<?php
/*
include_once("./cls_inventario.php");
include_once("./funciones_fecha.php");
*/
class CLS_INVENTARIO_INICIAL extends CLS_INVENTARIO{
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
INNER JOIN tbltiendas ON tbltiendas.idtblTienda = tblfacturas.idtblTienda WHERE idOpciones = 2";
			$this->titulo = "REGISTRO DE AJUSTES DE INVENTARIO";
	}
//-----------------------------------------------------------------------------------------------------------
	function insertNewRecord($f){
		extract($f);
		//Convertir la fecha de formato ingles o español a formato MYSQL antes de pasarlo a la funcion.
		//  PRIMERO REGISTRAMOS EN LA TABLA tblFacturas
		$fecha = d_ES_MYSQL($fecha);
		$opcion = 2; // 0 es Entregas
		//utf8_encode($comentario);
		$nuevaFactura = $this->nuevo_id("tblfacturas", "idFactura");
		$formaPago = 1;
		$r = $this->tblfacturasInsert($idtblTienda, $fecha, $numFactura, $opcion, $formaPago, $comentario);
		//  SEGUNDO: REGISTRAMOS EN LA TABLA tbldetalles SI $r = true.
		//  Determinamos el valor del idfactura en tblFacturas
		$n = count($idproducto);
		$precio_ing = 0;
		for($i = 0; $i < $n; $i++ ){
			// Convertimos las catidades a formato ingles.
			$cantidad_ing = numeroIngles($cantidad[$i], 0);
			if($cantidad_ing != 0){
				$cantidad_ing = -1 * $cantidad_ing;	
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
		//$comentario = "";
		$formaPago = 0;
		$res = $this->tblfacturasUpdate($idFactura, $idtblTienda, $fecha, $numFactura, 2, $formaPago, $comentario);
		// Se borra los registros de la tabla tbldetalles relacionados con la factura 
		$sql = "DELETE FROM tbldetalles WHERE idFactura = $idFactura";
		$res = $this->consultagenerica($sql);
		// Ahora se reescribe la factura con los datos suministrados.
		$n = count($idproducto);
		$precio_ing = 0;
		for($i = 0; $i < $n; $i++ ){
			// Convertimos las catidades a formato ingles.
			$cantidad_ing = numeroIngles($cantidad[$i], 0);
			if($cantidad_ing != 0){
				$cantidad_ing = -1 * $cantidad_ing;	
				$r = $this->tbldetallesInsert($nuevaFactura, $idproducto[$i], $cantidad_ing, $precio_ing);
				if($r== FALSE) return false;
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
	if(func_num_args() > 0){
		$idFactura = func_get_arg(0);
		$records = $this->tblfacturasRecords("idFactura = $idFactura");
		//$idtblTienda = func_get_arg(0);
		//$records = $this->tblcontrolingresosRecords("idtblTienda = $idtblTienda");
		//$records = $this->tblfacturasRecords("idFactura = $idFactura");
		foreach($records as $record){
			extract($record);
		}
		$utf8 = "x";
	}else{
		$utf8 = "";
		$pk = "";
		$idFactura = 0;
		$idtblTienda = 0;
		//$fecha = date('d/m/Y');
		$comentario = '';
		$fecha = d_US_ES(hoy());
		$idtblTienda = $recs[0]["idtblTienda"];
		$numFactura = $BD->nuevo_id("tblFacturas", "numFactura", "idOpciones = 2");
	}
	$ac = "onchange=\"xajax_asignarConXajax('dataGrid2', 'innerHTML', 'CLS_INVENTARIO_INICIAL', 'construirTabla', this.value);\"";
	$accionCMB = "onchange='xajax_cambiarNumFactura(this.value, 0)'";
	$ac2 = ($utf8 == "x")? " readonly ":"";
	$cmbidtblTienda = frm_comboGenerico("idtblTienda", "nombreTienda", "idtblTienda", "tblTiendas", "cls_inventario", "", " id='idtblTienda' class='form-control' $ac $ac2", $idtblTienda, $utf8);
	$nc = "style='font-weight:bold;text-align:center;' class='alerta'";
	$header ="<tr>
		<th $nc>PRODUCTOS</th>
		<th $nc>Cantidad</th>
		</tr>
		<!--<tr><th $nc >Sistema</th><th $nc >Tienda</th></tr>-->";
	$foot = "";
	/*	$sql = "SELECT idtblTienda, producto, tbldetalles.idproducto, SUM(cantidad) AS cantidad FROM tbldetalles 
	INNER JOIN tblfacturas ON tblfacturas.idFactura = tbldetalles.idFactura
	INNER JOIN tblproductos ON tbldetalles.idproducto = tblproductos.idproducto
	WHERE tblfacturas.idFactura = $idFactura
	GROUP BY idtblTienda, producto, tbldetalles.idproducto
	ORDER BY producto";*/
	$sql = "SELECT distinct A.idtblTienda, A.producto, A.idproducto, B.cantidad FROM 
(SELECT idtblTienda, producto, tbldetalles.idproducto, SUM(cantidad) AS cantidad FROM tbldetalles 
			INNER JOIN tblfacturas ON tblfacturas.idFactura = tbldetalles.idFactura
			INNER JOIN tblproductos ON tbldetalles.idproducto = tblproductos.idproducto
			WHERE idtblTienda = $idtblTienda
			GROUP BY idtblTienda, producto, tbldetalles.idproducto
			ORDER BY producto) as A
LEFT JOIN 
(SELECT idtblTienda, producto, tbldetalles.idproducto, cantidad 
FROM tbldetalles 
INNER JOIN tblfacturas ON tblfacturas.idFactura = tbldetalles.idFactura
right JOIN tblproductos ON tbldetalles.idproducto = tblproductos.idproducto
WHERE tblfacturas.idFactura = $idFactura) AS B
ON A.idproducto = B.idproducto";
	$cuerpo = "";
	$recs = $this->consultagenerica($sql);
	if(count($recs) == 0){
		$cuerpo = "<tr><td align='center' colspan='4'>NO SE TIENEN DATOS PARA ESTA TIENDA</td></tr>";
	}else{
		foreach($recs as $rec){
			extract($rec);
			$txtCantidad = frm_numero("cantidad[]", $cantidad, "", 4, 0);
			$txtProducto = frm_hidden("idproducto[]", $idproducto);
			$cantidad = ($utf8 == "")? "": -1*$cantidad;
			$cantidad = ($cantidad == 0)? $cantidad = "": $cantidad;
			$txtCantidad = frm_numero("cantidad[]", $cantidad, "", 4, 0);
			$producto = ($utf8 == "")? $producto: utf8_encode($producto);
			$cuerpo .="<tr>
				<td>".$txtProducto.$producto."</td>
				<td align='right'>$txtCantidad</td>
			</tr>";
		}
	}
	$txtFecha = frm_calendario2("fecha","fecha", "$fecha", "id='fecha' class='form-control input-md'" );
	//$txtControl = frm_text('numFactura', "", 6, 6, "class='form-control'");
	$txtControl = frm_numero("numFactura", $numFactura, 6, 6 , "class='form-control' readonly" ,4, 0);
	$aConceptos = array( "Llevado a otra tienda","Da&ntilde;o", "Hurto", "P&eacute;rdida","Robo");
	$iConceptos = array(0,1,2,3,4);
	$cmbConceptos = frm_select("comentario", $aConceptos, $iConceptos, $comentario);
	$htm2 = "<div class='container'><div class='row fondo_datos radio'><div class='col-md-12 '>";
	$htm2 .= "<h3 class='text-center' style='margin-top:-3px;'>RAZON DEL AJUSTE: $cmbConceptos</h3>";
	$htm2 .= "<div class='row'><div class='col-md-2'>Tienda</div><div class='col-md-2'>$cmbidtblTienda</div><div class='col-md-2'>Fecha</div><div class='col-md-2'>$txtFecha</div><div class='col-md-2'>Control</div><div class='col-md-2'>$txtControl</div></div>";
	$tabla = "<div class='row'><div class='col-md-6 col-md-offset-3'><table id='dataGrid2' class='adminlist table table-striped table-bordered dt-responsive' cellspacing='0' width='100%'><thead>$header</thead><tbody>$cuerpo</tbody><tfoot>$foot</tfoot></table></div></div>";
	$htm2 .= $tabla;
	
	$alineacionDerecha = " style='text-align:right' ";
	$numeroReal = " onkeypress='return NumCheck(event, this);'";

	$htm = "<form id='frm' class='form-horizontal' role='form'>".frm_hidden('idFactura', $idFactura);
	$htm .= $htm2;
	$htm .= "</form>";
	return $htm;		
	
	}
//-----------------------------------------------------------------------------------------------------------
	function construirTabla($idtblTienda){
		$sql = "SELECT idtblTienda, producto, tbldetalles.idproducto, SUM(cantidad) AS cantidad FROM tbldetalles 
			INNER JOIN tblfacturas ON tblfacturas.idFactura = tbldetalles.idFactura
			INNER JOIN tblproductos ON tbldetalles.idproducto = tblproductos.idproducto
			WHERE idtblTienda = $idtblTienda
			GROUP BY idtblTienda, producto, tbldetalles.idproducto
			ORDER BY producto";	
		$recs = $this->consultagenerica($sql);
		$nc = "style='font-weight:bold;text-align:center;' class='alerta'";
		$header ="<tr>
			<th $nc>PRODUCTOS</th>
			<th $nc>Cantidad</th>
		</tr>";
		$cuerpo = "";
		$foot = "";
		if(count($recs) == 0){
			$cuerpo = "<tr><td align='center' colspan='5'>NO SE TIENEN DATOS PARA ESTA TIENDA </td></tr>";
		}else{
			foreach($recs as $rec){
				extract($rec);
				$txtProducto = frm_hidden("idproducto[]", $idproducto);
				$txtCantidad = frm_numero("cantidad[]", "", "", 4, 0);
				$cuerpo .="<tr>
					<td>".$txtProducto.$producto."</td>
					<td align='right'>$txtCantidad</td>
				</tr>";
			}
		}
		$tabla = "<table id='dataGrid' class='adminlist table table-striped table-bordered dt-responsive' cellspacing='0' width='100%'><thead>$header</thead><tbody>$cuerpo</tbody><tfoot>$foot</tfoot></table>";
		return $tabla;
	}

//---------------------------------------------------------------------------------------------------------	

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
		$headers[] = "Control";
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
/*
$x = new CLS_INVENTARIO_INICIAL();
//echo $x->frmEntregas();
echo $x->construirTabla(2);
*/
?>