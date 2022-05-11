
	var intervalo;
	
	var ajax_output;
	var eval_resultado;
	
	var cancelar; 

	var editor = new Array();

	
	$(window).ready(function() {
		var altura = $(window).height() - 220;
		$('div.bloque_trabajo').css('height', altura + 'px');
	});







	function beginUpload(key, bar) {
		$("#" + bar).fadeIn();

		intervalo = setInterval(function() { 
			$.getJSON("upload_info.php?id=" + key, function(data) {
				if (data == null)
					return;

				var percentage = Math.floor(100 * parseInt(data.bytes_uploaded) / parseInt(data.bytes_total));
				$("#" + bar).progressBar(percentage);
			});
		}, 400);

		return true;
	}



	
	


	function upload_configurar(uid, boton, bar, funcion1, funcion2, salida, imagen) {

		$("#" + bar).progressBar({ barImage: 'img/progressbg.gif'});
	
		var button = $('#' + boton), interval;
		
//		var id_empleado = $('input#id_empleado').val();

		var nombre;
		nombre = 'imagen';
		
		
		new Ajax_upload(button,{
			action: funcion1, 
			name: nombre,
			key: uid,
			onSubmit : function(file, ext){
				if (ext && /^(jpg|png|jpeg|gif)$/.test(ext)){
				} else {
					alert("Tipo de archivo no válido");
					return false;				
				}
				
  				beginUpload(uid, bar);

				$('#' + boton).val('Subiendo');
				this.disable();
				
			},
			
			onComplete: function(file, response){
				var msg = response.split(';;');
				$('#' + boton).val('Subir imagen nueva');
				$('#' + bar + '_pbImage').css('background-position','0px 50%');
				$('#' + bar + '_pbText').html(' 100%');
				
				this.enable();
				
				clearInterval(intervalo);
				
				if ((msg[0] > 0) && (funcion2)) {
					$.ajax({
						url: funcion2,
						data: '',
						type: 'GET',
						success: respuesta
					});
				}
				
			
				function respuesta(msg) {
					$('#' + salida).html(msg);
				}
				
			}
		});
	}









	function bloque3_cerrar() {
		$('div#bloque1').css('visibility','visible');
		$('div#bloque3').css('display','none');
	}









	function ckeditor_recuperar() {
		if (editor) {
			var i = 0;
			var id;
		 	while (editor[i]) {
		 		id = $(editor[i].element).attr('id');
	 			$('textarea#' + id).val(editor[i].getData());
		 		i = i + 1;
		 	}
		
		}
	}
	



































	
	function menu(id) {
	
		if ($('ul#ul_menu_' + id).css('display') == 'none') {
			$('ul#ul_menu_' + id).css('display', 'block');
			$('span.menu').removeClass('menu_activo');
			$('span#span_menu_' + id).addClass('menu_activo');
			$('div.menu_selector').removeClass('menu_selector2');
			$('div#div_menu_' + id).addClass('menu_selector2');
			
		} else {
			$('ul#ul_menu_' + id).css('display', 'none');
			$('span.menu').removeClass('menu_activo');
			$('div.menu_selector').removeClass('menu_selector2');
		}
		
	
	}






	function actividad_editar_post(val) {
		var hoja = $('input#hoja').val();
		var funcion = $('input#funcion').val();
		modulo(['actividad', 'tabla', '&hoja=' + hoja + '&inactivo=' + $('input#inactivo').val(), 'tabla_actividad',0,0]);
	}

	function habitacion_editar_post(val) {
		var hoja = $('input#hoja').val();
		var funcion = $('input#funcion').val();
		modulo(['habitacion', 'tabla', "&id_tipo=" + $('select#id_tipo').val() + "&hoja=" + hoja + '&inactivo=' + $('input#inactivo').val(), 'tabla_actividad',0,0]);
	}
	
	function oferta_editar_post(val) {
		var hoja = $('input#hoja').val();
		var funcion = $('input#funcion').val();
		modulo(['oferta', 'tabla', '&hoja=' + hoja + '&inactivo=' + $('input#inactivo').val(), 'tabla_oferta',0,0]);
	}
	
	function seccion_editar_post(val) {
		var hoja = $('input#hoja').val();
		var funcion = $('input#funcion').val();
		modulo(['seccion', 'tabla', '&hoja=' + hoja + '&inactivo=' + $('input#inactivo').val(), 'tabla_seccion',0,0]);
	}

	function texto_editar_post(val) {
		var hoja = $('input#hoja').val();
		var funcion = $('input#funcion').val();
		modulo(['texto', 'tabla', '&hoja=' + hoja + '&inactivo=' + $('input#inactivo').val(), 'tabla_texto',0,0]);
	}




