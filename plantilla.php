<?php

class plantilla {

	private $seccion;
	
	function analytics() {
		
		$o = "
		<script type=\"text/javascript\">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-35055199-1']);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		
		</script>
		";
		
		return $o;
	}
	
	
	
	
	function cabecera_html() {

		$seccion = $GLOBALS["seccion"];
		$titulos["habitaciones"] = "HABITACIONES";
		$titulos["tarifas"] = "TARIFAS";
		$titulos["ofertas"] = "OFERTAS";
		$titulos["como_llegar"] = "COMO LLEGAR";
		
		if ($titulos[$seccion]) {
			$titulo = "- " . $titulos[$seccion];
		}
		
		
		$o = "
	<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
	<html xmlns='http://www.w3.org/1999/xhtml'>
		<head>
		  	<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
			<meta http-equiv='Content-Script-Type' content='type' />
			<meta http-equiv='Content-Style-Type' content='text/css' />
			<meta http-equiv='cache-control' content='no-cache'/>
			<title>La Almazara de Valdeverdeja $titulo</title>
			
			<link href='css/reset.css' rel='stylesheet' type='text/css' />	
			<link href='css/almazara.css' rel='stylesheet' type='text/css' />
			<link rel='stylesheet' type='text/css' href='js/colorbox/colorbox.css' media='screen' />
			<link rel='stylesheet' type='text/css' href='css/jquery/jquery-ui.css' />

			<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'/>
			<link href='http://fonts.googleapis.com/css?family=Playfair+Display:400,700' rel='stylesheet' type='text/css'/>
			<link href='http://fonts.googleapis.com/css?family=Droid+Serif' rel='stylesheet' type='text/css'/>
			
			<script type='text/javascript' src='js/jquery.js'></script>
			<script type='text/javascript' src='js/jquery-ui.js'></script>
			<script type='text/javascript' src='js/ajax.js'></script>
			<script type='text/javascript' src='js/almazara.js'></script>
			<script type='text/javascript' src='js/colorbox/jquery.colorbox.js'></script>
			<script type='text/javascript' src='js/ui.datepicker-es.js'></script>
			
		</head>
	
		<body>
		";
		
		return $o;
	
	}


	
	
	
	
	
	
	
	function cabecera() {
		
		$o .= "	
			<div id='cabecera_interior'>
				<div id='logo'><span class='todo' onclick=\"return menu_abrir('principal');\"></span></div>
				" . $this->menu_principal() . "
			</div>
			
		
		";
		return $o;
		
	}
	
	
	
	
	
	
	
	
	
	
	
	function como_llegar() {

		$texto = new texto();
		
		$o .= "
		<div id='como_llegar_box'>
			<div class='fondo1' id='como_llegar_izq'>
				<div id='como_llegar_izq_inner'>
					<h2>COMO LLEGAR</h2>
					<div style='height: 12px;'></div>
					<ul class='como_llegar'>
						<li>" . $texto->texto("como_llegar","direccion") . "</li>
						<li>" . $texto->texto("como_llegar","gps") . "</li>
					</ul>
	
					<div style='height: 15px;'></div>
					
					<h2>CONTACTO</h2>
					
					<div style='height: 11px;'></div>
					<ul class='como_llegar'>
						<li>" . $texto->texto("como_llegar","telefonos") . "</li>
						<li>" . $texto->texto("como_llegar","email") . "</li>
					</ul>
				</div>
			</div>
			
			<div id='como_llegar_der'>
				<div class='fondo2' id='como_llegar_arr'>
					<div id='como_llegar_gmaps'>
						<div id='como_llegar_gmaps_inner'>
							" . $texto->texto("como_llegar","gmaps") . "
						</div>
					</div>
				</div>
				
				<div class='fondo3' id='como_llegar_aba'>
					<div id='como_llegar_aba_inner'>
						<form id='form_ruta' onsubmit='google_ruta();return false;'>
							Para calcular su ruta introduzca la direcci&oacute;n de origen
							<div style='height: 5px;'></div>
							<div id='como_llegar_direccion'>
								<input type='text' class='todo' name='origen' id='origen' value='' style='border: 1px solid #b3a289; width: 300px;'/>
							</div>
							<div id='como_llegar_boton'>
								<input type='submit' class='cursor' name='calcular' id='calcular' value='CALCULAR'/>
							</div>
						</form>
					</div>
				</div>
			
			</div>
		
		
		</div>
			   
			   ";
		
		
		return $o;
	}	
	
	
	
	
	
	
	
	
	
