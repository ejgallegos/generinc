<?php
error_reporting(0);
$file = (isset($_GET['f'])) ? $_GET['f'] : '';
$ids = explode("_", $file);

$objeto = $ids[0];
$objeto_id = $ids[1];
$url = (isset($ids[2])) ? $ids[2] : "";
$archivo = URL_APPFILES . "{$objeto}/{$objeto_id}/{$url}";

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
	$archivo = URL_APPFILES . "common/imagenes/no_image.png";
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mime = finfo_file($finfo, $archivo);
	finfo_close($finfo);
	header("Content-Type: $mime");
	$imagen = readfile($archivo);
}
?>