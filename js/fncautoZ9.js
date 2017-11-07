$ = Awesomplete.$;
$$ = Awesomplete.$$;

document.addEventListener("DOMContentLoaded", function() {
	var nav = $("nav")
	$$("section > h1").forEach(function (h1) {
		if (h1.parentNode.id) {
			$.create("a", {
				href: "#" + h1.parentNode.id,
				textContent: h1.textContent.replace(/\(.+?\)/g, ""),
				inside: nav
			});
		}
	});
});

function cargar_autocompletar(){
/*	Esta funcion toma los vectores construidos en fncatoZ9.php
	y asigna los eventos de autocompletado a los campos de texto
	identificados con los IDs beneficiario y pagadores. 
*/	
	xajax_autocompletar();
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
// SE ASIGNA EL FOCO AL PRIMER CAMPO DE TEXTO DEL FORMULARIO ACTIVO.
  	$("form:not(.filter) :input:visible:enabled:first").focus();
}