	function habitaciones() {

		if ($_REQUEST["externo"]) {
			if ($_REQUEST["id_tipo"]) {
				$b2 .= $this->habitaciones_tipo() . "</div>";
				$estilo = " style='left: -744px;'";
			} else if ($_REQUEST["id_habitacion"]) {
				include_once("habitacion.php");
				$habitacion = new habitacion();
				$b3 .= $habitacion->plantilla();
				$estilo = " style='left: -1488px;'";
			}
			
		} else if ($_REQUEST["interno"]) {
			if ($_REQUEST["id_habitacion"]) {
				include_once("habitacion.php");
				$habitacion = new habitacion();
				$b3 .= $habitacion->plantilla();
				$estilo = " style='left: -1488px;'";
			}
			
		} else {
			if ($_REQUEST["id_tipo"]) {
				$o .= $this->habitaciones_tipo();
				return $o;
			} else if ($_REQUEST["id_habitacion"]) {
				
				if ($_REQUEST["reservar"]) {
					include_once("contacto.php");
					$contacto = new contacto();
					$o .= $contacto->reservar();
						
				} else {
					include_once("habitacion.php");
					$habitacion = new habitacion();
					$o .= $habitacion->plantilla();
				}
				return $o;
			}
		}
		
		$texto = new texto();
		
		$o .= "
		<div id='habitaciones_box'>
			<div id='habitaciones_box_inner' $estilo>
				<div class='habitaciones_box'>
					<div id='habitaciones_box1'>
						<div class='fondo1' id='habitaciones_texto'>
						  	<div id='habitaciones_texto_inner'>
						  		<h2>" . $texto->titulo("habitaciones","texto") . "</h2>
						  		<div style='height: 24px;'></div>
						  		" . $texto->datos["texto"] . "
						  	</div>
						</div>
					<div id='habitaciones_menu'>";
		
		$width = 55;
		$height = 34;
		
		$texto->texto("habitaciones","tipo1");
		$o .= "	<div class='habitaciones_boton cursor' onclick=\"habitaciones_boton(2,11);\">
					<div class='habitaciones_boton_imagen'>" . $texto->imagen($width, $height) . "</div>
					<div class='habitaciones_boton_texto'>" . $texto->datos["texto"] . "</div>
					<a class='todo' href='?s=habitaciones&paso=2&id_habitacion=11&externo=1&habitacion=" . htmlentities("HABITACIÓN DOBLE") . "' onclick='return no();'></a>			
				</div>
				";

		$texto->texto("habitaciones","tipo2");
		$o .= "	<div class='habitaciones_boton cursor' onclick=\"habitaciones_boton(2,12);\">
					<div class='habitaciones_boton_imagen'>" . $texto->imagen($width, $height) . "</div>
					<div class='habitaciones_boton_texto'>" . $texto->datos["texto"] . "</div>
					<a class='todo' href='?s=habitaciones&paso=2&id_habitacion=12&externo=1&tipo=" . htmlentities("SUITE AZUL") . "' onclick='return no();'></a>			
				</div>
				";
		
		$texto->texto("habitaciones","tipo3");
		$o .= "	<div class='habitaciones_boton cursor' onclick=\"habitaciones_boton(1,3);\">
					<div class='habitaciones_boton_imagen'>" . $texto->imagen($width, $height) . "</div>
					<div class='habitaciones_boton_texto'>" . $texto->datos["texto"] . "</div>
					<a class='todo' href='?s=habitaciones&paso=1&id_tipo=3&externo=1&tipo=villas' onclick='return no();'></a>
				</div>
		";
		
		$texto->titulo("habitaciones","texto");
		$o .= "
						<div id='habitaciones_imagen'>
							" . $texto->imagen(185,134) . "
						</div>
						</div>
			
					</div>
			   </div>
			   
			   
			   <div class='habitaciones_box'>
			   	<div id='habitaciones_box2'>$b2</div>
			   </div>
			   <div class='habitaciones_box'>
			   	<div id='habitaciones_box3'>$b3</div>
			   </div>
			   <div class='habitaciones_box'>
			   	<div class='habitaciones_box' id='habitaciones_box4'></div>
			   </div>
			   <div class='habitaciones_box'>
			   	<div class='habitaciones_box' id='habitaciones_box5'></div>
			   </div>
			</div>
		</div>
			   
			   ";
		
		
		return $o;
	}	
	
	
	
	
	
