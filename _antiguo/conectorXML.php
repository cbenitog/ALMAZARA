<?php 

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
if(	$selectortabla==1){


$datos='<?xml version="1.0" encoding="utf-8"?>';
/*$datos= '<?xml version="1.0" encoding="iso-8859-1"?>';*/
$datos.= '<root>';

$ssql = "SELECT * FROM $tablaDB";


			 $rs = mysql_query($ssql,$conn);

             $datas= mysql_num_rows($rs); 

             if ($datas> 0) {

             while ($rowEmp = mysql_fetch_assoc($rs)) {
     
	          $idx=$rowEmp[$id];
			  $seccionx=$rowEmp[$seccion];
			  $subseccionx=$rowEmp[$subseccion];
			  $ruta_textox=$rowEmp[$ruta_texto];
			  $ruta_imagen1x=$rowEmp[$ruta_imagen1];
			  $ruta_imagen2x=$rowEmp[$ruta_imagen2];
			  $ruta_imagen3x=$rowEmp[$ruta_imagen3];
			  $ruta_imagen4x=$rowEmp[$ruta_imagen4];
			  $ruta_imagen5x=$rowEmp[$ruta_imagen5];
			  $ruta_imagen6x=$rowEmp[$ruta_imagen6];
			  $ruta_imagen7x=$rowEmp[$ruta_imagen7];
			  $ruta_imagen8x=$rowEmp[$ruta_imagen8];
			  $ruta_imagen9x=$rowEmp[$ruta_imagen9];
			  $ruta_imagen10x=$rowEmp[$ruta_imagen10];
			  

//--------------------------1
$ssql2 = "SELECT
Laalmazarax.$ruta_imagen1 AS $ruta_imagen1,
pe_uploads.`file` AS `file`
FROM
(Laalmazarax
Inner Join pe_uploads ON ((Laalmazarax.ruta_imagen1_file = pe_uploads.id))) WHERE Laalmazarax.ruta_imagen1_file=$ruta_imagen1x
";
$rs2 = mysql_query($ssql2,$conn);
$datas2= mysql_num_rows($rs2); 
if ($datas2> 0) {while ($rowEmp2 = mysql_fetch_assoc($rs2)) {
	$ruta_imagen1x=$rowEmp2['file'];
}}


//--------------------------2
$ssql2 = "SELECT
Laalmazarax.$ruta_imagen2 AS $ruta_imagen2,
pe_uploads.`file` AS `file`
FROM
(Laalmazarax
Inner Join pe_uploads ON ((Laalmazarax.ruta_imagen2_file = pe_uploads.id))) WHERE Laalmazarax.ruta_imagen2_file=$ruta_imagen2x
";
$rs2 = mysql_query($ssql2,$conn);
$datas2= mysql_num_rows($rs2); 
if ($datas2> 0) {while ($rowEmp2 = mysql_fetch_assoc($rs2)) {
	$ruta_imagen2x=$rowEmp2['file'];
}}


//--------------------------3
$ssql2 = "SELECT
Laalmazarax.$ruta_imagen3 AS $ruta_imagen3,
pe_uploads.`file` AS `file`
FROM
(Laalmazarax
Inner Join pe_uploads ON ((Laalmazarax.ruta_imagen3_file = pe_uploads.id))) WHERE Laalmazarax.ruta_imagen3_file=$ruta_imagen3x
";
$rs2 = mysql_query($ssql2,$conn);
$datas2= mysql_num_rows($rs2); 
if ($datas2> 0) {while ($rowEmp2 = mysql_fetch_assoc($rs2)) {
	$ruta_imagen3x=$rowEmp2['file'];
}}

//--------------------------4
$ssql2 = "SELECT
Laalmazarax.$ruta_imagen4 AS $ruta_imagen4,
pe_uploads.`file` AS `file`
FROM
(Laalmazarax
Inner Join pe_uploads ON ((Laalmazarax.ruta_imagen4_file = pe_uploads.id))) WHERE Laalmazarax.ruta_imagen4_file=$ruta_imagen4x
";
$rs2 = mysql_query($ssql2,$conn);
$datas2= mysql_num_rows($rs2); 
if ($datas2> 0) {while ($rowEmp2 = mysql_fetch_assoc($rs2)) {
	$ruta_imagen4x=$rowEmp2['file'];
}}

//--------------------------5
$ssql2 = "SELECT
Laalmazarax.$ruta_imagen5 AS $ruta_imagen5,
pe_uploads.`file` AS `file`
FROM
(Laalmazarax
Inner Join pe_uploads ON ((Laalmazarax.ruta_imagen5_file = pe_uploads.id))) WHERE Laalmazarax.ruta_imagen5_file=$ruta_imagen5x
";
$rs2 = mysql_query($ssql2,$conn);
$datas2= mysql_num_rows($rs2); 
if ($datas2> 0) {while ($rowEmp2 = mysql_fetch_assoc($rs2)) {
	$ruta_imagen5x=$rowEmp2['file'];
}}

//--------------------------6
$ssql2 = "SELECT
Laalmazarax.$ruta_imagen6 AS $ruta_imagen6,
pe_uploads.`file` AS `file`
FROM
(Laalmazarax
Inner Join pe_uploads ON ((Laalmazarax.ruta_imagen6_file = pe_uploads.id))) WHERE Laalmazarax.ruta_imagen6_file=$ruta_imagen6x
";
$rs2 = mysql_query($ssql2,$conn);
$datas2= mysql_num_rows($rs2); 
if ($datas2> 0) {while ($rowEmp2 = mysql_fetch_assoc($rs2)) {
	$ruta_imagen6x=$rowEmp2['file'];
}}

//--------------------------7
$ssql2 = "SELECT
Laalmazarax.$ruta_imagen7 AS $ruta_imagen7,
pe_uploads.`file` AS `file`
FROM
(Laalmazarax
Inner Join pe_uploads ON ((Laalmazarax.ruta_imagen7_file = pe_uploads.id))) WHERE Laalmazarax.ruta_imagen7_file=$ruta_imagen7x
";
$rs2 = mysql_query($ssql2,$conn);
$datas2= mysql_num_rows($rs2); 
if ($datas2> 0) {while ($rowEmp2 = mysql_fetch_assoc($rs2)) {
	$ruta_imagen7x=$rowEmp2['file'];
}}


//--------------------------8
$ssql2 = "SELECT
Laalmazarax.$ruta_imagen8 AS $ruta_imagen8,
pe_uploads.`file` AS `file`
FROM
(Laalmazarax
Inner Join pe_uploads ON ((Laalmazarax.ruta_imagen8_file = pe_uploads.id))) WHERE Laalmazarax.ruta_imagen8_file=$ruta_imagen8x
";
$rs2 = mysql_query($ssql2,$conn);
$datas2= mysql_num_rows($rs2); 
if ($datas2> 0) {while ($rowEmp2 = mysql_fetch_assoc($rs2)) {
	$ruta_imagen8x=$rowEmp2['file'];
}}

//--------------------------9
$ssql2 = "SELECT
Laalmazarax.$ruta_imagen9 AS $ruta_imagen9,
pe_uploads.`file` AS `file`
FROM
(Laalmazarax
Inner Join pe_uploads ON ((Laalmazarax.ruta_imagen9_file = pe_uploads.id))) WHERE Laalmazarax.ruta_imagen9_file=$ruta_imagen9x
";
$rs2 = mysql_query($ssql2,$conn);
$datas2= mysql_num_rows($rs2); 
if ($datas2> 0) {while ($rowEmp2 = mysql_fetch_assoc($rs2)) {
	$ruta_imagen9x=$rowEmp2['file'];
}}

//--------------------------10
$ssql2 = "SELECT
Laalmazarax.$ruta_imagen10 AS $ruta_imagen10,
pe_uploads.`file` AS `file`
FROM
(Laalmazarax
Inner Join pe_uploads ON ((Laalmazarax.ruta_imagen10_file = pe_uploads.id))) WHERE Laalmazarax.ruta_imagen10_file=$ruta_imagen10x
";
$rs2 = mysql_query($ssql2,$conn);
$datas2= mysql_num_rows($rs2); 
if ($datas2> 0) {while ($rowEmp2 = mysql_fetch_assoc($rs2)) {
	$ruta_imagen10x=$rowEmp2['file'];
}}



//-----xml

$datos.= '  <opcion id="'.$idx.'" seccion="'.$seccionx.'" subseccion="'.$subseccionx.'" ruta_imagen1="'.$ruta_imagen1x.'" ruta_imagen2="'.$ruta_imagen2x.'" ruta_imagen3="'.$ruta_imagen3x.'" ruta_imagen4="'.$ruta_imagen4x.'" ruta_imagen5="'.$ruta_imagen5x.'" ruta_imagen6="'.$ruta_imagen6x.'" ruta_imagen7="'.$ruta_imagen7x.'" ruta_imagen8="'.$ruta_imagen8x.'" ruta_imagen9="'.$ruta_imagen9x.'" ruta_imagen10="'.$ruta_imagen10x.'" >';

$datos.= '  <ruta_textos><![CDATA['.$ruta_textox.']]></ruta_textos>';
$datos.= '  </opcion>';

													}

								}
$datos.= '</root>';


$caracteres_base=array('&aacute;','&eacute;','&iacute;','&oacute;','&uacute;','&Aacute;','&Eacute;','&Iacute;','&Oacute;','&Uacute;','&ntilde;','&Ntilde;','&uuml;','&Uuml;','&euro;','&amp;','&quot;','<strong>','</strong>','<em>','</em>','&ldquo;','&rdquo;');
$caracteres_replazar=array('á','é','í','ó','ú','A','E','I','O','U','ñ','Ñ','ü','Ü','€','&','"','<b>','</b>','<i>','</i>','"','"');					   
					   
$datosfinal=str_replace($caracteres_base,$caracteres_replazar,$datos);

echo $datosfinal; //--mostrar datos
					   }


?>