/* PARA EL EMPLEO DEL AUTOCOMPETADO SE REQUIERE DE:
	1. Del archivo de estilos: awesomplete.css 
	2. EL ARCHIVO PHP fncauto.php quien carga el vector de datos y los envia a javascript,
	3. de la libreria javaScript lockr.min.js (Para transferencia de vector de datos de php a javascript)
   	4. De los archivos  de awesomplete los cuales son awesomplete.min.js y 
   	5. index.js.  
*/
function autocompleta(){
	var beneficiarios = Lockr.get('beneficiarios');
	var pagadores = Lockr.get('pagadores');
	
	var input = document.getElementById("beneficiarios");
	new Awesomplete(input, {
		list: beneficiarios,
		autoFirst: true
	});

	var txtpagadores = document.getElementById("pagadores");
	new Awesomplete(txtpagadores, {
		list: pagadores,
		autoFirst: true
	});
}		

function activarAuto(){
		//xajax_asignarConXajax('pagina','innerHTML','CLS_COMPROBANTES','frmcomprobantes'); /* CARGAR FORMULARIO DINAMICAMENTE*/
		xajax_autocompletar();		/*   LLAMADA A LA FUNCION PARA LLENAR Y TRANSFERIR LOS ARREGLOS DEL AUTOCOMPLETADO */
		window.setTimeout("autocompleta()", 500);	//Espera de medio segundo antes de ejecutar la funcion autocompleta. 
}		