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
	$html ="
		<table border='0' class='tbllogo'>
			<tr>
				<td class='nlogito' width='15%'><img src='../images/logofaride.png' alt='logo' /></td>
				<td class='nEmpresa' width='70%'><div class='rtemp1'>Creaciones </div><div class='rtemp2'>Faride</div><div class='rtemp3'>Colections</div></td>
				<td  class='xfech' width='15%'><div class='nFecha'>Fecha: $dFecha</div></td>
			</tr>
		</table>
	<table border='0'>
	<tr>
		<td>Tienda:  $tiendas</td>
		<td>Fecha:  $fecha</td>
		<td>$sTipo:  $numFactura</td>
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
		$pos=(int)$pos+1;
		$htm="<tr>
			<td class='tdcenter'>[$pos]</td>
			<td class='tdcenter'>$producto</td>
			<td class='tddere'>$precioUnitario</td>
			<td class='tdcenter'>$cantidad</td>
			<td  class='tddere'>$nMonto</td>
		</tr>";
		return $htm;
	}
//-----------------------------------------------------------------------------------------------------------

	

	function repVentas($opcion = 0,$pFecha, $fFecha , $numTienda=0 ,$nrFact=0){
		$pFecha=d_ES_MYSQL($pFecha);
		$fFecha=d_ES_MYSQL($fFecha);
		$bd = new CLS_INVENTARIO;
		//$sql ="SELECT idtblTienda, nombreTienda FROM tbltiendas ORDER BY nombreTienda";
		if($numTienda==0){
			
			$fSql = " WHERE idOpciones=$opcion and fecha >= '$pFecha'  and fecha <= '$fFecha'  ORDER BY nombreTienda, numFactura";
		}elseif($nrFact==0){
			$fSql = " WHERE idOpciones=$opcion and fecha >= '$pFecha'  and fecha <= '$fFecha' and tbltiendas.idtblTienda = $numTienda   ORDER BY nombreTienda, numFactura";
		}else{
			$fSql = " WHERE idOpciones=$opcion and numFactura = $nrFact and tbltiendas.idtblTienda = $numTienda ";
		}
		$sql = "SELECT tbltiendas.idtblTienda, nombreTienda,  tblfacturas.idFactura,  DATE_FORMAT(fecha,  '%d/%c/%Y') as fecha , numFactura, idOpciones, 
comentario,idDetalles, producto, cantidad, precioUnitario  FROM tbltiendas  
			INNER JOIN tblfacturas ON tbltiendas.idtblTienda= tblfacturas.idtblTienda  INNER JOIN tbldetalles 
			ON tblfacturas.idFactura = tbldetalles.idFactura INNER JOIN tblproductos ON 
			tblproductos.idproducto=tbldetalles.idproducto $fSql" ;
		
		$mTiendas = $bd->consultagenerica($sql);
		$numFactura = array();
		$cantidad = array();
		$precioUnitario = array();
		$fecha = array();
		$producto = array();
		$tiendas = array();
		$tiendasPK = array();
		$nMonto = array();
		if($opcion==1){
			$sTipo="No. Factura";
		}else{
			$sTipo="No. Envio";
		}
		foreach($mTiendas as $tienda){
			$tiendas[] = $tienda["nombreTienda"];
			$numFactura[] = $tienda["numFactura"];
			if ($tienda["cantidad"]<0) {
				$cantidad[] = $tienda["cantidad"] * -1 ;
				$nMonto[]=$tienda["cantidad"]*$tienda["precioUnitario"]* -1;
			} 
			else{
				$cantidad[] = $tienda["cantidad"];
				$nMonto[]=$tienda["cantidad"]*$tienda["precioUnitario"];
			}
			$precioUnitario[] = $tienda["precioUnitario"];
			$fecha[] = $tienda["fecha"];
			$producto[]=$tienda["producto"];
		}
		$htm = $this->bCabecera();
		$nti = count($tiendas);
		$c = 0;
		$ntCant=0;
		$ntTotal=0;
		$nFact=-1;
		$nTienda=" ";
		$nFecha="01/01/2000";
	for($x=0; $x<$nti; $x++){

		if($nFact<>$numFactura[$x] or $nTienda<>$tiendas[$x]){
			if(($nFact<>(int)$numFactura[$x])or $fecha[$x]<>$nFecha ){
				if($nFact<>-1){
					$htm.="<tr><td colspan='3'>Totales </td><td>$ntCant</td><td class='tddere'>".numeroEspanol($ntTotal)."</td> </tr></table>";
					$ntCant=0;
					$ntTotal=0;
					$c=0;
					$htm.="<div style='page-break-after:always;'></div>";
				}
			}
			$nFact= (int)$numFactura[$x];
			$nTienda=$tiendas[$x];
			$nFecha=$fecha[$x];
			$htm.=$this->Encabezado($tiendas[$x],$fecha[$x],$numFactura[$x] ,$sTipo);
			$htm.=$this->encabezaRecibo( );
			$htm.=$this->cuerpoRecibo($producto[$x],$cantidad[$x] ,numeroEspanol($precioUnitario[$x]),numeroEspanol($nMonto[$x]),$c);
		}else{
			$htm.=$this->cuerpoRecibo($producto[$x],$cantidad[$x] ,numeroEspanol($precioUnitario[$x]),numeroEspanol($nMonto[$x]),$c);
		}
		$ntCant=$ntCant+$cantidad[$x];
		$ntTotal=$ntTotal+$nMonto[$x];
		$c++;
	}	
	$htm.="<tr><td colspan='3'>Totales </td><td>$ntCant</td><td class='tddere'>".numeroEspanol($ntTotal)."</td> </tr></table>";
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
	/*$xPf="01/11/2017";
	$xFf="25/11/2017";*/
	$x = new CLS_REPVENTAS;
	$HTML = $x->repVentas(1,$xPf,$xFf,$tiendas,0);
	
	echo $HTML; 
	 /*  
	$dompdf = new DOMPDF();
   	//$dompdf->set_paper('letter','landscape');
   	//$dompdf->set_paper('legal','landscape');
   	$dompdf->load_html($HTML);
   	$dompdf->render();
   	$dompdf->stream("Recibo: ".Date('Y-m-d').".pdf");
	/* */
		
?>