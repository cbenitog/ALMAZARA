<?php


class plantilla {
	

	private $id;

	
	
	
	function actividad() {
		
		include_once 'actividad.php';
		$actividad = new actividad();
		
		
		$o .= "
			<input type='hidden' id='funcion' value='texto'/>
			
			<div style='clear:both; height: 10px;'></div>";
		
		$o .= "<div class='tabla' id='tabla_actividad'>";
		$o .= $actividad->tabla();
		$o .= "</div>";
		
		return $o;
		
	}
	
	
	function actividad_bloque2() {
		
		
	}
	
			
	
	
	function cabecera() {
		
		
	
		$o .= "
			<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
			<html xmlns='http://www.w3.org/1999/xhtml' lang='es' xml:lang='es'>
			<head>
				<title>Backoffice - La Almazara de Valdeverdeja</title>
				<meta content='JavaScript' name='vs_defaultClientScript'/>
				<meta http-equiv='Content-Type' content='text/html;charset=iso-8859-1'/>
				
				<link href='../css/reset.css' rel='stylesheet' type='text/css' media='screen' />
				<link href='../css/backoffice.css' type='text/css' rel='stylesheet'/>
				<link rel='stylesheet' type='text/css' media='all' href='../css/jquery-ui.css'>
				<link rel='stylesheet' type='text/css' href='../js/colorbox/colorbox.css' media='screen' />
				
				<script type='text/javascript' src='../js/ckeditor/ckeditor.js'></script>
				<script type='text/javascript' src='../js/ckeditor/jquery.CKEditor.js'></script>
				<script type='text/javascript' src='../js/jquery.js'></script>
				<script type='text/javascript' src='../js/jquery-ui.js'></script>
				<script type='text/javascript' src='../js/ui.datepicker-es.js'></script>
				
				<script language='JavaScript' type='text/javascript' src='../js/ajax.js'></script>
				<script language='JavaScript' type='text/javascript' src='../js/ajaxupload.js'></script>
				";
	
		if ($GLOBALS["usuario"]->id_usuario) {
			$o .= "<script type='text/javascript' src='../js/backoffice.js'></script>
				";
		}
		
		$o .= "	<script type='text/javascript' src='../js/almazara.js'></script>
				<script type='text/javascript' src='../js/jquery.progressbar.js'></script>
				<script type='text/javascript' src='../js/colorbox/jquery.colorbox.js'></script>
				
			</head>
		";	
		
		return $o;	
		
	}
	



	
	
	
	
	
	
	
	
	

	
	
	
		
	
	
	

	
	
	
	
	
	
	
	function contacto() {
		
		include_once '../contacto.php';
		$contacto = new contacto();
		
		
		$o .= "<div style='clear:both; height: 10px;'></div>
				<input type='hidden' id='funcion' value='contacto'/>
			";
				
		$o .= "<div class='tabla' id='tabla_contacto'>";
		$o .= $contacto->tabla();
		$o .= "</div>";
		
		return $o;
		
	}
	
	
	
	
	
	
	
	
	
	function contacto_bloque2() {
		
		return $o;
	}


	
	
	
	
	
	
	function habitacion() {
		
		include_once 'habitacion.php';
		$habitacion = new habitacion();
		
		
		$o .= "
			<input type='hidden' id='funcion' value='texto'/>
			
			<div style='clear:both; height: 10px;'></div>";
		
		$o .= "<div class='tabla' id='tabla_habitacion'>";
		$o .= $habitacion->tabla();
		$o .= "</div>";
		
		return $o;
		
	}
	
	
	function habitacion_bloque2() {
		
		
	}
	
	
	
	
	

		
		
	function imagen() {
		
		include_once 'imagen.php';
		$imagen = new imagen();
		$imagen->id_imagen_tipo = 1;
		
		include_once("imagen_tipo.php");
		$tipo = new imagen_tipo();
		$tipo->id = 1;
		
		
		$o .= "<div style='clear:both; height: 10px;'></div>
				<input type='hidden' id='funcion' value='imagen'/>
			";
		
		$o .= "Tipo: " . $tipo->select("id_imagen_tipo", "onchange=\"formulario2(['imagen','tabla',['id_imagen_tipo'],'tabla_imagen',0,0]);\"") . 
				"<br/><br/>
				<div class='tabla' id='tabla_imagen'>";
		$o .= $imagen->tabla();
		$o .= "</div>";
		
		return $o;
		
	}
	
	
	
	
	
	
	
	
	
