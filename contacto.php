<?php

class contacto {
	
	public $id;
	public $datos;
	public $tabla = "contacto";
	
	public $id_tipo;
	
	
	
	
	
	function __construct() {
		$variable = "id_" . $this->tabla;
		if ($_REQUEST[$variable] && is_numeric($_REQUEST[$variable])) {
			$this->id = $_REQUEST[$variable];
			$this->recuperar();
		}
	}
	
	
	
	
	
	
		
	
	
	
	
	
	
	
	
	function reservar() {
		
			
		
		if ($_REQUEST["id_habitacion"] && is_numeric($_REQUEST["id_habitacion"])) {
			include_once("habitacion.php");
			$habitacion = new habitacion();
			
		} else {
			return acceso_restringido() . "1";
		}
		
		
		
		if ($_REQUEST["grabar"]) {
			
			include_once("post.php");
			$post = new post();
			$post->utf8 = 1;
			
			$post->parametros = array(
					'nombre' => array 	('string',1),
					'email' => array 	('string',1),
					'tlf' => array 	('string',1),
					'fecha1' => array 	('string',1),
					'fecha2' => array 	('string',1),
					'comentarios' => array 	('string',0), 
					'contacto' => array ('int',0)
			);
			
			$post->comprobar();

			$post->valores["id_habitacion"] = $habitacion->id;
			$post->valores["fecha_alta"] = fecha_hoy() . " " . hora_ahora();
			$post->valores["id_tipo"] = 1;
			
			if ($post->error) {
				
				$o .= error("ERROR: ");
				
				$primero = 1;
				foreach($post->errores as $key => $value) {
					if ($primero) {
						$primero = 0;
					} else {
						$error .= ", ";
					}
					$error .= $key;
				}
				$o .= error($error);
				
				if ($post->valores) {
					foreach ($post->valores as $key => $value) {
						$this->datos[$key] = $value;
					}
				}
				
			} else {
				
				include_once("texto.php");
				$texto = new texto();
				
				$q = $post->consulta($this->id,'contacto','', $extra, 'id');
				mysql_query($q);
				
				if (!$this->id) {
					$this->id = mysql_insert_id();
					$this->recuperar();
					
							// ENVIAR MAIL
				}
				
				if ($post->valores["contacto"]) {
					$contacto = "SÍ";
				} else {
					$contacto = "NO";
				}
				
				
				include_once("mail_envio.php");
				$mail = new mail_envio();
				$mail->to[0] = "info@almazaradevaldeverdeja.com";
				$mail->to[1] = $post->valores["email"];
				
				$mail->subject = "[almazara] RESERVA";
				$mail->replyto = $post->valores["email"];
				$mail->nameto = $post->valores["nombre"];
				$mail->texto = "NOMBRE: " . $post->valores["nombre"] . "<br/>
EMAIL: " . $post->valores["email"] . "<br/>
TLF.: " . $post->valores["tlf"] . "<br/>
HABITACIÓN: " . $habitacion->datos["nombre"] . "<br/>
FECHAS: " . $post->valores["fecha1"] . " - " . $post->valores["fecha2"] . "<br/>
CONTACTO COMERCIAL: $contacto<br/><br/>

COMENTARIOS:<br/> " . nl2br($post->valores["comentarios"]) . "<br/><br/>
ESTE CORREO NO CONSTITUYE UNA CONFIRMACIÓN DE LA RESERVA.  EL HOTEL SE PONDRÁ EN CONTACTO CON USTEDES PARA CONFIRMAR DISPONIBILIDAD Y FORMALIZAR LA MISMA"; 
				$salida = $mail->enviar();
				
				if ($mail->error) {
					$o .= "<div class='cursor flecha_volver' onclick=\"habitaciones_ir(2, $habitacion->id);\"></div>
					<div class='fondo1' id='habitacion_reserva_recibido'>
					<div id='habitacion_reserva_inner'>
					<h2>RESERVAS</h2>
					<div style='height: 23px;'></div>
					
					Ha habido un error en el envío. Puede ponerse en contacto con nosotros a través del email info@almazaradevaldeverdeja.com
			</div>
								</div>
					";
					
				} else {
				$o .= "
		<div class='cursor flecha_volver' onclick=\"habitaciones_ir(2, $habitacion->id);\"></div>
		<div class='fondo1' id='habitacion_reserva_recibido'>
			<div id='habitacion_reserva_inner'>
				<h2>RESERVAS</h2>
				<div style='height: 23px;'></div>
				" . $texto->texto("habitaciones","reservar_recibido") . "
			</div>
		</div>
				";
				}
				
				return $o;
			}	
		}
		
		
		$texto = new texto();
		
		$o .= "
		<form id='form_reservas' onsubmit=\"formulario(['contacto','reservar','form_reservas','habitaciones_box5',1,1]); return false;\">
		<input type='hidden' name='id_habitacion' id='id_habitacion' value='$habitacion->id'/>
			
		<div class='cursor flecha_volver' onclick=\"habitaciones_boton(2," . $habitacion->id . ");\"></div>
		<div class='fondo1' id='habitacion_reserva'>
			<div id='habitacion_reserva_inner'>
					<h2>RESERVA &#147;" . $habitacion->datos["nombre"] . "&#148;</h2>
				<div style='height: 23px;'></div>
					" . $texto->texto("habitaciones","reserva") . "
				<div style='height: 27px;'></div>
		
				<div class='left' id='form_col1'>
					<label for='nombre'>nombre *</label>
					<input type='text' class='obligatorio largo' name='nombre' id='nombre' value='" . $post->valores["nombre"] . "'/>
					
					<label for='tlf'>n&uacute;mero de tel&eacute;fono *</label>
					<input type='text' class='obligatorio largo' name='tlf' id='tlf' value='" . $post->valores["tlf"] . "'/>
					
					<label for='apellidos'>direcci&oacute;n de e-mail *</label>
					<input type='text' class='obligatorio largo' name='email' id='email' value='" . $post->valores["email"] . "'/>
				</div>

				<div class='left' id='form_col2'>
					<div class='left' id='form_col2_1'>
						<label for='fecha1'>fecha de entrada *</label>
						<input type='text' class='obligatorio corto fecha' name='fecha1' id='fecha1' value='" . $post->valores["fecha1"] . "'/>
					</div>
					<div class='left' id='form_col2_2'>
						<label for='fecha2'>fecha de salida *</label>
						<input type='text' class='obligatorio corto fecha' name='fecha2' id='fecha2' value='" . $post->valores["fecha2"] . "'/>
					</div>
					<div class='clear'></div>
					
					<label for='comentarios'>comentarios *</label>
					<textarea name='comentarios' id='comentarios'>" . $post->valores["comentarios"] . "</textarea>
				</div>
				<div class='clear'></div>
				
				<input type='checkbox' name='contacto' id='contacto' value='1' checked /> <label for='contacto'>a</label><label class='cursor' for='contacto'>Deseo recibir novedades y promociones de La Almazara de Valdeverdeja</label>
				
				
				<div style='clear:both;'></div>
							
			
			</div>
			
			<div class='habitacion_precio_boton'>
					<input type='submit' class='cursor' name='enviar' id='enviar' value='RESERVAR'/>
			</div>
			
		</div>

		</form>
			
		<script>
			$.datepicker.setDefaults( $.datepicker.regional[ 'es' ] );
			$('input.fecha').datepicker({ dateFormat: 'dd/mm/yy', firstDay: 1 });
		</script>
		";
		
		
		return $o;
		
	}
	
	
	
	
	
	
		
	
	
	
	
	
	
