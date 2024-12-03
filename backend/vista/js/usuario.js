
$(".tablaUsuario").DataTable({
	"ajax":"ajax/tablaUsuario.ajax.php",
	"deferRender": true,
	"retrieve": true,
	"processing": true,
	"language": {

		"sProcessing":     "Procesando...",
		"sLengthMenu":     "Mostrar _MENU_ registros",
		"sZeroRecords":    "No se encontraron resultados",
		"sEmptyTable":     "Ningún dato disponible en esta tabla",
		"sInfo":           "Mostrando registros del _START_ al _END_",
		"sInfoEmpty":      "Mostrando registros del 0 al 0",
		"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix":    "",
		"sSearch":         "Buscar:",
		"sUrl":            "",
		"sInfoThousands":  ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
		},
		"oAria": {
			"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		}

	}

});

$(".tablaUsuarioRegistrado").DataTable({
	"ajax":"ajax/tablaUsuarioRegistrado.ajax.php",
	"deferRender": true,
	"retrieve": true,
	"processing": true,
	"language": {

		"sProcessing":     "Procesando...",
		"sLengthMenu":     "Mostrar _MENU_ registros",
		"sZeroRecords":    "No se encontraron resultados",
		"sEmptyTable":     "Ningún dato disponible en esta tabla",
		"sInfo":           "Mostrando registros del _START_ al _END_",
		"sInfoEmpty":      "Mostrando registros del 0 al 0",
		"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix":    "",
		"sSearch":         "Buscar:",
		"sUrl":            "",
		"sInfoThousands":  ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
		},
		"oAria": {
			"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		}

	}

});

/*=============================================
Editar Administrador
=============================================*/

$(document).on("click", ".editarAdministrador", function(){

	var idAdministrador = $(this).attr("idAdministrador");

	var datos = new FormData();
  	datos.append("idAdministrador", idAdministrador);

  	$.ajax({
  		url:"ajax/usuario.ajax.php",
  		method: "POST",
  		data: datos,
  		cache: false,
		contentType: false,
    	processData: false,
    	dataType: "json",
    	success:function(respuesta){ 	

    		$('input[name="editarId"]').val(respuesta["id"]);
    		$('input[name="editarNombre"]').val(respuesta["nombre"]);
    		$('input[name="editarUsuario"]').val(respuesta["usuario"]);
    		$('input[name="passwordActual"]').val(respuesta["password"]);
    		

    	}

  	})

})

/*=============================================
Eliminar Administrador
=============================================*/

$(document).on("click", ".eliminarAdministrador", function(){

	var idAdministrador = $(this).attr("idAdministrador");

	if(idAdministrador == 1){

		swal({
          title: "Error",
          text: "Este administrador no se puede eliminar",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

        return;

	}

	swal({
	    title: '¿Está seguro de eliminar este administrador?',
	    text: "¡Si no lo está puede cancelar la acción!",
	    type: 'warning',
	    showCancelButton: true,
	    confirmButtonColor: '#3085d6',
	    cancelButtonColor: '#d33',
	    cancelButtonText: 'Cancelar',
	    confirmButtonText: 'Si, eliminar administrador!'
	  }).then(function(result){

	    if(result.value){

	    	var datos = new FormData();
       		datos.append("idEliminar", idAdministrador);

       		$.ajax({

	          url:"ajax/usuario.ajax.php",
	          method: "POST",
	          data: datos,
	          cache: false,
	          contentType: false,
	          processData: false,
	          success:function(respuesta){

	          	if(respuesta == "ok"){

	          		swal({
	                  type: "success",
	                  title: "¡CORRECTO!",
	                  text: "El administrador ha sido borrado correctamente",
	                  showConfirmButton: true,
	                  confirmButtonText: "Cerrar",
	                  closeOnConfirm: false
	                 }).then(function(result){

	                    if(result.value){

	                      window.location = "administradores";

	                    }
	                
	                })

	          	}

	          }

	        })  

	    }

	})

})




