<?php
	require_once("cls_alquileres.php");
	require_once("form_items.php");
	class CLS_TBL_USUARIOS extends CLS_ALQUILERES{
		var $sqlBase;
		var $titulo;
		var $ordenTabla ="data-order='[[ 0, \"asc\" ]]'";
//-----------------------------------------------------------------------------------------------------------
//	METODOS SIN CAMBIOS DE NINGUN TIPO
//-----------------------------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------------------------------
//	METODOS CON CAMBIOS. DICHOS CAMBIOS; 
//-----------------------------------------------------------------------------------------------------------
	function __construct(){
		parent::__construct();
		$this->sqlBase = "SELECT id_usuario, usuario, tipo_usuario, nombre_inquilino FROM tbl_usuarios";
		//$_SESSION["TITULO"] = "LISTADO DE USUARIOS DEL SISTEMA";
		$this->titulo = "LISTADO DE USUARIOS DEL SISTEMA";
	}
//-----------------------------------------------------------------------------------------------------------
	function insertNewRecord($f){
		extract($f);
		//Convertir la fecha de formato ingles o español a formato MYSQL antes de pasarlo a la funcion.
		
		$clave = md5($clave); 
		$r = $this->tbl_usuariosInsert($id_usuario, $usuario, $clave, $tipo_usuario, $nombre_inquilino, $responsable_inquilino, $correo_electronico, $telefono);
		return $r;
	}
//-----------------------------------------------------------------------------------------------------------
	function updateRecord($f){
		extract($f);
		//$clave = md5($clave);
		$res = $this->tbl_usuariosUpdate($usuario, $tipo_usuario, $nombre_inquilino, $responsable_inquilino, $correo_electronico, $telefono, $id_usuario);
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function deleteRecord($id){
		$res = $this->tbl_usuariosDelete("id_usuario = $id");
		return $res;
	}
//-----------------------------------------------------------------------------------------------------------
	function formAdd(){
		$html = $this->frmtbl_usuarios();
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function formEdit($id){
		$html = $this->frmtbl_usuarios($id);
		return $html;
	}
//-----------------------------------------------------------------------------------------------------------
	function frmtbl_usuarios(){
		$arrTipoUsurio = array("Inquilino","Administrador");
		$arrTU = array("INQ", "ADM");
		$alineacionDerecha = " style='text-align:right' ";
		$numeroReal = " onkeypress='return NumCheck(event, this);'";
		if(func_num_args() > 0){
			$id_usuario = func_get_arg(0);
			$records = $this->tbl_usuariosRecords("id_usuario = $id_usuario");
			foreach($records as $record){
				extract($record);
			}
			// Bloquear clave y usuario.
			$sw = 1;
			$clave = '';
			$textoBoton = "Actualizar";
			$accion = "onClick=\"xajax_update('CLS_TBL_USUARIOS',xajax.getFormValues('frm'))\"";
			$titulo = "<center><h3>Editar Usuario</h3></center>";
		}else{
			$sw = 0;
			$titulo = "<center><h3>Nuevo Usuario</h3></center>";
			$pk = "";
			$textoBoton = "Grabar";
			$accion = "onClick=\"xajax_save('CLS_TBL_USUARIOS',xajax.getFormValues('frm'))\"";
			$id_usuario = 0;
			$usuario = '';
			$clave = '';
			$tipo_usuario = 'INQ';
			$nombre_inquilino = '';
			$responsable_inquilino = '';
			$correo_electronico = '';
			$telefono = "";
		}
		$hid_usuario = frm_hidden("id_usuario", $id_usuario);
		$cmbTU = frm_select("tipo_usuario",$arrTipoUsurio, $arrTU,$tipo_usuario, ' class="form-control"');
		$habilitado = ($sw == 1) ? "readonly style='background-color:#D8D8D8' " : "";
		$htm = "<form id='frm' class='form-horizontal' role='form'>$hid_usuario
					$titulo
					<div class='form-group'>
						<label for='usuario' class='col-md-6'>Usuario</label>
						<div class='col-md-6'>".frm_text('usuario', $usuario, '15', '15 ', $habilitado.' class="form-control"')."</div>
					</div>";
		if($sw == 0){
			$htm .=		"<div class='form-group'>
						<label for='clave' class='col-md-6'>Clave</label>
						<div class='col-md-6'>".frm_password('clave', $clave, '15', '15', ' class="form-control"')."</div>
					</div>";	
		}				
		$htm .=		"<div class='form-group'>
						<label for='tipo_usuario' class='col-md-6'>Tipo de Usuario</label>
						<div class='col-md-6'>$cmbTU</div>
					</div>	
					<div class='form-group'>
						<label for='nombre_inquilino' class='col-md-6'>Nombre inquilino / Empresa</label>
						<div class='col-md-6'>".frm_text('nombre_inquilino', $nombre_inquilino, '45', '45 ', ' class="form-control"')."</div>
					</div>	
					<div class='form-group'>
						<label for='responsable_inquilino' class='col-md-6'>Responsable</label>
						<div class='col-md-6'>".frm_text('responsable_inquilino', $responsable_inquilino, '45', '45 ', ' class="form-control"')."</div>
					</div>	
					<div class='form-group'>
						<label for='correo_electronico' class='col-md-6'>Correo Electr&oacute;nico</label>
						<div class='col-md-6'>".frm_text('correo_electronico', $correo_electronico, '45', '45 ', ' class="form-control"')."</div>
					</div>	
					<div class='form-group'>
						<label for='telefono' class='col-md-6'>Tel&eacute;fono</label>
						<div class='col-md-6'>".frm_text('telefono', $telefono, '45', '45 ', ' class="form-control"')."</div>
					</div>						
			</form>";
	return $htm;	
	}
//-----------------------------------------------------------------------------------------------------------
/**  VALIDA LOS DATOS DE INGRESO DE UN FORMULARIO ANTES DE GRABARLOS A LA BASE DE DATOS.
* 
* @param array 	$f		Arreglo con las variables y valores tomados del formulario de datos.
* @param integer $new	Si es 1, indica que es nuevo registro. Con cero, es una actualizacion.
* 
* @return string  Si está vacio, todo bien; Si tiene texto, presenta problemas.
*/
	function checkAllData($f,$new = 0){		// Considerar colocar los campos obligatorios en el formulario.
		$patronNombrePersona = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]{2,}(\s[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ]{1,12})*$/";	
		$patronLetrasNumeros = "/^[a-zA-Z]{4,}(\s[a-zA-Z]{2,50})*$/";
		$patronUsuario = "/^[a-zA-Z0-9]+(([_]|[.])?[a-zA-Z0-9]+)*$/";
		$patronEmail = "/^[a-z0-9]+([.]{0,1}[_]{0,1}[-]{0,1}[a-z0-9]+)*[@][a-z0-9]+[.][a-z]{2,3}([.][a-z]{2}){0,1}$/";
	//	Patron para usuario Con al menos 8 caracteres.
		$patron = "/^[a-zA-Z0-9]+(([_]|[.])?[a-zA-Z0-9]+)*$/";		
		if($new == 1) {
			if(empty($f['usuario'])){ 
				return "El campo 'usuario' no puede ser nulo.";
			}elseif(preg_match($patronUsuario, $f['usuario']) ){
				$bd = new CLS_ALQUILERES;
				$n = $bd->numRegistros("tbl_usuarios","usuario = '".$f['usuario']."'" );
				if( 0 != $n ){
					return "Usuario ".$f['usuario']." ya existe en la base de datos.  Intente con otro, por favor.";
				}
			}else{
				return utf8_decode("El campo 'Usuario' debe contener letras, números, y los caracteres punto (.) y guión bajo (_)");
			}
			
			if(empty($f['clave'])){ 
				return "El campo 'Clave' no puede ser nulo.";
			}else {
				$msg = valida_password($f['clave']);
				if($msg != ""){
					return $msg;
				}	
			}	
		} 	
		if(empty($f['nombre_inquilino'])){
			return "El campo 'Nombre Inquilino / Empresa' no puede ser nulo.";
		}elseif(!preg_match($patronNombrePersona, $f['nombre_inquilino'])){
			return "El campo Nombre Inquilino / Empresa no puede tener caracteres especiales.";
		}  
		if(empty($f['responsable_inquilino'])){
			 return "El campo 'Responsable' no puede ser nulo.";
		}elseif(!preg_match($patronNombrePersona, $f['responsable_inquilino'])){
			return "El campo 'Responsable' solo debe tener caracteres letras y espacios en blanco.";
		} 
		if(empty($f['correo_electronico'])){ 
			return "El campo 'Correo Electr&oacute;nico' no puede ser nulo.";
		}elseif(!preg_match($patronEmail, $f['correo_electronico'])){
				return utf8_decode("Correo electrónico inválido.  Corrija, por favor.");
		}	
	 	return 0;
	}
//-----------------------------------------------------------------------------------------------------------
// Nombres de los campos de la consulta.
	function camposBD(){
		$fields = array();
		$fields[] = 'id_usuario';	
		$fields[] = 'usuario';	
		//$fields[] = 'clave';	
		$fields[] = 'tipo_usuario';	
		$fields[] = 'nombre_inquilino';	
		//$fields[] = 'responsable_inquilino';	
		//$fields[] = 'correo_electronico';	
		return $fields;
	}
//-----------------------------------------------------------------------------------------------------------
	function encabezados(){
		$headers = array();
//		$headers[] = "id_usuario";
		$headers[] = "Usuario";
		//$headers[] = "Clave";
		$headers[] = "Tipo de Usuario";
		$headers[] = "Nombre Inquilino / Empresa";
		//$headers[] = "Responsable";
		//$headers[] = "Correo Electr&oacute;nico";
		return $headers;
	}
//-----------------------------------------------------------------------------------------------------------
	function atributosEncabezados(){
		// HTML table: hearders attributes
		$attribsHeader = array();
//		$attribsHeader[] = '14';
		
		$attribsHeader[] = '14';
		$attribsHeader[] = '14';
		$attribsHeader[] = '14';
		return $attribsHeader;
	}
//-----------------------------------------------------------------------------------------------------------
	function atributosColumnas(){
		// HTML Table: columns attributes
		$attribsCols = array();
//		$attribsCols[] = 'nowrap style="text-align:left"';
		
		$attribsCols[] = 'nowrap style="text-align:left"';
		$attribsCols[] = 'nowrap style="text-align:left"';
		$attribsCols[] = 'nowrap style="text-align:left"';
		return $attribsCols;
	}
//-----------------------------------------------------------------------------------------------------------
   function existe($login){
    	$fila = $this->numRegistros("usuarios","usuario='$login'");
    	if ($fila == 0 ){
    		return FALSE;
    	}else{
    		return TRUE;
    	}
    }
//----------------------------------------------------------------------------------------------------    
//----------------------------------------------------------------------------------------------------    
    function cambiaClave($formulario){
    	$xr = new xajaxResponse();
    	$cooperativa = new CLSCOOPERATIVA();
    	$mensaje = clsUSUARIO::valida($formulario);
    	extract($formulario);
    	if(!$mensaje){
			$idusuario = $_SESSION["idusuario"];
			$clave = md5($nuevaclave1);
			$strSQL = "UPDATE usuarios SET  clave = '$clave' WHERE  idusuario = $idusuario";
			$r = $cooperativa->consultagenerica($strSQL);
			if($r){
				//$xr->alert("Se ha actualizado la clave correctamente.");
				$salida = "Se ha actualizado la clave correctamente.";
				$xr->script("document.getElementById('ventanaModal').style.visibility='visible';");
     			$xr->call("xajax_asignarEnXajax", "ventanaModal", "innerHTML", NULL, "alerta",$salida);
				if($_SESSION["USUARIO"]=="ADMINISTRADOR"){
					$xr->call("xajax_asignarEnXajax","contenedor", "innerHTML",  NULL, "menuAdministrador");									
				}else{
					$xr->call("xajax_asignarEnXajax","contenedor", "innerHTML",  NULL, "menuPrincipalUsuario", 1);
				}
			}else{
				$xr->alert("No se ha actualizado la clave!.  Intente de nuevo.");
			}
		}else{
			$xr->alert($mensaje);		
		}
    	return $xr;
    }
//----------------------------------------------------------------------------------------------------
   function frmLogin(){
        $evento = "onkeypress=\"if(enterCheck(event)==13)xajax_validaUsuario(xajax.getFormValues('idFormulario'))\"";
        $frm="<br/><br/><br/><br/><center>
        <div id='frmLogin' >
            <div id='frmEnvoltura'>
    		<div id='frmDiv'>
    			<form id='idFormulario'>
    				<div><p class='login'>Usuari@:</p></div><div><input type='text' name='usuario' autofocus id='user' /></div>
    				<div><p class='login'>Clave:</p></div><div><input type='password' name='password' $evento/></div>
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
        $bd = new CLS_ALQUILERES();
        $numReg =  $bd->numRegistros("tbl_usuarios","usuario='".$llogin."'");
        if($numReg == 0 ){
          $salida="Usuario no existe!.";
        }else{
         $Kpassword = MD5($password);
         $numReg =  $bd->numRegistros("tbl_usuarios","usuario='$llogin' and clave = '$Kpassword'");
         if($numReg == 1){
            $salida = "Acceso aceptado...";
            $_SESSION['usuario_activo'] = $llogin;
            // $salida = menuPrincipal();//			OOOOOJJJJJOOOOO
               $xr->assign("menu","style.display", "block");
               //$xr->script("xajax_showGrid('CLS_TBL_USUARIOS');");
               //$xr->script("xajax_showGrid('CLS_TBL_CUENTAS');");	
               //$xr->script("xajax_showGrid('CLS_TBL_TIPOS_INMUEBLES');");	
               $xr->script("xajax_showGrid('CLS_TBL_INMUEBLES');");		
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
	function frmCambioClave(){
		$accion = "onclick=\"xajax_cambiaClave(xajax.getFormValues('frm'))\";";
		//$tabla = new Table;
		//$htm = $tabla->Top("Cambio de clave de acceso al sistema.");
		$htm = "<center>
		<div style='border: thick solid #000;height:290px;width:280px;background-color::#d1e3ed;border-color:#3882C7;box-shadow: 4px 4px 5px #999;-webkit-box-shadow: 4px 4px 5px #999; -moz-box-shadow: 4px 4px 5px #999;';>
		<form id='frm'>
		<table border='0' style='background-color:fff'>
			<tr>
				<td colspan='2' align='center' style='background-color:#bd10ef; color:fff;padding:5px' ><h3>Cambiar Clave de Acceso</h3></td>
			</tr>
			<tr>
				<td rowspan='3' align='center'><img src='./imagenes/claves5.jpg' alt='' width='80px' height='80px' /></td>
				<td align='center' align='center' style='background-color: #7bb9f7; color:#000;'>Clave Actual<br/>".
				frm_password("clave", "", 12, 12, "autofocus  id='clave'")
			."<br/>&nbsp;</td>
			<tr>
				<td align='center' style='background-color:#f9b5fb; color:#000'>Nueva Clave<br/>".
				frm_password("nuevaclave1", "", 12, 12)
			."<br/>&nbsp;</td>
			<tr>
				<td align='center' style='background-color: #8cf273; color:#000'>Repita Nueva Clave".
				frm_password("nuevaclave2", "", 12, 12)
			."<br/>&nbsp;</td>
			</tr>
			<tr><td  colspan='2' align='center'><br/>&nbsp;".frm_button("grabar", "Grabar", $accion)."<br/>&nbsp;</td></tr>
		</table><br/>
		</form>
		</div>
		</center><br/>";
		//$htm .= $tabla->Footer();
		return $htm;
	}

//----------------------------------------------------------------------------------------------------


}

/*
	$cls = new CLS_TBL_USUARIOS;
	echo($cls->frmLogin());
	//echo($cls->frmtbl_usuarios());
	//echo($cls->frmCambioClave());
	/**/
//	echo md5("v123456");
?>
