$(document).ready(function() { 
	$('.act-del').click(deleteConcert);
	$('.act-upd').click(updateConcert);

	$('#create-concert input[type="submit"]').click(function() {
		resetErrors();
		// Coloco el nombre y los valores de los inputs en un array
		// excepto el de tipo submit, para validarlo con ajax
		var data = {};
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
		return false;
	});

	$('#submit-update').click(function() {
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
		return false;
	});

	function deleteConcert() {
		var row = $(this);
		var idcon = $('.idconc', $(this).parents('tr')).val();	
		$.ajax({
			type : "POST",
			url : "delete-concert.php",
			data: {id: idcon},
			success: function() {
		      	row.closest('tr').remove();
		   	}
		});
	}

	function updateConcert() {
		// borro los datos del body de la tabla
		$('#update-conc-table tbody').children().remove();
		// añado las 4 primeras celdas de la columna seleccionada 
		$(this).closest('tr').children('td').each(function(i) {
			if (i<4) $(this).clone().appendTo('#update-conc-table tbody');
		});
		// relleno los campos del formulario con los valores actuales
		$('#update-concert-id').val($(this).closest('tr').children('input').val());
		$('#update-date').val($('#update-conc-table td').eq(0).text());
		$('#update-time').val($('#update-conc-table td').eq(1).text());
		$("#update-genre :selected").attr('selected', false);
		$("#update-genre option:contains(" + $('#update-conc-table td').eq(2).text() + ")").attr('selected', true);
		$('#update-pay').val($('#update-conc-table td').eq(3).text());
		enableModal("#update-modal");
	}
});
