<?php
  require_once("xajax/xajax_core/xajax.inc.php");
  $xajax = new xajax("charasoftdd.server.php");
  $xajax->SetCharEncoding("ISO-8859-1");
  $xajax->setFlag('debug',true);
  $xajax->register(XAJAX_FUNCTION,"fduPedirPersona");
  $xajax->register(XAJAX_FUNCTION,"fduGrabarPersona");
  $xajax->register(XAJAX_FUNCTION,"fduMostrarPersona");
  $xajax->register(XAJAX_FUNCTION,"frmFactura");
  $xajax->register(XAJAX_FUNCTION,"fduTotal");
?>