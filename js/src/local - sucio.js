$(document).ready(function() { 
	$('.act-del').click(deleteConcert);
	$('#pending-conc .act-upd-pending').click(updatePendingConcert);
	$('#assigned-conc .act-drop').click(function() {
		assignConcert($(this), 0);
	});
	$('#pending-conc .act-ins').click(function() {
		verInscritos($(this));
	});

	$('#create-concert input[type="submit"]').click(function() {
		// resetErrors();
		// Coloco el nombre y los valores de los inputs en un array
		// excepto el de tipo submit, para validarlo con ajax
		var data = {};
		data["action"] = "new";
		validateConcert(data);
		/*
		$.each($('#create-concert input, #create-concert select'), function(i, v) {
     		if (v.type !== 'submit') {
        		data[v.name] = v.value;
      		}
      	});
      	// al procesar la validacion en el php 
      	// le indico que es un nuevo concierto
      	// con el campo action = new
      	data["action"] = "new";
		$.ajax({
      		dataType: 'json',
      		type: 'POST',
      		url: 'validateConcert.php',
      		data: data,
     		success: function(resp) {
     			// si la validacion tiene exito
     			if (resp.validation === true) {
     				// reseteo el formulario
     				$('#create-concert').trigger('reset');
     				// recargo la tabla
     				$('#pending-conc').html(resp.table);
     				$('.act-del').click(deleteConcert);
     				$('.act-upd').click(updateConcert);
     				return false;
     			} else {
         			$.each(resp, function(k, v) {
         				// k = indice/key, v = valor/value
	          			console.log(k + " => " + v); // ver los mensajes de error en la consola
	          			var error_msg = '<span class="error">'+v+'</span>';
	          			//al input con error le añado una clase y despues el mensaje de error
            			$('#create-concert input[name="' + k + '"], #create-concert select[name="' + k + '"]').addClass('inputError').after(error_msg);
     				});
     				// recojo el nombre de los campos con errores
     				// para seleccionar el primer input o select con error
     				var keys = Object.keys(resp);
     				$('#create-concert input[name="'+keys[1]+'"], #create-concert select[name="'+keys[1]+'"]').focus();
     			}
     			return false;
     		},
     	    error: function() {
        		console.log('Algo ha hecho kaput');
      		}
		});
		*/
		// retorno false para que no se envie el formulario y recargue la pagina
		return false;
	});

	$('#submit-update-pending').click(function() {
		var data = {};
		data["action"] = "update pending";
		validateConcert(data);
		/*
		resetErrors();
		var data = {};
		$.each($('#update-concert input, #update-concert select'), function(i, v) {
        	data[v.name] = v.value;
      	});
      	data["action"] = "update";
		$.ajax({
      		dataType: 'json',
      		type: 'POST',
      		url: 'validateConcert.php',
      		data: data,
     		success: function(resp) {
     			if (resp.validation === true) {
     				$('#pending-conc').html(resp.table);
     				$('.act-del').click(deleteConcert);
     				$('.act-upd').click(updateConcert);
     				disableModal("#update-modal")
     				return false;
     			} else {
         			$.each(resp, function(k, v) {
	          			console.log(k + " => " + v); 
	          			var error_msg = '<span class="error">'+v+'</span>';
            			$('#update-concert input[name="' + k + '"], #update-concert select[name="' + k + '"]').addClass('inputError').after(error_msg);
     				});
     				// no puedo usar esto por el maldito focusout
     				// ganas de matar aumentando
     				//var keys = Object.keys(resp);
     				//$('input[name="'+keys[1]+'"]').focus();
     			}
     			return false;
     		},
     	    error: function() {
        		console.log('Algo ha hecho kaput');
      		}
		});
		*/
		return false;
	});



	/*
	$('#submit-update-assigned').click(function() {
		var data = {};
		data["action"] = "update assigned";
		validateConcert(data);
	});
	*/
});

function verInscritos(elem) {
	var id = $(elem).closest('tr').children('input').val();	
	$.ajax({
		type: "post",
		dataType: 'json',
		url: 'inscritos-concierto.php',
		data: {concert: id},
		success: function(resp) {
			$('#inscritos-modal .modal-body').html(resp.table);
			enableModal("#inscritos-modal");
			$('.act-accept').click(function(){
				assignConcert($(this), 1);
			});
		}
	});
}

function assignConcert(elem, assigned) {
	var concert = $(elem).closest('tr').children('input').eq(0).val();
	var music = $(elem).closest('tr').children('input').eq(1).val();
	$.ajax({
		type: "post",
		dataType: 'json',
		url: 'assign-concert.php',
		data: {concert: concert, music: music, assign: assigned},
		success: function(resp) {
			$('#pending-conc tbody').html(resp.pending);
			$('#assigned-conc tbody').html(resp.assigned);
			$('.act-del').click(deleteConcert);
			$('#pending-conc .act-upd-pending').click(updatePendingConcert);
			$('#pending-conc .act-ins').click(function() {
				verInscritos($(this));
			});
			$('.act-drop').click(function() {
				assignConcert($(this), 0);
			});
			disableModal("#inscritos-modal");
		},
		error: function() {
			console.log('Algo ha hecho kaput');
		}
	});
}