	function habitaciones_tipo() {
		
		$id_tipo = $_REQUEST["id_tipo"];

		$o .= "
			<div class='cursor flecha_volver' onclick=\"habitaciones_boton(0,0);\"></div>
		";
		
		$tipos[1] = "habitaciones_dobles";
		$tipos[2] = "suite_azul";
		$tipos[3] = "villas";
		 
		if ($tipo = $tipos[$id_tipo]) {
			
		} else {
			return;
		}
		
		$texto = new texto();
		
		$o .= "
					<div class='fondo1 habitaciones_texto2'>
					  	<div id='habitaciones_texto_inner'>
					  		<h2>" . $texto->titulo("habitaciones",$tipo) . "</h2>
					  		<div style='height: 24px;'></div>
					  		" . $texto->datos["texto"] . "
					  	</div>
					</div>
					<div class='habitaciones_menu2'>";
		
		$width = 55;
		$height = 34;
		
		$q = "SELECT * FROM habitacion WHERE id_tipo = $id_tipo AND activo = 1 ORDER BY orden";
		$r = mysql_query($q);
		
		if (mysql_num_rows($r)) {
			include_once("habitacion.php");
			$habitacion = new habitacion();
		
			while ($habitacion->datos = mysql_fetch_array($r)) {
				$habitacion->id = $habitacion->datos["id"];
				$o .= $habitacion->boton();	
			}
		}
				
		return $o;
	}
	
	
	
	
	
	
	function hotel() {
		return principal();
	}
	
	
	
	
	function hotel_principal() {
		
		$texto = new texto();
		
		$o .= "
			<div style='height: 25px;'></div>
				<h2 class='principal'>" . $texto->titulo("hotel","presentacion") . "</h2>
				
			<div style='height: 25px;'></div>
				" . $texto->datos["texto"] . "
				
		";
		
		return $o;
		
	}
	
	
	
	
	
	function hotel_actividades() {
		
		include_once("actividad.php");
		$actividad = new actividad();
		
		$q = "SELECT * FROM actividad WHERE activo = 1 ORDER BY orden";
		$r = mysql_query($q);
		
		if (mysql_num_rows($r)) {
			$o .= "<div id='actividades_box'>";
			while ($actividad->datos = mysql_fetch_array($r)) {
				 $actividad->id = $actividad->datos["id"];
				 $o .= $actividad->plantilla();
			}
			$o .= "</div>";
		}
		
		
		return $o;
	}	
	
	
	function hotel_exteriores() {
		
		$texto = new texto;
		
		$o .= "
		<div class='fondo1' id='exteriores_up'>
			<div id='exteriores_up_inner'>
				<h2>" . $texto->titulo("exteriores","galeria") . "</h2>
				<div style='height: 20px;'></div>
				" . $texto->datos["texto"] . "
			</div>
		</div>
		";
		
		$imagen = new imagen();
		$imagen->id_imagen_tipo = 3;
		$o .= $imagen->galeria2("hotel", "exteriores");
		return $o;
	}
	
	
	function hotel_interiores() {
		$imagen = new imagen();
		$imagen->id_imagen_tipo = 3;
		$o .= $imagen->galeria("hotel", "interiores");
		return $o;
	}
	
	
	
	
	
