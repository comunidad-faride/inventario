<?php
/*include_once("./cls_inventario.php");*/
class CLS_USUARIO extends CLS_INVENTARIO{
    private $usuario;
    private $clave;
    private $link;
    private $bd;
//----------------------------------------------------------------------------------------------------
    
	function __construct(){
		parent :: __construct();
	/*	$this->bd = parent::conexion;*/
    }

//----------------------------------------------------------------------------------------------------
    function getUsuario(){
    	return $this ->usuario;
    }
//----------------------------------------------------------------------------------------------------
    function incluir($usuario,$clave){
	    $ret=false;
	    if(!$this->existe($usuario)){
		    $this ->usuario = $usuario;
	    	$this ->clave = $clave;
	    	$ret = $this->tblusuariosInsert($usuario, $this ->clave);	
		}
		if($ret){
			return TRUE;
		}else{
			return FALSE;
		}
    }

//----------------------------------------------------------------------------------------------------
    function existe($login){
    	$fila = $this->numRegistros("usuarios","usuario='$login'");
    	if ($fila == 0 ){
    		return FALSE;
    	}else{
    		return TRUE;
    	}
    }
//----------------------------------------------------------------------------------------------------    
    function borrar($login){
    	$ret = $this->tblusuariosDelete("usuario='$login'");
    	if($ret){
    		return TRUE;
    	}else{
    		return FALSE;
    	}			
    }
//----------------------------------------------------------------------------------------------------    
    function cambiaClave($formulario){
    	$xr = new xajaxResponse();
    	$baseDatos = new CLS_INVENTARIO();
    	$mensaje = CLS_USUARIO::valida($formulario);
    	extract($formulario);
    	if(!$mensaje){
			$idusuario = $_SESSION["USUARIO"];
			$clave = md5($nuevaclave1);
			$strSQL = "UPDATE tblusuarios SET  clave = '$clave' WHERE  usuario = '".$_SESSION["USUARIO"]."'";
			$r = $baseDatos->consultagenerica($strSQL);
			if($r){
				//$xr->alert("Se ha actualizado la clave correctamente.");
				$salida = "Se ha actualizado la clave correctamente.";
				//cument.getElementById('ventanaModal').style.visibility='visible';");
     			//$xr->call("xajax_asignarEnXajax", "ventanaModal", "innerHTML", NULL, "alerta",$salida);
				/*if($_SESSION["USUARIO"]=="ADMINISTRADOR"){
					$xr->call("xajax_asignarEnXajax","contenedor", "innerHTML",  NULL, "menuAdministrador");									
				}else{*/
					//$xr->call("xajax_asignarEnXajax","contenedor", "innerHTML",  NULL, "menuPrincipalUsuario", 1);
				/*}*/
				$xr->script("document.getElementById('clave').value='';document.getElementById('nuevaclave1').value='';document.getElementById('nuevaclave2').value='';" );
				//$xr->script("document.getElementById('nuevaclave1').value='';" );
				//$xr->script("document.getElementById('nuevaclave2').value='';" );
				$xr->call("aviso",$salida);
			}else{
				$mensaje = "No se ha actualizado la clave!.  Intente de nuevo.";
				//$xr->alert("No se ha actualizado la clave!.  Intente de nuevo.");
				$xr->call("aviso",$mensaje);
			}
		}else{
			//$xr->alert($mensaje);	
			$titulo = "AVISO";
			$xr->call("aviso",$mensaje);	
		}
    	return $xr;
    }
//----------------------------------------------------------------------------------------------------
	function valida($f){
		if(empty($f['clave'])) return "El campo 'Clave Actual' no puede ser nulo.";
		if(empty($f['nuevaclave1'])) return "El campo'Nueva Clave' no puede ser nulo";
		$salida = validarPatron($f['nuevaclave1'], ALFNUMCE);
		if($salida != "") return utf8_encode("El campo 'Nueva clave'  $salida");
		if(empty($f['nuevaclave2'])) return "El campo 'Repita Nueva Clave' no puede ser nulo.";
		$salida = validarPatron($f['nuevaclave2'], ALFNUMCE);
		if($salida != "") return utf8_encode("El campo 'Repita Nueva Clave'  $salida");
		if($f['nuevaclave1'] != $f['nuevaclave2']) return "Las nuevas claves deben ser iguales.";
		//$idusuario = $_SESSION["idUsuario"];
		$clase = new CLS_INVENTARIO();
		$registros = $clase->tblusuariosRecords("usuario = '" . $_SESSION["USUARIO"] . "'");
		foreach($registros as $registro){
			extract($registro);
		}
		if(MD5($f['clave']) != $clave) return "La 'Clave Actual' no coincide con la registrada.";
	 	return 0;
	}

//----------------------------------------------------------------------------------------------------
    function frmLogin(){
        $evento = "onkeypress=\"if(enterCheck(event)==13)xajax_validaUsuario(xajax.getFormValues('idFormulario'))\"";
        $frm="<br/><br/><br/><br/><center>
        <div id='frmLogin' >
            <div id='frmEnvoltura'>
    		<div id='frmDiv'>
    			<form id='idFormulario'>
    				<div><p class='login'>Usuari@:</p></div><div><input type='text' name='usuario' autofocus id='user' placeholder='Ingrese Login' /></div>
    				<div><p class='login'>Clave:</p></div><div><input type='password' autofocus name='password'  placeholder='Ingrese Clave'  $evento/></div>
    				<div class='submitDiv'><br/><input type='button' value='Iniciar sesi&oacute;n' 
                    onclick=\"xajax_validaUsuario(xajax.getFormValues('idFormulario'))\"/></div><br/>
    			</form>
    		</div>
        		</div>
        </div>
        </center>";
        return $frm;
    }
//----------------------------------------------------------------------------------------------------
	function frmCambioClave(){
		$accion = "onclick=\"xajax_cambiaClave(xajax.getFormValues('frm'))\";";
		
		$htm = '<form id="frm"><br/><br/><br/><br/>
	    	<div class="container bg-info">
	    		<br><br>
				<div class="col-md-12">
					<div class="col-md-offset-3 col-md-6 text-center">
						<label class="form-control" >CAMBIO DE CLAVE</label>
					</div>
				</div>
				<div class="col-md-12">
					<div class="col-md-offset-3 col-md-6 text-center  ">
						<label class="form-control"><i>Usuario:</i> '.$_SESSION["USUARIO"].'</label>
					</div>
				</div>
				<div class="col-md-12">
					<div class="col-md-offset-3 col-md-3 text-right  ">
					<label class="form-control">Clave actual</label>
					</div>
					<div class="col-md-3 "><p>'
						.frm_password("clave", "", 20, 20, "autofocus  id='clave' placeholder='Clave actual' class='form-control' id='clave'").
					'</p></div>
				</div>
				<div class="col-md-12">
					<div class="col-md-offset-3 col-md-3 text-right">
						<label class="form-control">Nueva clave:</label>
					</div>
					<div class="col-md-3 "><p>'
						.frm_password("nuevaclave1", "", 20, 20, " class='form-control' placeholder='Otra clave'  id='nuevaclave1'").
					'</p></div>
				</div>
				<div class="col-md-12">
					<div class="col-md-offset-3 col-md-3 text-right">
						<label class="form-control">Repita la clave:</label>
					</div>
					<div class="col-md-3">'
						.frm_password("nuevaclave2", "", 20, 20, " class='form-control' placeholder='Repita la nueva clave'  id='nuevaclave2'").
					'</div>
				</div>
				<div class="col-md-12">
					<br><br>
					<div class="col-md-offset-3 col-md-6 text-center">'
						.frm_button("grabar", "Grabar", $accion).	
					'</div>
					<br><br>
				</div>
			</div>
			</form>';
	    		
		
		
		
		
		return $htm;
	}

//----------------------------------------------------------------------------------------------------

