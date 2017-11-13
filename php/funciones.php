<?php
	include_once("./form_items.php");
	include_once("./cls_inventario.php");
	$cmbFP = frm_comboGenerico("idFormaPago", "formaPago", "idFormaPago",
	"tblformaspago", "CLS_INVENTARIO", "", "class='form-control'", 1);
	$tag2 = " onkeypress='return NumCheck(event, this, 6, 2);' style='text-align: right' ";
	$txtAporte = frm_text("monto", "", "10", "10", "$tag2 class='form-control' id='idMonto'");
	$html = '<div class="row">
		<div class="col-md-4">'.$cmbFP.'</div>
		<div class="col-md-4">Aporte Inicial</div>
		<div class="col-md-4">'.$txtAporte.'</div>
		</div>';
	echo $html;	
?>