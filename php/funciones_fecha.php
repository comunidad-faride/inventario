<?php

require_once("form_items.php");
date_default_timezone_set('America/Caracas');
/***************************************************
* Software: Funciones de fecha                                          *
* Version:  3.0                                                                 *
* Date:     2007-10-22                                                      *
* Author:   Prof. JosÃ© R. Delgado Errade                              *
* License:  Propietario                                                      *
*                                                                                   * 
* Puedes utilizar y modificar este software a tu conveniencia.*
***************************************************
          OBSERVACION    MUY    IMPORTANTE
  PARA TODOS LOS CASOS, LA FECHA DEBE TENER EL FORMATO MES/DIA/AAAA
/**

*Obtiene el aÃ±o de una fecha dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
* @return entero
*/
    function yAnno($strFecha)
    {
       $fecha=strtotime($strFecha);
       return date("Y",$fecha);
    }


/**
*Obtiene el mes de una fecha dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
* @return entero
*/
    function yMes($strFecha)
    {
       $fecha=strtotime($strFecha);
       return date("m",$fecha);
    }

 /**
*Obtiene el dia de una fecha dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
* @return entero
*/
    function iDia($strFecha)
    {
	 $fecha=strtotime($strFecha);
       return date("d",$fecha); 	
    }

/**
*Obtiene el nombre del mes de una fecha dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa o nÃºmero correspondiente al mes.
*@return string
*/	
    function strMes($strFecha){
      $Meses = array('enero','febrero','marzo','abril',
                      'mayo','junio','julio','agosto',
                      'septiembre','octubre','noviembre','diciembre');
 	if(is_string($strFecha)){
		return $Meses[iMes($strFecha)-1];		
	}else{
		return $Meses[$strFecha]-1;
	}
    } 


/**
*Obtiene nombre del mes corto (los tres primeros caracteres) de una fecha dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
* @return string
*/	
    function strMesCorto($strFecha)
    {
       $meses = array('ene','feb','mar','abr','may','jun',
                          'jul','ago','sep','oct','nov','dic');
       return $meses[iMes($strFecha)-1];
    }
	
/**
*Obtiene el nÃºmero de la semana de una fecha dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
* @return entero
*/	
    function iSemana($strFecha)
    {
       $fecha=strtotime($strFecha);
       return strftime("%W",$fecha); 	
    }

/**
*Genera la fecha correspondiente al primer dÃ­a del mes de una fecha dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
* @return date
*/	
    function dPrimerDiaMes($strFecha)
    {
      	$fecha=strtotime($strFecha);
      	$fPrimerDiaMes = strftime("%m/01/%Y",$fecha);
      	return $fPrimerDiaMes;
    }

/**
*Obtiene la fecha del Ãºltimo dÃ­a del mes de una fecha dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
* @return date
*/
    function dFinMes($strFecha)
    {
      	$fecha=strtotime($strFecha);
      	$finMes = date("m/t/Y",$fecha);
      	return $finMes;
    }

/**
*Obtiene el dÃ­a de la semana correspondiente a una fecha dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
* @return entero
*/
    function iDiaSemana($strFecha)
    {
      	$fecha=strtotime($strFecha);
      	return date("w",$fecha);
    }

/**
*Obtiene el nombre del dÃ­a de la semana de una fecha dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
* @return string
*/	
    function strDiaSemana($strFecha)
    {
      	$dias = array('domingo','lunes','martes','mi&eacute;rcoles','jueves','viernes','s&aacute;bado');
      	$dia=iDiaSemana($strFecha);
      	return $dias[$dia];
    }

/**
*Obtiene el nombre corto (3 caracteres) del dia de la semana de una fecha dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
* @return string*3
*/	
    function strDiaSemanaCorto($strFecha)
    {
      	$dias = array('dom','lun','mar','mie','jue','vie','sab');
      	$dia=iDiaSemana($strFecha);
      	return $dias[$dia];
    }

/**
*Obtiene la inicial del dÃ­a de la semana de una fecha dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
* @return string*1
*/
    function strDiaSemanaInicial($strFecha)
    {
      	$dias = array('d','l','m','m','j','v','s');
      	$dia=iDiaSemana($strFecha);
      	return $dias[$dia];
    }

/**
*Obtiene el nÃºmero de la primera semana de un mes de una fecha dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
* @return entero
*/
    function iPrimeraSemana($strFecha)
    {
        $PrimeraFecha = dPrimerDiaMes($strFecha);
        return iSemana($PrimeraFecha);
    }

