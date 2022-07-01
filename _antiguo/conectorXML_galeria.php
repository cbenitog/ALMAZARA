<?php

include('configuracionx.php');

$selectortabla = $_GET['tabla'];

//---conexión
$conn = mysql_connect($dbserver, $dbuser, $dbpassword);

mysql_select_db($dbname, $conn);


//--seleccion de provincia
switch ($selectortabla) {
    case 1:
        $tablaDB = $tablename1;
        break;
    case 2:
        $tablaDB = $tablename2;
        break;
    case 3:
        $tablaDB = $tablename3;
        break;
    case 4:
        $tablaDB = $tablename4;
        break;
}



//---XML web site	
//if($selectortabla==4){


/* echo '<?xml version="1.0" encoding="utf-8"?>'; */
$datos = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n";
$datos.= "<thumbnails>\r\n";

$ssql = "SELECT * FROM galeriax";


$rs = mysql_query($ssql, $conn);

$datas = mysql_num_rows($rs);

if ($datas > 0) {

    while ($rowEmp = mysql_fetch_assoc($rs)) {

        $idx = $rowEmp[$id];
        $ruta_titular = $rowEmp[$titularx];
        $ruta_textox = $rowEmp[$descripcionx];
        $ruta_thumbx = $rowEmp[$thumb_galeria];
        $ruta_bigx = $rowEmp[$big_galeria];


//--------------------------1
        $ssql2 = "SELECT
pe_uploads.`file`,
galeriax.id
FROM
galeriax
Inner Join pe_uploads ON galeriax.thumb_file = pe_uploads.id WHERE galeriax.id=$idx
";

$ssql3 = "SELECT
pe_uploads.`file`,
galeriax.id
FROM
galeriax
Inner Join pe_uploads ON galeriax.big_file = pe_uploads.id WHERE galeriax.id=$idx
";

        $rs2 = mysql_query($ssql2, $conn);
        $datas2 = mysql_num_rows($rs2);
        if ($datas2 > 0) {
            while ($rowEmp2 = mysql_fetch_assoc($rs2)) {
                $ruta_thumbx = $rowEmp2['file'];
            }
        }

	$rs3 = mysql_query($ssql3, $conn);
        $datas2 = mysql_num_rows($rs3);
        if ($datas2 > 0) {
            while ($rowEmp3 = mysql_fetch_assoc($rs3)) {
                $ruta_bigx = $rowEmp3['file'];
            }
        }
//-----xml
        //$datos.= '  <opcion id="' . $idx . '" ruta_imagen="' . $ruta_imagenx . '"  >';

        //$datos.= '  <ruta_titular><![CDATA[' . $ruta_titular . ']]></ruta_titular>';
        //$datos.= '  <ruta_textos><![CDATA[' . $ruta_textox . ']]></ruta_textos>';
        //$datos.= '  </opcion>';

	$datos.="	<thumbnail filename=\"".$ruta_thumbx."\" url=\"".$ruta_bigx."\" target=\"_parent\"
	title=\"".$ruta_titular."\"
	description=\"".$ruta_textox."\" />\r\n\r\n";


    }
}
$datos.= '</thumbnails>';


$caracteres_base = array('&aacute;', '&eacute;', '&iacute;', '&oacute;', '&uacute;', '&Aacute;', '&Eacute;', '&Iacute;', '&Oacute;', '&Uacute;', '&ntilde;', '&Ntilde;', '&uuml;', '&Uuml;', '&euro;', '&amp;', '&quot;', '<strong>', '</strong>', '<em>', '</em>');
$caracteres_replazar = array('á', 'é', 'í', 'ó', 'ú', 'A', 'E', 'I', 'O', 'U', 'ñ', 'Ñ', 'ü', 'Ü', '€', '&', '"', '<b>', '</b>', '<i>', '</i>');


$datosfinal = str_replace($caracteres_base, $caracteres_replazar, $datos);

echo $datosfinal; //--mostrar datos*/
//}

$DescriptorFichero = fopen("galeria_xml.xml", "w");

fputs($DescriptorFichero, $datosfinal);

fclose($DescriptorFichero);
?>

