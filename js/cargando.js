//   Este archivo debe ser cargado en el BODY del htm principal 
// Ej.:  <script type="text/javascript" src="./js/cargando.js"></script>
function muestra_cargando(){
  	//xajax.dom.create("capa_actualiza","div", "cargando");
  	//xajax.$('capa_cargando').innerHTML='<img src="./img/Boton_Cargando.gif" alt="cargando..."  border="0">';
  	//creaCapaCargando();
  	document.getElementById("cargando").style="display:flex";
}

function ocultar(){
	document.getElementById("cargando").style="display:none";
}

function creaCapaCargando(){
/*	             CAPA CARGANDO                  			*/	
	var y = document.createElement("div");
	y.style.margin = "auto";
	y.style.width = "100px";
	y.style.height= "100px";
	y.style.borderRadius = "50px";
	y.style.backgroundImage = "url(./img/cargando.gif)";
	y.style.zIndex = "1000";
/* 			CAPA cargando DE FONDO DE LA CAPA CARGANDO		*/	
	var x = document.createElement("div");
	x.id = "cargando";
	x.style.top = "0px";
	x.style.left = "0px";
	x.style.background = "rgba(25,0,25,.2)";
	x.style.width = "100%";
	x.style.height = "100vh";
	x.style.position = "absolute";
	x.style.display = "flex";	
	x.style.zIndex = "1000";
	x.appendChild(y);
	document.body.appendChild(x);	
}

creaCapaCargando();
xajax.callback.global.onResponseDelay = muestra_cargando();
xajax.callback.global.onComplete = ocultar();
