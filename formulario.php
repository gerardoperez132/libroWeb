<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Formulario Validation</title>
        <link type="text/css" href="css/estilo.css" rel="stylesheet" />      
        <script type="text/javascript" src="js/jquery-1.4.2.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript" src="js/validarForm.js"></script>
    </head>
    <body>
        
         <?php
function SanitizeInputXSS($dirty_input) {
return htmlspecialchars(rawurldecode(trim($dirty_input)), ENT_QUOTES,'UTF-8');
}
function Limpiarurl ($url) {
$url = ereg_replace ("/formulario.php", "", $url);
return $url;
}
    session_start();
        if(isset($_POST['boton'])){
            $Captcha = (string) $_POST['captcha'];
            if(SanitizeInputXSS($_POST['nombre']) == '' or !preg_match("/^[a-zA-Z ñÑçÇáéíóúüÁÉÍÓÚÜ]+$/", SanitizeInputXSS($_POST['nombre']))){
                $error1 = '<span class="error2">Servidor:Ingrese su nombre Correctamente</span>';
            }else if(SanitizeInputXSS($_POST['correo']) == '' or !preg_match("/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/",SanitizeInputXSS($_POST['correo']))){
                $error2 = '<span class="error2">Servidor:Ingrese un email correcto</span>';
            }else  if(SanitizeInputXSS($_POST['captcha']) == '') {
                                $error4 = '<span class="error2">Estimado Usuario, Verifique su código de confirmación</span>' ;
            }else if(sha1($Captcha) != $_SESSION["CAPTCHA"]){
                           $error5 = '<span class="error2">Estimado Usuario, Verifique su código de confirmación</span>';
            } else{
                                //variables
            $web = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $urlweb = Limpiarurl ($web);
            $titulo = 'CNTI';
            $nombre = SanitizeInputXSS($_POST['nombre']);
            $mensaje = SanitizeInputXSS($_POST['mensaje']);
            $para = SanitizeInputXSS($_POST['correo']);
            $mensaje2 = SanitizeInputXSS($_POST['mensaje']);
  if ($mensaje == ""){
  $mensaje = 'Hola,'."<br>".$nombre. ' acaba de visitar esta página web y quiere compartir el contenido de ella con usted. Para acceder al contenido de la página sólo debes hacer click en el link'."<br><br>".$urlweb;
    }else{
  $mensaje = 'Hola,'."<br>".$nombre. '  acaba de visitar esta página web y quiere compartir el contenido de ella con usted. Para acceder al contenido de la página sólo debes hacer click en el link'."<br><br>".$urlweb;
  $mensaje .= "<br><br>".'Ademas '. $nombre .'  te envio un mensaje:'."<br><br>";
  $mensaje .= "\"".$mensaje2."\"<br><br>";}
  $mensaje .= "<br><br>".'Contactos:'."<br>".'atencion@cnti.gob.ve'."<br>".'Master 0212-576-6312'."<br>".'0500-CNTI-000';

                //Cabeceras del correo
                $headers = "From: atencion@cnti.gob.ve\r\n"; //Quien envia?
                $headers .= "X-Mailer: PHP5\n";
                $headers .= 'MIME-Version: 1.0' . "\n";
                $headers .= 'Content-type: text/html; charset="UTF-8" ' . "\r\n"; //
                            
                if(mail($para, $titulo, $mensaje,$headers)){
                    echo "<div style=\" text-align:center \"> </br></br> <h3> Correo Enviado con Exito a: </br> $para <h3> <img alt=\"Error\" src=\"images/Fino.png\"/> </div>";
                    //$result = '<div class="result_ok">Email enviado correctamente :)</div>';    
                    // si el envio fue exitoso reseteamos lo que el usuario escribio:
                    $_POST['nombre'] = '';
                    $_POST['correo'] = '';
                    $_POST['mensaje'] = '';
                }else{
                    echo "<div style=\" text-align:center \"> </br></br> <h1> Error no pudo enviarse :( <h1> <img alt=\"Error\" src=\"images/Error.png\"/> </div>";
                    //$result = '<div class="result_fail">Hubo un error al enviar el mensaje :(</div>';
                }
                        }
        }
    ?>

            <form id="registro" name="registro" method="post">
                <div class="titulo"><h3>Compartir Contenido Por Correo.</h3></div>
                <div>
                    <label class="campo">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value='<?php echo $_POST['nombre']; ?>' />
                    <span class="ast">*</span> <div class="error3"><?php echo $error1 ?></div>
                </div>
                <div>
                    <label class="campo">Correo Remitente:</label>
                    <input type="text" id="correo" name="correo" value='<?php echo $_POST['correo']; ?>' /> 
                    <span class="ast">*</span> <div class="error3"><?php echo $error2 ?></div>
                </div>
                <div>
                    <label class="campo">Mensaje:</label>
                    <textarea id="mensaje" name="mensaje" rows ="10" cols ="45" ><?php echo $_POST['mensaje']; ?></textarea> 
                </div>
                <div>
                    <img src="captcha.php" alt="captcha"/>
                    <input type="text" id="captcha" name="captcha" style="width: 65px;" /> 
                    <span class="ast">*</span>
                    <div ><?php echo $error4 ?></div>
                    <div ><?php echo $error5 ?></div>

                 </div>
                <input type="submit" value="ENVIAR" name='boton'/>
            </form>
        
    </body>
</html>