/**
*Obtiene el nÃºmero de la Ãºltima semana de un mes  de una fecha dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
*@return entero
*/	
    function iUltimaSemana($strFecha)
    {
	    $UltimaFecha = dFinMes($strFecha);
        return iSemana($UltimaFecha);
    }

/**
*Obtiene el nÃºmero de semanas de un mes - la fecha escrita en formato inglÃ©s (mm/dd/aaaa)-.
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
*@return entero
*/  
	function iSemanasXmes($strFecha)
    {
		return iUltimaSemana($strFecha) - iPrimeraSemana($strFecha) + 1;
    }
    
/**
*Obtiene el Ãºltimo dÃ­a hÃ¡bil (lunes a viernes) de un mes de una fecha dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
* @return date
*/
	function dUltimoDiaHabilMes($strFecha)
    {
	$strFecha = dFinMes($strFecha);
       $DiaSemana = iDiaSemana($strFecha);
        if (($DiaSemana==0)or($DiaSemana==6)){
 	       $FechaFinal = (dViernesAnterior($strFecha));
        }else{
            $FechaFinal = ($strFecha);
            }
        return $FechaFinal;
    }

/**
*Obtiene el nÃºmero de semanas hÃ¡biles de un mes  - fecha dada escrita en formato inglÃ©s (mm/dd/aaaa)-.
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
* @return entero
*/	
    function iSemanasHabiles($strFecha){
        $PDHM = dPrimerDiaHabilMes(dPrimerDiaMes($strFecha));
        $UDHM = dUltimoDiaHabilMes(dFinMes($strFecha));
        $SPDHM = iSemana($PDHM);
        $SUDHM = iSemana($UDHM);
        return $SUDHM - $SPDHM + 1;
    }

/**
*Obtiene la fecha del prÃ³ximo lunes con relaciÃ³n a una fecha dada -escrita en formato inglÃ©s (mm/dd/aaaa)-.
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
* @return date
*/
    function dProximoLunes($strFecha)	
    {
	$mes=iMes($strFecha);
	$Anno=iAnno($strFecha);
	$diaMes=iDia($strFecha);
	$diaSemana=iDiaSemana($strFecha);
	if($diaSemana==0)
     	   	$DiaProximoLunes = $diaMes+1;
	else
     	$DiaProximoLunes = $diaMes+8-$diaSemana;   
		$dia=mktime(0,0,0,$mes,$DiaProximoLunes,$Anno);
	return date("m/d/Y",$dia);  
    }
	
//  Se suministra la fecha en formato ingles (M/D/Y)	
	function lunesXmes($fecha){
		//$fecha = date("m/d/Y");
		$dPrimerDia = dPrimerDiaMes($fecha);
		if(strDiaSemanaInicial($dPrimerDia)== "l"){
			$dPrimerLunes = $dPrimerDia;
		}else{
			$dPrimerLunes = dProximoLunes($dPrimerDia); 
		}
		//$iSemanas = iSemanasXmes($fecha);
		$nuevaFecha = strtotime ( '+28 day' , strtotime ( $dPrimerLunes ) ) ;
		$nuevaFecha = date ( 'm/d/Y' , $nuevaFecha );
		if(dPrimerDiaMes($nuevaFecha)== $dPrimerDia){
			return 5;
		}else{
			return 4;
		}
	}
//	echo lunesXmes("06/01/2015");  Se suministra la fecha en formato ingles
/**
*Obtiene la fecha del prÃ³ximo viernes correspondiente a una fecha dada -escrita en formato inglÃ©s (mm/dd/aaaa)-.
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
* @return date
*/	
    function dProximoViernes($strFecha)
    {
      	$mes=iMes($strFecha);
      	$Anno=iAnno($strFecha);
      	$diaMes=iDia($strFecha);
      	$diaSemana=iDiaSemana($strFecha);
      	if($diaSemana<=4)
		$DiaProximo = $diaMes+5-$diaSemana;
      	else
	$DiaProximo = $diaMes+12-$diaSemana;
      	$dia=mktime(0,0,0,$mes,$DiaProximo,$Anno);
      	return date("m/d/Y",$dia);
    }


