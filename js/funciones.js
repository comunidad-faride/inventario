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
	
	
	function esp2ing(valorEspanol){
		//var cantidad = document.getElementById(item).value;
		if(valorEspanol.search(".") > -1) valorEspanol = valorEspanol.replace(".", "");
		if(valorEspanol.search(",") > -1){
			valorEspanol = valorEspanol.replace(",", ".");
		}
		return  Number(valorEspanol);	
	}
	
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

	function formatear(valor, dec){
		valor = esp2ing(valor);
		return ing2esp(valor, dec);
	}

function cambiarImagen() {
	if(document.getElementById("pdf").src == "http://localhost/parrot/imagenes/pdf.jpg"){
		document.getElementById("pdf").src = "imagenes/no_pdf.jpg";
		document.getElementById("idImprimir").value = "no imprimir";
	}else{
    	document.getElementById("pdf").src = "imagenes/pdf.jpg";
    	document.getElementById("idImprimir").value = "imprimir";
	}
}

//  Retorna el codigo de la tecla ingresada en algun campo de texto.  Ejemplo: if(enterCheck(event)==13)haga_algo();
function enterCheck(e) {
  key = e.keyCode ? e.keyCode : e.which
  return key
}

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

function onOff(objeto, condicion){
	document.getElementById(objeto).style.display=condicion;
	//if(existeElementoHTML())
}


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

function totalizar(){
	var sumatoria = 0;
	var acumulador = 0;
	for(i = 1; i < 12 ; i++){
		var multiplicando = "precio" + i;
		var multiplicador = "cantidad" + i;
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
	return true;
}

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


