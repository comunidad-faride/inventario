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
	  var enteros = enteros || ( enteros = 6 ); 	
	  var decimales = decimales || ( decimales = 2);
	  key = e.keyCode ? e.keyCode : e.which;
	  cadena = field.value
	  // backspace,  movimientos izquierda y derecha
	  if (key == 8 || key == 37 || key == 39) return true
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
	  	  		enteros = enteros + 1
	  	  	}	
	  	  	if(long <= enteros){
	  	  			return true;
	  	  		}else{
	  	  			return false;
	  	  		}
	  	  }
	  }
	  // Admite solo una coma
	  if(key == 44){
	  	if(cadena.length == 0) return false
	  	if(cadena.indexOf(",")<0)return true
	  }
	  // other key
	  return false
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
/*	switch(indice){
		case 1:
			document.getElementById(objetos[0]).focus();
			break;
		case 2:
			document.getElementById(objetos[2]).focus();
			break;
		case 3:
			document.getElementById(objetos[1]).focus();
			break;					
	}*/
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