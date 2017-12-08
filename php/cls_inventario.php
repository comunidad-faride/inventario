<?php
require_once "perf_sql.php"; 
class CLS_INVENTARIO
{
     private $link;
     private $lBaseDatos;
     public $filas;
     public $campos;
     public $msg = "";
//-------------------------------------------------------------------------
     function __construct()
      {
        $servidor="localhost";
        $usuario="root";
        $clave="";
        $basedatos="invent";
        $msg = "";
        $this->link = mysql_connect ($servidor,$usuario, $clave);
        
        if (!$this->link) {
        	$this->msg = 'No se pudo conectar al servidor. ' . mysql_error();
            return FALSE;
        }
        $mBD = mysql_select_db($basedatos, $this->link);
        if (!$mBD) {
            $this->msg = 'No se puede abrir la base de datos : ' . mysql_error();
            return FALSE;
         }
         $this->msg = $msg;
          $this->lBaseDatos = $basedatos;
        }
     //-------------------------------------------------------------------------

     function nuevo_id($entidad,$atributo, $condicion=""){
     	if($condicion == ""){
         	$sqlconsulta = "SELECT MAX(".$atributo.") + 1 as nuevo FROM ".$entidad.";";
		}else{
         	$sqlconsulta = "SELECT MAX(".$atributo.") + 1 as nuevo FROM ".$entidad." WHERE $condicion;";
		}
         $result = mysql_query($sqlconsulta);
         if (!$result) {
             $this->msg ='Fall&oacute; la consulta: ' . mysql_error();
              return FALSE;
         }
         else {
            $row = mysql_fetch_array($result, MYSQL_ASSOC);
            $valor = $row["nuevo"];
            if(is_numeric($valor)){
              return $valor;
            }else{
             return 1;
            }
         }
     }
//-------------------------------------------------------------------------
/**
* Retorna la posicion de un registro
* 
* @version 1.0
* @param string $entidad
* @param string $Campo
* @param string $filtos ejemplo "Campo= 5"
* 
* @return
*/
     function posRegistro($entidad, $Campo, $filtos="1"){
         $sqlconsulta = "SELECT $Campo as nuevo FROM ".$entidad." Where $filtos ;";
         $result = mysql_query($sqlconsulta);
         if (!$result) {
             $this->msg ='Fall&oacute; la consulta: ' . mysql_error();
              return FALSE;
         }
         else {
            $row = mysql_fetch_array($result, MYSQL_ASSOC);
            $valor = $row["nuevo"];
            if(is_numeric($valor)){
              return $valor;
            }else{
             return 1;
            }
         }
     }

//-------------------------------------------------------------------------
     function numRegistros($entidad,$criterio=""){
         if($criterio==""){
             $sqlConsulta = "SELECT COUNT(*) as registros FROM $entidad";
         }else{
             $sqlConsulta = "SELECT COUNT(*) as registros FROM $entidad WHERE $criterio";
         }
		 
        $result = mysql_query($sqlConsulta);
         if (!$result) {
             $this->msg ='Fall&oacute; la consulta: ' . mysql_error();
              return FALSE;
         }
         else {
            $row = mysql_fetch_array($result, MYSQL_ASSOC);
            $valor = $row["registros"];
            if(is_numeric($valor)){
              return $valor;
            }else{
             return 0;
            }
         }
     }
//-------------------------------------------------------------------------
 function max_id($entidad,$atributo){
         $sqlconsulta = "SELECT MAX(".$atributo.") as maximo FROM ".$entidad.";";
         $result = mysql_query($sqlconsulta);
         if (!$result) {
             $this->msg ='Fall&oacute; la consulta: ' . mysql_error();
              return FALSE;
         }
         else {
            $row = mysql_fetch_array($result, MYSQL_ASSOC);
            $valor = $row["maximo"];
            if(is_numeric($valor)){
              return $valor;
            }else{
             return 1;
            }
         }
     }

//-------------------------------------------------------------------------
function consultagenerica($strsql, $utf8=0){
    if($strsql!=""){
    	if($utf8==1){
			mysql_query("set names 'utf8'");
		}
        $result = mysql_query($strsql);
        if(!$result){
             $this->msg ='Fall&oacute; la consulta: ' . mysql_error();
              return FALSE;
        }else{
            if(preg_match("/select/i",$strsql)){
                $this->filas = mysql_num_rows($result);
                $matrizasociativa = array();
                $ifila=0;
                while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                    foreach($row as $campo=>$valor){
                        $matrizasociativa[$ifila][$campo]=$valor;
                    }
                    $ifila++; 
                }
                return $matrizasociativa;
            }
            return true;
        }
    }else{
        return false;
    }
}
//-----------------------------------------------------------------------
/**
* Actualiza los campos de una tabla en la base de datos dependiendo de los criterios
* @param string $Campos -- Campo igual 'valor' a actualizar. Ejemplo: Nombrecampo='Valor' &oacute; (Nombrecampo1='Valor1', Nombrecampo2='Valor2'...)
* @param string $tabla  -- Nombre de la tabla a actualizar
* @param string $criterios -- criterio por el que se actualizara -- ejemplo: Nombrecampox='Valorx'
* 
* @return True si actualiza
*/
   function UpdateGenerico($tabla, $Campos, $criterios) {
         $strSQL = "UPDATE $tabla SET  $Campos  WHERE  $criterios ";
      $result = mysql_query($strSQL);
      if(!$result){
             $this->msg ='Fall&oacute; el string de actualizaci&oacute;n' . mysql_error();
              return FALSE;
      } else {
      return true;
   }
   }  
 //-----------------------------------------------------------------------
      function atributos($entidad){
         $result = mysql_query("select * from ".$entidad);
         if (!$result) {
             $this->msg ='Fall&oacute; la consulta: ' . mysql_error();
              return FALSE;
         }
         $i = 0;
         $matriz=array();
         while ($i < mysql_num_fields($result)) {
             $meta = mysql_fetch_field($result, $i);
             if (!$meta) {
             $this->msg ='informaci&oacute;n de atributo no disponible.<br/>\n';
              return FALSE;
             }
             $len   = mysql_field_len($result, $i);
             $arr[$i]=array('nombre'=>$meta->name,'tipo'=>$meta->type,
                      'numerico'=>$meta->numeric,'longitud'=>$len,
                      'no_nulo'=>$meta->not_null,'pk'=>$meta->primary_key,
                      'blob'=>$meta->blob, 'clave_multiple'=>$meta->multiple_key,
                      'entidad'=>$meta->table,'clave_unica'=>$meta->unique_key,
                      'sin_signo'=>$meta->unsigned,'ceros'=>$meta->zerofill);
             $i++;
         }
         return $arr;
     }