function dMenos_un_dia($fecha){
	//$fecha = date('Y-m-j');
	$nuevafecha = strtotime ( '+2 day' , strtotime ( $fecha ) ) ;
	$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
 
	return $nuevafecha;
}


/**
*Obtiene la fecha del viernes anterior correspondiente a una fecha dada -escrita en formato inglÃ©s (mm/dd/aaaa)-.
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
* @return date
*/
    function dViernesAnterior($strFecha)
    {
      	$mes=iMes($strFecha);
      	$Anno=iAnno($strFecha);
      	$diaMes=iDia($strFecha);
      	$diaSemana=iDiaSemana($strFecha);
      	if($diaSemana<=5)
           	   $DiaAnterior = $diaMes-(2+$diaSemana);
      	else
           	   $DiaAnterior = $diaMes-1;
      	$dia=mktime(0,0,0,$mes,$DiaAnterior,$Anno);
      	return date("m/d/Y",$dia);
    }


/**
*Obtiene la fecha del primer dÃ­a hÃ¡bil (lunes a viernes) de un mes  de una fecha dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
* @return date
*/
    function dPrimerDiaHabilMes($strFecha)
    {
		$strFecha = dPrimerDiaMes($strFecha);
        	$DiaSemana = iDiaSemana($strFecha);
        if ($DiaSemana==0){
 	       $FechaInicial = dProximoLunes($strFecha);
        }elseif($DiaSemana<=5){
		    $FechaInicial = ($strFecha);
        }else{
            $FechaInicial = (dProximoLunes($strFecha));
            }
        return $FechaInicial;
    }

/**
*Genera string 'dia de mes de aÃ±o'  de una fecha dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
* @return string
*/	
    function strFechaLarga($strFecha)
    {
      	$dia = iDia($strFecha);
      	$mes = strMes($strFecha);
      	$anno = iAnno($strFecha);
      	$Fecha= $dia . " de " . $mes . " de " . $anno;
      	return $Fecha;
    }	

/**
*Obtiene fecha en formato dd/mm/aaaa  de una fecha dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
* @return date
*/
    function dFechaES($strFecha)
    {
       $fecha=iDia($strFecha) ."/". iMes($strFecha) . "/" .iAnno($strFecha);
       return $fecha;
    }
//	echo dFechaES("05/12/2013");	

/**
*Genera fecha en formato aaaa/mm/dd  de una fecha dada escrita en formato espaÃ±ol (dd/mm/aaaa).
*
*@param date $strFecha		Fecha suministrada en formato mm/dd/aaaa
* @return date
*/
function d_ES_MYSQL($fecha)
{
  /* El formato de $fecha es dd/mm/aaaa 
     Como salida se tendrÃ¡ un string de fecha con el formato aaaa/mm/dd
     para utilizar como valor de ingreso a MySQL.                       */
    $dia = substr($fecha,0,2);
    $mes = substr($fecha,3,2);
    $annio=substr($fecha,6,4);
    $salida = $annio."/".$mes."/".$dia;
    return $salida;
}
//echo d_ES_mysql('12/05/2013'); fecha: 12 de mayo de 2013


/**
*Genera fecha en formato mm/dd/aaaa  de una fecha dada escrita en formato espaÃ±ol (dd/mm/aaaa).
*
*@param date $strFecha		Fecha suministrada en formato dd/mm/aaaa
* @return date
*/
function d_ES_US($fecha)
{
  /* El formato de $fecha es dd/mm/aaaa 
     Como salida se tendrÃ¡ un string de fecha con el formato aaaa/mm/dd
     para utilizar como valor de ingreso a MySQL.                       */
    $dia = substr($fecha,0,2);
    $mes = substr($fecha,3,2);
    $annio=substr($fecha,6,4);
    $salida = "$mes/$dia/$annio";
    return $salida;
}


function d_US_ES($fecha)
{
  /* El formato de $fecha es dd/mm/aaaa 
     Como salida se tendrÃ¡ un string de fecha con el formato aaaa/mm/dd
     para utilizar como valor de ingreso a MySQL.                       */
    $mes = substr($fecha,0,2);
  	$dia =  substr($fecha,3,2);
    $annio=substr($fecha,6,4);
    $salida = "$dia/$mes/$annio";
    return $salida;
}


