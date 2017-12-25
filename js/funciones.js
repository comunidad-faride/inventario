//==================================================================================================
// Anula la entrada de datos en varias columnas de la matriz
	function anularFila(valor, id){
		var fila = id.substring(0, 2);
		var col = "C";
		if(valor=="SI"){
			var activado = false;
			var fondo = "#ffffff";
		}else{
			var activado = true;
			var fondo = '#b8aea7';
		}	
		var item;
		for(i = 5; i <= 10; i++){
			item = fila +"C"+i;
			document.getElementById(item).disabled = activado;
			document.getElementById(item).style.background = fondo;
		}
		return false;
	}	
//==================================================================================================	
	//	Solo admite números reales hasta dos decimales con coma de separador.	
	function NumCheck(e, field, enteros, decimales) {
	// enteros y decimales son argumentos predefinidos.
	  /*var enteros = enteros || ( enteros = 6 ); 	
	  var decimales = decimales || ( decimales = 2);*/
	  key = e.keyCode ? e.keyCode : e.which;
	  cadena = field.value;
	  // backspace,  movimientos izquierda, derecha y salto de tabulacion
	  if (key == 8 || key == 37 || key == 39 || key == 9) return true;
	  if(decimales == 0 && key == 44) return false;
	  
	  // +-  Adminte uno de los dos caracteres al principio de la cadena.
	  if(key == 43 || key == 45){
	  	signo = String.fromCharCode(key);
	  	if(cadena.charAt(0) == "+" || cadena.charAt(0) == "-"){
	  		return false;	
	  	}else{
	  		return signo + (cadena);
	  	}
	  }
	  // 0-9
	  if (key > 47 && key < 58) {
	  	  var n = cadena.indexOf(",");
	  	  var long = cadena.length;
	  	  if(n >= 0){
	  	  	if(long - n == decimales + 1){
	  	  		return false;
	  	  	}else{
	  	  		return true;	
	  	  	}
	  	  }else{
	  	  	if(cadena.charAt(0) == "+" || cadena.charAt(0) == "-"){
	  	  		enteros = enteros + 1;
	  	  	}	
	  	  	if(long <= enteros){
	  	  			return true;
	  	  		}else{
	  	  			return false;
	  	  		}
	  	  }
	  }
	  // Admite solo una coma
	  if(key == 44 && decimales > 0){
	  	if(cadena.length == 0) return false;
	  	if(cadena.indexOf(",")<0)return true;
	  }
	  // other key
	  return false
	}
//==================================================================================================	
	
function esp2ing(valorEspanol){
	if(valorEspanol.lenght == 0){
		valorEspanol = "";	
	}else{
		if(valorEspanol.search(".") > -1) valorEspanol = replaceAll(valorEspanol, ".", "" );
		if(valorEspanol.search(",") > -1) valorEspanol = valorEspanol.replace(",", ".");
	}	
	return  Number(valorEspanol);	
}
//==================================================================================================	
	function ing2esp(valorIngles, decimales){
		var nuevoValor;
		if(decimales == 0){
			var valor = Math.ceil(valorIngles);
			nuevoValor = valor.toLocaleString('de-DE');		
		}else{
			var dec;
			if(Math.ceil(valorIngles) == valorIngles){
				dec = ",00";	
			}else{
				if(Math.ceil(valorIngles * 10) == valorIngles * 10){
					dec = "0";	
				} else {
					dec = "";
				}
			}
			nuevoValor =  valorIngles.toLocaleString('de-DE');
			nuevoValor = nuevoValor + dec;
		}
		return nuevoValor;
	}
//----------------------------------------------------------------------------------------------------------
/**
*Convierte un string numérico de formato 
*
*@param 	string  $name		Nombre del objeto SELECT
*@param 	array 	$arrTxt		Elemento oculto que sera tomado al seleccionar un elemento del SELECT
*@param 	array 	$arrVals	Texto a mostrar del  elemento del SELECT
*@param 	string 	$default	Texto seleccionado por defecto del objeto SELECT
*@param 	string 	$extraTag 	String que contendrᠰropiedades adicionales del objeto Select.
* @return SELECT
*/
//----------------------------------------------------------------------------------------------------------
	function formatear(valor, dec){
		valor = esp2ing(valor);
		return ing2esp(valor, dec);
	}