	function menu() {
		
		$seccion = $GLOBALS["seccion"];
		$activo[$seccion] = "menu_boton_activo";
		
		$o .= "
		<div id='menu_fondo'>
			<div id='menu_contenido'>
			 <div id='menu_logo'>
			 	<span class='cursor' onclick=\"return menu_abrir('principal');\"><img src='img/logo.png' alt='Hotel La Almazara de Valdeverdeja'/></span>
			 </div>
				";
		
		$q = "SELECT * FROM seccion WHERE id_padre = 0 AND activo = 1 ORDER BY orden";
		$r = mysql_query($q);
		
		$o .= "
		<div id='menu_izq'>
			<div class='menu_boton right " . $activo["tarifas"] . " cursor' id='menu_boton_tarifas' onclick=\"return menu_abrir('tarifas');\">
				<div class='menu_enlace ' id='menu_tarifas'>
					<a id='a_tarifas' class='" . $activo['tarifas'] . "' href='index.php?s=tarifas' onclick=\"return no();\">TARIFAS</a>
				</div>
			</div>
			<div class='menu_separador right'></div>
			<div class='menu_boton right " . $activo["habitaciones"] . " cursor'  id='menu_boton_habitaciones' onclick=\"return menu_abrir('habitaciones');\">
				<div class='menu_enlace ' id='menu_habitaciones'>
					<a id='a_habitaciones' class='" . $activo['habitaciones'] . "' href='index.php?s=habitaciones' onclick=\"return no();\">HABITACIONES</a>
				</div>
			</div>
			<div class='menu_separador right'></div>
			<div class='menu_grupo right' id='menu_grupo_hotel' onmouseover=\"menu_over('hotel');\" onmouseout=\"menu_out('hotel');\">
				<div class='menu_boton " . $activo["hotel"] . " cursor' id='menu_boton_hotel' onclick=\"return menu_abrir('principal');\">
					<div class='menu_enlace ' id='menu_hotel'>
						<a id='a_hotel' class='" . $activo['hotel'] . "' href='?' onclick=\"return no();\">PRINCIPAL</a>
					</div>
				</div>
				<div class='menu_sub ease' id='menu_sub_hotel'>
					<div class='menu_sub_enlace cursor' id='menu_sub_enlace_hotel_interiores' onclick=\"menu_sub_abrir('hotel','interiores');\">
						<a href='?" . urlencode("s=hotel&sub=interiores") . "' onclick=\"return menu_sub_abrir();\">Interiores</a>
					</div>
					<div class='menu_sub_enlace cursor' id='menu_sub_enlace_hotel_exteriores' onclick=\"menu_sub_abrir('hotel','exteriores');\">
						<a href='?" . urlencode("s=hotel&sub=exteriores") . "' onclick=\"return menu_sub_abrir();\">Exteriores</a>
					</div>
					<div class='menu_sub_enlace cursor' id='menu_sub_enlace_hotel_actividades' onclick=\"menu_sub_abrir('hotel','actividades');\">
						<a href='?" . urlencode("s=hotel&sub=actividades") . "' onclick=\"return menu_sub_abrir();\">Actividades</a>
					</div>
				</div>
				
			</div>
			<div class='menu_separador right'></div>
		</div>
		
		<div id='menu_der'>
			<div class='menu_boton left " . $activo["ofertas"] . " cursor' onclick=\"return menu_abrir('ofertas');\" id='menu_boton_ofertas'>
				<div class='menu_enlace ' id='menu_ofertas'>
					<a id='a_ofertas' class='" . $activo['ofertas'] . "' href='index.php?s=ofertas' onclick=\"return no();\">OFERTAS</a>
				</div>
			</div>
			<div class='menu_separador left'></div>
			<div class='menu_boton left " . $activo["como_llegar"] . " cursor' onclick=\"return menu_abrir('como_llegar');\" id='menu_boton_como_llegar'>
				<div class='menu_enlace ' id='menu_como_llegar'>
					<a id='a_como_llegar' class='" . $activo['como_llegar'] . "' href='index.php?s=como_llegar' onclick=\"return no();\">COMO LLEGAR</a>
				</div>
			</div>
			<div class='menu_separador left'></div>
		</div>
	</div>	
</div>
		";
		
	
		
		return $o;
		
	}
				
		
	

	
	
	
	
	
	function ofertas() {

		include_once("oferta.php");
		$oferta = new oferta();
			
		if ($_REQUEST["id_oferta"]) {
			$o .= $oferta->plantilla();
			return $o;
		}
		
		$texto = new texto();
		
		$o .= "
		<div id='ofertas_box'>
			<div id='ofertas_box_inner'>
				<div class='ofertas_box'>
					<div id='ofertas_box1'>
						<div class='cursor flecha_ofertas_listado flecha_arr' id='flecha_ofertas_listado_arr'></div>
		";
		
		
		$o .= "
						<div class='slide_wrapper' id='ofertas_listado_wrapper'>";
		
		$fecha = fecha_hoy();
		
		$q = "SELECT * FROM oferta WHERE activo = 1 AND (fecha_fin is NULL OR fecha_fin >= '$fecha') ORDER BY orden";
		$r = mysql_query($q);
		
		if ($num = mysql_num_rows($r)) {
			if ($num > 4) {
				$alto = $num*73;
			} else {
				$alto = 292;
			}
			$o .= "<div class='slide' id='ofertas_listado' style='height: " . $alto . "px;'>";
			while ($oferta->datos = mysql_fetch_array($r)) {
				$oferta->id = $oferta->datos["id"];
				$o .= $oferta->plantilla_resumen();
			}
			$o .= "</div>";
		}
		
		$o .= "
						</div>
						<div class='cursor flecha_ofertas_listado flecha_aba' id='flecha_ofertas_listado_aba'></div>
					</div>
				</div>
					
			<script>
				setTimeout(function() {slide_v_load('ofertas_listado');},500);
			</script>";
		
		
		
		$o .= "
			   
			   
			   <div class='ofertas_box'>
				   	<div id='ofertas_box2'></div>
			   </div>
			</div>
		</div>
			   
			   ";
		
		
		return $o;
	}	
	
	
	
	
	
	
	
	
	
	
	
	
	function pie() {
		
		$texto = new texto();
		
		
		$o .= "
		<div id='pie'>
			<div id='pie_trans'></div>
			<div id='pie_contenido'>
				<div id='pie_direccion'>
					" . $texto->texto("hotel","direccion") . "
				</div> 
				<div id='pie_logos'>
					<span id='recomendado'>&nbsp;</span>
					<div style='height: 7px;'></div>
					<a href='http://www.guiarepsol.com/es_es/turismo/reportajes/otros/seleccion_hoteles_rurales.aspx' onclick=\"window.open('http://www.guiarepsol.com/es_es/turismo/reportajes/otros/seleccion_hoteles_rurales.aspx');return false;\" onkeypress=onclick=\"window.open('http://www.guiarepsol.com/es_es/turismo/reportajes/otros/seleccion_hoteles_rurales.aspx');return false;\"><img class='3rd' id='third_repsol' src='img/logo_repsol.png' alt='Recomendado en Gu&iacute;a Repsol'/></a>
					<a href='http://www.latribunadetalavera.es/noticia.cfm/Local/20101127/familia/cope/60C83AC0-DAB2-C705-84102A2F601D3CD4' onclick=\"window.open('http://www.latribunadetalavera.es/noticia.cfm/Local/20101127/familia/cope/60C83AC0-DAB2-C705-84102A2F601D3CD4');return false;\" onkeypress=onclick=\"window.open('http://www.latribunadetalavera.es/noticia.cfm/Local/20101127/familia/cope/60C83AC0-DAB2-C705-84102A2F601D3CD4');return false;\"><img class='3rd' id='third_cope' src='img/logo_cope.png' alt='Premio COPE al mérito empresarial'/></a>
					<a href='http://www.trivago.es/valdeverdeja-104591/hotel/la-almazara-165286/opiniones' onclick=\"window.open('http://www.trivago.es/valdeverdeja-104591/hotel/la-almazara-165286/opiniones');return false;\" onkeypress=onclick=\"window.open('http://www.trivago.es/valdeverdeja-104591/hotel/la-almazara-165286/opiniones');return false;\"><img class='3rd' id='third_trivago' src='img/logo_trivago.png' alt='&nbsp;'/></a>
					<a href='http://www.tripadvisor.es/Hotel_Review-g1072382-d1341533-Reviews-Almazara_de_Valdeverdeja-Valdeverdeja_Province_of_Toledo_Castile_La_Mancha.html' onclick=\"window.open('http://www.tripadvisor.es/Hotel_Review-g1072382-d1341533-Reviews-Almazara_de_Valdeverdeja-Valdeverdeja_Province_of_Toledo_Castile_La_Mancha.html');return false;\" onkeypress=onclick=\"window.open('http://www.tripadvisor.es/Hotel_Review-g1072382-d1341533-Reviews-Almazara_de_Valdeverdeja-Valdeverdeja_Province_of_Toledo_Castile_La_Mancha.html');return false;\"><img class='3rd' id='third_tripadvisor' src='img/logo_tripadvisor.png' alt='Recomendado en Trip Advisor'/></a>
					<a href='http://www.johansens.com/spain/toledo' onclick=\"window.open('http://www.johansens.com/spain/toledo');return false;\" onkeypress=onclick=\"window.open('http://www.johansens.com/spain/toledo');return false;\"><img class='3rd' id='third_j' src='img/logo_j.png' alt='Recomendado por Conde Nast Johansen&apos;s Prefred Hotels'/></a>
				</div>
			</div>
		</div>";
		
		return $o;
			
	}

	
	
	
	
	
	
