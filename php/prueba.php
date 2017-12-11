<?php
	include_once("cls_inventario.php");
	$header ="<tr>
			<th rowspan='2'>PRODUCTOS</th>
			<th colspan='2'>Cantidad</th>
			<th rowspan='2'>Dif</th>
			<th rowspan='2'>Concepto</th>
		</tr>
		<tr><th >Sistema</th><th >Tienda</th></tr>";
	$foot = "<tr>
			<th rowspan='2'>PRODUCTOS</th>
			<th >Sistema</th>
			<th >Tienda</th>
			<th rowspan='2'>Dif</th>
			<th rowspan='2'>Concepto</th>
		</tr>
		<tr><th colspan='2'>Cantidad</th></tr>";
	$cuerpo ="<tr>
		<td>uno</td>
		<td>dos</td>
		<td>tres</td>
		<td>cuatro</td>
		<td>cinco</td>
	</tr>";
	$tabla = "<table border='1'><thead>$header</thead><tbody>$cuerpo</tbody><tfoot>$foot</tfoot></table>";
	
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
<title></title>
<meta charset="UTF-8">
<meta name="author" content="PROF. JOSE R. DELGADO E.">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximun-scale=1, minimun-scale=1">
</head>
<body>
	<?php 
		echo $tabla;
	?>
</body>
</html>