    function validaUsuario($frmEntrada){
    	$xr = new xajaxResponse();    
        // $respuesta->alert("entr� a validar usuario.");
        // return $respuesta;
         $bool = 0;
    if($frmEntrada["usuario"]=="" && $frmEntrada["password"]==""){
        $salida = "Debe ingresar usuario y clave.";
    } else{
      if($frmEntrada["usuario"]==""){
        $salida = "Debe ingresar usuario para continuar.";
      }else{
        if($frmEntrada["password"]==""){
            $salida = "Debe ingresar la clave para continuar.";
        }else{
        
        $llogin=$frmEntrada["usuario"];
        $password=$frmEntrada["password"];
        $bd = new CLS_INVENTARIO();
        $numReg =  $bd->numRegistros("tblUsuarios","usuario='".$llogin."'");
        if($numReg == 0 ){
          $salida="Usuario no existe!.";
        }else{
         $Kpassword = MD5($password);
         $numReg =  $bd->numRegistros("tblUsuarios","usuario='$llogin' and clave = '$Kpassword'");
         if($numReg == 1){
            $salida = "Acceso aceptado...";
            // $salida = menuPrincipal();//			OOOOOJJJJJOOOOO
               $xr->assign("menu","style.display", "block");			//  ACTIVA EL MENU GENERAL
               $_SESSION["USUARIO"] = $llogin;
               //$xr->script("xajax_showGrid('CLS_TBLUSUARIOS');");		//	MUESTRA LA VENTANA INICIAL	
               $xr->script('xajax_asignarConXajax("contenedor", "innerHTML", "CLS_USUARIO", "frmCambioClave")');
               $bool = 1;
               return $xr;
            }else{       //  Clave de acceso inapropiada...
               $salida = "Clave incorrecta";
          }
         }
        }
       }
    }
    //  aqui se hace algo con $salida.
    $xr = $xr->script("aviso('$salida')");
     return $xr;
  }
//----------------------------------------------------------------------------------------------------

}
/* Procesos validados con mysql:

 borrar
 existe
 frmlogin
 getUsuario
 incluir
 modificar
 validaUsuario		** OJO ** Por validar.

*/

/* Procesos validados con mysqli:

 borrar
 existe
 frmlogin
 getUsuario
 incluir
 modificar
 validaUsuario		** OJO ** Por validar.

*/
/*
$miClase = new CLS_USUARIO();
$P = "delgadoerrade";
$c1 = "odagledesoj*1958";
$r = $miClase->incluir($P, $c1);
*/
//	SELECT COUNT( * ) AS numero FROM usuarios WHERE usuario = 'Rosaira'AND 
//	
/*echo ("clave = '2eae20f25a6d70838357f5efbbcaa923' ");
echo("<br/>");
echo ("<br/>"."$c1 = ".md5($c1));*/

/*$r = $miClase->modificar($P, $c1, "RPO1993");

if($r){
	echo("El registro se actualiz� correctamente.");
}else{
	echo("El registro NO se actualiz�.");
}*/

//echo($miClase->frmLogin());
/*echo md5("odagledesoj*1958");*/
//echo $miClase->frmCambioClave();
?>