	function presentacion() {
		
		$texto = new texto();
		
		
		$o .= "<div id='banda'></div>
			<div id='titulo'>
				<h1>" . $texto->texto("presentacion", "lema") . "</h1>
			</div>
		";
		
		return $o;
	}
	
	
	
	
	

	
	
	
	function principal() {
		
		$this->seccion = $GLOBALS["seccion"];
		$sub = $GLOBALS["sub"];
		
		if (($this->seccion == "hotel") && $sub) {
			$this->seccion .= "_" . $sub;
		}
		$seccion = $this->seccion;
		
		
/*		if (!$_COOKIE["almazara_intro"]) {
			$o .= "
				<div class='transition_no' id='intro_velo'>
					<div id='intro_fondo'>
						<img src='img/intro_fondo.jpg' alt=''/>
					</div>
					
					<div class='cursor transition_no hidden' id='intro_circulo' onclick='intro_end();'>
						<div class='hidden transition_no intro_frase' id='intro_1'></div>
						<div class='hidden transition_no intro_frase' id='intro_2'></div>
						<div class='hidden transition_no intro_frase' id='intro_3'></div>
						<div class='hidden transition_no intro_frase' id='intro_4'></div>
					</div>
					
				</div>
				
				<script type='text/javascript'>
					$('div#intro_circulo').ready(function() {
						intro();
					});
				</script>
			";
		}*/

		
		$q = "SELECT * FROM texto WHERE nombre like 'fondo'";
		$r = mysql_query($q);
		
		if (mysql_num_rows($r)) {
			include_once("seccion.php");
			$sec = new seccion();
			while ($fila = mysql_fetch_array($r)) {
				$sec->id = $fila["id_seccion"];
				$sec->recuperar();
				$nombre = $sec->datos["nombre"];
				
				$q = "SELECT nombre FROM imagen WHERE id_relacionada = " . $fila["id"] . " AND id_imagen_tipo = 3";
				$r2 = mysql_query($q);
				
				$archivo = mysql_result($r2,0,0);
				
				$fondos[$nombre] = $archivo;
			}
			$fondos["hotel_actividades"] = $fondos["actividades"];
			$fondos["hotel_interiores"] = $fondos["interiores"];
			$fondos["hotel_exteriores"] = $fondos["exteriores"];
			$fondos["principal"] = $fondos["hotel"];
			$fondos["hotel_principal"] = $fondos["hotel"];
		}
		
		
		if ($seccion == "habitaciones" && $_REQUEST["id_tipo"]) {
			$estilo = "style='height: 421px;'";
		} else if ($seccion == "habitaciones" && $_REQUEST["id_habitacion"]) {
			$estilo = "style='height: 439px;'";
		}
		
		
		$o .= "
			<div id='bg_wrapper'>
				<div id='bg' style='background-image: url(fotos/textos/" . $fondos[$seccion] . ");'></div>
				<div id='bg2'></div>
			</div>

			<div id='menu'>
				" . $this->menu() . "
			</div>
			
			" . $this->pie() . "
			
			<div class='principal_fondo' id='principal_fondo_$seccion'>
				<div class='principal_fondo_linea principal_fondo_linea_$seccion'></div>
				<div class='principal_fondo_cuerpo' id='principal_fondo_cuerpo_$seccion' $estilo></div>
				<div class='principal_fondo_linea principal_fondo_linea_$seccion'></div>
			</div>

			<div id='todo'>
			
				<div id='principal_wrapper'>

				" . $this->principal_wrapper() . "
					
				</div>
			</div>
		";

		if ($fondos) {
			$o .= "<div id='temp'>";
			foreach ($fondos as $seccion => $fondo) {
				$o .= "<img id='fondo_$seccion' src='fotos/textos/" . $fondo ."' alt=''/>";
			}
			$o .= "
				<input type='hidden' id='alto_como_llegar' value='439'/>
				<input type='hidden' id='alto_habitaciones' value='364'/>
				<input type='hidden' id='alto_hotel_actividades' value='364'/>
				<input type='hidden' id='alto_hotel_exteriores' value='364'/>
				<input type='hidden' id='alto_hotel_interiores' value='364'/>
				<input type='hidden' id='alto_principal' value='296'/>
				<input type='hidden' id='alto_ofertas' value='426'/>
				<input type='hidden' id='alto_tarifas' value='317'/>
				<div id='pagina_nueva'></div>
			</div>";
		}

			
		$o .= $this->analytics() . "

			</body>
			</html>
				
		";
		
		
		return $o;
	
	}
	
	
	