	function recuperar() {
		if ($this->id) {
			$q = "SELECT * FROM $this->tabla WHERE id = $this->id";
			$r = mysql_query($q);
			
			if (mysql_num_rows($r)){
				$this->datos = mysql_fetch_assoc($r);	
			}
		} else {
			$this->datos = "";
		}
		
	}
		
	
	
	
	
	
	
	
	function respondido() {
		
		if (!$this->id) {
			return acceso_restringido();
		}
		
		if ($_REQUEST["respondido"]) {
			$respondido = 1;
		} else {
			$respondido = 0;
		}
		
		$q = "UPDATE contacto 
				SET respondido = $respondido
				WHERE id = $this->id";
		mysql_query($q);
		
		return;
	}
	
	
	
	
	
	
	
	function tabla() {

		if (!$GLOBALS["usuario"]->id_usuario) {
			return acceso_restringido();
		}
		
		$titulo = "CONTACTOS: ";
		if ($_REQUEST["respondido"] == 1) {
			$respondido = 1;
			$boton_activo = "<input type='button' value='VER PENDIENTES' onclick=\"modulo(['contacto', 'tabla', '&respondido=0', 'tabla_contacto', 0, 0]);\" style='float: right; margin: 5px 2px 5px 2px;'/>";
			$titulo .= " RESPONDIDOS";
		} else {
			$respondido = 0;
			$boton_activo = "<input type='button' value='VER RESPONDIDOS' onclick=\"modulo(['contacto', 'tabla', '&respondido=1', 'tabla_contacto', 0, 0]);\" style='float: right; margin: 5px 2px 5px 2px;'/>";
			$titulo .= " PENDIENTES";
		}
		
		$num_filas = 20;
		
		if ($_REQUEST["hoja"]) {
			$puntero = $num_filas * $puntero;
		} else {
			$puntero = 0;
		}
		
		$fecha = fecha_hoy();
				
		$q = "SELECT * 
				FROM contacto
				WHERE respondido = $respondido
				ORDER BY fecha_alta DESC
				LIMIT $puntero, $num_filas";
		$r = mysql_query($q);

		$o .= " <input type='hidden' id='hoja' value='" . $_REQUEST["hoja"] . "'/>
				<input type='hidden' id='valor_respondido' value='" . $_REQUEST["respondido"] . "'/>
				
				$boton_activo
			";
		
		$o .= "<h3>$titulo</h3><br/>";
		
		if (mysql_num_rows($r)) {
			$i = 0;
			
			$o .= "
				<div class='tabla_cabecera'>	
				<div class='tabla_th' style='width: 20%;'>
					TIPO
				</div>
				<div class='tabla_th' style='width: 30%;'>
					NOMBRE
				</div>
				<div class='tabla_th' style='width: 15%;'>
					F.RESERVA
				</div>
				<div class='tabla_th' style='width: 15%;'>
					F.ALTA
				</div>
				<div class='tabla_th' style='width: 20%;'>
					&nbsp; 
				</div>
				<div style='clear:both;'></div>
				</div>
			";
			
			while ($this->datos = mysql_fetch_array($r)) {
				if (($i % 2) == 0) {
					$clase = "tabla_par";
				} else {
					$clase = "tabla_impar";
				}
				
				$this->id = $this->datos["id"];
				
				$o .= "<div class='tabla_tr $clase'>" . $this->tabla_fila() . "</div>";
				$i += 1;
			}
			
		} else {
			$o .= error("No hay peticiones de contacto.");
		}
		
		
		
		return $o;
		
	}
	
	
	
	
	
	

	
	
