
try{if('undefined'==typeof xajax)
throw{name:'SequenceError',message:'Error: xajax core was not detected, debug module disabled.'}
if('undefined'==typeof xajax.debug)
xajax.debug={}
xajax.debug.workId='xajaxWork'+new Date().getTime();xajax.debug.windowSource='about:blank';xajax.debug.windowID='xajax_debug_'+xajax.debug.workId;if('undefined'==typeof xajax.debug.windowStyle)
xajax.debug.windowStyle=
'width=800,'+
'height=600,'+
'scrollbars=yes,'+
'resizable=yes,'+
'status=yes';if('undefined'==typeof xajax.debug.windowTemplate)
xajax.debug.windowTemplate=
'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'+
'<html><head>'+
'<title>SALIDA DE DEPURACION DE XAJAX</title>'+
'<style type="text/css">'+
'/* <![CDATA[ */'+
'.debugEntry { margin: 3px; padding: 3px; border-top: 1px solid #999999; } '+
'.debugDate { font-weight: bold; margin: 2px; } '+
'.debugText { margin: 2px; } '+
'.warningText { margin: 2px; font-weight: bold; } '+
'.errorText { margin: 2px; font-weight: bold; color: #ff7777; }'+
'/* ]]> */'+
'</style>'+
'</head><body>'+
'<h2>SALIDA DE DEPURACION DE XAJAX</h2>'+
'<div id="debugTag"></div>'+
'</body></html>';xajax.debug.text=[];
xajax.debug.text[100]='ADVERTENCIA: ';
xajax.debug.text[101]='ERROR: ';
xajax.debug.text[102]='MENSAJE DE DEPURACION XAJAX:\n';
xajax.debug.text[103]='...\n[RESPUESTA LARGA]\n...';
xajax.debug.text[104]='ENVIANDO PEDIDO';
xajax.debug.text[105]='EXPEDIDO [';
xajax.debug.text[106]=' bytes]';
xajax.debug.text[107]='LLAMANDO: ';
xajax.debug.text[108]='URI: ';
xajax.debug.text[109]='INICIANDO PEDIDO';
xajax.debug.text[110]='PROCESANDO PARAMETEROS [';
xajax.debug.text[111]=']';
xajax.debug.text[112]='SIN PARAMETEROS PARA PROCESAR';
xajax.debug.text[113]='PREPARANDO PEDIDO';
xajax.debug.text[114]='INICIANDO LLAMADA XAJAX (obsoleta: use xajax.request)';
xajax.debug.text[115]='INICIANDO LLAMADA XAJAX';
xajax.debug.text[116]='No hay procesador de respuesta disponible para procesar la respuesta desde el servidor.\n';
xajax.debug.text[117]='.\nCompruebe si hay mensajes de error desde el servidor.';
xajax.debug.text[118]='RECIBIDO [status: ';
xajax.debug.text[119]=', tamaño: ';
xajax.debug.text[120]=' bytes, tiempo: ';
xajax.debug.text[121]='ms]:\n';
xajax.debug.text[122]='El servidor retorna el estadus HTTP siguiente: ';
xajax.debug.text[123]='\nRECIBIDO:\n';
xajax.debug.text[124]='El servidor devolvió una redirección a:<br />';
xajax.debug.text[125]='HECHO [';
xajax.debug.text[126]='ms]';
xajax.debug.text[127]='INICIALIZACIÓN DE OBJETO DE SOLICITUD';
xajax.debug.exceptions=[];
xajax.debug.exceptions[10001]=' Respuesta XML Invalida: La respuesta contiene una etiqueta desconocida: {data}.';
xajax.debug.exceptions[10002]='GetRequestObject: XMLHttpRequest no está disponible, xajax está desabilitado.';
xajax.debug.exceptions[10003]='Sobrecarga de cola: No se puede agregar el objeto a la cola porque está lleno.';
xajax.debug.exceptions[10004]='Respuesta XML inválida: La respuesta contiene una etiqueta inesperada o texto: {data}.';
xajax.debug.exceptions[10005]='Solicitud URI no válida: Invalida or ausente URI; autodetecion fallida; Especifique uno explícitamente.';
xajax.debug.exceptions[10006]='Comando de respuesta no válido: Comando de respuesta mal formado recibido.';
xajax.debug.exceptions[10007]='Comando de respuesta no válido: El commando [{data}] no es conocido.';
xajax.debug.exceptions[10008]='El ElementO con ID [{data}] no se encuentra en el documento.';
xajax.debug.exceptions[10009]='Solicitud no válida: parámetro de nombre de función que falta.';
xajax.debug.exceptions[10010]='Petición no válida: parámetro de objeto de función que falta.';
xajax.debug.getExceptionText=function(e){if('undefined'!=typeof e.code){if('undefined'!=typeof xajax.debug.exceptions[e.code]){var msg=xajax.debug.exceptions[e.code];if('undefined'!=typeof e.data){msg.replace('{data}',e.data);}
return msg;}
}else if('undefined'!=typeof e.name){var msg=e.name;if('undefined'!=typeof e.message){msg+=': ';msg+=e.message;}
return msg;}
return 'An unknown error has occurred.';}
xajax.debug.writeMessage=function(text,prefix,cls){try{var xd=xajax.debug;if('undefined'==typeof xd.window||true==xd.window.closed){xd.window=window.open(xd.windowSource,xd.windowID,xd.windowStyle);if("about:blank"==xd.windowSource)
xd.window.document.write(xd.windowTemplate);}
var xdw=xd.window;var xdwd=xdw.document;if('undefined'==typeof prefix)
prefix='';if('undefined'==typeof cls)
cls='debugText';text=xajax.debug.prepareDebugText(text);var debugTag=xdwd.getElementById('debugTag');var debugEntry=xdwd.createElement('div');var debugDate=xdwd.createElement('span');var debugText=xdwd.createElement('pre');debugDate.innerHTML=new Date().toString();debugText.innerHTML=prefix+text;debugEntry.appendChild(debugDate);debugEntry.appendChild(debugText);debugTag.insertBefore(debugEntry,debugTag.firstChild);try{debugEntry.className='debugEntry';debugDate.className='debugDate';debugText.className=cls;}catch(e){}
}catch(e){if(text.length > 1000)text=text.substr(0,1000)+xajax.debug.text[102];alert(xajax.debug.text[102]+text);}
}
xajax.debug.prepareDebugText=function(text){try{text=text.replace(/&/g,'&amp;')
.replace(/</g,'&lt;')
.replace(/>/g,'&gt;')
.replace(/\n/g,'<br />');return text;}catch(e){xajax.debug.stringReplace=function(haystack,needle,newNeedle){var segments=haystack.split(needle);haystack='';for(var i=0;i < segments.length;++i){if(0!=i)
haystack+=newNeedle;haystack+=segments[i];}
return haystack;}
xajax.debug.prepareDebugText=function(text){text=xajax.debug.stringReplace(text,'&','&amp;');text=xajax.debug.stringReplace(text,'<','&lt;');text=xajax.debug.stringReplace(text,'>','&gt;');text=xajax.debug.stringReplace(text,'\n','<br />');return text;}
xajax.debug.prepareDebugText(text);}
}
xajax.debug.executeCommand=xajax.executeCommand;xajax.executeCommand=function(args){try{if('undefined'==typeof args.cmd)
throw{code:10006};if(false==xajax.command.handler.isRegistered(args))
throw{code:10007,data:args.cmd};return xajax.debug.executeCommand(args);}catch(e){var msg='ExecuteCommand (';if('undefined'!=typeof args.sequence){msg+='#';msg+=args.sequence;msg+=', ';}
if('undefined'!=typeof args.cmdFullName){msg+='"';msg+=args.cmdFullName;msg+='"';}
msg+='):\n';msg+=xajax.debug.getExceptionText(e);msg+='\n';xajax.debug.writeMessage(msg,xajax.debug.text[101],'errorText');}
return true;}
xajax.debug.parseAttributes=xajax.parseAttributes;xajax.parseAttributes=function(child,obj){try{xajax.debug.parseAttributes(child,obj);}catch(e){var msg='ParseAttributes:\n';msg+=xajax.debug.getExceptionText(e);msg+='\n';xajax.debug.writeMessage(msg,xajax.debug.text[101],'errorText');}
}
xajax.debug.commandHandler=xajax.command.handler.unregister('dbg');xajax.command.handler.register('dbg',function(args){args.cmdFullName='debug message';xajax.debug.writeMessage(args.data,xajax.debug.text[100],'warningText');return xajax.debug.commandHandler(args);});xajax.debug.$=xajax.tools.$;xajax.tools.$=function(sId){try{var returnValue=xajax.debug.$(sId);if('object'!=typeof returnValue)
throw{code:10008};}
catch(e){var msg='$:';msg+=xajax.debug.getExceptionText(e);msg+='\n';xajax.debug.writeMessage(msg,xajax.debug.text[100],'warningText');}
return returnValue;}
xajax.debug._objectToXML=xajax.tools._objectToXML;xajax.tools._objectToXML=function(obj,guard){try{if(0==guard.size){var msg='OBJECT TO XML: maxDepth = ';msg+=guard.maxDepth;msg+=', maxSize = ';msg+=guard.maxSize;xajax.debug.writeMessage(msg);}
var r=xajax.debug._objectToXML(obj,guard);if(0==guard.depth){var msg='OBJECT TO XML: size = ';msg+=guard.size;xajax.debug.writeMessage(msg);}
return r;}catch(e){var msg='ObjectToXML: ';msg+=xajax.debug.getExceptionText(e);msg+='\n';xajax.debug.writeMessage(msg,xajax.debug.text[101],'errorText');}
return '';}
xajax.debug._internalSend=xajax._internalSend;xajax._internalSend=function(oRequest){try{xajax.debug.writeMessage(xajax.debug.text[104]);xajax.debug.writeMessage(
xajax.debug.text[105]+
oRequest.requestData.length+
xajax.debug.text[106]
);oRequest.beginDate=new Date();xajax.debug._internalSend(oRequest);}catch(e){var msg='InternalSend: ';msg+=xajax.debug.getExceptionText(e);msg+='\n';xajax.debug.writeMessage(msg,xajax.debug.text[101],'errorText');throw e;}
}
xajax.debug.submitRequest=xajax.submitRequest;xajax.submitRequest=function(oRequest){var msg=oRequest.method;msg+=': ';text=decodeURIComponent(oRequest.requestData);text=text.replace(new RegExp('&xjx','g'),'\n&xjx');text=text.replace(new RegExp('<xjxobj>','g'),'\n<xjxobj>');text=text.replace(new RegExp('<e>','g'),'\n<e>');text=text.replace(new RegExp('</xjxobj>','g'),'\n</xjxobj>\n');msg+=text;xajax.debug.writeMessage(msg);msg=xajax.debug.text[107];var separator='\n';for(var mbr in oRequest.functionName){msg+=separator;msg+=mbr;msg+=': ';msg+=oRequest.functionName[mbr];separator='\n';}
msg+=separator;msg+=xajax.debug.text[108];msg+=separator;msg+=oRequest.URI;xajax.debug.writeMessage(msg);try{return xajax.debug.submitRequest(oRequest);}catch(e){xajax.debug.writeMessage(e.message);if(0 < oRequest.retry)
throw e;}
}
xajax.debug.initializeRequest=xajax.initializeRequest;xajax.initializeRequest=function(oRequest){try{var msg=xajax.debug.text[109];xajax.debug.writeMessage(msg);return xajax.debug.initializeRequest(oRequest);}catch(e){var msg='InitializeRequest: ';msg+=xajax.debug.getExceptionText(e);msg+='\n';xajax.debug.writeMessage(msg,xajax.debug.text[101],'errorText');throw e;}
}
xajax.debug.processParameters=xajax.processParameters;xajax.processParameters=function(oRequest){try{if('undefined'!=typeof oRequest.parameters){var msg=xajax.debug.text[110];msg+=oRequest.parameters.length;msg+=xajax.debug.text[111];xajax.debug.writeMessage(msg);}else{var msg=xajax.debug.text[112];xajax.debug.writeMessage(msg);}
return xajax.debug.processParameters(oRequest);}catch(e){var msg='ProcessParameters: ';msg+=xajax.debug.getExceptionText(e);msg+='\n';xajax.debug.writeMessage(msg,xajax.debug.text[101],'errorText');throw e;}
}
xajax.debug.prepareRequest=xajax.prepareRequest;xajax.prepareRequest=function(oRequest){try{var msg=xajax.debug.text[113];xajax.debug.writeMessage(msg);return xajax.debug.prepareRequest(oRequest);}catch(e){var msg='PrepareRequest: ';msg+=xajax.debug.getExceptionText(e);msg+='\n';xajax.debug.writeMessage(msg,xajax.debug.text[101],'errorText');throw e;}
}
xajax.debug.call=xajax.call;xajax.call=function(){try{xajax.debug.writeMessage(xajax.debug.text[114]);var numArgs=arguments.length;if(0==numArgs)
throw{code:10009};var functionName=arguments[0];var oOptions={}
if(1 < numArgs)
oOptions=arguments[1];oOptions.debugging=true;return xajax.debug.call(functionName,oOptions);}catch(e){var msg='Call: ';msg+=xajax.debug.getExceptionText(e);msg+='\n';xajax.debug.writeMessage(msg,xajax.debug.text[101],'errorText');throw e;}
}
xajax.debug.request=xajax.request;xajax.request=function(){try{xajax.debug.writeMessage(xajax.debug.text[115]);var numArgs=arguments.length;if(0==numArgs)
throw{code:10010};var oFunction=arguments[0];var oOptions={}
if(1 < numArgs)
oOptions=arguments[1];oOptions.debugging=true;return xajax.debug.request(oFunction,oOptions);}catch(e){var msg='Request: ';msg+=xajax.debug.getExceptionText(e);msg+='\n';xajax.debug.writeMessage(msg,xajax.debug.text[101],'errorText');throw e;}
}
xajax.debug.getResponseProcessor=xajax.getResponseProcessor;xajax.getResponseProcessor=function(oRequest){try{var fProc=xajax.debug.getResponseProcessor(oRequest);if('undefined'==typeof fProc){var msg=xajax.debug.text[116];try{var contentType=oRequest.request.getResponseHeader('content-type');msg+="Content-Type: ";msg+=contentType;if('text/html'==contentType){msg+=xajax.debug.text[117];}
}catch(e){}
xajax.debug.writeMessage(msg,xajax.debug.text[101],'errorText');}
return fProc;}catch(e){var msg='GetResponseProcessor: ';msg+=xajax.debug.getExceptionText(e);msg+='\n';xajax.debug.writeMessage(msg,xajax.debug.text[101],'errorText');throw e;}
}
xajax.debug.responseReceived=xajax.responseReceived;xajax.responseReceived=function(oRequest){var xx=xajax;var xt=xx.tools;var xd=xx.debug;var oRet;try{var status=oRequest.request.status;if(xt.arrayContainsValue(xx.responseSuccessCodes,status)){var packet=oRequest.request.responseText;packet=packet.replace(new RegExp('<cmd','g'),'\n<cmd');packet=packet.replace(new RegExp('<xjx>','g'),'\n<xjx>');packet=packet.replace(new RegExp('<xjxobj>','g'),'\n<xjxobj>');packet=packet.replace(new RegExp('<e>','g'),'\n<e>');packet=packet.replace(new RegExp('</xjxobj>','g'),'\n</xjxobj>\n');packet=packet.replace(new RegExp('</xjx>','g'),'\n</xjx>');oRequest.midDate=new Date();var msg=xajax.debug.text[118];msg+=oRequest.request.status;msg+=xajax.debug.text[119];msg+=packet.length;msg+=xajax.debug.text[120];msg+=(oRequest.midDate-oRequest.beginDate);msg+=xajax.debug.text[121];msg+=packet;xd.writeMessage(msg);}else if(xt.arrayContainsValue(xx.responseErrorsForAlert,status)){var msg=xajax.debug.text[122];msg+=status;msg+=xajax.debug.text[123];msg+=oRequest.request.responseText;xd.writeMessage(msg,xajax.debug.text[101],'errorText');}else if(xt.arrayContainsValue(xx.responseRedirectCodes,status)){var msg=xajax.debug.text[124];msg+=oRequest.request.getResponseHeader('location');xd.writeMessage(msg);}
oRet=xd.responseReceived(oRequest);}catch(e){var msg='ResponseReceived: ';msg+=xajax.debug.getExceptionText(e);msg+='\n';xd.writeMessage(msg,xajax.debug.text[101],'errorText');}
return oRet;}
xajax.debug.completeResponse=xajax.completeResponse;xajax.completeResponse=function(oRequest){try{var returnValue=xajax.debug.completeResponse(oRequest);oRequest.endDate=new Date();var msg=xajax.debug.text[125];msg+=(oRequest.endDate-oRequest.beginDate);msg+=xajax.debug.text[126];xajax.debug.writeMessage(msg);return returnValue;}catch(e){var msg='CompleteResponse: ';msg+=xajax.debug.getExceptionText(e);msg+='\n';xajax.debug.writeMessage(msg,xajax.debug.text[101],'errorText');throw e;}
}
xajax.debug.getRequestObject=xajax.tools.getRequestObject;xajax.tools.getRequestObject=function(){try{xajax.debug.writeMessage(xajax.debug.text[127]);return xajax.debug.getRequestObject();}catch(e){var msg='GetRequestObject: ';msg+=xajax.debug.getExceptionText(e);msg+='\n';xajax.debug.writeMessage(msg,xajax.debug.text[101],'errorText');throw e;}
}
if(xajax.dom.assign){xajax.debug.assign=xajax.dom.assign;xajax.dom.assign=function(element,property,data){try{return xajax.debug.assign(element,property,data);}catch(e){var msg='xajax.dom.assign: ';msg+=xajax.debug.getExceptionText(e);msg+='\n';msg+='Eval: element.';msg+=property;msg+=' = data;\n';xajax.debug.writeMessage(msg,xajax.debug.text[101],'errorText');}
return true;}
}
if(xajax.tools){if(xajax.tools.queue){if(xajax.tools.queue.retry){if('undefined'==typeof xajax.debug.tools)
xajax.debug.tools={};if('undefined'==typeof xajax.debug.tools.queue)
xajax.debug.tools.queue={};xajax.debug.tools.queue.retry=xajax.tools.queue.retry;xajax.tools.queue.retry=function(obj,count){if(xajax.debug.tools.queue.retry(obj,count))
return true;if(obj.cmd&&'s'==obj.cmd)
return false;xajax.debug.writeMessage('Retry count exceeded.');return false;}
}
}
}
xajax.debug.isLoaded=true;xjx={}
xjx.$=xajax.tools.$;xjx.getFormValues=xajax.tools.getFormValues;xjx.call=xajax.call;xjx.request=xajax.request;xajax.$=xajax.tools.$;xajax.getFormValues=xajax.tools.getFormValues;}catch(e){alert(e.name+': '+e.message);}