	function principal_wrapper() {
		
		$seccion = $this->seccion;

		$o .= "		<div class='principal' id='principal_$seccion'>
						" . $this->$seccion() . "
					</div>
					
		";
		return $o;
		
	}
	
	
	
	
	
	
	
	
	function seccion() {
		
		$this->seccion = $_REQUEST["s"];
		$sub = $_REQUEST["sub"];
		
		$secciones = array("hotel", "hotel_interiores", "hotel_exteriores", 
			"hotel_actividades", "habitaciones", "tarifas", 
			"ofertas", "como_llegar");
		
		foreach ($secciones as $sec) {
			$validos[$sec] = 1;
		}
		
		if ($sub) {
			$this->seccion .= "_" . $sub;
		}
		$seccion = $this->seccion;
		
		
		if ($validos[$seccion]) {
		} else {
			$this->seccion = "hotel_principal";
		}
		
		return $this->principal_wrapper();
		
	}

	
	
	
	
	
	
	
	function tarifas() {

		include_once("habitacion.php");
		$hab = new habitacion();
		
		$texto = new texto();
		
		$o .= "
		<div id='tarifas_box'>";
		
		$q = "SELECT * FROM habitacion WHERE activo = 1 ORDER BY id_tipo, orden";
		$r = mysql_query($q);
		
		if ($num = mysql_num_rows($r)) {
			$num_hab = ceil($num / 3);
			
			$o .= "<div class='tarifas_col'>";
			$i = 0;
			while ($hab->datos = mysql_fetch_array($r)) {
				if ($i == $num_hab) {
					$i = 0;
					$o .= "</div><div class='tarifas_col'>";
				}
				$hab->id = $hab->datos["id"];
				$o .= $hab->plantilla_resumen();
				$i += 1; // cyb
			}
			$o .= "</div>";
			
		}
		$o .= "<div class='clear'></div>
		
			<div id='tarifas_abajo'>
				" . $texto->texto("tarifas","texto") . "
			</div>
		
		</div>
			   
			   ";
		
		
		return $o;
	}	
	
	
	
	

}


?>
