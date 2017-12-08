var xModal = 0;
var formModal = "";
//*******************************************************************
function existeElementoHTML(idElemento){
   	var salida=false;
   	if(document.getElementById(idElemento)){
      salida=true;
    }
    return salida;
}
//*******************************************************************
function aviso(mensaje){ // Verde.  Bien hecho. Registro grabajo, borradado 
      //xModal=xModal+1;
      addModal('AVISO', mensaje, 'aviso',["Continuar"]);//
}
//*******************************************************************
function alerta(mensaje){ // Azul.  Carga de Formulario. 
      //xModal=xModal+1;
      addModal('ALERTA', mensaje, 'alerta',["Uno", "Dos"]);  
}
//*******************************************************************
function critical(mensaje){	// Rojo. Ej. Borrado de registro.
   	  //xModal=xModal+1;	
   	  
      addModal('CUIDADO', mensaje, 'critico', ["Borrar", "Seguir"]);  
      addModal( titulo, mensaje, clsTitulo, arBotones, strFuncion, arParametros)
}
//*******************************************************************
function informacion(mensaje){ // Naranja.  Equivalente al rojo.
    //  xModal=xModal+1;
      addModal('AVISO', mensaje, "critico", ["Continuar"]);  
}
//*******************************************************************
function modal(titulo, mensaje, funcion, args){
     // xModal=xModal+1;      
      addModal(titulo, mensaje, "alerta",["Si","No"],funcion, args);
     // addModal( titulo, mensaje, clsTitulo, arBotones, strFuncion, arParametros)
}
//*******************************************************************
function frmModal(titulo, formulario, funcion, argumentos){
	xModal++;
	addModal(titulo, formulario, "alerta", ["Grabar", "Salir"]);
}
//*******************************************************************
function cuantosDiv(){
    var x = 
        document.getElementsByTagName("DIV");
    var n = x.length;
    var c = 0;
    for(i=0;i<n;i++){
        var nombre = x[i].id;
        if( nombre.substr(0,11) == "fondo_modal"){
            c++;
        }
    }
    if(c==1){
        xModal=0;
    }
}
//*******************************************************************
function cerrarModal(xId){
        if(existeElementoHTML(xId)){ 
        	$("#"+xId).fadeOut(500, function(){
        		var x = document.getElementById(xId);
            	document.body.removeChild(x)
        	});          
        }
}
//*******************************************************************
// Agrega ventana Modal al HTML
//	titulo:		titulo de la ventana modal
//  mensaje:    Mensaje de la ventana modal
//	clsTitulo:  Nombre de la clase CSS que tendran el titulo y los botones. 
//				Asigna colores de texto y fondo.
//	arBotones:	Arreglo de textos de los botones. Usar notacion con corchetes. Ej. ["SI","NO"]
//	strFuncion:	Nombre de la funcion a ejecutar en el boton.
//	arParametros: Arreglo de argumentos de la funcion.  Notacion con corchetes.
//*******************************************************************
function addModal( titulo, mensaje, clsTitulo, arBotones, strFuncion, arParametros){
	arBotones  || (arBotones=0);
	strFuncion || (strFuncion='');
	arParametros || (arParametros='');
	var zIndex=100;
	xModal++;
	var zi = zIndex + xModal*10;
	//	Crea un forndo transparente para la ventana modal.
	var x=document.createElement("DIV");
	//alert("Punto de parada.");
	x.id="fondo_modal"+xModal;
	var xId = x.id;
	strModal = "fondo_modal"+xModal;
	x.className="fondo_modal";
	x.style="z-index:"+zi;
	//  Crea la capa modal.	
	var y=document.createElement("DIV");
	y.className="capa_modal";
	y.style="z-index:"+zi;
	//	Caracteristicas del titulo modal
	var mh = document.createElement("DIV");
	mh.addEventListener("click",function(){cerrarModal(xId);});
	mh.title="Cerrar Ventana";
	mh.className = "cabeza_modal "+clsTitulo;
	mh.innerHTML=titulo; 
	y.appendChild(mh);
	//  Caracteristicas del cuerpo modal
	var mb = document.createElement("div");
	mb.id="cuerpo_modal"+xModal;	//???
	mb.className="cuerpo_modal";
	mb.innerHTML = mensaje;
	mb.style.textAlign="center";
	mb.style = "display:flex;display:-webkit-flex;";
	y.appendChild(mb);
	//	Caracteristiacas del pie modal.	SE CREA DE SER NECESARIO.
	if(Array.isArray(arBotones)){
		var nBotones = arBotones.length;
		var mf = document.createElement("DIV");
		mf.className="pie_modal";
	//	Crear botones para el pie modal	
	//	Primer boton.  No necesariamente el de la izquierda.
		var btn1=document.createElement("button");
		btn1.className="boton_modal " + clsTitulo;
		var funcCall = strFuncion +  "("  + arParametross(arParametros) +  ");";
		if(strFuncion.substring(0,5) == "xajax"){ 
			if(strFuncion.substring(0,12) != "xajax_delete"){
				btn1.addEventListener("click", function(){eval(strFuncion)});
			// Almacena el nombre del formulario modal en una variable global.
				formModal =  xId;	
			}else{
				btn1.addEventListener("click", function(){eval(strFuncion), cerrarModal(xId);});
			}
		}else{
			btn1.addEventListener("click", function(){eval(funcCall), cerrarModal(xId);});						}
			btn1.innerHTML=arBotones[0];
		mf.appendChild(btn1);
		if(nBotones == 2){
		//  Segundo boton del pie modal
			var btn2=document.createElement("button");
			btn2.className="boton_modal " + clsTitulo;
			//btn2.id = "btn2"; 
			btn2.addEventListener("click", function() {cerrarModal(xId);});
			btn2.innerHTML=arBotones[1];
			mf.appendChild(btn2);				
		}
		y.appendChild(mf);	// oJO: SI ES NECESARIO
	}	
	//	Se agrega la capa modal al fondo modal.
		x.appendChild(y);
	// Se agregan todos los elementos al documento.
	document.body.appendChild(x);
	$("#"+xId).fadeOut(0);
	$("#"+xId).slideDown("slow");
}
//------------------------------------------------------------------------
//  Construye parametros para la funcion llamada.
//*************************************************************************
function arParametross(p){
    if(Array.isArray(p)){
       var strArgumento = ""; 
       var n = p.length;
       for(i = 0; i < n; i++){
            	strArgumento += "\""+p[i]+"\"";
            if(i < n-1){
                strArgumento += ",";
            }
        }       
    }else{
        strArgumento = "\""+p+"\"";   
    }
    return strArgumento;
}

function deleteRecord(CLASE, idRegistro){
	var strFuncion = "xajax_delete('"+CLASE+"',"+idRegistro+")";
	addModal("Borrar Registro", "&iquest;Realmente quiere borrar este registro?", "critico", ["Si", "No"],strFuncion);
}