	function tabla_fila() {
		
		if ($this->datos["id_tipo"] == 1) {
			$tipo = "EVENTO";
		} else if ($this->datos["id_tipo"] == 2) {
			$tipo = "RESERVA";
		}
		
		$o .= "
			<div class='tabla_td' style='width: 18%;'>
				$tipo 
			</div>
			<div class='tabla_td' style='width: 28%;'>
				" . $this->datos["nombre"] . "&nbsp;
			</div>
			<div class='tabla_td' style='width: 13%;'>
				" . $this->datos["fecha"]. "&nbsp;
			</div>
			<div class='tabla_td' style='width: 13%;'>
				" . fecha($this->datos["fecha_alta"]) . " " . substr($this->datos["fecha_alta"], 11, 5) . "&nbsp;
			</div>
			<div class='tabla_td' style='width: 18%; text-align: right;'>
				<span class='a' onclick=\"modulo(['contacto', 'ver', '&id_contacto=$this->id', 'bloque2_trabajo', 0, 0]);\">ver</span>
				<span class='a' onclick=\"confirmacion(['Borrar contacto','contacto', 'borrar', '&id_contacto=$this->id', 'tabla_contacto', 0, 0]);\">borrar</span>
			</div>
			<div style='clear:both;'></div>
		";
		
		return $o;
	}
	
	

	
	
	
	
	
	
	
	
	
	