/**
*Genera fecha en formato espaÃ±ol (dd/mm/aaaa)  de una fecha dada escrita en formato MySQL (aaaa/mm/dd).
*
*@param date 		$strFecha		Fecha suministrada en formato  MySQL (aaaa/mm/dd).
* @return date
*/
function dMySQL_ES($fecha){
	//Transforma la fecha de formato MySQL (yyyy/mm/dd) a formato espaÃ±ol (dd/mm/yyyy)
	    $dia = substr($fecha,8,2);
	    $mes = substr($fecha,5,2);
	    $annio=substr($fecha,0,4);
	    $salida = sprintf("%02s/%02s/%04s",$dia, $mes, $annio);
	    return $salida;	
}
 
/**
*Genera fecha en formato Ã­nglÃ©s (dd/mm/aaaa)  de una fecha dada escrita en formato MySQL (aaaa/mm/dd).
*
*@param date 		$fecha		Fecha suministrada en formato  MySQL (aaaa/mm/dd).
* @return date
*/
function dMySQL_US($fecha){
	    $dia = substr($fecha,8,2);
	    $mes = substr($fecha,5,2);
	    $annio=substr($fecha,0,4);
	    $salida = sprintf("%02s/%02s/%04s", $mes,$dia, $annio);
	    return $salida;	
}

//echo dMySQL_sp("1958/05/12");



/**
*Genera fecha en formato  MySQL (aaaa/mm/dd)  de una fecha dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date 		$strFecha		Fecha suministrada en formato  MySQL (aaaa/mm/dd).
* @return date
*/
    function d_US_MySQL($strFecha)
    {        
 	$fecha= iAnno($strFecha)."/". iMes($strFecha) . "/" .iDia($strFecha);
       	return $fecha;
    }
  // echo d_US_MySQL('20/10/2014');
/**
*Indica si es sabado una fecha  dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date 		$strFecha		Fecha suministrada en formato  MySQL (aaaa/mm/dd).
* @return boolean
*/
    function bEsSabado($strFecha)
    {
      	$dia=iDiaSemana($strFecha);
      	if($dia==6)
      		return true;
      	else
      		return false;
    }

/**
*Indica si es domingo una fecha  dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date 		$strFecha		Fecha suministrada en formato  MySQL (aaaa/mm/dd).
* @return boolean
*/
    function bEsDomingo($strFecha)
    {
      	$dia=iDiaSemana($strFecha);
      	if($dia==0)
      		return true;
      	else
      		return false;
    }

	
/**
*Indica si es lunes una fecha  dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date 		$strFecha		Fecha suministrada en formato  MySQL (aaaa/mm/dd).
* @return boolean
*/	
    function bEsLunes($strFecha)
    {
      	$dia=iDiaSemana($strFecha);
      	if($dia==1)
      		return true;
      	else
		return false;
    }


/**
*Indica si es viernes una fecha  dada escrita en formato inglÃ©s (mm/dd/aaaa).
*
*@param date 		$strFecha		Fecha suministrada en formato  MySQL (aaaa/mm/dd).
* @return boolean
*/
    function bEsViernes($strFecha)
    {
      	$dia=iDiaSemana($strFecha);
      	if($dia==5)
      		return true;
      	else
      		return false;
    }

/**
*Crea un arreglo con fechas de los dÃ­as hÃ¡biles (lunes a viernes) de un mes -formato de fecha inglÃ©s (mm/dd/aaaa).
*
*@param 	date $strFecha		Fecha suministrada en formato inglÃ©s.
* @return 	Fecha arreglo de fechas en formato ingles
*/
function adFechasHabiles($strFecha)
    {
       $PrimerDia = dPrimerDiaHabilMes(dPrimerDiaMes($strFecha));
       $UltimoDia = dUltimoDiaHabilMes(dFinMes($strFecha));
	$diaInicial = iDia($PrimerDia);
	$diaFinal = iDia($UltimoDia);
	$mes = iMes($strFecha);
	$anno = iAnno($strFecha);
	//$Fecha[0] = $PrimerDia;
       for($i=1; $i < $diaFinal; $i++){
       	$fechaX = date("$mes/$i/$anno");
		if(!bEsSabado($fechaX) AND !bEsDomingo($fechaX)){
			$Fecha[] = $fechaX;
		} 
       }
	$Fecha[]=$UltimoDia;
       return $Fecha;//$Aarreglo;
    }

/*	$a = adFechasHabiles("06/1/2013");		//Falta depurarse esta  funcion.
	foreach($a as $x){
		echo (" $x <br/>");
	}
*/