//-----------------------------------------------------------------------
   function tblcontrolInsert( $idControlFisico, $idproducto, $cantidad) {
      $idControl = $this->nuevo_id("tblcontrol", "idControl");
      $cols = get_commas(false, 'idControl', 'idControlFisico', 'idproducto', 'cantidad');
      $vals = get_commas(true, '!!'.$idControl, '!!'.$idControlFisico, '!!'.$idproducto, '!!'.$cantidad);
      $strSQL = get_insert('tblcontrol',$cols, $vals);
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblcontrolUpdate($idControl, $idControlFisico, $idproducto, $cantidad) {
         $strSQL = "UPDATE tblcontrol SET  idControlFisico = $idControlFisico,  idproducto = $idproducto,  cantidad = $cantidad WHERE  idControl = $idControl";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblcontrolDelete($condicion) {
      $strSQL = "DELETE FROM tblcontrol WHERE $condicion";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblcontrolRecords($condicion='1', $campoOrden = null, $orden='asc') {
        $strSQL = "SELECT * FROM tblcontrol WHERE $condicion";
        if($campoOrden!=null){
            $strSQL = $strSQL. " ORDER BY $campoOrden $orden";
        }
      $result = mysql_query($strSQL);
      if(!$result){
      return '';
      } else {
      $this->filas = $this->numRegistros('tblcontrol',$condicion);
      $this->campos = mysql_num_fields($result);
 if($this->filas!=0){
      $matriz = $this->atributos('tblcontrol');
      $iMatriz = count($matriz);  // Atributos de la entidad.
      $i=0;
      foreach($matriz as $v){ 
          $atributo[$i++] = $v['nombre']; 
      }
      $j=0; // Indice de la matriz.
      while($row = mysql_fetch_array($result)) { 
         for($i=0;$i<$iMatriz;$i++){
            $matrizAsoc[$j][$atributo[$i]] = $row[$atributo[$i]];
         }
      $j++;
      }
      return $matrizAsoc;
}else{
	return 0;
}
      }
   }
//-----------------------------------------------------------------------
   function tblcontrolfisicoInsert( $idtblTienda, $fecha) {
      $idControlFisico = $this->nuevo_id("tblcontrolfisico", "idControlFisico");
      $cols = get_commas(false, 'idControlFisico', 'idtblTienda', 'fecha');
      $vals = get_commas(true, '!!'.$idControlFisico, '!!'.$idtblTienda, $fecha);
      $strSQL = get_insert('tblcontrolfisico',$cols, $vals);
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblcontrolfisicoUpdate($idControlFisico, $idtblTienda, $fecha) {
         $strSQL = "UPDATE tblcontrolfisico SET  idtblTienda = $idtblTienda,  fecha = '$fecha' WHERE  idControlFisico = $idControlFisico";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblcontrolfisicoDelete($condicion) {
      $strSQL = "DELETE FROM tblcontrolfisico WHERE $condicion";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblcontrolfisicoRecords($condicion='1', $campoOrden = null, $orden='asc') {
        $strSQL = "SELECT * FROM tblcontrolfisico WHERE $condicion";
        if($campoOrden!=null){
            $strSQL = $strSQL. " ORDER BY $campoOrden $orden";
        }
      $result = mysql_query($strSQL);
      if(!$result){
      return '';
      } else {
      $this->filas = $this->numRegistros('tblcontrolfisico',$condicion);
      $this->campos = mysql_num_fields($result);
 if($this->filas!=0){
      $matriz = $this->atributos('tblcontrolfisico');
      $iMatriz = count($matriz);  // Atributos de la entidad.
      $i=0;
      foreach($matriz as $v){ 
          $atributo[$i++] = $v['nombre']; 
      }
      $j=0; // Indice de la matriz.
      while($row = mysql_fetch_array($result)) { 
         for($i=0;$i<$iMatriz;$i++){
            $matrizAsoc[$j][$atributo[$i]] = $row[$atributo[$i]];
         }
      $j++;
      }
      return $matrizAsoc;
}else{
	return 0;
}
      }
   }
//-----------------------------------------------------------------------
   function tbldetallesInsert( $idFactura, $idproducto, $cantidad, $precioUnitario) {
      $idDetalles = $this->nuevo_id("tbldetalles", "idDetalles");
      $cols = get_commas(false, 'idDetalles', 'idFactura', 'idproducto', 'cantidad', 'precioUnitario');
      $vals = get_commas(true, '!!'.$idDetalles, '!!'.$idFactura, '!!'.$idproducto, '!!'.$cantidad, '!!'.$precioUnitario);
      $strSQL = get_insert('tbldetalles',$cols, $vals);
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tbldetallesUpdate($idDetalles, $idFactura, $idproducto, $cantidad, $precioUnitario) {
         $strSQL = "UPDATE tbldetalles SET  idFactura = $idFactura,  idproducto = $idproducto,  cantidad = $cantidad,  precioUnitario = $precioUnitario WHERE  idDetalles = $idDetalles";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tbldetallesDelete($condicion) {
      $strSQL = "DELETE FROM tbldetalles WHERE $condicion";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tbldetallesRecords($condicion='1', $campoOrden = null, $orden='asc') {
        $strSQL = "SELECT * FROM tbldetalles WHERE $condicion";
        if($campoOrden!=null){
            $strSQL = $strSQL. " ORDER BY $campoOrden $orden";
        }
      $result = mysql_query($strSQL);
      if(!$result){
      return '';
      } else {
      $this->filas = $this->numRegistros('tbldetalles',$condicion);
      $this->campos = mysql_num_fields($result);
 if($this->filas!=0){
      $matriz = $this->atributos('tbldetalles');
      $iMatriz = count($matriz);  // Atributos de la entidad.
      $i=0;
      foreach($matriz as $v){ 
          $atributo[$i++] = $v['nombre']; 
      }
      $j=0; // Indice de la matriz.
      while($row = mysql_fetch_array($result)) { 
         for($i=0;$i<$iMatriz;$i++){
            $matrizAsoc[$j][$atributo[$i]] = $row[$atributo[$i]];
         }
      $j++;
      }
      return $matrizAsoc;
}else{
	return 0;
}
      }
   }
//-----------------------------------------------------------------------
   function tblfacturasInsert( $idtblTienda, $fecha, $numFactura, $opcion, $formaPago, $comentario) {
      $idFactura = $this->nuevo_id("tblfacturas", "idFactura");
      $cols = get_commas(false, 'idFactura', 'idtblTienda', 'fecha', 'numFactura', 'idOpciones', 'idFormaPago', 'comentario');
      $vals = get_commas(true, '!!'.$idFactura, '!!'.$idtblTienda, $fecha, '!!'.$numFactura, '!!'.$opcion, $formaPago, $comentario);
      $strSQL = get_insert('tblfacturas',$cols, $vals);
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblfacturasUpdate($idFactura, $idtblTienda, $fecha, $numFactura, $opcion, $formaPago, $comentario) {
         $strSQL = "UPDATE tblfacturas SET  
         	idtblTienda = $idtblTienda,  fecha = '$fecha',  
         	numFactura = $numFactura,  idOpciones = $opcion,  
         	formaPago = $formaPago, comentario = '$comentario' WHERE  idFactura = $idFactura";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblfacturasDelete($condicion) {
      $strSQL = "DELETE FROM tblfacturas WHERE $condicion";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblfacturasRecords($condicion='1', $campoOrden = null, $orden='asc') {
        $strSQL = "SELECT * FROM tblfacturas WHERE $condicion";
        if($campoOrden!=null){
            $strSQL = $strSQL. " ORDER BY $campoOrden $orden";
        }
      $result = mysql_query($strSQL);
      if(!$result){
      return '';
      } else {
      $this->filas = $this->numRegistros('tblfacturas',$condicion);
      $this->campos = mysql_num_fields($result);
 if($this->filas!=0){
      $matriz = $this->atributos('tblfacturas');
      $iMatriz = count($matriz);  // Atributos de la entidad.
      $i=0;
      foreach($matriz as $v){ 
          $atributo[$i++] = $v['nombre']; 
      }
      $j=0; // Indice de la matriz.
      while($row = mysql_fetch_array($result)) { 
         for($i=0;$i<$iMatriz;$i++){
            $matrizAsoc[$j][$atributo[$i]] = $row[$atributo[$i]];
         }
      $j++;
      }
      return $matrizAsoc;
}else{
	return 0;
}
      }
   }
//-----------------------------------------------------------------------
   function tblformaspagoInsert( $formaPago) {
      $idFormaPago = $this->nuevo_id("tblformaspago", "idFormaPago");
      $cols = get_commas(false, 'idFormaPago', 'formaPago');
      $vals = get_commas(true, '!!'.$idFormaPago, $formaPago);
      $strSQL = get_insert('tblformaspago',$cols, $vals);
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblformaspagoUpdate($idFormaPago, $formaPago) {
         $strSQL = "UPDATE tblformaspago SET  formaPago = '$formaPago' WHERE  idFormaPago = $idFormaPago";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblformaspagoDelete($condicion) {
      $strSQL = "DELETE FROM tblformaspago WHERE $condicion";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblformaspagoRecords($condicion='1', $campoOrden = null, $orden='asc') {
        $strSQL = "SELECT * FROM tblformaspago WHERE $condicion";
        if($campoOrden!=null){
            $strSQL = $strSQL. " ORDER BY $campoOrden $orden";
        }
      $result = mysql_query($strSQL);
      if(!$result){
      return '';
      } else {
      $this->filas = $this->numRegistros('tblformaspago',$condicion);
      $this->campos = mysql_num_fields($result);
 if($this->filas!=0){
      $matriz = $this->atributos('tblformaspago');
      $iMatriz = count($matriz);  // Atributos de la entidad.
      $i=0;
      foreach($matriz as $v){ 
          $atributo[$i++] = $v['nombre']; 
      }
      $j=0; // Indice de la matriz.
      while($row = mysql_fetch_array($result)) { 
         for($i=0;$i<$iMatriz;$i++){
            $matrizAsoc[$j][$atributo[$i]] = $row[$atributo[$i]];
         }
      $j++;
      }
      return $matrizAsoc;
}else{
	return 0;
}
      }
   }
//-----------------------------------------------------------------------
   function tblmovimientosInsert( $fecha, $idOtrasAcciones, $tiendaOrigen, $tiendaDestino) {
      $idMovimientos = $this->nuevo_id("tblmovimientos", "idMovimientos");
      $cols = get_commas(false, 'idMovimientos', 'fecha', 'idOtrasAcciones', 'tiendaOrigen', 'tiendaDestino');
      $vals = get_commas(true, '!!'.$idMovimientos, $fecha, '!!'.$idOtrasAcciones, '!!'.$tiendaOrigen, '!!'.$tiendaDestino);
      $strSQL = get_insert('tblmovimientos',$cols, $vals);
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblmovimientosUpdate($idMovimientos, $fecha, $idOtrasAcciones, $tiendaOrigen, $tiendaDestino) {
         $strSQL = "UPDATE tblmovimientos SET  fecha = '$fecha',  idOtrasAcciones = $idOtrasAcciones,  tiendaOrigen = $tiendaOrigen,  tiendaDestino = $tiendaDestino WHERE  idMovimientos = $idMovimientos";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblmovimientosDelete($condicion) {
      $strSQL = "DELETE FROM tblmovimientos WHERE $condicion";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblmovimientosRecords($condicion='1', $campoOrden = null, $orden='asc') {
        $strSQL = "SELECT * FROM tblmovimientos WHERE $condicion";
        if($campoOrden!=null){
            $strSQL = $strSQL. " ORDER BY $campoOrden $orden";
        }
      $result = mysql_query($strSQL);
      if(!$result){
      return '';
      } else {
      $this->filas = $this->numRegistros('tblmovimientos',$condicion);
      $this->campos = mysql_num_fields($result);
 if($this->filas!=0){
      $matriz = $this->atributos('tblmovimientos');
      $iMatriz = count($matriz);  // Atributos de la entidad.
      $i=0;
      foreach($matriz as $v){ 
          $atributo[$i++] = $v['nombre']; 
      }
      $j=0; // Indice de la matriz.
      while($row = mysql_fetch_array($result)) { 
         for($i=0;$i<$iMatriz;$i++){
            $matrizAsoc[$j][$atributo[$i]] = $row[$atributo[$i]];
         }
      $j++;
      }
      return $matrizAsoc;
}else{
	return 0;
}
      }
   }
//-----------------------------------------------------------------------
   function tblotrasaccionesInsert( $accion) {
      $idOtrasAcciones = $this->nuevo_id("tblotrasacciones", "idOtrasAcciones");
      $cols = get_commas(false, 'idOtrasAcciones', 'accion');
      $vals = get_commas(true, '!!'.$idOtrasAcciones, $accion);
      $strSQL = get_insert('tblotrasacciones',$cols, $vals);
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblotrasaccionesUpdate($idOtrasAcciones, $accion) {
         $strSQL = "UPDATE tblotrasacciones SET  accion = '$accion' WHERE  idOtrasAcciones = $idOtrasAcciones";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblotrasaccionesDelete($condicion) {
      $strSQL = "DELETE FROM tblotrasacciones WHERE $condicion";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblotrasaccionesRecords($condicion='1', $campoOrden = null, $orden='asc') {
        $strSQL = "SELECT * FROM tblotrasacciones WHERE $condicion";
        if($campoOrden!=null){
            $strSQL = $strSQL. " ORDER BY $campoOrden $orden";
        }
      $result = mysql_query($strSQL);
      if(!$result){
      return '';
      } else {
      $this->filas = $this->numRegistros('tblotrasacciones',$condicion);
      $this->campos = mysql_num_fields($result);
 if($this->filas!=0){
      $matriz = $this->atributos('tblotrasacciones');
      $iMatriz = count($matriz);  // Atributos de la entidad.
      $i=0;
      foreach($matriz as $v){ 
          $atributo[$i++] = $v['nombre']; 
      }
      $j=0; // Indice de la matriz.
      while($row = mysql_fetch_array($result)) { 
         for($i=0;$i<$iMatriz;$i++){
            $matrizAsoc[$j][$atributo[$i]] = $row[$atributo[$i]];
         }
      $j++;
      }
      return $matrizAsoc;
}else{
	return 0;
}
      }
   }
//-----------------------------------------------------------------------
   function tblpagosInsert( $idFactura, $fecha, $referencia, $monto, $confirmado) {
      $idPago = $this->nuevo_id("tblpagos", "idPago");
      $cols = get_commas(false, 'idPago', 'idFactura',  'fecha', 'referencia','monto', 'confirmado');
      $vals = get_commas(true, '!!'.$idPago, '!!'.$idFactura, $fecha, $referencia, '!!'.$monto, $confirmado);
      $strSQL = get_insert('tblpagos',$cols, $vals);
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblpagosUpdate($idPago, $idFactura, $fecha, $referencia, $monto, $confirmado) {
         $strSQL = "UPDATE tblpagos SET  idFactura = $idFactura,  idFormaPago = $idFormaPago,  fecha = '$fecha',  monto = $monto,  confirmado = '$confirmado', referencia='$referencia' WHERE  idPago = $idPago";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblpagosDelete($condicion) {
      $strSQL = "DELETE FROM tblpagos WHERE $condicion";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      	return true;
   	  }
   }
//-----------------------------------------------------------------------
   function tblpagosRecords($condicion='1', $campoOrden = null, $orden='asc') {
        $strSQL = "SELECT * FROM tblpagos WHERE $condicion";
        if($campoOrden!=null){
            $strSQL = $strSQL. " ORDER BY $campoOrden $orden";
        }
      $result = mysql_query($strSQL);
      if(!$result){
      return '';
      } else {
      $this->filas = $this->numRegistros('tblpagos',$condicion);
      $this->campos = mysql_num_fields($result);
 if($this->filas!=0){
      $matriz = $this->atributos('tblpagos');
      $iMatriz = count($matriz);  // Atributos de la entidad.
      $i=0;
      foreach($matriz as $v){ 
          $atributo[$i++] = $v['nombre']; 
      }
      $j=0; // Indice de la matriz.
      while($row = mysql_fetch_array($result)) { 
         for($i=0;$i<$iMatriz;$i++){
            $matrizAsoc[$j][$atributo[$i]] = $row[$atributo[$i]];
         }
      $j++;
      }
      return $matrizAsoc;
}else{
	return 0;
}
      }
   }
//-----------------------------------------------------------------------
   function tblpiezasInsert( $idproducto, $cantidad, $tblMovimientos_idMovimientos) {
      $idPiezas = $this->nuevo_id("tblpiezas", "idPiezas");
      $cols = get_commas(false, 'idPiezas', 'idproducto', 'cantidad', 'tblMovimientos_idMovimientos');
      $vals = get_commas(true, '!!'.$idPiezas, '!!'.$idproducto, '!!'.$cantidad, '!!'.$tblMovimientos_idMovimientos);
      $strSQL = get_insert('tblpiezas',$cols, $vals);
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblpiezasUpdate($idPiezas, $idproducto, $cantidad, $tblMovimientos_idMovimientos) {
         $strSQL = "UPDATE tblpiezas SET  idproducto = $idproducto,  cantidad = $cantidad,  tblMovimientos_idMovimientos = $tblMovimientos_idMovimientos WHERE  idPiezas = $idPiezas";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblpiezasDelete($condicion) {
      $strSQL = "DELETE FROM tblpiezas WHERE $condicion";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblpiezasRecords($condicion='1', $campoOrden = null, $orden='asc') {
        $strSQL = "SELECT * FROM tblpiezas WHERE $condicion";
        if($campoOrden!=null){
            $strSQL = $strSQL. " ORDER BY $campoOrden $orden";
        }
      $result = mysql_query($strSQL);
      if(!$result){
      return '';
      } else {
      $this->filas = $this->numRegistros('tblpiezas',$condicion);
      $this->campos = mysql_num_fields($result);
 if($this->filas!=0){
      $matriz = $this->atributos('tblpiezas');
      $iMatriz = count($matriz);  // Atributos de la entidad.
      $i=0;
      foreach($matriz as $v){ 
          $atributo[$i++] = $v['nombre']; 
      }
      $j=0; // Indice de la matriz.
      while($row = mysql_fetch_array($result)) { 
         for($i=0;$i<$iMatriz;$i++){
            $matrizAsoc[$j][$atributo[$i]] = $row[$atributo[$i]];
         }
      $j++;
      }
      return $matrizAsoc;
}else{
	return 0;
}
      }
   }
//-----------------------------------------------------------------------
   function tblproductosInsert( $producto) {
      $idproducto = $this->nuevo_id("tblproductos", "idproducto");
      $cols = get_commas(false, 'idproducto', 'producto');
      $producto = utf8_decode($producto);
      $vals = get_commas(true, '!!'.$idproducto, $producto);
      $strSQL = get_insert('tblproductos',$cols, $vals);
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblproductosUpdate($idproducto, $producto) {
   		$producto = utf8_decode($producto);
        $strSQL = "UPDATE tblproductos SET  producto = '$producto' WHERE  idproducto = $idproducto";
      	$result = mysql_query($strSQL);
      	if(!$result){
      		return false;
      	}else {
      		return true;
   		}
   }
//-----------------------------------------------------------------------
   function tblproductosDelete($condicion) {
      $strSQL = "DELETE FROM tblproductos WHERE $condicion";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblproductosRecords($condicion='1', $campoOrden = null, $orden='asc') {
        $strSQL = "SELECT * FROM tblproductos WHERE $condicion";
        if($campoOrden!=null){
            $strSQL = $strSQL. " ORDER BY $campoOrden $orden";
        }
      $result = mysql_query($strSQL);
      if(!$result){
      return '';
      } else {
      $this->filas = $this->numRegistros('tblproductos',$condicion);
      $this->campos = mysql_num_fields($result);
 if($this->filas!=0){
      $matriz = $this->atributos('tblproductos');
      $iMatriz = count($matriz);  // Atributos de la entidad.
      $i=0;
      foreach($matriz as $v){ 
          $atributo[$i++] = $v['nombre']; 
      }
      $j=0; // Indice de la matriz.
      while($row = mysql_fetch_array($result)) { 
         for($i=0;$i<$iMatriz;$i++){
            $matrizAsoc[$j][$atributo[$i]] = $row[$atributo[$i]];
         }
      $j++;
      }
      return $matrizAsoc;
}else{
	return 0;
}
      }
   }
//-----------------------------------------------------------------------
   function tbltiendasInsert( $nombreTienda, $Responsable, $direccion, $telefono) {
      $idtblTienda = $this->nuevo_id("tbltiendas", "idtblTienda");
      $cols = get_commas(false, 'idtblTienda', 'nombreTienda', 'Responsable', 'direccion', 'telefono');
      $vals = get_commas(true, '!!'.$idtblTienda, $nombreTienda, $Responsable, $direccion, $telefono);
      $strSQL = get_insert('tbltiendas',$cols, $vals);
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tbltiendasUpdate($idtblTienda, $nombreTienda, $Responsable, $direccion, $telefono) {
         $strSQL = "UPDATE tbltiendas SET  nombreTienda = '$nombreTienda',  Responsable = '$Responsable',  direccion = '$direccion',  telefono = '$telefono' WHERE  idtblTienda = $idtblTienda";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tbltiendasDelete($condicion) {
      $strSQL = "DELETE FROM tbltiendas WHERE $condicion";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tbltiendasRecords($condicion='1', $campoOrden = null, $orden='asc') {
        $strSQL = "SELECT * FROM tbltiendas WHERE $condicion";
        if($campoOrden!=null){
            $strSQL = $strSQL. " ORDER BY $campoOrden $orden";
        }
      $result = mysql_query($strSQL);
      if(!$result){
      return '';
      } else {
      $this->filas = $this->numRegistros('tbltiendas',$condicion);
      $this->campos = mysql_num_fields($result);
 if($this->filas!=0){
      $matriz = $this->atributos('tbltiendas');
      $iMatriz = count($matriz);  // Atributos de la entidad.
      $i=0;
      foreach($matriz as $v){ 
          $atributo[$i++] = $v['nombre']; 
      }
      $j=0; // Indice de la matriz.
      while($row = mysql_fetch_array($result)) { 
         for($i=0;$i<$iMatriz;$i++){
            $matrizAsoc[$j][$atributo[$i]] = $row[$atributo[$i]];
         }
      $j++;
      }
      return $matrizAsoc;
}else{
	return 0;
}
      }
   }
//-----------------------------------------------------------------------
   function tblusuariosInsert( $usuario, $clave) {
   	  $clave = md5($clave);
      $idUsuario = $this->nuevo_id("tblusuarios", "idUsuario");
      $cols = get_commas(false, 'idUsuario', 'usuario', 'clave');
      $vals = get_commas(true, '!!'.$idUsuario, $usuario, $clave);
      $strSQL = get_insert('tblusuarios',$cols, $vals);
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblusuariosUpdate($idUsuario, $usuario, $clave) {
   		$clave = md5($clave);
        $strSQL = "UPDATE tblusuarios SET  usuario = '$usuario',  clave = '$clave' WHERE  idUsuario = $idUsuario";
      	$result = mysql_query($strSQL);
      	if(!$result){
      		return false;
      	} else {
      	return true;
   }
   }
//-----------------------------------------------------------------------
   function tblusuariosDelete($condicion) {
      $strSQL = "DELETE FROM tblusuarios WHERE $condicion";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblusuariosRecords($condicion='1', $campoOrden = null, $orden='asc') {
        $strSQL = "SELECT * FROM tblusuarios WHERE $condicion";
        if($campoOrden!=null){
            $strSQL = $strSQL. " ORDER BY $campoOrden $orden";
        }
      $result = mysql_query($strSQL);
      if(!$result){
      return '';
      } else {
      $this->filas = $this->numRegistros('tblusuarios',$condicion);
      $this->campos = mysql_num_fields($result);
 if($this->filas!=0){
      $matriz = $this->atributos('tblusuarios');
      $iMatriz = count($matriz);  // Atributos de la entidad.
      $i=0;
      foreach($matriz as $v){ 
          $atributo[$i++] = $v['nombre']; 
      }
      $j=0; // Indice de la matriz.
      while($row = mysql_fetch_array($result)) { 
         for($i=0;$i<$iMatriz;$i++){
            $matrizAsoc[$j][$atributo[$i]] = $row[$atributo[$i]];
         }
      $j++;
      }
      return $matrizAsoc;
}else{
	return 0;
}
      }
   }

//-----------------------------------------------------------------------
   function tblopcionesInsert( $opciones) {
      $idopciones = $this->nuevo_id("tblopciones", "idOpciones");
      $cols = get_commas(false, 'idOpciones', 'opcion');
      $vals = get_commas(true, '!!'.$idopciones, $opciones);
      $strSQL = get_insert('tblOpciones',$cols, $vals);
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblopcionesUpdate($idopciones, $opcion) {
         $strSQL = "UPDATE tblOpciones SET  opcion = '$opcion' WHERE idOpciones = $idopciones";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblopcionesDelete($condicion) {
      $strSQL = "DELETE FROM tblOpciones WHERE $condicion";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblopcionesRecords($condicion='1', $campoOrden = null, $orden='asc') {
        $strSQL = "SELECT * FROM tblOpciones WHERE $condicion";
        if($campoOrden!=null){
            $strSQL = $strSQL. " ORDER BY $campoOrden $orden";
        }
      $result = mysql_query($strSQL);
      if(!$result){
      return '';
      } else {
      $this->filas = $this->numRegistros('tblOpciones',$condicion);
      $this->campos = mysql_num_fields($result);
 if($this->filas!=0){
      $matriz = $this->atributos('tblOpciones');
      $iMatriz = count($matriz);  // Atributos de la entidad.
      $i=0;
      foreach($matriz as $v){ 
          $atributo[$i++] = $v['nombre']; 
      }
      $j=0; // Indice de la matriz.
      while($row = mysql_fetch_array($result)) { 
         for($i=0;$i<$iMatriz;$i++){
            $matrizAsoc[$j][$atributo[$i]] = $row[$atributo[$i]];
         }
      $j++;
      }
      return $matrizAsoc;
}else{
	return 0;
}
      }
   }
//-----------------------------------------------------------------------
   function tblbancosInsert( $banco, $tipo_cuenta, $num_cuenta) {
      $idBanco = $this->nuevo_id("tblbancos", "idBanco");
      $cols = get_commas(false, 'idBanco', 'banco', 'tipo_cuenta', 'num_cuenta');
      $vals = get_commas(true, '!!'.$idBanco, $banco, $tipo_cuenta, $num_cuenta);
      $strSQL = get_insert('tblbancos',$cols, $vals);
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblbancosUpdate($idBanco, $banco, $tipo_cuenta, $num_cuenta) {
         $strSQL = "UPDATE tblbancos SET  banco = '$banco',  tipo_cuenta = '$tipo_cuenta',  num_cuenta = '$num_cuenta' WHERE  idBanco = $idBanco";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblbancosDelete($condicion) {
      $strSQL = "DELETE FROM tblbancos WHERE $condicion";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblbancosRecords($condicion='1', $campoOrden = null, $orden='asc') {
        $strSQL = "SELECT * FROM tblbancos WHERE $condicion";
        if($campoOrden!=null){
            $strSQL = $strSQL. " ORDER BY $campoOrden $orden";
        }
      $result = mysql_query($strSQL);
      if(!$result){
      return '';
      } else {
      $this->filas = $this->numRegistros('tblbancos',$condicion);
      $this->campos = mysql_num_fields($result);
 if($this->filas!=0){
      $matriz = $this->atributos('tblbancos');
      $iMatriz = count($matriz);  // Atributos de la entidad.
      $i=0;
      foreach($matriz as $v){ 
          $atributo[$i++] = $v['nombre']; 
      }
      $j=0; // Indice de la matriz.
      while($row = mysql_fetch_array($result)) { 
         for($i=0;$i<$iMatriz;$i++){
            $matrizAsoc[$j][$atributo[$i]] = $row[$atributo[$i]];
         }
      $j++;
      }
      return $matrizAsoc;
}else{
	return 0;
}
      }
   }
//-----------------------------------------------------------------------
   function tblcontrolingresosInsert( $idtblTienda, $fecha, $comentario) {
      $idcontrol = $this->nuevo_id("tblcontrolingresos", "idcontrol");
      $cols = get_commas(false, 'idcontrol', 'idtblTienda', 'fecha', 'comentario');
      $vals = get_commas(true, '!!'.$idcontrol, '!!'.$idtblTienda, $fecha, $comentario);
      $strSQL = get_insert('tblcontrolingresos',$cols, $vals);
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblcontrolingresosUpdate($idcontrol, $idtblTienda, $fecha, $comentario) {
         $strSQL = "UPDATE tblcontrolingresos SET  fecha = '$fecha',  comentario = '$comentario', idtblTienda = $idtblTienda WHERE  idcontrol = $idcontrol";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblcontrolingresosDelete($condicion) {
      $strSQL = "DELETE FROM tblcontrolingresos WHERE $condicion";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblcontrolingresosRecords($condicion='1', $campoOrden = null, $orden='asc') {
        $strSQL = "SELECT * FROM tblcontrolingresos WHERE $condicion";
        if($campoOrden!=null){
            $strSQL = $strSQL. " ORDER BY $campoOrden $orden";
        }
      $result = mysql_query($strSQL);
      if(!$result){
      return '';
      } else {
      $this->filas = $this->numRegistros('tblcontrolingresos',$condicion);
      $this->campos = mysql_num_fields($result);
 if($this->filas!=0){
      $matriz = $this->atributos('tblcontrolingresos');
      $iMatriz = count($matriz);  // Atributos de la entidad.
      $i=0;
      foreach($matriz as $v){ 
          $atributo[$i++] = $v['nombre']; 
      }
      $j=0; // Indice de la matriz.
      while($row = mysql_fetch_array($result)) { 
         for($i=0;$i<$iMatriz;$i++){
            $matrizAsoc[$j][$atributo[$i]] = $row[$atributo[$i]];
         }
      $j++;
      }
      return $matrizAsoc;
}else{
	return 0;
}
      }
   }
//-----------------------------------------------------------------------
   function tblingresosInsert( $idBanco, $idtipomovimiento, $idcontrol, $monto) {
      $idingresos = $this->nuevo_id("tblingresos", "idingresos");
      $cols = get_commas(false, 'idingresos', 'idBanco', 'idtipomovimiento', 'idcontrol', 'montoIngreso');
      $vals = get_commas(true, '!!'.$idingresos, '!!'.$idBanco, '!!'.$idtipomovimiento, '!!'.$idcontrol, '!!'.$monto);
      $strSQL = get_insert('tblingresos',$cols, $vals);
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblingresosUpdate($idtipomovimiento, $idcontrol) {
         $strSQL = "UPDATE tblingresos SET  idcontrol = $idcontrol WHERE  idtipomovimiento = $idtipomovimiento";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblingresosDelete($condicion) {
      $strSQL = "DELETE FROM tblingresos WHERE $condicion";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tblingresosRecords($condicion='1', $campoOrden = null, $orden='asc') {
        $strSQL = "SELECT * FROM tblingresos WHERE $condicion";
        if($campoOrden!=null){
            $strSQL = $strSQL. " ORDER BY $campoOrden $orden";
        }
      $result = mysql_query($strSQL);
      if(!$result){
      return '';
      } else {
      $this->filas = $this->numRegistros('tblingresos',$condicion);
      $this->campos = mysql_num_fields($result);
 if($this->filas!=0){
      $matriz = $this->atributos('tblingresos');
      $iMatriz = count($matriz);  // Atributos de la entidad.
      $i=0;
      foreach($matriz as $v){ 
          $atributo[$i++] = $v['nombre']; 
      }
      $j=0; // Indice de la matriz.
      while($row = mysql_fetch_array($result)) { 
         for($i=0;$i<$iMatriz;$i++){
            $matrizAsoc[$j][$atributo[$i]] = $row[$atributo[$i]];
         }
      $j++;
      }
      return $matrizAsoc;
}else{
	return 0;
}
      }
   }
//-----------------------------------------------------------------------
   function tbltipomovbanInsert( $movimiento_bancario) {
      $idtipomovimiento = $this->nuevo_id("tbltipomovban", "idtipomovimiento");
      $cols = get_commas(false, 'idtipomovimiento', 'movimiento_bancario');
      $vals = get_commas(true, '!!'.$idtipomovimiento, $movimiento_bancario);
      $strSQL = get_insert('tbltipomovban',$cols, $vals);
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tbltipomovbanUpdate($idtipomovimiento, $movimiento_bancario) {
         $strSQL = "UPDATE tbltipomovban SET  movimiento_bancario = '$movimiento_bancario' WHERE  idtipomovimiento = $idtipomovimiento";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tbltipomovbanDelete($condicion) {
      $strSQL = "DELETE FROM tbltipomovban WHERE $condicion";
      $result = mysql_query($strSQL);
      if(!$result){
      return false;
      } else {
      return true;
   }
   }
//-----------------------------------------------------------------------
   function tbltipomovbanRecords($condicion='1', $campoOrden = null, $orden='asc') {
        $strSQL = "SELECT * FROM tbltipomovban WHERE $condicion";
        if($campoOrden!=null){
            $strSQL = $strSQL. " ORDER BY $campoOrden $orden";
        }
      $result = mysql_query($strSQL);
      if(!$result){
      return '';
      } else {
      $this->filas = $this->numRegistros('tbltipomovban',$condicion);
      $this->campos = mysql_num_fields($result);
 if($this->filas!=0){
      $matriz = $this->atributos('tbltipomovban');
      $iMatriz = count($matriz);  // Atributos de la entidad.
      $i=0;
      foreach($matriz as $v){ 
          $atributo[$i++] = $v['nombre']; 
      }
      $j=0; // Indice de la matriz.
      while($row = mysql_fetch_array($result)) { 
         for($i=0;$i<$iMatriz;$i++){
            $matrizAsoc[$j][$atributo[$i]] = $row[$atributo[$i]];
         }
      $j++;
      }
      return $matrizAsoc;
}else{
	return 0;
}
      }
   }
//-----------------------------------------------------------------------
}
?>