	function ver() {

		if (!$GLOBALS["usuario"]->id_usuario) {
			return acceso_restringido();
		}

		if (!$this->id) {
			return acceso_restringido();
		}
		
		if ($this->datos["id_tipo"] == 1) {
			$tipo = "EVENTO";
		} else if ($this->datos["id_tipo"] == 2) {
			$tipo = "RESERVA";
		} 
		
		$i = 0;
		
		if ($this->datos["respondido"]) {
			$respondido = "checked";
		} else {
			$respondido = "";
		}
		
		if ($this->datos["contacto"]) {
			$contacto = "S&Iacute;";
		} else {
			$contacto = "NO";
		}
		
		$o .= "
			<div class='tabla_tr " . tabla_par($i++) . "'>	
				<div class='tabla_td' style='width: 18%;'>
					Respondido:
				</div>
				<div class='tabla_td' style='width: 78%;'>
					<input type='checkbox' id='respondido' value='1' onchange=\"formulario2(['contacto','respondido&id_contacto=$this->id', ['respondido'], 'temp',0,1]);\"/>
				</div>
				<div style='clear:both;'></div>
			</div>
		
			<div class='tabla_tr " . tabla_par($i++) . "'>	
				<div class='tabla_td' style='width: 18%;'>
					TIPO
				</div>
				<div class='tabla_td' style='width: 78%;'>
					$tipo
				</div>
				<div style='clear:both;'></div>
			</div>
			
			<div class='tabla_tr " . tabla_par($i++) . "'>	
				<div class='tabla_td' style='width: 18%;'>
					FECHA ALTA
				</div>
				<div class='tabla_td' style='width: 78%;'>
					" . fecha($this->datos["fecha_alta"]) . " " . substr($this->datos["fecha_alta"], 11, 5) . "
				</div>
				<div style='clear:both;'></div>
			</div>
			
			<div class='tabla_tr " . tabla_par($i++) . "'>	
				<div class='tabla_td' style='width: 18%;'>
					NOMBRE
				</div>
				<div class='tabla_td' style='width: 78%;'>
					" . $this->datos["apellidos"] . ", " . $this->datos["nombre"] . " 
				</div>
				<div style='clear:both;'></div>
			</div>
			
			<div class='tabla_tr " . tabla_par($i++) . "'>	
				<div class='tabla_td' style='width: 18%;'>
					EMAIL
				</div>
				<div class='tabla_td' style='width: 78%;'>
					<a href='mailto:" . $this->datos["email"] . "'>" . $this->datos["email"] . "</a> 
				</div>
				<div style='clear:both;'></div>
			</div>
			
			<div class='tabla_tr " . tabla_par($i++) . "'>	
				<div class='tabla_td' style='width: 18%;'>
					TLF. 
				</div>
				<div class='tabla_td' style='width: 78%;'>
					" . $this->datos["tlf"] . " 
				</div>
				<div style='clear:both;'></div>
			</div>
			";
					
		if ($this->datos["id_tipo"] == 1) {
			$o .= "
			<div class='tabla_tr " . tabla_par($i++) . "'>	
				<div class='tabla_td' style='width: 18%;'>
					TIPO DE EVENTO
				</div>
				<div class='tabla_td' style='width: 78%;'>
					" . $this->datos["tipo"] . " 
				</div>
				<div style='clear:both;'></div>
			</div>";
		}
		
		$o .= "
			<div class='tabla_tr " . tabla_par($i++) . "'>	
				<div class='tabla_td' style='width: 18%;'>
					Nº DE PERSONAS
				</div>
				<div class='tabla_td' style='width: 78%;'>
					" . $this->datos["numero"] . " 
				</div>
				<div style='clear:both;'></div>
			</div>
			
			<div class='tabla_tr " . tabla_par($i++) . "'>	
				<div class='tabla_td' style='width: 18%;'>
					FECHA DE RESERVA 
				</div>
				<div class='tabla_td' style='width: 78%;'>
					" . $this->datos["fecha"] . " 
				</div>
				<div style='clear:both;'></div>
			</div>
			
			<div class='tabla_tr " . tabla_par($i++) . "'>	
				<div class='tabla_td' style='width: 18%;'>
					HORA DE RESERVA 
				</div>
				<div class='tabla_td' style='width: 78%;'>
					" . $this->datos["hora"] . " 
				</div>
				<div style='clear:both;'></div>
			</div>
			
			<div class='tabla_tr " . tabla_par($i++) . "'>	
				<div class='tabla_td' style='width: 18%;'>
					CONTACTO COMERCIAL 
				</div>
				<div class='tabla_td' style='width: 78%;'>
					" . $contacto . " 
				</div>
				<div style='clear:both;'></div>
			</div>
			";
		
		if ($this->datos["id_tipo"] == 2) {
			
			$o .= "
			<div class='tabla_tr " . tabla_par($i++) . "'>	
				<div class='tabla_td' style='width: 18%;'>
					COMENTARIOS 
				</div>
				<div class='tabla_td' style='width: 78%;'>
					" . nl2br($this->datos["comentarios"]) . " 
				</div>
				<div style='clear:both;'></div>
			</div>";
		}
		
		return $o;
		
	}
	
		
	
	
	
	
	
	
	
	
	
			
}

?>