function deleteConcert() {
	var row = $(this).closest('tr');
	var id = $(row).children('input').val();	
	$.ajax({
		type : "POST",
		url : "delete-concert.php",
		data: {id: id},
		success: function() {
			row.remove();
		}
	});
}


function updatePendingConcert() {
	// borro los datos del body de la tabla
	$('#update-pending-table tbody').children().remove();
	// añado las 4 primeras celdas de la columna seleccionada 
	$(this).closest('tr').children('td').each(function(i) {
		if (i<4) $(this).clone().appendTo('#update-pending-table tbody');
	});
	// relleno los campos del formulario con los valores actuales
	$('#update-pending-concert-id').val($(this).closest('tr').children('input').val());
	$('#update-pending-date').val($('#update-pending-table td').eq(0).text());
	$('#update-pending-time').val($('#update-pending-table td').eq(1).text());
	$("#update-pending-genre :selected").attr('selected', false);
	$("#update-pending-genre option:contains(" + $('#update-pending-table td').eq(2).text() + ")").attr('selected', true);
	$('#update-pending-pay').val($('#update-pending-table td').eq(3).text());
	enableModal("#update-pending-modal");
}

// Quizas lo uso, o quizas no.
/*
function updateAssignedConcert() {
	$('#update-assigned-table tbody').children().remove();
	$(this).closest('tr').children('td').each(function(i) {
		if (i<5) $(this).clone().appendTo('#update-assigned-table tbody');
	});
	$('<td><span id="act-drop">Baja</span></td>').appendTo('#update-assigned-table tbody');
	$('#update-assigned-concert-id').val($(this).closest('tr').children('input').val());
	$('#update-assigned-date').val($('#update-assigned-table td').eq(0).text());
	$('#update-assigned-time').val($('#update-assigned-table td').eq(1).text());
	$("#update-assigned-genre :selected").attr('selected', false);
	$("#update-assigned-genre option:contains(" + $('#update-assigned-table td').eq(2).text() + ")").attr('selected', true);
	$('#update-assigned-pay').val($('#update-assigned-table td').eq(3).text());
	enableModal("#update-assigned-modal");
}
*/

function validateConcert(data) {
	resetErrors();
	// Coloco el nombre y los valores de los inputs en un array
	// excepto el de tipo submit, para validarlo con ajax
	switch (data["action"]) {
		case "new": 
		$.each($('#create-concert input, #create-concert select'), function(i, v) {
			if (v.type !== 'submit') {
				data[v.name] = v.value;
			}
		});
		break;

		case "update pending":  	
		$.each($('#update-pending-concert input, #update-pending-concert select'), function(i, v) {
			data[v.name] = v.value;
		});
		break;
	}
	$.ajax({
		dataType: 'json',
		type: 'POST',
		url: 'validateConcert.php',
		data: data,
		success: function(resp) {
     	// si la validacion tiene exito
     	if (resp.validation === true) {
	     	// recargamos la tabla de conciertos pendientes
	     	// y enlazamos los eventos de nuevo a las acciones
	     	$('#pending-conc tbody').html(resp.pendingTable);
	     	$('#pending-conc .act-del').click(deleteConcert);
	     	$('#pending-conc .act-upd-pending').click(updatePendingConcert);
	     	$('#pending-conc .act-ins').click(function() {
	     		verInscritos($(this));
	     	});
	     	// depende de la accion que hayamos hecho
	     	// haremos una cosa u otra
	     	switch (data["action"]) {
	     		case "new": 
	     			// reseteo el formulario
	     			$('#create-concert').trigger('reset');
	     			break;

     				case "update pending":
     				// cierro el modal
     				disableModal("#update-pending-modal");
     				break;
     			}	
     			return false;
     		} else {
     			$.each(resp, function(k, v) {
 				// k = indice/key, v = valor/value
       			console.log(k + " => " + v); // ver los mensajes de error en la consola
       			var error_msg = '<span class="error">'+v+'</span>';
       			switch (data["action"]) {
       				case "new": 
	         			//al input con error le añado una clase y despues el mensaje de error
	         			$('#create-concert input[name="' + k + '"], #create-concert select[name="' + k + '"]').addClass('inputError').after(error_msg);
						// recojo el nombre de los campos con errores
	    				// para seleccionar el primer input o select con error
	    				var keys = Object.keys(resp);
	    				$('#create-concert input[name="'+keys[1]+'"], #create-concert select[name="'+keys[1]+'"]').focus();
	    				break;

	    				case "update pending":
	    				$('#update-pending-concert input[name="' + k + '"], #update-pending-concert select[name="' + k + '"]').addClass('inputError').after(error_msg);
						// no puedo usar el focus por que me salta el focusout en el modal...
						break;
					}	
				}); 
     		}
     		return false;
     	},
     	error: function() {
     		console.log('Algo ha hecho kaput');
     	}
	});
}
