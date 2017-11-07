<?php

/**********************************************************************
*  PHP Perfect SQL v1.0	                    by Jose Carlos García Neila
* ----------------------------------------------------------------------
*  Realiza consultas SQL sin preocuparte de su sintaxis
*   · Para más información se acompañana documentación en PDF
*
*  Modifique el código a su gusto si lo desea y distribuyalo sin problema
*  ninguno, aunque si le pediría que incluya intacto este encabezado.
* 
*  http://www.distintiva.com/jose/_perf_sql
************************************************************************/



//------ Funciones de abstraccion de consultas SQL ---------------------

//-INSERT- $columns=get_commas(...)   $values=get_commas(...)
function get_insert($table, $columns, $values){
	return "INSERT INTO $table ($columns) VALUES ($values)";
}

//-UPDATE- $values=get_mult_set(...)   $where=get_mult_set(...) o get_simp_set(...)
function get_update($table, $values, $where){
	return "UPDATE $table SET $values WHERE $where";
}

//-UPDATE- actualiza una tabla con valores de otra (sólo MySQL >4.xx)
function get_update_join($table_a, $table_b, $id_a, $id_b, $values, $where=''){
	if($where!='')	$where="AND ($where)";
	return "UPDATE $table_a a, $table_b b SET $values WHERE a.$id_a=b.$id_b $where";
}

//-SELECT- $columns=get_commas(...) o '*'   $where=get_mult_set(...) o get_simp_set(...)
function get_select($table, $columns, $where='', $order=''){
	$tmp = "SELECT $columns FROM $table";
	if($where!=''){
		$tmp.=" WHERE $where";
	}
	if($order!=''){
		$tmp.=" ORDER BY $where";
	}
	return $tmp;
}

//-SELECT- entre 2 tablas por 2 indices comunes
function get_select_join($table_a, $table_b, $id_a, $id_b, $columns, $where='', $order=''){
	$table ="$table_a a, $table_b b";
	$w="a.$id_a=b.$id_b ";
	if($where!='')	$w.="AND ($where)";
	return get_select($table, $columns, $w, $order);
}


//-DELETE-  $where=get_mult_set(...) o get_simp_set(...)
function get_delete($table, $where=''){
	$tmp = "DELETE FROM $table";
	if($where!=''){
		$tmp.=" WHERE $where";
	}
	return $tmp;
}
//- get_commas(true|false, 1, 2, 4...) true pone comillas  => '1','2','4'...
function get_commas(){
	$a=func_get_args();
	$com = $a[0];
	return get_commasA(array_slice($a, 1, count($a)-1), $com);
}
//- como la anterior pero devuelve entre comas el array pasado
function get_commasA($arr_in, $comillas=true){
	$temp='';
	$coma="'";
	if(!$comillas) $coma=''; //-el 1er param==true, metemos comas

	foreach($arr_in as $arg){
	   if($temp!='')  $temp.=","; 
	   if(substr($arg,0,2)=='!!'){ //- Si empieza por !! no le pongo comas...
			$temp.=substr($arg,2); continue;
	   }
	   $temp.="$coma".$arg."$coma";
	}
	return $temp;
}

//- Devuelve una asignacion (por defecto) simple entre comillas  X='1' 
function get_simp_set($col, $val, $sign='=', $comillas=true){
	$cm="'";
	if(!$comillas) $cm='';
	if(substr($val,0,2)=='!!'){ //- Si empieza por !! no le pongo comas...
		$val=substr($val,2); $cm='';
	}
	return $col."$sign $cm".$val."$cm";
}

//-Mezcla cada valor de $a_cols, con uno de $a_vals   "X='1', T='2'...
//- ej:  con $simb='or'  X='1' or T='2'...
//- ej:  con $sign='>'   X>'1' or T>'2'...
function get_mult_set($a_cols, $a_vals, $simb=',', $sign='=', $comillas=true){
	$temp='';
	for($x=0;$x<count($a_cols);$x++){
		if($temp!='')  $temp.=" $simb ";
	   $temp.= get_simp_set($a_cols[$x],$a_vals[$x], $sign, $comillas);
	}
	return $temp;
}

function get_between($col, $min, $max){
	return "($col BETWEEN $min AND $max)";
}


?>