	function imagen_bloque2() {
		
		return $o;
	}


	
	
	
	
	
	
	
	
	

	
	
	
	function login() {
		
		if (!$GLOBALS["usuario"]->id) {
			if ($_REQUEST["login"]) {
				$usuario = new usuario();
				$resultado = $usuario->login_usuario('');
				
				if ($usuario->error) {
					
					$texto .= error($usuario->error_texto);
					
				} else {
					$texto = "$resultado
						<script type='text/javascript'>
						<!--
							redirigir('index.php?',2000);
						//-->
						</script>
						";
					return $texto;
					
				}
			}
			
			$o = $texto;
			
			$o .= " 
				<div id='div_login'>
				
					<div class='center' ><img src='img/logo.png'/></div>
				
					<p class='texto_login' style='text-align: center;'>Introduce tu nombre de usuario y contrase&ntilde;a para acceder al backoffice</p>
									
					<div id='form_login'>
								
						<form method='post' action='index.php?objeto=plantilla&funcion=login' id='login'>
							<label class='form_login' for='usuario'>Usuario:</label><br />
	      					<input id='usuario' name='usuario' value='" . $_REQUEST["usuario"] . "'/> <br />
	      					
	      					<label class='form_login' for='pass'>Contrase&ntilde;a</label><br />
	      					<input type='password' id='password' name='password' value=''/>
	      					<input type='submit' name='login' value='enviar' style='display: none;'/>
	      					<p><input type='submit' id='login' name='login' value='enviar'/>	</p>
						</form>
					</div>
				</div>
				";
						
		} else {
			$o .= "Hay abierta una sesión de usuario, puedes volver al 
					<a href='index.php?'>inicio</a> o <a href='logout.php?'>desconectar</a>";
		}
		
		return $o;
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	

	

	

	
	
	
	
	
	
	

	function novedad() {
		
		include_once '../novedad.php';
		$novedad = new novedad();
		
		
		$o .= "<div style='clear:both; height: 10px;'></div>
				<input type='hidden' id='funcion' value='novedad'/>
			";
		
		$o .= "<div class='tabla' id='tabla_novedad'>";
		$o .= $novedad->tabla();
		$o .= "</div>";
		
		return $o;
		
	}
	
	
	
	
	
	
	
	
	
	function novedad_bloque2() {
		
		return $o;
	}
	
	
	
	
	function oferta() {
		
		include_once 'oferta.php';
		$oferta = new oferta();
		
		
		$o .= "
			<input type='hidden' id='funcion' value='texto'/>
			
			<div style='clear:both; height: 10px;'></div>";
		
		$o .= "<div class='tabla' id='tabla_oferta'>";
		$o .= $oferta->tabla();
		$o .= "</div>";
		
		return $o;
		
	}
	
	
	function oferta_bloque2() {
		
		
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	function principal() {
		
		$objeto = $_REQUEST["objeto"];
		$funcion = $_REQUEST["funcion"];
		
		if (!$GLOBALS["usuario"]->id_usuario) {
			$o .= $this->login();
			return $o;
		}
		
		if (!$objeto) {
			$objeto = "plantilla";
		} 
		
		if (!$funcion) {
			$funcion = "presentacion";
		}
		
		if (!objeto_valido($objeto,$funcion)) {
			$o .= acceso_restringido();
			return $o;		
		}
		
		$funcion_b2 = $funcion . "_bloque2";
		
		include_once($objeto . ".php");
		$clase = new $objeto();
		
		
		$q = "SELECT titulo1, titulo2 FROM menu_backoffice WHERE funcion = '$funcion'";
		$r = mysql_query($q);
		
		if (mysql_num_rows($r)) {
			$titulo1 = stripslashes(mysql_result($r,0,0));
			$titulo2 = stripslashes(mysql_result($r,0,1));
		}
		
			
		$o .= "<body>

			<div id='todo'>
			<div id='logo'>
				<a class='div' href='index.php?'><img src='img/logo.png' width='120'/></a>
			</div>
		
			<div id='barra_blanca'></div>
			<div id='cabecera'>
				<div id='cabecera_titulo'>BIENVENIDO AL BACKOFFICE DE LA ALMAZARA</div>
				<div id='cabecera_enlace'><a href='logout.php?'>cerrar sesi&oacute;n</a></div>
			</div>
			
			<div id='menu'>
				<div id='menu_interior'>
					" . $this->menu() . "
				</div>
			</div>
		
			<div id='general'>
				
				<div id='bloque1'>
					";

		$o .= "	<div class='bloque_titulo'>$titulo1</div>
					<div class='bloque_trabajo' id='bloque1_trabajo'> 	
					"  . $clase->$funcion() . "
					</div>";
		
		$o .= "
				</div>
				
				<div id='bloque2'>
					";

		$o .= "	<div class='bloque_titulo' id='bloque_titulo2'>$titulo2</div>
				<div class='bloque_trabajo' id='bloque2_trabajo'> 
						" . $clase->$funcion_b2() . "
					</div>";
		
		$o .=  "
				</div>
				
				<div id='bloque3'>
					<div class='bloque_titulo'><span class='a' onclick='bloque3_cerrar();'>CERRAR</a></div>
					<div class='bloque_trabajo' id='bloque3_trabajo'>
					</div>
				</div>
				<div style='clear:both;'></div>
			</div>
			</div>
			<div id='velo'></div>
			<div id='editor'></div>
		</body>
		</html>
			";
	
		
		return $o;
								
	}



	
	
	
	
	
	
	
	
	function carta_seccion() {
		
		include_once 'carta_seccion.php';
		$categoria = new carta_seccion();
		
		$o .= "
			<input type='hidden' id='funcion' value='texto'/>
			
			<div style='clear:both; height: 10px;'></div>";
		
		$o .= "<div class='tabla' id='tabla_carta_seccion'>";
		$o .= $categoria->tabla();
		$o .= "</div>";
		
		return $o;
		
	}
	
	
	function carta_seccion_bloque2() {
		
		
	}
	
	
	

	
	
	
		
	
	
	
	
	
	
	
	


	function menu() {
		
		if (!$GLOBALS["usuario"]->id_usuario) {
			return acceso_restringido();
		}

		if ($GLOBALS["usuario"]->datos["nivel"] == 1) {
			$q = "SELECT menu_backoffice.funcion, menu_backoffice.texto, id_menu 
					FROM menu_backoffice 
					WHERE id_padre = 0
					ORDER BY orden, menu_backoffice.id_menu					";
			
		} else {
			$q = "SELECT menu_backoffice.funcion, menu_backoffice.texto, menu_backoffice.id_menu 
					FROM menu_backoffice ON web.id = menu_backoffice.id_web
						INNER JOIN rel_menu_backoffice_usuario ON rel_menu_backoffice_usuario.id_menu = menu_backoffice.id_menu
					WHERE rel_menu_backoffice_usuario.id_usuario = " . $GLOBALS["usuario"]->id_usuario . "
						AND id_padre = 0	
					ORDER BY orden, menu_backoffice.id_menu";
		}
		$r = mysql_query($q);

		
		$funcion = $_REQUEST["funcion"];
		
		if (mysql_num_rows($r)) {
			$i = 0;
			
			$o .= "<ul>";
			
			while ($fila = mysql_fetch_array($r)) {

				$o .= "<li>
						<div id='div_menu_$i' class='menu_selector'></div>";
				
				if ($fila["funcion"]) {
					if ($fila["funcion"] == $funcion) {
						$clase_a = "menu_activo";
					} else {
						$clase_a = "";
					}
					$o .= "<a class='menu $clase_a' href='index.php?funcion=" . $fila["funcion"] . "'>" . $fila["texto"] . "</a>";
						
				} else {
					$o .= "<span class='menu $clase_a' href='index.php?funcion=" . $fila["funcion"] . "' onclick='menu_abrir(" . $fila["id_menu"] . ");'>" . $fila["texto"] . "</span>";
					
					if ($_REQUEST["id_padre"] == $fila["id_menu"]) {
						$display = "";
					} else {
						$display = "display: none;";
					}
					
					$q2 = "SELECT * FROM menu_backoffice WHERE id_padre = " . $fila["id_menu"] . " ORDER BY ORDEN";
					$r2 = mysql_query($q2);
					
					if (mysql_num_rows($r2)) {
						$o .= "<div class='menusub' id='menusub_" . $fila["id_menu"] . "' style='$display'><ul>";
						while ($fila2 = mysql_fetch_array($r2)) {
							if ($fila2["funcion"] == $funcion) {
								$clase_a = "menu_activo";
							} else {
								$clase_a = "";
							}
							$o .= "<li class='menusub'><a class='menu $clase_a' href='index.php?funcion=" . $fila2["funcion"] . "&id_padre=" . $fila["id_menu"] . "'>" . $fila2["texto"] . "</a></li>";
						}
						
						$o .= "</ul></div>";
					}
					
				}
				
				$o .= "<div style='clear: both;'></div>
					</li>";
				$i += 1;
			}
			$o .= "</ul>";
				
			
		} else {
			return acceso_restringido();
		}
		
		
		return $o;
		
	}

	
	
	
	
	
	
	
	
	

	
	
	
	
	
	
	
	
	function pie() {
	
		return $o;		
	}
		
	
	
	
	
	
	
	function plato() {
		
		include_once 'plato.php';
		$plato = new plato();
		
		include_once 'carta.php';
		$carta = new carta();
		
		
		$o .= "
			<input type='hidden' id='funcion' value='texto'/>
			
			<div style='clear:both; height: 10px;'></div>";
		
		$o .= "Categor&iacute;a: " . $carta->select_Carta("id_carta", "onchange=\"formulario2(['plato','tabla',['id_carta'],'tabla_plato',0,0]);\"") . 
				"<br/><br/>";
		$o .= "<div class='tabla' id='tabla_plato'>";
		$o .= $plato->tabla();
		$o .= "</div>";
		
		return $o;
		
	}
	
	
	function plato_bloque2() {
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	function presentacion() {
		
		$o .= "
			Elige una opci&oacute;n del menú. 
			";
		
		return $o;
		
	}
	
	
	
	function presentacion_bloque2() {
		$o .= "<br/>";
		
		return $o;
	}

	
	

	
	
	
	
	
	function seccion() {
		
		include_once '../seccion.php';
		$seccion = new seccion();
		
		
		$o .= "
			<input type='hidden' id='funcion' value='seccion'/>
			<div style='clear:both; height: 10px;'></div>";
		
		$o .= "<div class='tabla' id='tabla_seccion'>";
		$o .= $seccion->tabla();
		$o .= "</div>";
		
		return $o;
		
	}
	
	
	function seccion_bloque2() {
		
		
	}
	
	
		
	
	
	
	

	
	
	
	
	
	
	
	
	
	
	
	
	function texto() {
		
		include_once '../texto.php';
		$texto = new texto();
		
		
		$o .= "
			<input type='hidden' id='funcion' value='texto'/>
			<div style='clear:both; height: 10px;'></div>";
		
		$o .= "<div class='tabla' id='tabla_empleo'>";
		$o .= $texto->tabla();
		$o .= "</div>";
		
		return $o;
		
	}
	
	
	function texto_bloque2() {
		
		
	}
	
	
	

	
	
	
	function usuario() {
		
		include_once 'usuario.php';
		$usuario = new usuario();
		
		
		$o .= "
			<input type='hidden' id='funcion' value='usuario'/>
			<div style='clear:both; height: 10px;'></div>";
		
		$o .= "<div class='tabla' id='tabla_contacto'>";
		$o .= $usuario->tabla();
		$o .= "</div>";
		
		return $o;
		
	}
	
	
	function usuario_bloque2() {
		
		
	}
		
	
	
	
	
	
	
	
	function video() {
		
		include_once 'video.php';
		$video = new video();
		
		$o .= "
			<input type='hidden' id='funcion' value='video'/>
			
			<div style='clear:both; height: 10px;'></div>";
		
		$o .= "<div class='tabla' id='tabla_video'>";
		$o .= $video->tabla();
		$o .= "</div>";
		
		return $o;
		
	}
	
	
	function video_bloque2() {
		
		
	}
	
		

	

	
}


?>