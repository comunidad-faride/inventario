<?php


	require_once("../dompdf/dompdf_config.inc.php");
	include_once("./cls_inventario.php");
	include_once("./form_items.php");
	include_once("./funciones_fecha.php");


class CLS_REPVENTAS extends CLS_INVENTARIO{
	function bCabecera(){
		$html ="<!DOCTYPE HTML >
			<html>
			<head>
			<meta charset='UTF-8'>
			<title>Reporte</title>
			
			<link rel='stylesheet' href='../css/respestilos.css' />
			</head>
			<body><div class='contenido'>";
		return $html;
	}
	function bPie(){
		$html="</div></body>
			</html>";
		return $html;
	}
	function Encabezado( $tiendas, $fecha, $numFactura, $sTipo){
	$dFecha=date("d/m/y");
	$html ="";
	if($sTipo==0){
		
	$html .="
		<table border='0' class='tbllogo'>
			<tr>
				<td class='nlogito' width='15%'><img src='../images/logofaride.png' alt='logo' /></td>
				<td class='nEmpresa' width='70%'><div class='rtemp1'>Creaciones </div><div class='rtemp2'>Faride</div><div class='rtemp3'>Colections</div></td>
				<td  class='xfech' width='15%'><div class='nFecha'>Fecha: $dFecha</div></td>
			</tr>
		</table>";
		
	}
	$html .="
	<table border='0'>
	<tr>
		<td>Tienda:  $tiendas</td>
		<td>Fecha:  $dFecha</td>
		<td>  $numFactura</td>
	</tr>
		
</table>";
	return $html;
	
	}
	
	function encabezaRecibo(){
		
		$htm="
		<table border='1' >
			<tr>
				<th></th>
				<th>Producto</th>
				<th>precio Unitario</th>
				<th>Cantidad</th>
				<th>Precio</th>
			</tr>";
		return $htm;
	}
	function cuerpoRecibo($producto,$cantidad,$precioUnitario,$nMonto, $pos){
		$pos=(int)$pos;
		if(($pos % 2)==0){
			$XF="style='background-color: #f4f4f4'";
		}else{
			$XF="style='background-color: #ffffff'";
			
		}
		if($cantidad<0){
			$xg="style='color: red'";
		}else{
			$xg="style='color: blue'";
			
		}
		$htm="<tr $XF >
			<td class='tdcenter'>$pos </td>
			<td class='tdcenter'>$producto</td>
			<td >$precioUnitario</td>
			<td class='tdcenter' $xg>$cantidad</td>
			<td  class='tddere' $xg>$nMonto</td>
		</tr>";
		return $htm;
	}
//-----------------------------------------------------------------------------------------------------------

	function llena_arreglo($aCantidad, $aInventario, $aTipo, $aValor, $aMonto, $aOpcion,$invpieza, $pieza){
		switch ( $aOpcion){
		
			case 0:
				$aCantidad[$aTipo]=$aValor;
				$aInventario[$aTipo]=$aMonto*$aValor;
				$invpieza[$aTipo]=$pieza;
				break;
			case 1:
				if ($aValor<0){
					$aMonto=$aMonto*$aValor*-1;
				}else{
					$aMonto=$aMonto*$aValor;
				}
				$aCantidad[$aTipo]=$aCantidad[$aTipo]+$aValor;
				$aInventario[$aTipo]=$aInventario[$aTipo]+$aMonto;
				$invpieza[$aTipo]=$pieza;
		}
	}

//-----------------------------------------------------------------------------------------------------------
	/**
	* 
	* @param numerico $opcion (0 = resumen; 1=detalle)
	* @param undefined $pFecha
	* @param undefined $numTienda
	* 
	* @return
	*/
	function repVentas($opcion = 0,$pFecha,  $numTienda=0 ){
		$xFecha=dMenos_un_dia(d_ES_MYSQL($pFecha));
		
		$fFecha=d_ES_MYSQL($pFecha);
		$bd = new CLS_INVENTARIO;
		$pSql ="SELECT  max(idproducto) as pcant  FROM tblproductos ";
		$mProducto = $bd->consultagenerica($pSql, 1);
		foreach($mProducto as $xProd){
			$pcant= $xProd["pcant"]+1;
		}
		$iniinvpieza=new SplFixedArray($pcant);
		$iniinvcantidad=new SplFixedArray($pcant);
		$iniinvProducto=new SplFixedArray($pcant);
		$inginvpieza=new SplFixedArray($pcant);
		$inginvcantidad=new SplFixedArray($pcant);
		$inginvProducto=new SplFixedArray($pcant);
		$egrMinvpieza=new SplFixedArray($pcant);
		$egrMinvCantidad=new SplFixedArray($pcant);
		$egrMinvProducto=new SplFixedArray($pcant);
		
		if($numTienda==0){
			
			$fSql = " '$fFecha' ";
		}else{
			$fSql = "  '$fFecha' and tblfacturas.idtblTienda =$numTienda ";
		}
		
		$sql = "SELECT * FROM  (SELECT tblfacturas.idtblTienda, nombreTienda, DATE_FORMAT(date('$xFecha')  ,  '%d/%c/%Y') as fecha, date('$xFecha') as f,
		 tbldetalles.idproducto,  producto , sum(cantidad) as cantidad, max(precioUnitario) as precioUnitario from tbldetalles
		inner join tblfacturas on tblfacturas.idFactura = tbldetalles.idFactura inner join tbltiendas on tbltiendas.idtblTienda = tblfacturas.idtblTienda
		inner join tblproductos on tbldetalles.idproducto = tblproductos.idproducto
		where fecha < $fSql 		GROUP BY idtblTienda, idproducto
		UNION 
		SELECT tblfacturas.idtblTienda, nombreTienda, DATE_FORMAT(fecha ,  '%d/%c/%Y') as fecha, fecha as f, tbldetalles.idproducto, producto, cantidad, precioUnitario from tbldetalles
		inner join tblfacturas on tblfacturas.idFactura = tbldetalles.idFactura inner join tbltiendas on tbltiendas.idtblTienda = tblfacturas.idtblTienda
		inner join tblproductos on tbldetalles.idproducto = tblproductos.idproducto
		where fecha >= $fSql ) A  
		ORDER BY idtblTienda, f, idproducto ";//" $fSql" ;
		
