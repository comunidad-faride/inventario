<?php
	class CLS_TBLTIENDAS extends CLS_INVENTARIO{
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
			$this->sqlBase = "SELECT idtblTienda, nombreTienda, Responsable, direccion, telefono FROM tbltiendas";
			$this->titulo = "TIENDAS REGISTRADAS";
	}
//-----------------------------------------------------------------------------------------------------------
	function insertNewRecord($f){
		extract($f);
		//Convertir la fecha de formato ingles o español a formato MYSQL antes de pasarlo a la funcion.
		$r = $this->tbltiendasInsert( $nombreTienda, $Responsable, $direccion, $telefono);
		return $r;
	}
//-----------------------------------------------------------------------------------------------------------
	function updateRecord($f){
		extract($f);
		$res = $this->tbltiendasUpdate($idtblTienda, $nombreTienda, $Responsable, $direccion, $telefono);
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function deleteRecord($id){
		$res = $this->tbltiendasDelete("idtblTienda = $id");
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function formAdd(){
		$html = $this->frmtbltiendas();
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function formEdit($id){
		$html = $this->frmtbltiendas($id);
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function frmtbltiendas(){
		$alineacionDerecha = " style='text-align:right' ";
		$numeroReal = " onkeypress='return NumCheck(event, this);'";
		if(func_num_args() > 0){
			$idtblTienda = func_get_arg(0);
			$records = $this->tbltiendasRecords("idtblTienda = $idtblTienda");
			foreach($records as $record){
				extract($record);
			}
			$textoBoton = "Actualizar";
			$accion = "onClick=\"xajax_update('CLS_TBLTIENDAS',xajax.getFormValues('frm'))\"";
		}else{
			$pk = "";
			$textoBoton = "Grabar";
			$accion = "onClick=\"xajax_save('CLS_TBLTIENDAS',xajax.getFormValues('frm'))\"";
			$nombreTienda = '';
			$Responsable = '';
			$direccion = '';
			$telefono = '';
			$idtblTienda = 0;
		}
		$htm = "<form id='frm' class='form-horizontal' role='form'>
					".frm_hidden('idtblTienda', $idtblTienda)."	
					<div class='form-group'>
						<label for='nombreTienda' class='col-md-6 text-right'>Nombre de Tienda:</label>
						<div class='col-md-6'>".frm_text('nombreTienda', $nombreTienda, '50', '50 ', ' class="form-control"')."</div>
					</div>	
					<div class='form-group'>
						<label for='Responsable' class='col-md-6 text-right'>Responsable:</label>
						<div class='col-md-6'>".frm_text('Responsable', $Responsable, '50', '50 ', ' class="form-control"')."</div>
					</div>	
					<div class='form-group'>
						<label for='direccion' class='col-md-6 text-right'>Direcci&oacute;n:</label>
						<div class='col-md-6'>".frm_text('direccion', $direccion, '145', '145 ', ' class="form-control"')."</div>
					</div>	
					<div class='form-group'>
						<label for='telefono' class='col-md-6 text-right'>Tel&eacute;fono</label>
						<div class='col-md-6'>".frm_text('telefono', $telefono, '11', '11 ', ' class="form-control"')."</div>
					</div>	
			</form>";
	return $htm;	
	}
//-----------------------------------------------------------------------------------------------------------
	function checkAllData($f,$new = 0){		// Considerar colocar los campos obligatorios en el formulario.
		if(empty($f['nombreTienda'])) return "El campo 'nombreTienda' no puede ser nulo.";
		$salida = validarPatron($f['nombreTienda'],ALFANUMYES);
		if( $salida != "") return "El campo 'Nombre de tienda' $salida";
		if(empty($f['Responsable'])) return "El campo 'Responsable' no puede ser nulo.";
		$salida = validarPatron($f['Responsable'],ALFANUMYES);
		if( $salida != "") return "El campo 'Responsable ' $salida";
		if(empty($f['direccion'])) return utf8_decode("El campo 'Dirección' no puede ser nulo.");
		$salida = validarPatron($f['direccion'],ALFANUMYES);
		if( $salida != "") return utf8_decode("El campo 'Dirección ' $salida");
		if(empty($f['telefono'])) return utf8_decode("El campo 'Teléfono' no puede ser nulo.");
		$salida = validarPatron($f['telefono'],DIGITOS,11);
		if( $salida != "") return utf8_decode("En el campo 'Teléfono' $salida");
	 	return 0;
	}
//-----------------------------------------------------------------------------------------------------------
// Nombres de los campos de la consulta.
	function camposBD(){
		$fields = array();
		$fields[] = 'idtblTienda';	
		$fields[] = 'nombreTienda';	
		$fields[] = 'Responsable';		
		$fields[] = 'telefono';	
		return $fields;
	}
//-----------------------------------------------------------------------------------------------------------
	function encabezados(){
		$headers = array();
		$headers[] = "Nombre de Tienda";
		$headers[] = "Responsable";
		$headers[] = "tel&eacute;fono";
		return $headers;
	}
//-----------------------------------------------------------------------------------------------------------
	function atributosEncabezados(){
		// HTML table: hearders attributes
		$attribsHeader = array();
		$attribsHeader[] = '20';
		$attribsHeader[] = '20';
		$attribsHeader[] = '20';
		return $attribsHeader;
	}
//-----------------------------------------------------------------------------------------------------------
	function atributosColumnas(){
		// HTML Table: columns attributes
		$attribsCols = array();
		$attribsCols[] = 'nowrap style="text-align:left"';
		$attribsCols[] = 'nowrap style="text-align:left"';
		$attribsCols[] = 'nowrap style="text-align:left"';
		return $attribsCols;
	}

//-----------------------------------------------------------------------------------------------------------
	function resumenTienda($tienda){
		$bd = new CLS_INVENTARIO;
		$sql = "SELECT producto, -1*sum(cantidad) AS cantidad, max(precioUnitario) as precioUnitario, 
			-1*sum(cantidad) * max(precioUnitario) AS multiplicacion from tbldetalles 
		INNER JOIN tblfacturas ON tblfacturas.idFactura = tbldetalles.idFactura
		INNER JOIN tbltiendas ON tbltiendas.idtblTienda = tblfacturas.idtblTienda
		INNER JOIN tblproductos ON tblproductos.idproducto = tbldetalles.idproducto
		WHERE opcion = 'V'  AND tblfacturas.idtblTienda = $tienda
		GROUP BY  producto
		ORDER BY nombreTienda";
		$recs = $bd->consultagenerica($sql);
		$recsTiendas = $bd->tbltiendasRecords("idtblTienda = $tienda");
		$nombreTienda = strtoupper($recsTiendas[0]["nombreTienda"]);
		$header = array("No.","PRODUCTO", "CANTIDAD", "PRECIO UNITARIO", "TOTAL");
		$htm = "<table class='table table-bordered'><thead><tr>";
		$htm .= "<caption class='text-center'><h3><strong>Inventario en $nombreTienda</strong></h3></caption>";
		foreach($header as $encabezado){
			$htm .= "<th class='text-center'>".$encabezado."</th>";
		}
		$htm .= "</tr></thead>";
		$htm .= "<tbody>";
		$totalCantidad = 0;
		$totalAcumulado = 0;
		$contador = 0;
		foreach($recs as $registro){
			extract($registro);
			$contador++;
			$eCantidad = numeroEspanol($cantidad, 0);
			$ePrecioUnitario = numeroEspanol($precioUnitario,2);
			$eProducto = numeroEspanol($multiplicacion, 2);
			$totalCantidad += $cantidad;
			$totalAcumulado += $multiplicacion;
			$htm .= "<tr>  <td class='text-right'>$contador</td>
				<td>$producto</td>
				<td class='text-right'>$eCantidad</td>
				<td class='text-right'>$ePrecioUnitario</td>
				<td class='text-right'>$eProducto</td></tr>";	
		}
		$htm .= "</tbody>";
		$eTotalAcumulado = numeroEspanol($totalAcumulado, 2);
		$eTotalCantidad = numeroEspanol($totalCantidad, 0);
		$pie = "<tfoot><tr><th colspan='2' class='text-center'>TOTALES</th><th  class='text-right'>$eTotalCantidad</th><th colspan='2' class='text-right'>$eTotalAcumulado</th></tr></tfoot>";
		$htm .= $pie;
		$htm .= "</table>";
		return $htm;
	}
//-----------------------------------------------------------------------------------------------------------
	function analiticoXTienda(){
	// Estas líneas son para mostrar si el git detecta
	// Cuando se ha realizado un cambio de algún archivo del sistema.	
	}
//-----------------------------------------------------------------------------------------------------------

}
?>