//==================================================================================================
function cambiarImagen() {
	if(document.getElementById("pdf").src == "http://localhost/parrot/imagenes/pdf.jpg"){
		document.getElementById("pdf").src = "imagenes/no_pdf.jpg";
		document.getElementById("idImprimir").value = "no imprimir";
	}else{
    	document.getElementById("pdf").src = "imagenes/pdf.jpg";
    	document.getElementById("idImprimir").value = "imprimir";
	}
}
//==================================================================================================
function ocultaCampo(valor){
	if(valor==1){
		document.getElementById('formar').style.display="none";
		document.getElementById('numfact').style.display="block";
	}else{
		document.getElementById('formar').style.display="block";
		document.getElementById('numfact').style.display="none";
	}
}
//==================================================================================================
//  Retorna el codigo de la tecla ingresada en algun campo de texto.  Ejemplo: if(enterCheck(event)==13)haga_algo();
function enterCheck(e) {
  key = e.keyCode ? e.keyCode : e.which
  return key
}
//==================================================================================================
// Funcion complementaria de los formularios reportes bancarios.
function activaFechas(indice){
	var capas = new Array("xDia","xMes","xFechas");
	var ids = new Array("rX0","rX1","rX2");
	for(i = 0; i <3 ; i++){
		if(indice == i){
			onOff(capas[i],"block");
			document.getElementById(ids[i]).style.fontWeight = "900";	
		}else{
			onOff(capas[i],"none");
			document.getElementById(ids[i]).style.fontWeight = "normal";
		}
	}

}
//==================================================================================================
function onOff(objeto, condicion){
	document.getElementById(objeto).style.display=condicion;
	//if(existeElementoHTML())
}
//==================================================================================================

function onOffCampos(valor){
	if(2 == valor ){
		onOff("id_Edificio", "none");
		onOff("id_piso", "none");
		document.getElementById("nombre_edificio").value="";	
		document.getElementById("piso").value="";	
	}else{
		onOff("id_Edificio", "block");
		onOff("id_piso", "block");
	}
}
//==================================================================================================
function totalizar(){
	var sumatoria = 0;
	var acumulador = 0;
	for(i = 1; i < 12 ; i++){
		var multiplicando = "precio" + i;
		var multiplicador = "cantidad" + i;
		if(existeElementoHTML(multiplicando) && existeElementoHTML(multiplicador)){
			var precioEsp = document.getElementById(multiplicando).value;
			var cantidadEsp = document.getElementById(multiplicador).value;
			var idproducto = "totalxProducto" + i;
			var cantidad = esp2ing(cantidadEsp);
			var precio = esp2ing(precioEsp); 
			if( precio != 0 && cantidad != 0 ){
				var subtotal = precio * cantidad;
				document.getElementById(idproducto).innerHTML = ing2esp(subtotal, 2);
				sumatoria += subtotal;
				acumulador += cantidad;
				var sumaPrecio = ing2esp(sumatoria, 2);
				document.getElementById("idSumaBs").innerHTML = sumaPrecio;			
				var producto = precio * cantidad;
				document.getElementById("idSumaProductos").innerHTML = ing2esp(acumulador, 0);
			}
		}
	}
	return true;
}
//==================================================================================================
//			FUNCIONES PARA PROCESAR FORMULARIO DE INGRESOS 
//==================================================================================================

function asignarEventos(nFilas, nCol){
	var id="";
	for(i = 0; i < nCol; i++){
		for(j = 0; j < nFilas; j++){
			id = "f"+j+"c"+i;
			//var elemento = document.getElementById(id) ;
			document.getElementById(id).addEventListener("keyup", function(){totalizarMatriz(nFilas, nCol)});
		/*	elemento.addEventListener("keypress", NumCheck(event, this, 12, 2));*/
		//	elemento
			document.getElementById(id).addEventListener("blur", function(){
				if(this.value != ""){
					this.value = formatear(this.value, 2);
				}
			});
							
		}
	}
}
//==================================================================================================
var totalizarMatriz = function(filas, columnas){
	var id="";
	var sumaFilas= new Array(filas);
	sumaFilas = blanquearArreglo(sumaFilas);
	var sumaCols= new Array(columnas);
	sumaCols = blanquearArreglo(sumaCols);
	var total = 0;
	var y;
	var txtFila;
	var txtCol;
	for(i=0; i<filas; i++){
		for(j = 0 ; j < columnas; j++){
			id = "f"+i+"c"+j;
			var x = document.getElementById(id).value;
			if(x != ""){
				y = esp2ing(x);
				sumaFilas[i] += y;
				sumaCols[j] += y;
				id = "total"+i;
				document.getElementById(id).value = ing2esp(sumaFilas[i], 2);
				id = "totales["+j+"]";
				document.getElementById(id).value = ing2esp(sumaCols[j], 2);
			}
		}
	}
}

