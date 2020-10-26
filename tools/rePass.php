<?php
require_once "common/libs/PHPMailer/class.phpmailer.php";
require_once "dbTonka.php";


class RePass extends View {
        public function actualizaContrasena($obj_usuario, $new_password) {
                $sistema = "qManagement " . APP_VERSION;
                $recurso = "Recuperar Contraseña";
                $usuario = $obj_usuario->denominacion;
                $usuario_so = gethostbyaddr($_SERVER['REMOTE_ADDR']);
                $host = $_SERVER['REMOTE_ADDR'];
                $fecha = date('Y-m-d H:i:s');
                $sql = "INSERT INTO appslog(sistema, recurso, usuario, usuario_so, host, fecha)
                        VALUES(?, ?, ?, ?, ?, ?)";
                $datos = array($sistema, $recurso, $usuario, $usuario_so, $host, $fecha);
                $rst = query_log_tonka($sql, $datos);
                
                $gui = file_get_contents('static/emailRePass.html');
                $fecha_desglosada = $this->descomponer_fecha();

                $origen = "NOresponder.edelar@emdersa.com.ar";
                $nombre = "Envios Automaticos EDELAR S.A.";
                $host = "172.18.2.18";
                $port = 25;
                $usuario = "edelar\Noresponder";
                $token = "Miercoles$14";
                $smtp_secure = "";
                $asunto = "Blanqueo de contraseña: " . APP_TITTLE;
                $destino = $obj_usuario->usuariodetalle->correoelectronico;
                $obj_usuario = $this->set_dict($obj_usuario);
                
                $render = $this->render($fecha_desglosada, $gui);
                $render = $this->render($obj_usuario, $render);
                $render = str_replace("{new_password}", $new_password, $render);
                
                $mail = new PHPMailer();
                $mail->CharSet = "UTF-8";
                $mail->Host = $host;
                $mail->IsSMTP();
                $mail->SMTPAuth = true;
                $mail->Username = $usuario;
                $mail->Password = $token;
                $mail->SMTPSecure = $smtp_secure;
                $mail->Port = $puerto;
                $mail->From = $origen;
                $mail->FromName = $nombre;
                $mail->AddAddress($destino);
                $mail->IsHTML(true);
                $mail->Subject = $asunto;
                $mail->Body = $render;
                $mail->Send();
        }
}
?>
