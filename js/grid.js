	
	//'lBfrtip' 
	function grid(argumento){
		$('#tblCRUD').DataTable( {
			responsive: true,
			"lengthMenu": [ 5, 10, 15, 25, 50, 75, 100 ],
			dom:  "<'row'<'col-sm-5'B><'col-sm-4'l><'col-sm-3'f>>" + "<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-5'i><'col-sm-7'p>>",
			buttons: [
				{
					text: 'Agregar registro',
					action: function ( e, dt, node, config ) {
		                xajax_add(argumento);// argumento de la funcion add. Normalmente es el nombre de la clase.
		            }
				}
			],
			language: {
				    "sProcessing":     "Procesando...",
				    "sLengthMenu":     "Mostrar _MENU_ registros",
				    "sZeroRecords":    "No se encontraron resultados",
				    "sEmptyTable":     "Ning&uacute;n dato disponible en esta tabla",
				    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
				    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
				    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
				    "sInfoPostFix":    "",
				    "sSearch":         "Buscar:",
				    "sUrl":            "",
				    "sInfoThousands":  ",",
				    "sLoadingRecords": "Cargando...",
				    "oPaginate": {
				        "sFirst":    "Primero",
				        "sLast":     "&Uacute;ltimo",
				        "sNext":     "Siguiente",
				        "sPrevious": "Anterior"
				    },
				    "oAria": {
				        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
				    }
				}
		} );
		var estilo = "";
		$('table tr th').css({'margin': '0px','padding': '6px 4px 2px 4px','height': '25px','background': 'url(images/background.jpg)','background-repeat': 'repeat','font-size':'11px','color': '#000'});
	
	} 
	