/**
*Crea un calendario con tres combos correspondientes a dias, meses y aÃ±os.
*
*@param string 		$dia				nombre que se asigna al combo de los dÃ­as.
*@param string 		$mes			nombre que se asigna al combo de los meses
*@param string 		$anio			nombre que se asigna al campo de los aÃ±os.
*@param string 		$dReferencia		fecha (inglesa) de referencia que serÃ¡ mostrada por defecto.
*@param string 		$extraTag			caracterÃ­sticas adicionales de calendario.
* @return calendario
*
*/
    function frm_calendarioBasico($dia, $mes, $anio, $dReferencia='', $extraTag='')
    {
      $dias=array();
      $anios = array();
       for ($i=0; $i<=30; $i++)
       {
            $dias[$i]=$i+1;
       }
       $imeses= array(1,2,3,4,5,6,7,8,9,10,11,12);
       $meses = array('ene','feb','mar','abr','may','jun',
                          'jul','ago','sep','oct','nov','dic');
       $annioInicial = date("Y");
       $annioFinal = $annioInicial-60;
       if ($dReferencia=='') {
         $hoy = date("m/d/Y");
         $mesActual = date("m");
       } else {
          $fecha=date("$dReferencia");
          $hoy = $fecha;
          $mesActual = iMes($hoy);
       }
       for ($i=0; $i<=60; $i++)  {
         $anios[$i] = $annioInicial;
         $annioInicial = $annioInicial-1;
       }
       $lDia=frm_select($dia,$dias,$dias,iDia($hoy), $extraTag);
       $lMes=frm_select($mes,$meses,$imeses,$mesActual, $extraTag);
       $lAnn=frm_select($anio,$anios,$anios,iAnno($hoy), $extraTag);
       return $lDia.$lMes.$lAnn;
    }




function MesStr_dig($strMes,$car=0){
  $vMes=array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
  for($i=0;$i<=11;$i++){
        $lMes=$vMes[$i];
        if($car!=0){
            if(stristr($vMes[$i],$strMes)){
              $indice=$i;
              break;
            }
        }else{
            if($vMes[$i]==$strMes){
              $indice=$i;
              break;
            }
        }
  }
  return $indice+1;
}

/**
*Crea un calendario con dos combos correspondientes a meses y aÃ±os.
*
*@param string 		$mes			nombre que se asigna al combo de los meses
*@param string 		$anio			nombre que se asigna al campo de los aÃ±os.
*@param string 		$dReferencia		fecha (inglesa) de referencia que serÃ¡ mostrada por defecto.
*@param string 		$extraTag			caracterÃ­sticas adicionales de calendario.
* @return calendario
*
*/
    function xfrm_medioCalendario($mes,$anio,$dReferencia='',$extraTag='')
    {
       $anios = array();
       $imeses= array(1,2,3,4,5,6,7,8,9,10,11,12);
       $meses = array('ene','feb','mar','abr','may','jun',
                          'jul','ago','sep','oct','nov','dic');
       $annioInicial = date("Y");
       $annioFinal = $annioInicial-5;
       if ($dReferencia=='') {
         $hoy = date("m/d/Y");
         $mesActual = date("m");
       } else {
          $fecha=date("$dReferencia");
          $hoy = $fecha;
          $mesActual = iMes($hoy);
       }
       for ($i=0; $i<=5; $i++)  {
         $anios[$i] = $annioInicial;
         $annioInicial = $annioInicial-1;
       }
       $lMes=frm_select($mes,$meses,$imeses,$mesActual, $extraTag);
       $lAnn=frm_select($anio,$anios,$anios,iAnno($hoy), $extraTag);
       return $lMes.$lAnn;
    }
  
/**
*Crea un combo de objetos para mostrar y seleccionar fechas.
*
*@param string  $nombreCampo	Nombre del textbox donde se mostrara la fecha.
*@param string 	$idCampo 		Nombre del id requerido para la actualizacion de la fecha una vez seleccionada.
*@param date	$fecha			Fecha por defecto... Si se omite toma el dia actual.
*@param string	$imagen 		Nombre de la imagen que se utilizara como icono del calendario.
*@param int 	$ancho 			Ancho de la imagen en pixeles
*@param int 	$alto 			Alto de la imagen en pixeles
*@return combo
*/