		$mTiendas = $bd->consultagenerica($sql, 1);
		//$idtblTienda = array();
		$cantidad = array();
		$precioUnitario = array();
		$xfecha = array();
		$fecha = array();
		$idproducto = array();
		$producto = array();
		$tiendas = array();
		$tiendasPK = array();
		$nMonto = array();
		
		//$idOpciones = array();
		if($opcion==1){
			$sTipo="No. Factura";
		}else{
			$sTipo="No. Envio";
		}
		foreach($mTiendas as $tienda){
			$tiendasPK[] = $tienda["idtblTienda"];
			$tiendas[] = $tienda["nombreTienda"];
			$cantidad[] = $tienda["cantidad"]  ;
			$xfecha[]=$tienda["f"];
			$precioUnitario[] = $tienda["precioUnitario"];
			$fecha[] = $tienda["fecha"];
			$producto[]=$tienda["producto"];
			$idproducto[]=$tienda["idproducto"];
			//$idOpciones[]=$tienda["idOpciones"];
		}
		$cFecha="2000/01/01";
		$htm = $this->bCabecera();
		$nti = count($tiendas);
		$c = 0;
		$xT=0;
		$ntCant=0;
		$ntTotal=0;
		$nFact=-1;
		$nTienda=" ";
		$nFecha="2000/01/01";
	for($x=0; $x<$nti; $x++){
		if ($nFecha<$xfecha[$x]){
			$nFecha=$xfecha[$x];
			$c++;
		}
		if ($c==1){
			$this->llena_arreglo($iniinvcantidad,$iniinvProducto,$idproducto[$x], $cantidad[$x],$precioUnitario[$x],0, $iniinvpieza, $producto[$x]);
			
		}else{
			if($cantidad[$x]<0){
				$this->llena_arreglo($egrMinvCantidad,$egrMinvProducto,$idproducto[$x], $cantidad[$x],$precioUnitario[$x],1, $egrMinvpieza, $producto[$x]);
			}else{
				$this->llena_arreglo($inginvcantidad,$inginvProducto,$idproducto[$x], $cantidad[$x],$precioUnitario[$x],1, $inginvpieza, $producto[$x]);
			}
			
		}
	}
	$c=0;
	for($x=1; $x<$pcant; $x++){
		//$cVar=$iniinvcantidad[$x]; 
		if(isset ($iniinvcantidad[$x] )){
			$c++;
			
				
			if($x==1){
				
				$htm.=$this->Encabezado($tiendas[$x],$fecha[$x],"inventario Inicial" ,0);
				$htm.=$this->encabezaRecibo( );
				$htm.=$this->cuerpoRecibo($iniinvpieza[$x],$iniinvcantidad[$x] ,"Saldo Inicial",numeroEspanol($iniinvProducto[$x]),$c);
			}else{
				
					
				$htm.=$this->cuerpoRecibo($iniinvpieza[$x],$iniinvcantidad[$x] ,"Saldo Inicial",numeroEspanol($iniinvProducto[$x]),$c);
				
				
			
		}	
		}
		
	}	
	$htm.="</table>";
	$c=0;
	for($x=1; $x<$pcant; $x++){
		//if(isset ($inginvcantidad[$x] ) OR isset($egrMinvCantidad)){
			$sw=0;
		if($x==1){
			
			$htm.=$this->Encabezado($tiendas[$x],$fecha[$x],"Movimiento de inventario" ,1);
			$htm.=$this->encabezaRecibo( );
			if(isset ($inginvcantidad[$x] )){
				$c++;
				$sw=1;
				$htm.=$this->cuerpoRecibo($inginvpieza[$x],$inginvcantidad[$x] ,"ingreso",numeroEspanol($inginvProducto[$x]),$c);
			}
			if(isset ($egrMinvCantidad[$x] )){
				if ($sw==0){
					$c++;
				}
				$htm.=$this->cuerpoRecibo($egrMinvpieza[$x],$egrMinvCantidad[$x] ,"venta",numeroEspanol($egrMinvProducto[$x]),$c);
			}
		}else{
			if(isset ($inginvcantidad[$x] )){
				$c++;
				$sw=1;				
				$htm.=$this->cuerpoRecibo($inginvpieza[$x],$inginvcantidad[$x] ,"ingreso",numeroEspanol($inginvProducto[$x]),$c);
			}
			if(isset ($egrMinvCantidad[$x] )){
				if ($sw==0){
					$c++;
				}
				$htm.=$this->cuerpoRecibo($egrMinvpieza[$x],$egrMinvCantidad[$x] ,"venta",numeroEspanol($egrMinvProducto[$x]),$c);
			}
			
		}
		
		
	}	
	$htm.="</table>";
	$c=0;
	for($x=1; $x<$pcant; $x++){
		if(isset ($iniinvcantidad[$x] ) OR isset ($inginvcantidad[$x] ) OR isset($egrMinvCantidad)){
			if(isset($iniinvpieza[$x])){
				$xiniinvpieza= $iniinvpieza[$x];
			}elseif(isset($inginvpieza[$x])){
				$xiniinvpieza= $inginvpieza[$x];
				
			}elseif(isset($egrMinvpieza[$x])){	
				$xiniinvpieza=$egrMinvpieza[$x];
			}else{
				$xiniinvpieza="-1";
			}
			$xiniinvcantidad=$iniinvcantidad[$x] +$inginvcantidad[$x] +$egrMinvCantidad[$x] ;
			$xiniinvProducto=$iniinvProducto[$x]+$inginvProducto[$x]-$egrMinvProducto[$x];
		if($xiniinvpieza!="-1"){
			$c++;
		if($x==1){
			
			$htm.=$this->Encabezado($tiendas[$x],$fecha[$x],"Inventario Final" ,1);
			$htm.=$this->encabezaRecibo( );
			$htm.=$this->cuerpoRecibo($xiniinvpieza,$xiniinvcantidad ,"Saldo Final",numeroEspanol($xiniinvProducto),$c);
			//$htm.=$this->cuerpoRecibo($egrMinvpieza[$x],$egrMinvCantidad[$x] ,0,numeroEspanol($egrMinvProducto[$x]),$c);
		}else{
			$htm.=$this->cuerpoRecibo($xiniinvpieza,$xiniinvcantidad ,"Saldo Final",numeroEspanol($xiniinvProducto),$c);
			//$htm.=$this->cuerpoRecibo($egrMinvpieza[$x],$egrMinvCantidad[$x] ,0,numeroEspanol($egrMinvProducto[$x]),$c);
			
		}
		}	
		}
		
	}	
	$htm.="</table>";
	//$htm.="<div style='page-break-after:always;'></div>";
	$htm.=$this->bPie();
	return $htm;
	}
}
	$xPf 		= $_COOKIE["fechaInicial"];// Recuperacion de datos por los cookies.
	$xFf 		= $_COOKIE["fechaFinal"];
	$tiendas 	= $_COOKIE["tiendas"];
	$tipoReport = $_COOKIE["tipoReporte"];
	$numFactura = $_COOKIE["numFactura"];
	$xDocu = $_COOKIE["tPdf"];
	$x = new CLS_REPVENTAS;
	$HTML = $x->repVentas(-1,$xPf,$tiendas);
	if ($xDocu==1){
		echo $HTML; 
	}else{
		$dompdf = new DOMPDF();
		$dompdf->load_html(utf8_decode($HTML));
		$dompdf->render();
		$canvas = $dompdf->get_canvas(); 
		$font = Font_Metrics::get_font("helvetica", "bold"); 
		$canvas->page_text(512, 10, "Página: {PAGE_NUM} de {PAGE_COUNT}",$font, 8, array(0,0,0)); 

		$filename = "Resumen_Inventario".date("Y-m-d").'.pdf';
		$dompdf->stream($filename);	
	}
		
?>