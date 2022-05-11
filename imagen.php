<?php

class imagen {
	
	public $id;
	public $datos;
	private $tabla = "imagen";
	
	public $admin;
	public $id_imagen_tipo;
	
	public $id_modulo;
	public $modulo;
	
	public $ancho_th_max = 142;
	public $alto_th_max = 122;
	
	public $id_relacionada;
	
	
	
	
	function __construct() {
		$variable = "id_" . $this->tabla;
		if ($_REQUEST[$variable] && is_numeric($_REQUEST[$variable])) {
			$this->id = $_REQUEST[$variable];
			$this->recuperar();
		}
	}
	
	
	
	
	
	
	
	function borrar() {
		global $mysqli;

		if (!$GLOBALS["usuario"]->id_usuario) {
			return acceso_restringido();
		}

		if ($_REQUEST["id_imagen"] && is_numeric($_REQUEST["id_imagen"])) {
			$this->id = $_REQUEST["id_imagen"];
			$this->recuperar();
		} else {
			return acceso_restringido() . "1";
		}

		$q = "SELECT nombre FROM imagen_tipo WHERE id = " . $this->datos["id_imagen_tipo"];
		$r = $mysqli->query($q);
		
		if ($r->num_rows) {
			$sub = $rmysqli_result($r,0,0) . "/";
		}
		
		$q = "DELETE FROM imagen WHERE id = $this->id";
		$mysqli->query($q);

		$q = "UPDATE imagen 
				SET orden = orden - 1 
				WHERE id_imagen_tipo = " . $this->datos["id_imagen_tipo"] . "
					AND orden > " . $this->datos["orden"];
		$mysqli->query($q);
		
		
		$raiz = "../";
		
		$path = $raiz . "fotos/" . $sub . $this->datos["nombre"];
		$path2 = $raiz . "fotos/" . $sub . "th_" . $this->datos["nombre"];;
		
		unlink($path);
		unlink($path2);
		
		
		$this->id_imagen_tipo = $this->datos["id_imagen_tipo"];
		
		
		if ($this->id_imagen_tipo == 3) {
			include_once("texto.php");
			$texto = new texto();
			$texto->id = $this->datos["id_relacionada"];
			$o .= $texto->editar_imagenes_bloque();

		} else if ($this->id_imagen_tipo == 4) {
			include_once("habitacion.php");
			$hab = new habitacion();
			$hab->id = $this->datos["id_relacionada"];
			$o .= $hab->editar_imagenes_bloque();
			
		} else if ($this->id_imagen_tipo == 5) {
			include_once("oferta.php");
			$oferta = new oferta();
			$oferta->id = $this->datos["id_relacionada"];
			$o .= $oferta->editar_imagenes_bloque();
			
		} else {
			$o .= $this->tabla();
		}
		
		
		return "1;" . $o;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function colorbox() {
		global $mysqli;
		$args = func_get_args();
		$ancho = $args[0];
		$alto = $args[1];
		$extra = $args[2];
		
		$o .= "
			<a class='colorbox' rel='$id_destino' href='" . $this->enlace() . "' title='" . $this->datos["titulo"] . "'>
				" . $this->ver_th($ancho, $alto, $extra) . "
			</a>
		";
		return $o;
	}
	
	

	
	
	
	
	
	
	

	
	function desplazar() {
		global $mysqli;
		if ($_REQUEST["id_imagen"] && is_numeric($_REQUEST["id_imagen"])) {
			$this->id = $_REQUEST["id_imagen"];
			$this->recuperar();
		} else {
			return acceso_restringido() . "1";
		}

		$this->id_imagen_tipo = $this->datos["id_imagen_tipo"];
		
		
		if ($_REQUEST["id_imagen_tipo"]) {
			if (is_numeric($_REQUEST["id_imagen_tipo"])) {
				
				$this->id_imagen_tipo = $_REQUEST["id_imagen_tipo"];
				 
				if ($_REQUEST["id_relacionada"] && is_numeric($_REQUEST["id_relacionada"])) {
					
					$this->id_relacionada = $_REQUEST["id_relacionada"];
					
					if ($_REQUEST["desp"] == 1) {
						$q = "SELECT orden 
								FROM imagen 
								WHERE id_imagen_tipo = " . $_REQUEST["id_imagen_tipo"] . "
									AND id_relacionada = " . $_REQUEST["id_relacionada"] . "
									AND orden > " . $this->datos["orden"] . "
								ORDER BY orden
								LIMIT 1";
						$r = $mysqli->query($q);
						
						if ($r->num_rows) {
							$orden_nuevo = $rmysqli_result($r,0,0);
							$cambiar = 1;
						} else {
							$cambiar = 0;
						}
						
					} else {
						$q = "SELECT orden 
								FROM imagen 
								WHERE id_imagen_tipo = " . $_REQUEST["id_imagen_tipo"] . "
									AND id_relacionada = " . $_REQUEST["id_relacionada"] . "
									AND orden < " . $this->datos["orden"] . "
								ORDER BY orden DESC
								LIMIT 1";
						$r = $mysqli->query($q);
										
						if ($r->num_rows) {
							$orden_nuevo = $rmysqli_result($r,0,0);
							$cambiar = 1;
						} else {
							$cambiar = 0;
						}
						
					}
					
				} else {
					return acceso_restringido();
				} 
				
			} else {
				return acceso_restringido();
			}
			
		} else {
			$this->id_imagen_tipo = $this->datos["id_imagen_tipo"];
			$this->id_relacionada = 0;
						
			if ($_REQUEST["desp"] == 1) {
				if ($this->datos["orden"] < $this->orden_max()) {
					$orden_nuevo = $this->datos["orden"] + 1;
					$cambiar = 1;
				} else {
					$cambiar = 0;
				}
			} else {
				if ($this->datos["orden"] > 1) {
					$orden_nuevo = $this->datos["orden"] - 1;
					$cambiar = 1;
				} else {
					$cambiar = 0;
				}
			}
			
		}
				
		if ($cambiar) {
			$q = "UPDATE imagen  
					SET orden = " . $this->datos["orden"] . "
					WHERE id_imagen_tipo = " . $this->datos["id_imagen_tipo"] . "
					 AND orden = $orden_nuevo";
			$mysqli->query($q);
			
			$q = "UPDATE imagen  
					SET orden = $orden_nuevo
					WHERE id = $this->id";
			$mysqli->query($q);
		}
				
		
		if ($this->id_relacionada) {
			if ($this->id_imagen_tipo == 3) {
				include_once("texto.php");
				$texto = new texto();
				$texto->id = $this->id_relacionada;
				$texto->recuperar();
				$o .= $texto->editar_imagenes_bloque();
				
			} else if ($this->id_imagen_tipo == 4) {
				include_once("plato.php");
				$plato = new plato();
				$plato->id = $this->id_relacionada;
				$plato->recuperar();
				$o .= $plato->editar_imagenes_bloque();
			
			} else if ($this->id_imagen_tipo == 5) {
				include_once("novedad.php");
				$novedad = new novedad();
				$novedad->id = $this->id_relacionada;
				$novedad->recuperar();
				$o .= $novedad->editar_imagenes_bloque();
			}
			
		} else {
			$o = $this->tabla();
		}
		
		return $o;
		
	}
	
	
	
	
	
	
	
	
	
	function directorio() {
		global $mysqli;
		if (!$this->id) {
			return;
		}
		
		if ($this->datos["id_imagen_tipo"]) {
			$q = "SELECT nombre FROM imagen_tipo WHERE id = " . $this->datos["id_imagen_tipo"];
			$r = $mysqli->query($q);
			
			if ($r->num_rows) {
				$sub = $rmysqli_result($r,0,0) . "/";
			}
		}
		
		if ($this->admin) {
			$pre = "../";
		} else {
			$pre = "";
		}
		
		if ($this->datos["recorte"] && ($this->datos["ajuste"] == 2)) {
			$recorte = "recorte_";
		} else {
			$recorte = "";
		}
		
//		$ruta = $pre . "fotos/" . $sub . $recorte. $this->id . "_" . $this->datos["nombre"];
		$ruta = $pre . "fotos/" . $sub;
		
		return $ruta;
	
	}
	
	
	
	
	
	
	
	
	
	
	
	function editar() {
		global $mysqli;
		if ($_REQUEST["id_imagen"]) {
			if (is_numeric($_REQUEST["id_imagen"])) {
				$this->id = $_REQUEST["id_imagen"];
				$this->recuperar();
			} else {
				return acceso_restringido();
			}
		}
		
		if ($_REQUEST["grabar"]) {
			$q = "UPDATE imagen 
					SET titulo = '" . utf8_decode($_REQUEST["titulo"]) . "'
				WHERE id = $this->id";
			$r = $mysqli->query($q);
			
			return "Imagen grabada correctamente";
		}
		
		
		
		include_once("imagen_tipo.php");
		$tipo = new imagen_tipo();
		$tipo->id = $this->datos["id_imagen_tipo"];
		
		if (!$tipo->id) {
			if ($_REQUEST["id_imagen_tipo"] && is_numeric($_REQUEST["id_imagen_tipo"])) {
				$tipo->id = $_REQUEST["id_imagen_tipo"];
			}
		}
		
		
		$o .= "
			<input type='button' value='Grabar' onclick=\"formulario(['imagen', 'editar&id_imagen=$this->id&grabar=1', 'form_imagen', 'bloque2_trabajo', 0, 1]);\" style='float: right; margin: 5px 2px 5px 2px;'/>

			<div style='clear:both;'></div>";
			
			
		$o .= "
				
		
			<form id='form_imagen'  onsubmit=\"formulario(['imagen', 'editar&grabar=1&id_imagen=$this->id', 'form_imagen', 'bloque2_trabajo', 0, 1]);\">
			";
			
			
		$o .= "
			<div class='tabla_tr'>
			 <div class='tabla_td' style='width: 23%; text-align: right; padding-top: 4px;'>
			 	<strong>Thumb:</strong>
			 </div>
			 <div class='tabla_td' style='width: 73%;'>
				<span id='imagen_thumb'>" . $this->thumb() . "</span>
			 </div>
			 <div style='clear: both;'></div>
			</div>
			
			<div class='tabla_tr'>
			 <div class='tabla_td' style='width: 23%; text-align: right; padding-top: 4px;'>
			 	<strong>T&iacute;tulo:</strong>
			 </div>
			 <div class='tabla_td' style='width: 73%;'>
				<input type='text' class='todo' id='titulo' name='titulo' value='" . texto_form($this->datos["titulo"]) . "'/>
			 </div>
			 <div style='clear: both;'></div>
			</div>

			<input type='submit' value='Grabar' style='float: right; margin: 5px 2px 5px 2px;'/>
			</form>
			";
		
		
		
			
		
		
		return $o;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function enlace() {
		global $mysqli;
		if ($this->datos["id_imagen_tipo"]) {
			$q = "SELECT nombre FROM imagen_tipo WHERE id = " . $this->datos["id_imagen_tipo"];
			$r = $mysqli->query($q);
			
			if ($r->num_rows) {
				$sub = mysqli_result($r,0,0) . "/";
			}
		}

		if ($GLOBALS["backoffice"]) {
			$pre = "../";
		} else {
			$pre = "";
		}
		
		$ruta = $pre . "fotos/" . $sub . $this->datos["nombre"];
		return $ruta;
		
	}	
	
	
	
	
	
	function enlace_th() {
		global $mysqli;
		if ($this->datos["id_imagen_tipo"]) {
			$q = "SELECT nombre FROM imagen_tipo WHERE id = " . $this->datos["id_imagen_tipo"];
			$r = $mysqli->query($q);
			
			if ($r->num_rows) {
				$sub = $rmysqli_result($r,0,0) . "/";
			}
		}

		if ($GLOBALS["backoffice"]) {
			$pre = "../";
		} else {
			$pre = "";
		}
		
		$ruta = $pre . "fotos/" . $sub . "th_" . $this->datos["nombre"];
		return $ruta;
		
	}	
		
	
	
	
	
	
	
	
	function estilo($ancho, $alto) {
		global $mysqli;
		$proporcion = $ancho / $alto;
		
		if ($this->datos["height"]) {
			$proporcion2 = $this->datos["width"] / $this->datos["height"];
		} else {
			return;
		}

		if ($proporcion2 >= $proporcion) {
			$alto_img = $alto;
			$ancho_img = $alto_img * $proporcion2;
			$dif = ($ancho - $ancho_img) / 2;

			$estilo = "width: " . $ancho_img . "px; height: " . $alto_img . "px; margin-left: " . $dif  . "px;";
					
		} else {
			$ancho_img = $ancho; 
			if ($this->datos["width"]) {
				$alto_img = $ancho_img * $this->datos["height"] / $this->datos["width"];
			} else {
				$alto_img = 0;
			}
			$dif = ($alto - $alto_img) / 2;
					
			$estilo = "width: " . $ancho_img . "px; height: " . $alto_img . "px; margin-top: " . $dif  . "px;";
		}
				

		return $estilo;
		
	}
	
	
	
	
	
	
	
	function frame($width, $height) {
		global $mysqli;
		$q = "SELECT *
			 FROM imagen
			 WHERE id_imagen_tipo = $this->id_imagen_tipo AND id_relacionada = $this->id_relacionada
			 ORDER BY orden";
		$r = $mysqli->query($q);
		
		if ($r->num_rows) {
			$i = 0;
			while ($this->datos = $r->fetch_array()) {
				$this->id = $this->datos["id"];
				$estilo = $this->estilo($width,$height);
				if ($i > 0) {
					$estilo .= "display: none;"; 
				} 
				$o .= "<img id='img_$i' src='" . $this->enlace() . "' style='$estilo' alt=''/>";
				$i += 1;
			}
		}
		
		return $o;
		
	}
		
	
	
	

	
	
	function galeria() {
		global $mysqli;

		if ($this->id_imagen_tipo == 3)  {
			$args = func_get_args();
			
			$texto = new texto();
			$texto->texto($args[1],"galeria");
			
			$where .= " AND id_relacionada = $texto->id AND id_imagen_tipo = 3";
			
		} else if ($this->id_relacionada) {
			$where .= " AND id_relacionada = $this->id_relacionada  AND id_imagen_tipo = 3";
		}
			
		$q = "SELECT * FROM imagen WHERE 1=1 $where ORDER BY orden";
		$r = $mysqli->query($q);
		
		$o .= "
		<div id='galeria_box'>
			<div class='cursor flecha_galeria flecha_izq' id='flecha_galeria_izq'></div>
			<div class='fondo1' id='galeria_inner'>
				<div class='slide_wrapper' id='galeria_wrapper'>";
		
		if ($num = $r->num_rows) {
			$num_fotos = ceil($num / 2);
			if ($num_fotos > 4) {
				$ancho = $num_fotos*156;
			} else {
				$ancho = 624;
			}
			$o .= "<div class='slide' id='galeria' style='width: " . $ancho . "px;'>";
			$i = 1;
			while ($this->datos = $r->fetch_array()) {
				$this->id = $this->datos["id"];
				$o .= "<div class='galeria_foto'>
						<a class='colorbox' rel='gal' href='" . $this->enlace() . "' title='" . $this->datos["titulo"] . "'>" . $this->thumb(142,122) . "</a>
					</div>";
				$i += 1;
			}
			$o .= "</div>";
		}
		
		$o .= "
				</div>
			</div>
			<div class='cursor flecha_galeria flecha_der' id='flecha_galeria_der'></div>
		
			<div style='clear: both;'></div>
		</div>
			<script>
				$('a.colorbox').colorbox({rel: 'gal', maxWidth: '90%', maxHeight: '90%;'});
				setTimeout(function() {slide_h_load('galeria')}, 500);
			</script>";
		
		return $o;
	}
	
	
	
	
	
		
	function galeria2() {
		global $mysqli;
		if ($this->id_imagen_tipo == 3)  {
			$args = func_get_args();
			
			$texto = new texto();
			$texto->texto($args[1],"galeria");
			
			$where .= " AND id_imagen_tipo = 3 AND id_relacionada = $texto->id";
			
		} else if ($this->id_relacionada) {
			$where .= " AND id_imagen_tipo = 3 AND id_relacionada = $this->id_relacionada";
		}
			
		$q = "SELECT * FROM imagen WHERE 1=1 $where ORDER BY orden";
		$r = $mysqli->query($q);
		
		$o .= "
		<div id='galeria_box2'>
			<div class='cursor flecha_galeria flecha_izq2' id='flecha_galeria_izq'></div>
			<div class='fondo2' id='galeria_inner'>
				<div class='slide_wrapper' id='galeria_wrapper'>";
		
		if ($num_fotos = $r->num_rows) {
			if ($num_fotos > 4) {
				$ancho = $num_fotos*156;
			} else {
				$ancho = 624;
			}
			$o .= "<div class='slide' id='galeria' style='width: " . $ancho . "px;'>";
			$i = 1;
			while ($this->datos = $r->fetch_array()) {
				$this->id = $this->datos["id"];
				$o .= "<div class='galeria_foto'>
						<a class='colorbox' rel='gal' href='" . $this->enlace() . "' title='" . $this->datos["titulo"] . "'>" . $this->thumb(142,122) . "</a>
					</div>";
				$i += 1;
			}
			$o .= "</div>";
		}
		
		$o .= "
				</div>
			</div>
			<div class='cursor flecha_galeria flecha_der2' id='flecha_galeria_der'></div>
		
			<div style='clear: both;'></div>
		</div>
			<script>
				$('a.colorbox').colorbox({rel: 'gal', maxWidth: '90%', maxHeight: '90%;'});
				setTimeout(function() {slide_h_load('galeria')}, 500);
			</script>";
		
		return $o;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	function orden_max() {
global $mysqli;
		if ($this->id_relacionada) {
			$where = " AND id_relacionada = $this->id_relacionada";
		}
		
		
		$q = "SELECT orden 
				FROM imagen  
				WHERE id_imagen_tipo = $this->id_imagen_tipo 
					$where
				ORDER BY orden DESC
				LIMIT 1";
			
		$r = $mysqli->query($q);
		
		if ($r->num_rows) {
			$orden = $rmysqli_result($r,0,0);
		} else {
			$orden = 0;
		}
		
		return $orden;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function raiz() {
		global $mysqli;
		if (!$this->id) {
			return;
		}
		
		if ($this->datos["id_imagen_tipo"]) {
			$q = "SELECT nombre FROM imagen_tipo WHERE id = " . $this->datos["id_imagen_tipo"];
			$r = $mysqli->query($q);
			
			if ($r->num_rows) {
				$sub = $rmysqli_result($r,0,0) . "/";
			}
		}
		
		if ($this->admin) {
			$pre = "../";
		} else {
			$pre = "";
		}
		
		$ruta = $pre . "fotos/" . $sub;
		
		return $ruta;
	
	}
	
		
	
	
	

	
	
	function recuperar() {
		global $mysqli;
		if ($this->id) {
			$q = "SELECT * FROM $this->tabla WHERE id = $this->id";
			$r = $mysqli->query($q);
			
			if ($r->num_rows){
				$this->datos = $r->fetch_assoc();	
			}
		} else {
			$this->datos = "";
		}
		
	}
	
	
	
	
	
	
	
	
	function seleccionar() {
		global $mysqli;
		if (!$GLOBALS["usuario"]->id_usuario) {
			return acceso_restringido();
		}
		
		$o .= "<div onclick=\"imagen_editor_cerrar();\" style='float: right; text-align: right; margin-right: 8px; margin-top: -1px;'>
					<img src='img/boton_x.png' alt=''>
			</div>";
			
		
		if ($_REQUEST["id"] && is_numeric($_REQUEST["id"])) {
			$id = $_REQUEST["id"];
		} else {
			return $o . acceso_restringido();
		}
		
		if ($_REQUEST["modulo"]) {
			$modulo = $_REQUEST["modulo"];
		} else {
			return $o . acceso_restringido();
		}
		
		if ($_REQUEST["id_circuito"] && is_numeric($_REQUEST["id_circuito"])) {
			$id_circuito = $_REQUEST["id_circuito"];
		} else {
			return $o . acceso_restringido();
		}
		
		
		if ($_REQUEST["grabar"]) {
			
			if ($_REQUEST["id_imagen"] && is_numeric($_REQUEST["id_imagen"])) {
				$id_imagen = $_REQUEST["id_imagen"];
			} else {
				return acceso_restringido();
			}
			
			$q = "UPDATE rel_circuito_imagen 
					SET uso = 0 
					WHERE id_circuito = $id_circuito AND uso = $id";
			$mysqli->query($q);
			
			$q = "UPDATE $modulo 
					SET id_imagen = $id_imagen
					WHERE id = $id";
			$mysqli->query($q);
			
			
			$q = "UPDATE rel_circuito_imagen
					SET uso = $id
					WHERE id_circuito = $id_circuito AND id_imagen = $id_imagen";
			$mysqli->query($q);
			
			include_once("imagen.php");
			$imagen = new imagen();
			$imagen->id = $id_imagen;
			$imagen->admin = 1;
			$imagen->recuperar();

			return $imagen->thumb();
					
		}
		
		
		$o .= "<div id='editor_imagen'>
			
			Selecciona o busca una imagen: <input type='text' id='buscar_nombre' name='buscar_nombre' value=''/>
				<input type='button' value='buscar' onclick=\"imagen_buscar('$modulo', $id_circuito, $id, 1);\"/>

			";

		$q = "SELECT * FROM rel_circuito_imagen WHERE id_circuito = $id_circuito";
		$r = $mysqli->query($q);
		
		$o .= "<div id='seleccionar_imagenes'>";
		if ($r->num_rows) {
			include_once('imagen.php');
			$imagen = new imagen();
			$imagen->admin = 1;
			while ($fila = $r->fetch_array()) {
				$imagen->id = $fila["id_imagen"];
				$imagen->recuperar();

				$o .= "	<div class='img_seleccionar' onclick='imagen_seleccionada(\"$modulo\", $id_circuito, $imagen->id, $id);'>
							" . $imagen->thumb() . "
						<div style='clear: both;'></div>
						</div>
						";
				
			}
		} else {
			$o .= "No hay im�genes relacionadas. ";
		}
		$o .= "</div>";
				
		$o .= "</div>";
		
		return $o;
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function subir() {
		global $mysqli;
		if ($_REQUEST["nombre"]) {
			$nombre = $_REQUEST["nombre"];
		} else { 
			return "0;;" . acceso_restringido();
		}
		
		
		if ($_REQUEST["id_imagen_tipo"] && is_numeric($_REQUEST["id_imagen_tipo"])) {
			$this->id_imagen_tipo = $_REQUEST["id_imagen_tipo"];
		} else {
			$this->id_imagen_tipo = 0;
		}
		
		if ($_REQUEST["id_relacionada"] && is_numeric($_REQUEST["id_relacionada"])) {
			$this->id_relacionada = $_REQUEST["id_relacionada"];
		} else {
			$this->id_relacionada = 0;
		}
		
		if ($this->id_imagen_tipo) {
			include_once("imagen_tipo.php");
			$tipo = new imagen_tipo();
			$tipo->id_imagen_tipo = $this->id_imagen_tipo;
			$tipo->recuperar();
			$this->modulo = $tipo->datos["nombre"];
		}

		$file = $_FILES[$nombre];
		
		
		if ($file["name"] <> null) {
			if (($file["type"] == "image/jpeg") || ($file["type"] == "image/pjpeg")) {
				$tipo_jpeg = 1;
			} else if ($file["type"] == "image/gif") {
				$tipo_gif = 1;
			} else if (($file["type"] == "image/png") || ($file["type"] == "image/x-png")) {
				$tipo_png = 1;
			} else {
				$this->error = "El formato de imagen no se puede usar.
						Por favor, trata de reenviarla en otro formato (JPG, GIF o PNG).
						 Gracias";
				return "0;;" . $this->error;
			}
		} else {
			$this->error = "No hay fichero.";
			return "0;;" . $this->error;
		}
		
		
		$fecha = fecha_hoy() . " " . hora_ahora();

		
		$imagedata = getimagesize($file["tmp_name"]);
		$w = $imagedata[0];
		$h = $imagedata[1];
		
		
		$q = "INSERT INTO imagen (id_imagen_tipo, width, height) 
					VALUES ($this->id_imagen_tipo, '$w', '$h')";
		$mysqli->query($q);
		$this->id = $mysqli->insert_id;
		
		$this->nombre = $this->id . "_" . $file["name"]; 
		$this->nombre_thumb = "th_" . $this->nombre;
		
		
		if ($this->admin) {
			$raiz = "../";
		} else {
			$raiz = "";
		}
		
		
		$ruta = $raiz . "fotos/" . $this->modulo . "/";
		
		
		$cadena = $ruta . $this->nombre;
		$resultado = copy($file["tmp_name"],$cadena);

		
		if ($w > $this->ancho_th_max) {
			$new_th_w= $this->ancho_th_max;
			$new_th_h = ($new_th_w * $h) / $w;
		} else {
			$new_th_w = $w;
			$new_th_h = $h;
		}

		if ($new_th_h < $this->alto_th_max) {
			$new_th_h = $this->alto_th_max;
			$new_th_w = ($new_th_h * $w) / $h;
		}
		
				
		$cadena = $ruta . $this->nombre_thumb;
		$im2 = ImageCreateTrueColor($new_th_w, $new_th_h);
				
		if ($tipo_jpeg) {
			$image = ImageCreateFromJpeg($file["tmp_name"]);
		} else if ($tipo_gif) {
			$image = ImageCreateFromGif($file["tmp_name"]);
		} else if ($tipo_png) {
			$image = ImageCreateFromPng($file["tmp_name"]);
		}
					
		imagecopyResampled ($im2, $image, 0, 0, 0, 0, $new_th_w, $new_th_h, $imagedata[0], $imagedata[1]);
					
		if ($tipo_jpeg) {
			$resultado = imagejpeg($im2,$cadena);
		} else if ($tipo_gif) {
			$resultado = imagegif($im2,$cadena);
		} else if ($tipo_png) {
			$resultado = imagepng($im2,$cadena);
		}
	
		if (!isset($resultado)) {
			$q = "DELETE * FROM imagen WHERE id = $this->id";
			$mysqli->query($q);
			$this->error = "Ha habido un error al copiar la imagen";
			return "0;;" . $this->error;
		}
		
		
		if ($this->id_relacionada) {

			$update = ", id_relacionada = $this->id_relacionada";
			
			if ($this->id_imagen_tipo == 2) {
				$q = "UPDATE imagen 
						SET id_relacionada = 0
						WHERE id_relacionada = $this->id_relacionada
							AND id_imagen_tipo = 2";
				$r = $mysqli->query($q);
				
				$q = "UPDATE actividad 
						SET id_imagen = $this->id
						WHERE id = $this->id_relacionada";
				$r = $mysqli->query($q);
								
			} else if ($this->id_imagen_tipo == 5) {
				$q = "UPDATE imagen 
						SET id_relacionada = 0
						WHERE id_relacionada = $this->id_relacionada
							AND id_imagen_tipo = 5";
				$r = $mysqli->query($q);
				
				$q = "UPDATE oferta 
						SET id_imagen = $this->id
						WHERE id = $this->id_relacionada";
				$r = $mysqli->query($q);
								
			}
			
		}
		
		
		$q = "UPDATE imagen 
				SET nombre = '" . $this->nombre . "', 
					th_width = '" . $new_th_w . "', 
					th_height = '" . $new_th_h . "', 
					orden = " . $tipo->orden_max() . "
					$update
				WHERE id = $this->id";
		$mysqli->query($q);
		
		$this->recuperar();
		
			
    	imagedestroy($image);
    	imagedestroy($im2);
	    
		return "$this->id;;Imagen subida correctamente;;" . $this->thumb();	    
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function tabla() {
		global $mysqli;
		if (!$GLOBALS["usuario"]->id_usuario) {
			return acceso_restringido();
		}
		
		$num_filas = 20;
		if ($_REQUEST["hoja"]) {
			$puntero = $num_filas * $puntero;
		} else {
			$puntero = 0;
		}
		
		if (!$this->id_imagen_tipo) {
			if ($_REQUEST["id_imagen_tipo"] && is_numeric($_REQUEST["id_imagen_tipo"])) {
				$this->id_imagen_tipo = $_REQUEST["id_imagen_tipo"];
			} else {
				return acceso_restringido();
			}
		}
		
		include_once("imagen_tipo.php");
		$tipo = new imagen_tipo();
		$tipo->id = $this->id_imagen_tipo;
		$tipo->recuperar();
		$orden_max = $tipo->orden_max();
		
		
		$fecha = fecha_hoy();
		
		$o .= "	<input type='hidden' id='hoja' value='" . $_REQUEST["hoja"] . "'/>
			<form action='ajax.php' method='post' id='uploadform' enctype='multipart/form-data' onsubmit='beginUpload(\"$uid\", \"imagen_bar\");'>
				<div style='float: right;'>
					<input type='button' id='boton_imagen' value='Subir nueva imagen' style='margin-left: 3px;'/>
					<input type='hidden' name='UPLOAD_IDENTIFIER' id='progress_key' value='$uid' />
					
				</div>
				<div style='float: left; margin-left: 10px;'>
				</div>
				<div style='clear: both;'></div>
				</form><br/>
				
				<script type= \"text/javascript\">
				upload_configurar('$uid', 
					'boton_imagen', 
					'imagen_bar', 
					'ajax.php?objeto=imagen&funcion=subir&id=$this->id&id_imagen_tipo=$this->id_imagen_tipo&nombre=imagen', 
					'ajax.php?objeto=imagen&funcion=tabla&id_imagen_tipo=$this->id_imagen_tipo', 
					'tabla_imagen', 
					1, 
					'id_imagen');
			</script>
		
		";
		
		
		$q = "SELECT * 
				FROM imagen 
				WHERE id_imagen_tipo = $this->id_imagen_tipo
				ORDER BY orden ";
		$r = $mysqli->query($q);
		
		if ($r->num_rows) {
			
			while ($this->datos = $r->fetch_array()) {
				$this->id = $this->datos["id"];
				$o .= "<div class='img_editar'>" . $this->thumb() . "
							<div style='clear: both;'></div>";
				$o .= "<div style='text-align:center;'>";
				$o .= " <span class='a' onclick=\"modulo(['imagen','editar', '&id_imagen=$this->id', 'bloque2_trabajo',0,0]);\">editar</span>";
				$o .= " <span class='a' onclick=\"modulo(['imagen','desplazar', '&id_imagen=$this->id&desp=-1', 'tabla_imagen',0,0]);\">subir</span>";
				$o .= " <span class='a' onclick=\"modulo(['imagen','desplazar', '&id_imagen=$this->id&desp=1', 'tabla_imagen',0,0]);\">bajar</span>";
				$o .= " <span class='a' onclick=\"confirmacion(['Borrar imagen', 'imagen','borrar', '&id_imagen=$this->id', 'tabla_imagen',0,0]);\">borrar</span>";
				$o .= "</div>";				
				$o .= "	</div>";
			}
			
		} else {
			$o .= error("No hay im&aacute;genes.");
		}
		
		
		
		return $o;
		
	}
	
	
	
		
	
	
	
	
	
	
	
		
	
	function thumb() {
		global $mysqli;
		if (!$this->id) {
			return;
		}
		
		$args = func_get_args();
		$ancho = $args[0];
		$alto = $args[1];
		$extra = $args[2];
		
		
		if ($ancho && $alto) {
			$estilo = $this->estilo($ancho, $alto);
		}		
		
		$o .= "<img class='img_thumb' src='" . $this->thumb_enlace() . "' title='" . texto_form($this->datos["titulo"]) . "' style='$estilo' alt=''/>";
		
		return $o;
		
	}
	
	
	
	function thumb_enlace() {
		global $mysqli;
		if ($this->datos["id_imagen_tipo"]) {
			$q = "SELECT nombre FROM imagen_tipo WHERE id = " . $this->datos["id_imagen_tipo"];
			$r = $mysqli->query($q);
			
			if ($r->num_rows) {
				$sub = mysqli_result($r,0,0) . "/";
			}
		}

		if ($GLOBALS["backoffice"]) {
			$pre = "../";
		} else {
			$pre = "";
		}
		
		$ruta = $pre . "fotos/" . $sub . "th_" . $this->datos["nombre"];
		return $ruta;
		
	}
	
	
	
	
	
	
	
	function ver() {
		global $mysqli;
		if (!$this->id) {
			if ($_REQUEST["id_imagen"] && is_numeric($_REQUEST["id_imagen"])) {
				$this->id = $_REQUEST["id_imagen"];
				$this->recuperar();
			} else {
				return;
			}
		}
		
		$args = func_get_args();
		$ancho = $args[0];
		$alto = $args[1];
		$extra = $args[2];
		
		if (!$ancho) {
			if ($_REQUEST["ancho"] && $_REQUEST["alto"] && is_numeric($_REQUEST["ancho"]) && is_numeric($_REQUEST["alto"])) {
				$ancho = $_REQUEST["ancho"];
				$alto = $_REQUEST["alto"];
			}
		}
		
		if ($ancho && $alto) {
			$estilo = $this->estilo($ancho, $alto);
			$extra .= " style='$estilo'";
		}
		
		$o .= "<img src='" . $this->enlace() . "' $extra/>";
		
		return $o;
	}
	
	
	
	
	function ver_th() {
		global $mysqli;
		if (!$this->id) {
			if ($_REQUEST["id_imagen"] && is_numeric($_REQUEST["id_imagen"])) {
				$this->id = $_REQUEST["id_imagen"];
				$this->recuperar();
			} else {
				return;
			}
		}
		
		$args = func_get_args();
		$ancho = $args[0];
		$alto = $args[1];
		$extra = $args[2];
		
		if (!$ancho) {
			if ($_REQUEST["ancho"] && $_REQUEST["alto"] && is_numeric($_REQUEST["ancho"]) && is_numeric($_REQUEST["alto"])) {
				$ancho = $_REQUEST["ancho"];
				$alto = $_REQUEST["alto"];
			}
		}
		
		if ($ancho && $alto) {
			$estilo = $this->estilo($ancho, $alto);
			$extra .= " style='$estilo'";
		}
		
		$o .= "<img src='" . $this->enlace_th() . "' $extra/>";
		
		return $o;
	}	
	
		
}

?>