function frm_calendario($nombreCampo="fecha", $idCampo="xFecha", $fecha="", $extraTag = "",$imagen="./imagenes/calend.jpg", $ancho=30, $alto=30 ){

	//Para recordar  =>  El uso de esta funcion requiere
	// 1. Copiar la siguiente instruccionn en el body de la pagina web:  <script type='text/JavaScript' src='scw.js'></script>
	// 2. Crear una pagina vacia en la carpeta raiz del sitio web con nombre: scwblank.html
	// 3. Copiar el archivo scw.js en la carpeta raiz del sitio web.
	// 4. Copiar la imagen en el directorio que se quiera y hacer la referencia correspondiente.  Por defecto tomara calend.jpg
	if($fecha==""){
		$fecha = date("d/m/Y");
	}
	$htm = frm_text($nombreCampo, $fecha,12,12," id='$idCampo' onclick='scwShow(this,event)' $extraTag");
	$htm .= frm_imagen($imagen,"calendario",$ancho,$alto,"onclick=\"scwShow(scwID('$idCampo'), event);return false;\"");
	return $htm;
	}
//  Igual al anterior pero sin la imagen.
function frm_calendario2($nombreCampo="fecha", $idCampo="xFecha", $fecha="", $extraTag = "",$imagen="./imagenes/calend.jpg", $ancho=30, $alto=30 ){

	//Para recordar  =>  El uso de esta funcion requiere
	// 1. Copiar la siguiente instruccionn en el body de la pagina web:  <script type='text/JavaScript' src='scw.js'></script>
	// 2. Crear una pagina vacia en la carpeta raiz del sitio web con nombre: scwblank.html
	// 3. Copiar el archivo scw.js en la carpeta raiz del sitio web.
	// 4. Copiar la imagen en el directorio que se quiera y hacer la referencia correspondiente.  Por defecto tomara calend.jpg
	if($fecha==""){
		$fecha = date("d/m/Y");
	}
	$htm = frm_text($nombreCampo, $fecha,12,12," id='$idCampo' onclick='scwShow(this,event)' $extraTag");
	//$htm .= frm_imagen($imagen,"calendario",$ancho,$alto,"onclick=\"scwShow(scwID('$idCampo'), event);return false;\"");
	return $htm;
	}

//echo frm_calendario("miFecha", "miFecha");


/**
* Retorna buenos dias, tardes o noche dependiendo de la hora del sistema.
* 
* 
* @return	string que refleja el momento del día.
*/
function momentoDiario(){
	$hora = date("H");
	//echo "$hora<br/>";
	if($hora<12){
		$s = "Buenos dias";
	}elseif($hora>12 and $hora<18){
		$s = "Buenas tardes";
	}else{
		$s = "Buenas noches";
	}
	return $s;
}

function hoy(){
	return date("m/d/Y");
}

/**
* VALIDA UNA FECHA INGRESADA EN FORMATO DD/MM/AAAA
* 
* @param string $value fecha a ser validada.
* 
* @return boolean
*/
function es_fecha_valida($value){ 
    // Formato para la fecha: dd/mm/aaaa
    // Autor: José Delgado. 
    // Fecha: 09/01/2017
    
    $diaX = (int) substr($value, 0,2);
    $mesX = (int) substr($value, 3,2);
    $aaaaX = (int) substr($value,6,4);
    if( is_int($diaX) and is_int($mesX) and is_int($aaaaX) ){		
	    $fecha = d_ES_US($value);
	    $dia = (int) iDia($fecha);
	    $mes = (int) yMes($fecha);
	    $aaaa = (int) yAnno($fecha);
		if($dia == $diaX and $mes == $mesX){		
		    if(checkdate($mes, $dia, $aaaa)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}    
	}
	return FALSE;
} 

/**
* VALIDA UNA FECHA INGRESADA EN FORMATO DD/MM/AAAA
* 
* @param string $fecha fecha a ser validada en formado dd/mm/aaaa.
* 
* @return boolean
*/
function valida_fecha($fecha){
	$patronFecha = "/^([0-9]{2}([-]|[\/]){1}){2}[0-9]{4}$/";
	if(!preg_match($patronFecha, $fecha)){
		return FALSE;
	}else{
		return es_fecha_valida($fecha);//Retorna true o false.
	}
}
/*
	$fecha = "16/01/2017";
	if(valida_fecha($fecha)){
		echo("Fecha correcta");
	}else{
		echo "Existe problemas con el formato de la fecha suministrada";
	}
*/	
?>