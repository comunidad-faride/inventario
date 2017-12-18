<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<meta name="" content="">
	<script>
		/// <summary>
/// Validamos el número de enteros y decimales
/// </summary>
/// <param name="el">Elemento que lanza el método</param>
/// <param name="evt">Evneto</param>
/// <param name="ints">Número de enteros permitidos</param>
/// <param name="decimals">Número de decimales permitidos</param>
function validateFloatKeyPress(el, evt, ints, decimals) {

    // El punto lo cambiamos por la coma
    if (evt.keyCode == 46) {
        evt.keyCode = 44;
    }
    
    // Valores numéricos
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 44 && charCode > 31
        && (charCode < 48 || charCode > 57)) {
        return false;
    }
    
    // Sólo una coma
    if (charCode == 44) {
        if (el.value.indexOf(",") !== -1) {
            return false;
        }

        return true;
    }

    // Determinamos si hay decimales o no
    if (el.value.indexOf(",") == -1) {
        // Si no hay decimales, directamente comprobamos que el número que hay ya supero el número de enteros permitidos
        if (el.value.length >= ints) {
            return false;
        }
    }
    else {

        // Damos el foco al elemento
        el.focus();

        // Para obtener la posición del cursor, obtenemos el rango de la selección vacía
        var oSel = document.selection.createRange();

        // Movemos el inicio de la selección a la posición 0
        oSel.moveStart('character', -el.value.length);

        // La posición de caret es la longitud de la selección
        iCaretPos = oSel.text.length;

        // Distancia que hay hasta la coma
        var dec = el.value.indexOf(",");

        // Si la posición es anterior a los decimales, el cursor está en la parte entera
        if (iCaretPos <= dec) {
            // Obtenemos la longitud que hay desde la posición 0 hasta la coma, y comparamos
            if (dec >= ints) {
                return false;
            }
        }
        else { // El cursor está en la parte decimal
            // Obtenemos la longitud de decimales (longitud total menos distancia hasta la coma menos el carácter coma)
            var numDecimals = el.value.length - dec - 1;
                
            if (numDecimals >= decimals) {
                return false;
            }
        }
    }
    
    return true;
}
	</script>
</head>
<body>
	<form>
	<font face="arial" size="2">Por favor, entra un número con hasta 2 decimales (con punto separador).</font><br>
		<input type="text" onkeypress="return validateFloatKeyPress(this, event, 4, 6);"/>
	</form>	
	

</body>
</html>