//==================================================================================================
var blanquearArreglo = function(arreglo){
	var n = arreglo.length;
	for(i=0; i < n; i++){
		arreglo[i] = 0;
	}
	return arreglo;
}
//==================================================================================================
var sumar = function(){
	var acumulador = 0;
	var campo = "m";
	for(i = 0; i < 4; i++){
		var item = campo + i;
		var cantidad = document.getElementById(item).value;
		if(cantidad.search(",") > -1){
			cantidad = cantidad.replace();
		}
		acumulador += Number(cantidad);
	}
	var f_acumulador =  acumulador.toFixed(2);
	var x_acumulador = f_acumulador.replace(".", ",");
	document.getElementById("total").value = x_acumulador;
}
//==================================================================================================
var blanquear = function(){
	for(i = 1; i < 12; i++){
		var multiplicando = "precio" + i;
		var multiplicador = "cantidad" + i;
		var idproducto = "totalxProducto" + i;
		document.getElementById(multiplicando).value = "";	
		document.getElementById(multiplicador).value = "";	
		document.getElementById(idproducto).innerHTML = "";	
	}
	document.getElementById("idSumaBs").innerHTML = "";
	document.getElementById("idSumaProductos").innerHTML = "";
}
//==================================================================================================
//  FUNCION QUE AGREGA UNA NUEVA FILA AL FINAL DE LA TABLA IDENTIFICADA POR SU ID.
var validaCrearFila = function(x){
	var idCantidad = "cantidad"+x;
	var idPrecio = "precio"+x;
	var cantidad = document.getElementById(idCantidad).value;
	var precio = document.getElementById(idPrecio).value;
	if(cantidad == "0" || precio == "0,00"){
		return false;
	}else{
		return true;
	}
}
//==================================================================================================
function nuevaFila(idTabla){
	var tabla = document.getElementById(idTabla);
	var x = tabla.rows.length;
	var filaAnterior = x - 2;
	if( x == 13 ) return false;
	var y = validaCrearFila(filaAnterior);
	if( y == false){
		if(filaAnterior == 1){
			var idCantidad = "cantidad1";
		}else{
			var idCantidad = "cantidad" + filaAnterior;
		}
		document.getElementById(idCantidad).focus();
		return false;
	}
	var fila = tabla.insertRow(x-1);	
	var numFila = x - 1;
	fila.id ="fila" + numFila;
	//n = aIds.length;
	var y = new Array();
	for(i = 0; i < 5; i++){
		y[i] = fila.insertCell(i);
		y[i].id = "fila"+numFila+"col" + i;
		y[i].style.textAlign  = "center";
		y[i].innerHTML = "";
		if(i == 4){
			y[i].id = "totalxProducto" + numFila;
			y[i].style.textAlign  = "right";
			y[i].style.paddingRight  = "5px";// style="padding-left:5px;:5px;"
		}			
	}
	xajax_camposTabla(numFila);
}
//==================================================================================================
function activaAporte(valor){
	if(valor == 4){
		document.getElementById("idMonto").disabled=false;
		document.getElementById("idMonto").focus();
	}else{
		document.getElementById("idMonto").disabled=true;
	}
}
//==================================================================================================
function openWindow(name, url) {
	var height = screen.availHeight-30;
	var width = screen.availWidth-10;
	var left = 0;
	var top = 0;
	settings = 'fullscreen=no,resizable=yes,location=no,toolbar=no,menubar=no';
	settings = settings + ',status=no,directories=no,scrollbars=yes';
	settings = settings + ',width=' + width +',height=' + height;
	settings = settings + ',top=' + top +',left=' + left;
	settings = settings + ',charset=iso-8859-1';
	var win = window.open(url, "", settings);
	win.outerHeight = screen.availHeight;
	win.outerWidth = screen.availWidth;
	win.resizeTo(screen.availWidth, screen.availHeight);
	if (!win.focus)
	win.focus();
	return win;
}
//==================================================================================================
//  Funciones para quitar los campos de texto con ceros con sin coma.
function limpiaCeros(){
	var selectedTextBox = document.activeElement;
	suValor = selectedTextBox.value;
	if(suValor == "0" || suValor == "0,00"){
		suId = selectedTextBox.id;
		document.getElementById(suId).value="";
	}	
}

//==================================================================================================
function activarLimpiaCeros(){
	var entradas = document.getElementsByTagName("input");
	var n = entradas.length;
	for(i = 0; i < n; i++){
		document.getElementsByTagName("input")[i].addEventListener("focus", limpiaCeros, true);
	}
}
//==================================================================================================
function  muestraFila(valor){
	var siguiente = valor +1;
	var id = "f"+siguiente;
	var celda = "id"+valor;
	document.getElementById(id).style.display = "block";
	document.getElementById(celda).innerHTML = "";
	return true;
}
//==================================================================================================
function activaPluss(valor){
	var idReferencia = "idReferencia"+valor;
	var idMonto = "idMonto"+valor;
	var id = "acc"+valor;
	var monto = document.getElementById(idMonto).value;
	var referencia = document.getElementById(idReferencia).value;
	if(monto != "" && referencia != 0){
		//document.getElementBy().style.display = "block";

	}
}
//==================================================================================================
function replaceAll( text, busca, reemplaza ){
  while (text.toString().indexOf(busca) != -1)
      text = text.toString().replace(busca,reemplaza);
  return text;
}
//==================================================================================================
function sumaPagos(){
	var suma = 0;
	var y;
	for(i = 0; i < 3; i++){
		var id = "idMonto"+i;
		if(existeElementoHTML(id)){
			var valor = document.getElementById(id).value;
			y = esp2ing(valor);
			suma += Number(y);
		}		
	}
	if(existeElementoHTML(id)){
		document.getElementById("txtSumaPagos").innerHTML = ing2esp(suma);
	}
}