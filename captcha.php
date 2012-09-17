<?php
    session_start();
 
    // Genero el codigo y lo guardo en la sesión para consultarlo luego.
    $codigo_captcha = substr(sha1(microtime() * mktime()), 0, 6);
    $_SESSION['CAPTCHA'] = sha1($codigo_captcha);
 
    // Genero la imagen
    $imagen = imagecreatetruecolor(70, 25);
 
    // Colores RGB
    $ColorFondo = imagecolorallocate($imagen, 230, 230, 230);
    $ColorLetra = imagecolorallocate($imagen, 90, 90, 90);
    $ColorLinea = imagecolorallocate($imagen, 245, 245, 245);
 
    // Fondo
    imagefill($imagen, 0, 0, $ColorFondo);
 
    imageline($imagen, 0, 5, 70, 5, $ColorLinea);
    imageline($imagen, 0, 10, 70, 10, $ColorLinea);
    imageline($imagen, 0, 15, 70, 15, $ColorLinea);
    imageline($imagen, 0, 20, 70, 20, $ColorLinea);
    imageline($imagen, 12, 0, 12, 25, $ColorLinea);
    imageline($imagen, 24, 0, 24, 25, $ColorLinea);
    imageline($imagen, 36, 0, 36, 25, $ColorLinea);
    imageline($imagen, 48, 0, 48, 25, $ColorLinea);
    imageline($imagen, 60, 0, 60, 25, $ColorLinea);
 
    // Escribo el código
    imageString($imagen, 5, 8, 5, $codigo_captcha, $ColorLetra);
 
    // final.
    header("Content-type: image/png");
    imagepng($imagen);
    imagepng($imagen);
?>
