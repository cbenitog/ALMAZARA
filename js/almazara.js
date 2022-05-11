
	var semaforito_de_avidesa = 0;
	var espera;
	var eval_resultado;
	var slide_desp, slide_tope, stop, slide_top, height;
	
	
	$(document).ready(function() {
		$.datepicker.setDefaults($.datepicker.regional["es"]);
		ajustar();
		$('img.3rd').mouseover(function() {
			$('span#recomendado').html($(this).attr('alt'));
		});
	
		$('img.3rd').mouseout(function() {
			$('span#recomendado').html("&nbsp;");
		});

		$(window).resize(function() {
			ajustar();			
		});
	});
	
	
	
	
	function ajustar() {
		var top = ($(window).height() - $('div.principal_fondo_cuerpo').height() -4) / 2;
		$('div.principal_fondo').css('top',top);
		$('div.principal').css('margin-top', top + 39);
	}
	
	
	function contacto_reservar_pre(val) {
		$('input#enviar').val('ENVIANDO');
		return true;
	}
	
	function contacto_reservar_post(val) {
		
		var alto, pos_top;
		
		alto = 197;
		pos_top = ((alto - $('div.principal_fondo_cuerpo').height()) / 2 * -1) + parseInt($('div.principal_fondo').position().top);
		$('div.principal_fondo_cuerpo').animate({height: alto}, 500);
		$('div.principal_fondo').animate({top: pos_top}, 500);
		
		
		var pos_left = 4 * 744 * -1;
		$('div#habitaciones_box_inner').animate({left: pos_left},500);
		
		

		$('input#enviar').val('RESERVAR');
		$('input').removeAttr('disabled');
		return true;

	}
	
	
	function no() {
		return false;
	}
	
	
	function google_ruta(){
		window.open("https://maps.google.com/maps?f=d&source=s_d&saddr=" + escape($('input#origen').val()) +"&daddr=La+Almazara+de+Valdeverdeja&ie=UTF8&z=12",'google_maps');
	} 	

	
	
	
	function habitaciones_boton(paso,id) {
		
		var pos_top, alto;
		
		if (paso == 0) {
			alto = 364;
			response('');
			
		} else if (paso == 1) {
			alto = 421;
			parametros = "objeto=plantilla&funcion=habitaciones&id_tipo=" + id;
			
			$.ajax({
				type: "GET",
		        url: "ajax.php?" + parametros,
		        async: false,
		        success: response 
			});

		} else if (paso == 2) {
			alto = 439;
			parametros = "objeto=plantilla&funcion=habitaciones&id_habitacion=" + id;
			
			$.ajax({
				type: "GET",
		        url: "ajax.php?" + parametros,
		        async: false,
		        success: response 
			});

		} else if (paso == 3) {
			alto = 364;
			parametros = "objeto=plantilla&funcion=habitaciones&reservar=1&id_habitacion=" + id;
			$.ajax({
				type: "GET",
		        url: "ajax.php?" + parametros,
		        async: false,
		        success: response 
			});

		} else if (paso == 4) {
			alto = 197;
			response('');
		}
		
		pos_top = ((alto - $('div.principal_fondo_cuerpo').height()) / 2 * -1) + parseInt($('div.principal_fondo').position().top);
		$('div.principal_fondo_cuerpo').animate({height: alto}, 500);
		$('div.principal_fondo').animate({top: pos_top}, 500);
		
		$('div.principal').css('margin-top',pos_top + 39);
		
		
		function response(data) {
			var pos_left = paso * 744 * -1;
			
			if (paso == 0) {
				$('div#habitaciones_box_inner').animate({left: pos_left},500);
			} else if (paso == 1) {
				$('div#habitaciones_box2').html(data);
				$('div#habitaciones_box_inner').animate({left: pos_left},500);
			} else if (paso == 2) {
				$('div#habitaciones_box3').html(data);
				$('div#habitaciones_box_inner').animate({left: pos_left},500);
			} else if (paso == 3) {
				$('div#habitaciones_box4').html(data);
				$('div#habitaciones_box_inner').animate({left: pos_left},500);
			} else if (paso == 4) {
				$('div#habitaciones_box_inner').animate({left: pos_left},500);
			}
				
			
		}
		
	}
	
	
	function habitaciones_ir(paso) {
		var pos_top, alto;
		var pos_left = paso * 744 * -1;
		$('div#habitaciones_box_inner').animate({left: pos_left},500);
		
		if (paso == 0) {
			alto = 364;
		} else if (paso == 1) {
			alto = 421;
		} else if (paso == 2) {
			alto = 439;
		} else if (paso == 3) {
			alto = 364;
		} else if (paso == 4) {
			alto = 197;
		}
		
		pos_top = ((alto - $('div.principal_fondo_cuerpo').height()) / 2 * -1) + parseInt($('div.principal_fondo').position().top);
		$('div.principal_fondo_cuerpo').animate({height: alto}, 500);
		$('div.principal_fondo').animate({top: pos_top}, 500);
		
		$('div.principal').css('margin-top',pos_top + 39);
	}
	
	
		
	function intro() {
		$('div#intro_circulo').fadeIn(4000,function() {
			$('div#intro_1').fadeIn(3000,function() {
				$('div#intro_2').fadeIn(3000,function() {
					$('div#intro_3').fadeIn(3000,function() {
						$('div#intro_4').fadeIn(3000,function() {
							
						});
					});
				});
			});
		});

	}
	
	function intro_end() {
		$('div#intro_velo').css('position','absolute');
		$('div#intro_velo').animate({height: 0},1500, function() {
			$('div#intro_velo').remove();
		});
		
		
		var name = 'orecanto_intro';
		var value = 1;
		var date = new Date();
	    date.setTime(date.getTime()+(60*60*1000));
	    var expires = "; expires="+date.toGMTString();
	    document.cookie = name+"="+value+expires+"; path=/";
	}
	
	


	

	function menu(b) {
		$('div.menu_boton').removeClass('menu_boton_activo');
		$('div#menu_boton_' + b).addClass('menu_boton_activo');
	}

	
	function menu_abrir(b) {
		
		$('div#bg2').css('display','block');
		$('div#bg2').css('background-image','url(' + $('img#fondo_' + b).attr('src') + ')');
		$('div#bg').fadeOut(1500, function() {
			$('div#bg').css('background-image', $('div#bg2').css('background-image'));
			$('div#bg').css('display','block');
			$('div#bg2').css('display','none');
		});
		
		var alto = $('input#alto_' + b).val();
		height = parseInt($('div.principal_fondo_cuerpo').css('height'));
		$('div.principal_fondo_cuerpo').animate({height: alto}, 500);
		
		var top = ($(window).height() - alto - 4) / 2;
		$('div.principal_fondo').animate({top: top}, 500);
		$('div.principal_fondo_cuerpo.')
		
		
		$('div#principal_wrapper').fadeOut(500,function() {
			modulo(['plantilla','seccion','&s=' + b,'pagina_nueva',0,b]);
			menu(b);
			
			if (b == "principal") {
				$('div.principal_fondo_cuerpo').css('background-color','#291604');
				$('div.principal_fondo_linea').css('background-color','#291604');
				$('div.principal_fondo').css('opacity','0.85');
			} else {
				$('div.principal_fondo_cuerpo').css('background-color','black');
				$('div.principal_fondo_linea').css('background-color','black');
				$('div.principal_fondo').css('opacity','0.4');
			}

		});
		
		return false;
	}
	
	
	
	
	function menu_over(b) {
		$('div#menu_sub_' + b).css('height','100px');
	}
	
	function menu_out(b) {
		$('div#menu_sub_' + b).css('height','0px');
	}
	
	
	
	
	function menu_sub(b,sub) {
		$('div.menu_boton').removeClass('menu_boton_activo');
		$('div.menu_sub_enlace').removeClass('menu_sub_enlace_activo');
		$('div#menu_sub_enlace_' + b + '_' + sub).addClass('menu_sub_enlace_activo');
	}

	

	function menu_sub_abrir(b,sub) {
		
		if (!b) {
			return false;
		}
		
		$('div#bg2').css('display','block');
		$('div#bg2').css('background-image','url(' + $('img#fondo_' + b + '_' + sub).attr('src') + ')');
		$('div#bg').fadeOut(1500, function() {
			$('div#bg').css('background-image', $('div#bg2').css('background-image'));
			$('div#bg').css('display','block');
			$('div#bg2').css('display','none');
		});
		
		var alto = $('input#alto_' + b + '_' + sub).val();
		height = parseInt($('div.principal_fondo_cuerpo').css('height'));
		$('div.principal_fondo_cuerpo').animate({height: alto}, 500);
		
		var top = ($(window).height() - alto - 4) / 2;
		$('div.principal_fondo').animate({top: top}, 500);
		$('div.principal_fondo_cuerpo.')
		
		
		$('div#principal_wrapper').fadeOut(500,function() {
			modulo(['plantilla','seccion','&s=' + b + '&sub=' + sub,'pagina_nueva',0,b + '_' + sub]);
			menu_sub(b,sub);
			$('div.principal_fondo_cuerpo').css('color','black');
			$('div.principal_fondo_linea').css('color','black');
			$('div.principal_fondo').css('opacity','0.4');
		});
		

		
		return false;
	}
	
	
	
	

	
	function ofertas_boton(paso,id) {
		
		var pos_top, alto;
		
		if (paso == 0) {
			alto = 423;
			response('');
			
		} else if (paso == 1) {
			alto = 469;
			parametros = "objeto=plantilla&funcion=ofertas&id_oferta=" + id;
			
			$.ajax({
				type: "GET",
		        url: "ajax.php?" + parametros,
		        async: false,
		        success: response 
			});

		}
		
		pos_top = ((alto - $('div.principal_fondo_cuerpo').height()) / 2 * -1) + parseInt($('div.principal_fondo').position().top);
		$('div.principal_fondo_cuerpo').animate({height: alto}, 500);
		$('div.principal_fondo').animate({top: pos_top}, 500);
		$('div.principal').css('margin-top',pos_top + 39);
		
		
		function response(data) {
			var pos_left = paso * 713 * -1;
			
			if (paso == 0) {
				$('div#ofertas_box_inner').animate({left: pos_left},500);
			} else if (paso == 1) {
				$('div#ofertas_box2').html(data);
				$('div#ofertas_box_inner').animate({left: pos_left},500);
			} 
				
			
		}
		
	}
	
	
	function ofertas_ir(paso) {
		var pos_left = paso * 713 * -1;
		$('div#habitaciones_box_inner').animate({left: pos_left},500);
		
	}	
	
	
	
	
	
	
	function plantilla_seccion_pre(v) {
		
		var b = "habitaciones";
		
		$('div#bg2').css('display','block');
		$('div#bg2').css('background-image','url(' + $('img#fondo_' + b).attr('src') + ')');
		$('div#bg').fadeOut(1500, function() {
			$('div#bg').css('background-image', $('div#bg2').css('background-image'));
			$('div#bg').css('display','block');
			$('div#bg2').css('display','none');
		});
		
		var alto = 439;
		height = parseInt($('div.principal_fondo_cuerpo').css('height'));
		$('div.principal_fondo_cuerpo').animate({height: alto}, 500);
		
		var top = ($(window).height() - alto - 4) / 2;
		$('div.principal_fondo').animate({top: top}, 500);
		$('div.principal_fondo_cuerpo.')
		
		
		$('div#principal_wrapper').fadeOut(500,function() {
			if (b == "hotel") {
				$('div.principal_fondo_cuerpo').css('color','#291604');
				$('div.principal_fondo_linea').css('color','#291604');
				$('div.principal_fondo').css('opacity','0.85');
			} else {
				$('div.principal_fondo_cuerpo').css('color','black');
				$('div.principal_fondo_linea').css('color','black');
				$('div.principal_fondo').css('opacity','0.4');
			}

		});
		
		sleep(500);
		
		return false;
	}
	
	
	
	function plantilla_seccion_post(b) {
			$('div#principal_wrapper').html($('div#pagina_nueva').html());
			$('div#pagina_nueva').html('');
			$('div.principal').css('margin-top', parseInt($('div.principal_fondo').css('top')) + 38);
			$('div#principal_wrapper').fadeIn(500, function() {
				$('a.colorbox').colorbox({rel: 'gal', maxWidth: '90%', maxHeight: '90%;'});
			});
	}
	
	
	
	


	function sleep(milliseconds) {
	  var start = new Date().getTime();
	  for (var i = 0; i < 1e7; i++) {
	    if ((new Date().getTime() - start) > milliseconds){
	      break;
	    }
	  }
	}


	
	
	function slide_h_desplazar(b, desp) {
	    slide_left = parseInt($('div#' + b).position().left);
	    slide_desp = desp;
	    slide_tope = ($('div#' + b).width() - $('div#' + b + '_wrapper').width()) * -1;
	    slide_h_desplazar2(b);
	}

	

	
	function slide_h_desplazar2(b) {
		
	    slide_left = slide_left + slide_desp;
		$('div#' + b).animate({left: slide_left},35, function() {
			if (slide_desp < 0) {
				if (slide_left <= slide_tope) {
					stop = 1;
					slide_left = slide_tope;
				}
			} else {
				if (slide_left >= 0) {
					stop = 1;
					slide_left = 0;
				}
			}

			slide_h_flechas(b);
			
			if (stop == 0) {
				slide_h_desplazar2(b);
	   		} else {
	   			clearTimeout(espera);
	   		}
			
		});
		
    }
	
	
	
	function slide_h_flechas(b) {
		
		if ($('div#' + b).width() > $('div#' + b + '_wrapper').width()) {
			$('div#flecha_' + b + '_der').css('visibility','visible');
			if ($('div#' + b).position().left < 0) {
				$('div#flecha_' + b + '_izq').css('visibility','visible');
			} else {
				$('div#flecha_' + b + '_izq').css('visibility','hidden');
			}
			
			if (slide_left <= slide_tope) {
				$('div#flecha_' + b + '_der').css('visibility','hidden');
			} else {
				$('div#flecha_' + b + '_der').css('visibility','visible');
			}
				
			
			
		} else {
			$('div.flecha_' + b).css('visibility','hidden');
			$('div#' + b).animate({left: 0}, 300);
		}
	}

    
	
	function slide_h_load(b) {
		
		if ($('div#' + b).width() > $('div#' + b + '_wrapper').width()) {
			$('div#flecha_' + b + '_der').css('visibility','visible');
		} else {
			$('div.flecha_' + b).css('visibility','hidden');
		}
		$('div#flecha_' + b + '_der').mouseover(function() {
			stop = 0;
			slide_h_desplazar(b,-10);
		});
		$('div#flecha_' + b + '_der').click(function() {
			stop = 1;
			slide_h_desplazar(b,-50);
		});
		$('div#flecha_' + b + '_der').mouseout(function() {
			slide_h_stop(b);
		});
		
		$('div#flecha_' + b + '_izq').mouseover(function() {
			stop = 0;
			slide_h_desplazar(b,10);
		});
		$('div#flecha_' + b + '_izq').click(function() {
			stop = 1;
			slide_h_desplazar(b,50);
		});
		$('div#flecha_' + b + '_izq').mouseout(function() {
			slide_h_stop(b);
		});
		
	}
	
	function slide_h_stop(b) {
		stop = 1;
	}
	
	
	
	

	function slide_v_desplazar(b, desp) {
	    slide_top = parseInt($('div#' + b).position().top);
	    slide_desp = desp;
	    slide_tope = ($('div#' + b).height() - $('div#' + b + '_wrapper').height()) * -1;
	    slide_v_desplazar2(b);
	}

	

	
	function slide_v_desplazar2(b) {
		
	    slide_top = slide_top + slide_desp;
		$('div#' + b).animate({top: slide_top},35, function() {
			if (slide_desp < 0) {
				if (slide_top <= slide_tope) {
					stop = 1;
					slide_top = slide_tope;
				}
			} else {
				if (slide_top >= 0) {
					stop = 1;
					slide_top = 0;
				}
			}

			slide_v_flechas(b);
			
			if (stop == 0) {
				slide_v_desplazar2(b);
	   		} else {
	   			clearTimeout(espera);
	   		}
			
		});
		
    }
	
	
	
	function slide_v_flechas(b) {
		
		if ($('div#' + b).height() > $('div#' + b + '_wrapper').height()) {
			$('div#flecha_' + b + '_aba').css('visibility','visible');
			if ($('div#' + b).position().top < 0) {
				$('div#flecha_' + b + '_arr').css('visibility','visible');
			} else {
				$('div#flecha_' + b + '_arr').css('visibility','hidden');
			}
			
			if (slide_top <= slide_tope) {
				$('div#flecha_' + b + '_aba').css('visibility','hidden');
			} else {
				$('div#flecha_' + b + '_aba').css('visibility','visible');
			}
				
			
			
		} else {
			$('div.flecha_' + b).css('visibility','hidden');
			$('div#' + b).animate({top: 0}, 300);
		}
	}

    
	
	function slide_v_load(b) {
		if ($('div#' + b).height() > $('div#' + b + '_wrapper').height()) {
			$('div#flecha_' + b + '_aba').css('visibility','visible');
		} else {
			$('div.flecha_' + b).css('visibility','hidden');
		}
		$('div#flecha_' + b + '_aba').mouseover(function() {
			stop = 0;
			slide_v_desplazar(b,-10);
		});
		$('div#flecha_' + b + '_aba').click(function() {
			stop = 1;
			slide_v_desplazar(b,-50);
		});
		$('div#flecha_' + b + '_aba').mouseout(function() {
			slide_v_stop(b);
		});
		
		$('div#flecha_' + b + '_arr').mouseover(function() {
			stop = 0;
			slide_v_desplazar(b,10);
		});
		$('div#flecha_' + b + '_arr').click(function() {
			stop = 1;
			slide_v_desplazar(b,50);
		});
		$('div#flecha_' + b + '_arr').mouseout(function() {
			slide_v_stop(b);
		});
		
	}
	
	function slide_v_stop(b) {
		stop = 1;
	}