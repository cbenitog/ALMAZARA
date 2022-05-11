
	var cancelar;	
	
	
	function cargando() {
		return "<img src='img/ajax-loader.gif'>";
	}




	
	function ckeditor_destruir() {
		for(var name in CKEDITOR.instances) {
			CKEDITOR.remove(CKEDITOR.instances[name]);
		}
	}
	
	function ckeditor_update() {
		for(var name in CKEDITOR.instances) {
	         CKEDITOR.instances[name].updateElement();
		}
	}
	
	
	
	
	
	function confirmacion(parametros) {
		
		var texto = parametros[0];
		var objeto = parametros[1];
		var funcion = parametros[2];
		var param = parametros[3];
		var objetivo = parametros[4];
		var pre = parametros[5];
		var post = parametros[6];
		
		
		if (param == undefined) {
			param = "";
		}
		
		if (objetivo == undefined) {
			objetivo = "trabajo";
		}
		
		var ok = confirm(texto);
		
		if (ok == true) {
			var parametros = "objeto=" + objeto + 
							"&funcion=" + funcion + param;
							
			$.ajax({
				type: "GET",
		        url: "ajax.php?" + parametros,
		        success: response 
	        
			});
		}
	
		function response(data) {
			
			if (data[0] == 1) {
				$('#' + objetivo).html(data.substr(2)); 
			} else if (data[0] == 0) {
				alert(data.substr(2));
			} 
			
			ajax_output = "";
			if (post != 0) {
				ajax_output = data;
				var funcion2 = funcion.split('&');
				var funcion_previa = objeto + "_" + funcion2[0] + "_post('" + post + "')";
				eval(funcion_previa);
			} 			
		
		}
	
	
	}





	function form_check(form) {
		
		var error = 0;
		
		$('.obligatorio').each(function (index, input) {
			if ($(input).val()) {
				if ($(input).is('select')) {
					if ($(input).val() > 0) {
						$(input).removeClass('no_valido');					
					} else {
						error = 1;
						$(input).addClass('no_valido');
					}
                } else {
					$(input).removeClass('no_valido');
				}
			} else {
				error = 1;
				$(input).addClass('no_valido');
			}
		});

		
		if ($(form).attr('id') == "form_registro") {
		
			var password = $('input#registro_password').val();

			if ($('input#registro_password').val() != $('input#registro_password2').val()) {
				error = 2;
				$('input#registro_password').addClass('no_valido');
				$('input#registro_password2').addClass('no_valido');
				$('input#registro_password').val("");
				$('input#registro_password2').val("");
			}
			
			if (password.length < 6) {
				error = 4;
			}
			
			if (!isNaN(password)) {
				error = 5;
			}
			
			if ($('input#codigo').val() != $('input#codigo2').val()) {
				error = 3;
				$('input#codigo').addClass('no_valido');
				$('input#codigo').val("");
			}
			
		} else if ($(form).attr('id') == "form_recuperacion") {
		
			var password = $('input#registro_password').val();

			if ($('input#registro_password').val() != $('input#registro_password2').val()) {
				error = 2;
				$('input#registro_password').addClass('no_valido');
				$('input#registro_password2').addClass('no_valido');
				$('input#registro_password').val("");
				$('input#registro_password2').val("");
			}
			
			if (password.length < 6) {
				error = 4;
			}
			
			if (!isNaN(password)) {
				error = 5;
			}
			
		} else if ($(form).attr('id') == "form_contacto") {
		    var mult = $('input#num1').val() * $('input#num2').val();
			if (mult != $('input#mult').val()) {
				alert("El valor de la multiplicación no es correcto");
				$('input#mult').addClass('no_valido');
				return false;
			} else {
				$('input#mult').removeClass('no_valido');
			}
		}
		
		if (error == 1) {
			alert("Es necesario rellenar algunos campos");
		} else if (error == 2) {
			alert("La contraseña y la confirmación son diferentes");
		} else if (error == 3) {
			alert("El código anti-bot no coincide");
		} else if (error == 4) {
			alert("La contraseña es demasiado corta");
		} else if (error == 5) {
			alert("La contraseña no puede ser numérica");
		}

		

		if (error) {
			return false;
		} else {
			return true;
		}
	} 
	




	
	
	
	
	function formulario(parametros) {
		
		var objeto = parametros[0];
		var funcion = parametros[1];
		var formulario = parametros[2];
		var objetivo = parametros[3];
		var pre = parametros[4];
		var post = parametros[5]; 
		
		if (typeof CKEDITOR != "undefined") {
			ckeditor_update();
		}
		
		if (!form_check()) {
			return false;
		}
					// primero vemos si hay que hacer algún tratamiento previo
		
		if (pre == 1) {
			var funcion_previa = objeto + "_" + funcion + "_pre()";
			eval(funcion_previa);
			if (eval_resultado == false) {
				return false;
			}
		}
		
		if (cancelar) {
			cancelar = 0;
			return;
		}
		
		
		if (formulario == undefined) {
			return;
		}
		
		if (objetivo == undefined) {
			objetivo = "trabajo";
		}
		
				// Tenemos que recorrer los parámetros y recuperarlos
				
		var i = 0;
		var valor;
		var parametros = "objeto=" + objeto + 
						"&funcion=" + funcion + 
						"&grabar=1";
						

		
		parametros = parametros + "&" + $('form#' + formulario).serialize();
		
		$('#' + objetivo).html(cargando());
		$.ajax({
			type: "POST", 
	        url: "ajax.php?",
	        data: parametros,
	        success: response 
        
		});
		
		if (typeof CKEDITOR != "undefined") {
			ckeditor_destruir();
		}
		
		return false;
		
		function response(data) {
			
			$('#' + objetivo).html(data);
			
			if (post != 0) {
				var funcion2 = funcion.split('&');
				var funcion_previa = objeto + "_" + funcion2[0] + "_post(" + post + ")";
				eval(funcion_previa);
			} 
			
		}
	
	
	}
	












	function formulario2(parametros) {
		
		var objeto = parametros[0];
		var funcion = parametros[1];
		var param = parametros[2];
		var objetivo = parametros[3];
		var pre = parametros[4];
		var post = parametros[5]; 
		var anyadir = parametros[6];
		

					// primero vemos si hay que hacer algún tratamiento previo
		
		if (pre == 1) {
			var funcion_previa = objeto + "_" + funcion + "_pre()";
			eval(funcion_previa);
			if (eval_resultado == false) {
				return false;
			}
		}
		
		if (cancelar) {
			cancelar = 0;
			return;
		}
		
		
		if (param == undefined) {
			return;
		}
		
		if (objetivo == undefined) {
			objetivo = "trabajo";
		}
		
				// Tenemos que recorrer los parámetros y recuperarlos
				
		var i = 0;
		var valor;
		var parametros = "objeto=" + objeto + 
						"&funcion=" + funcion + 
						"&grabar=1";
						
								
		while (param[i] != undefined) {
			
					// comprobamos si es un checkbox porque entonces tendremos que coger el :selected
			if ($('#' + param[i]).attr("type") == "checkbox") {
				valor = $('#' + param[i] + ":checked").val();
			} else {
				valor = $('#' + param[i]).val();
			}
			parametros += "&" + param[i] + "=" + valor;
			i += 1;
		}
		
//		location.replace("index.php?objeto=" + objeto + "&funcion=" + funcion);

		if (anyadir != 1) {
			$('#' + objetivo).html(cargando());
		}
		
				
		$.ajax({
			type: "POST", 
	        url: "ajax.php?",
	        data: parametros,
	        success: response 
        
		});
		$('#' + objetivo).html(cargando());
		
		function response(data) {
			
			if (anyadir == 1) {
				$('#' + objetivo).append(data);
			} else {
				$('#' + objetivo).html(data);
			}
			
			if (post != 0) {
				var funcion2 = funcion.split('&');
				var funcion_previa = objeto + "_" + funcion2[0] + "_post(" + post + ")";
				eval(funcion_previa);
			}
			 
		}
	
	
	}
	













	function modulo(parametros) {
		
		var objeto = parametros[0];
		var funcion = parametros[1];
		var param = parametros[2];
		var objetivo = parametros[3];
		var pre = parametros[4];
		var post = parametros[5]; 
		var anyadir = parametros[6]; 
		var anim = parametros[7]; 
		
		
					// primero vemos si hay que hacer algún tratamiento previo
		
		if (pre) {
			var funcion_previa = objeto + "_" + funcion + "_pre(" + pre + ")";
			eval(funcion_previa);
			if (eval_resultado == false) {
				return false;
			}
		}
		
		if (cancelar) {
			cancelar = 0;
			return;
		}
		
		if (param == undefined) {
			param = "";
		}
		
		if (objetivo == undefined) {
			objetivo = "trabajo";
		}
		
		var parametros = "objeto=" + objeto + 
						"&funcion=" + funcion + param;

		if (anim == 1) {
			$('#' + objetivo).fadeOut(200,function() {
				$.ajax({
					type: "GET",
			        url: "ajax.php?" + parametros,
			        success: response 
		        
				});
					
			})
		} else {
			$.ajax({
				type: "GET",
		        url: "ajax.php?" + parametros,
		        success: response 
	        
			});
			
			$('#' + objetivo).html(cargando());
		}
	
		function response(data) {
			$('#' + objetivo).html(data);
			if (post != 0) {
				var funcion_previa = objeto + "_" + funcion + "_post('" + post + "')";
				eval(funcion_previa);
			}
			
			if (anim == 1) {
				$('#' + objetivo).fadeIn(200);
			}
			
		}
	
	
	}
	


	
	
	
	
	




