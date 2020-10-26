<?php
error_reporting(0);
$file = (isset($_GET['f'])) ? $_GET['f'] : '';
$ids = explode("_", $file);

$objeto = $ids[0];
$objeto_id = $ids[1];
$archivo = URL_APPFILES . "{$objeto}/{$objeto_id}";

if(file_exists($archivo)) {
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mime = finfo_file($finfo, $archivo);
	finfo_close($finfo);
	header("Content-Type: $mime");
	$imagen = readfile($archivo);
} elseif ($objeto_id == 0) {
	$archivo = URL_APPFILES . "common/imagenes/image_pdf.png";
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mime = finfo_file($finfo, $archivo);
	finfo_close($finfo);
	header("Content-Type: $mime");
	$imagen = readfile($archivo);
} else {
	$archivo = URL_APPFILES . "common/imagenes/no_image.jpg";
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mime = finfo_file($finfo, $archivo);
	finfo_close($finfo);
	header("Content-Type: $mime");
	$imagen = readfile($archivo);
}
?>