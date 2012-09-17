<?php

function Limpiarurl ($url) {
$url = ereg_replace ("/mail.php", "", $url);
//$url = ereg_replace ("http://", "", $url);
return $url;
}
function validarLadoServidorN($nombre){ 
    if(!preg_match("/^[a-zA-Z ]+$/", $nombre))  
        return false;  
    // SI longitud, SI caracteres A-z  
    else  
        return true;  
}
//function validarLadoServidorM($mensaje){ 
//    if(!preg_match("/^[\\w\n\s \.\?\¿\!\¡\,]+$/", $mensaje))  
//        return false;
//    // SI longitud, SI caracteres A-z  
//    else  
//        return true; 
//}
function validateEmail($correo){  
if(!filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL))
        return false;
    // SI rellenado, SI email valido  
    else  
        return true;  
}  
 function SanitizeInputXSS($dirty_input) {
return htmlspecialchars(rawurldecode(trim($dirty_input)), ENT_QUOTES,'UTF-8');
}
    session_start();
	$nombre = SanitizeInputXSS($_POST['nombre']);
	$mensaje = SanitizeInputXSS($_POST['mensaje']);
	$para = SanitizeInputXSS($_POST['correo']);
	$titulo = 'CNTI';
  //$cabeceras .= 'From: gobiernoenlinea' . "\r\n";
	$Captcha = (string) $_POST['captcha'];
  $web = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  $urlweb = Limpiarurl ($web);
 $cabeceras .= 'From: <gobiernoenlinea@cnti.gob.ve>' . "\r\n";
 //$cabeceras .= "X-Mailer: PHP/" . phpversion() . " \r\n";
 //$cabeceras .= "Mime-Version: 1.0 \r\n";
 $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	//Mensaje predeterminado para el usuario

//////////////////////////////////////////////////////////////////////////////////////////
if(!validarLadoServidorN($nombre)){                                                     //
echo '<script language="javascript">alert("Nombre Erroneo");</script>';                 //
                                                                                        //
  exit(' ');                                                                            //
}                                                                                       //
                                                                                        //
  //if(!validarLadoServidorM($mensaje)){                                                  //
  //echo '<script language="javascript">alert("Mensaje Erroneo");</script>';              //
        //$mensaje = "error";                                                           //
  // exit(' ');                                                                           //
  //}                                                                                     //
                                                                                        //
if(!validateEmail($correo)){                                                           //
echo '<script language="javascript">alert("Correo Erroneo");</script>';                 //
        //$rcorreo = "error";                                                           //
  exit(' ');                                                                            //
}                                                                                       //
//////////////////////////////////////////////////////////////////////////////////////////

	if ($mensaje == ""){
	$mensaje = 'Hola,'."<br>".$nombre. ' Acaba de visitar esta página web y quiere compartir el contenido de ella con usted, para acceder al contenido de la página sólo debes hacer click en el link'."<br><br>".$urlweb;
	}else{
	$mensaje = 'Hola,'."<br>".$nombre. '  Acaba de visitar esta página web y quiere compartir el contenido de ella con usted, para acceder al contenido de la página sólo debes hacer click en el link'."<br><br>".$urlweb;
	$mensaje .= "<br><br>".'Además '. $nombre .'  te envio un mensaje:'."<br><br>";
  $mensaje .= "\"".$_POST['mensaje']."\"<br><br>";


	}
    $mensaje .= "<br><br>".'Contactos:'."<br>".'atencion@cnti.gob.ve'."<br>".'Master 0212-576-6312'."<br>".'0500-CNTI-000';

	if(sha1($Captcha) != $_SESSION["CAPTCHA"]) {
						
        echo "<div style=\" text-align:center \"> </br></br> <h2> Captcha Erroneo <h2> <img alt=\"Error\" src=\"images/Error.png\"/> </div>";
        echo "<div style=\" text-align:center \"> <input type='button' value='OK' onClick='history.go(-1);'></div>";
            //echo  "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            //Limpiarurl ($web);
        //echo $urlweb;
             exit(' ');
            }
      //////////////////////////validaciones lado Servidor//////////////////////////////////
      //  if(!preg_match("/^[a-zA-Z ]+$/", $nombre))  {
      //  return false; }
      //else{echo '<script language="javascript">alert("Nombre Erroneo");</script>';}
      /////////////////////////////////////////////////////////////////////////////////////
	    //	if(!preg_match("/^[a-zA-Z ]+$/", $mensaje))  {
      //  echo '<script language="javascript">alert("Mensaje Erroneo");</script>';
      // exit(' ');
      //  return false;  }
      //  else {echo '<script language="javascript">alert("Mensaje Erroneo");</script>';}
      //////////////////////////////////////////////////////////////////////////////////////
      //  if(!filter_var($rcorreo, FILTER_SANITIZE_EMAIL)){
      //  return false;
      //  }   else { echo '<script language="javascript">alert("Correo Erroneo");</script>';} 
      //////////////////////////////////////////////////////////////////////////////////////
//header("Location: index.html"); 
//Colocarlos en tablas
	if (mail($para, $titulo, $mensaje, $cabeceras)){
		    echo "<div style=\" text-align:center \"> </br></br> <h3> Correo Enviado con Exito a: </br> $para <h3> <img alt=\"Error\" src=\"images/Fino.png\"/> </div>";
        echo "<script type=\"text/javascript\" src=\"js/tinybox.js\"></script> <div style=\" text-align:center \">  <div class=\"tclose\"></div> ";

	}else{
	    echo "<div style=\" text-align:center \"> </br></br> <h1> Error no pudo enviarse :( <h1> <img alt=\"Error\" src=\"images/Error.png\"/> </div>";
      echo "<div style=\" text-align:center \"> <input type='button' value='OK' onClick='history.go(-1);'></div>";

	}
	session_destroy();
?>
