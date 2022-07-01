<?php 

//http://www.toolz.es/almazara/almazara2/conectorXML_ofertas.php?tabla=2

include('configuracionx.php');

$selectortabla=$_GET['tabla'];




//---conexión
$conn = mysql_connect($dbserver,$dbuser,$dbpassword);

mysql_select_db($dbname,$conn);


//--seleccion de provincia
switch ($selectortabla) {
    case 1:
		  $tablaDB=$tablename1;
        break;
    case 2:
		  $tablaDB=$tablename2;
        break;
	case 3:
		  $tablaDB=$tablename3;
        break;

}


	
//---XML web site	
if(	$selectortabla==2){


/*echo '<?xml version="1.0" encoding="utf-8"?>';*/
$datos= '<?xml version="1.0" encoding="iso-8859-1"?>';
$datos.= '<root>';

$ssql = "SELECT * FROM $tablaDB ORDER BY id ASC";


			 $rs = mysql_query($ssql,$conn);

             $datas= mysql_num_rows($rs); 

             if ($datas> 0) {

             while ($rowEmp = mysql_fetch_assoc($rs)) {
     
	          $idx=$rowEmp[$id];
			  $ruta_titular=$rowEmp[$Titularx];
			  $ruta_textox=$rowEmp[$Textox];
			  $ruta_imagenx=$rowEmp[$imagenx];
			  

//--------------------------1
$ssql2 = "SELECT
pe_uploads.`file`,
Ofertasx.id
FROM
Ofertasx
Inner Join pe_uploads ON Ofertasx.imagen_file = pe_uploads.id  WHERE Ofertasx.id=$idx 
";

$rs2 = mysql_query($ssql2,$conn);
$datas2= mysql_num_rows($rs2); 
if ($datas2> 0) {while ($rowEmp2 = mysql_fetch_assoc($rs2)) {
	 $ruta_imagenx=$rowEmp2['file'];
}}

//-----xml

$datos.= '  <opcion id="'.$idx.'" ruta_imagen="'.$ruta_imagenx.'"  >';

$datos.= '  <ruta_titular><![CDATA['.$ruta_titular.']]></ruta_titular>';
$datos.= '  <ruta_textos><![CDATA['.$ruta_textox.']]></ruta_textos>';
$datos.= '  </opcion>';

													}

								}
$datos.= '</root>';


$caracteres_base=array('&aacute;','&eacute;','&iacute;','&oacute;','&uacute;','&Aacute;','&Eacute;','&Iacute;','&Oacute;','&Uacute;','&ntilde;','&Ntilde;','&uuml;','&Uuml;','&euro;','&amp;','&quot;','<strong>','</strong>','<em>','</em>');
$caracteres_replazar=array('á','é','í','ó','ú','A','E','I','O','U','ñ','Ñ','ü','Ü','€','&','"','<b>','</b>','<i>','</i>');					   
	
	
	
$datosfinal=str_replace($caracteres_base,$caracteres_replazar,$datos);

echo $datosfinal; //--mostrar datos*/
					   }


?>