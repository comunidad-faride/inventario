<?php
/*
	File: xajax_lang_de.inc.php

	Contains the debug and error messages output by xajax translated to German.

	Title: xajax class

	Please see <copyright.inc.php> for a detailed description, copyright
	and license information.
	
	Translations provided by: (Thank you!)
	- mic <info@joomx.com>
	- q_no
*/

/*
	@package xajax
	@version $Id: xajax_lang_de.inc.php 362 2007-05-29 15:32:24Z calltoconstruct $
	@copyright Copyright (c) 2005-2006 by Jared White & J. Max Wilson
	@license http://www.xajaxproject.org/bsd_license.txt BSD License
*/

//SkipAIO

$objLanguageManager = xajaxLanguageManager::getInstance();
$objLanguageManager->register('es', array(
	'LOGHDR:01' => '** Registro de Errores xajax - ',
	'LOGHDR:02' => " **\n",
	'LOGHDR:03' => "\n\n\n",
			'LOGERR:01' => "** Registro de Error **\n\nxajax No pudo escribir en el archivo de registro de errores:\n",
			'LOGMSG:01' => "** Mensajes de error de PHP: **",
			'CMPRSJS:RDERR:01' => 'El archivo Javascript no comprimido xajax no se pudo encontrar <b>',
			'CMPRSJS:RDERR:02' => '</b> Carpeta.  Error ',
			'CMPRSJS:WTERR:01' => 'El archivo javascript comprimido xajax no se pudo escribir en el <b>',
			'CMPRSJS:WTERR:02' => '</b> Carpeta.  Error ',
			'CMPRSPHP:WTERR:01' => 'El archivo comprimido xajax <b>',
			'CMPRSPHP:WTERR:02' => '</b>No se pudo escribir. Error ',
			'CMPRSAIO:WTERR:01' => 'El archivo comprimido xajax <b>',
			'CMPRSAIO:WTERR:02' => '/xajaxAIO.inc.php</b> No se pudo escribir.  Error ',
			'DTCTURI:01' => 'Error xajax :Xajax no ha podido identificar automáticamente su URI solicitada.',
			'DTCTURI:02' => 'Please set the Request URI explicitly when you instantiate the xajax object.',
			'ARGMGR:ERR:01' => 'Argumento de objeto malformado recibido: ',
			'ARGMGR:ERR:02' => ' <==> ',
			'ARGMGR:ERR:03' => 'Los datos xajax entrantes no se pudieron convertir de UTF-8',
			'XJXCTL:IAERR:01' => 'Atributo [ Invalid ',
			'XJXCTL:IAERR:02' => '] por elemento [',
			'XJXCTL:IAERR:03' => '].',
			'XJXCTL:IRERR:01' => 'Se ha pasado un objeto de solicitud no válido a xajaxControl::setEvent',
			'XJXCTL:IEERR:01' => 'Attribute (event name) [ Invalido ',
			'XJXCTL:IEERR:02' => '] por elemento [',
			'XJXCTL:IEERR:03' => '].',
			'XJXCTL:MAERR:01' => 'Falta el atributo requerido [',
			'XJXCTL:MAERR:02' => '] por elemento [',
			'XJXCTL:MAERR:03' => '].',
			'XJXCTL:IETERR:01' => "Denominación de etiqueta final no válida; Debe ser prohibido u opcional.\n",
			'XJXCTL:ICERR:01' => "Clase no válida especificada para el control html; Debería ser  %inline, %block or %flow.\n",
			'XJXCTL:ICLERR:01' => 'Control Invalido pasado a addChild; Debería ser derivado de xajaxControl.',
			'XJXCTL:ICLERR:02' => 'Control Invalido  pasado a addChild [',
			'XJXCTL:ICLERR:03' => '] por elemento [',
			'XJXCTL:ICLERR:04' => "].\n",
			'XJXCTL:ICHERR:01' => 'Parametro Invalido pasado a xajaxControl::addChildren; Debería ser array de objectos xajaxControl ',
			'XJXCTL:MRAERR:01' => 'Falta el atributo requerido [',
			'XJXCTL:MRAERR:02' => '] por elemento [',
			'XJXCTL:MRAERR:03' => '].',
			'XJXPLG:GNERR:01' => 'El complemento de respuesta debe anular a la funcion getName .',
			'XJXPLG:PERR:01' => 'El complemento de respuesta debe anular al proceso function.',
			'XJXPM:IPLGERR:01' => 'Intentar registrar un complemento no válido: ',
			'XJXPM:IPLGERR:02' => 'Debe derivarse de xajaxRequestPlugin o xajaxResponsePlugin.',
			'XJXPM:MRMERR:01' => 'Error al localizar el método de registro para los siguientes: ',
			'XJXRSP:EDERR:01' => 'Pasar la codificación de caracteres al constructor xajaxResponse está obsoleto, en su lugar debe usar $xajax->configure("characterEncoding", ...);',
			'XJXRSP:MPERR:01' => 'Nombre de plugin no válido o faltante detectado en la llamada a xajaxResponse::plugin',
			'XJXRSP:CPERR:01' => "El \$sType parametro de addCreate es obsoleto.  Use el método addCreateInput() .",
			'XJXRSP:LCERR:01' => "El objeto de respuesta xajax no pudo cargar comandos ya que los datos proporcionados no eran una matriz válida.",
			'XJXRSP:AKERR:01' => 'Nombre de etiqueta no válido codificado en el arreglo.',
			'XJXRSP:IEAERR:01' => 'Arreglo incorrectamente codificado.',
			'XJXRSP:NEAERR:01' => 'Matriz no codificada detectada.',
			'XJXRSP:MBEERR:01' => 'La salida de respuesta xajax no se pudo convertir en HTML porque la function mb_convert_encoding  no está disponible',
			'XJXRSP:MXRTERR' => 'Error: No puedes mezclar en una sola respuesta.',
			'XJXRSP:MXCTERR' => 'Error: No se pueden mezclar tipos de contenido en una sola respuesta.',
			'XJXRSP:MXCEERR' => 'Error: No se pueden mezclar codificaciones de caracteres en una sola respuesta.',
			'XJXRSP:MXOEERR' => 'Error: No se pueden mezclar entidades de salida (true/false) en una sola respuesta.',
			'XJXRM:IRERR' => 'Se devolvió una respuesta no válida al procesar esta solicitud.',
			'XJXRM:MXRTERR' => 'Error: No puede mezclar tipos de respuesta mientras procesa una sola solicitud: '
	));

//EndSkipAIO