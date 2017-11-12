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
				$salida = "Se ha actualizado la clave correctamente.";
				$xr->script("document.getElementById('clave').value='';document.getElementById('nuevaclave1').value='';document.getElementById('nuevaclave2').value='';" );
				$xr->call("aviso",$salida);
			}else{
				$mensaje = "No se ha actualizado la clave!.  Intente de nuevo.";
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
        $frm="
        <div id='frmLogin' class='frmLogin' >
            <div id='frmEnvoltura' class='frmEnvoltura'>
    		<div id='frmDiv'>
    			<form id='idFormulario' class='iformula'>
    				<h2 style='margin-top:-25px; margin-bottom:-10px;'>Iniciar Sesi&oacute;n</h2>
    				<input type='text' name='usuario' autofocus id='user' placeholder=' &#9787; Ingrese Usuario' value=''/>
    				<input type='password' autofocus name='password'  placeholder='&#128272; Ingrese Clave' value=''  $evento/>
    				<input type='button' value='Iniciar sesi&oacute;n' onclick=\"xajax_validaUsuario(xajax.getFormValues('idFormulario'))\"/>
    			</form>
    		</div>
        		</div>
        </div>
        ";
        return $frm;
    }
//----------------------------------------------------------------------------------------------------
	function frmCambioClave(){	//$nombreUsuario
		$accion = "onclick=\"xajax_cambiaClave(xajax.getFormValues('frm'))\";";
		$clase = "class='form-control'";
		$htm = " 
		<form id='frm' class='container col-md-4 col-md-offset-4'>
	<div id='' class='row  ' >
 	   <div id='' class='col-md-12 text-center' style='margin-bottom:-20px;'>
				<h2 >Cambio de Clave</h2>
		</div>
		<div class='row'>
			<div class='col-md-12 text-center'>
				<h3 ><i>Usuario: </i>".$_SESSION['USUARIO']."</h3>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-4 col-md-offset-2'>
				<label >Clave actual:</label>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-8 col-md-offset-2'>
				<input type='password' autofocus name='clave' id='clave' placeholder='&#128272;  Clave actual' $clase />
			</div>
		</div>
		<div class='row'>
			<div class='col-md-4 col-md-offset-2'>
				<label >Nueva clave:</label>
			</div>
		</div>		
		<div class='row'>
			<div class='col-md-8 col-md-offset-2'>
				<input type='password' autofocus name='nuevaclave1' id='nuevaclave1'  placeholder='&#128272; nueva clave'$clase />
			</div>
		</div>						
		<div class='row'>
			<div class='col-md-6 col-md-offset-2'>
				<label >Repita la clave:</label>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-8 col-md-offset-2'>
				<input type='password' autofocus name='nuevaclave2' id='nuevaclave2'  placeholder='&#128272; repita nueva clave' $clase/>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-12 text-center'>
				<br/>	
				<input class= 'btn btn-primary' type='button' value='Grabar' id='grabar' onclick=\"xajax_validaUsuario(xajax.getFormValues('frm'))\"/>
				<br/><br/>
			</div>
		</div>
										
		</div>	
		</form>	
		";
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
			$xr->script("xajax_showGrid('CLS_VENTAS');");
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

?>
