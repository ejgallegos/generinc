<?php
require_once 'common/libs/PHPMailer/class.phpmailer.php';


class EmailHelper extends View {
	public function envia_email($dict_email, $destinos_array, $asunto) { 
                $gui = file_get_contents("static/common/mail/plantilla.html");
                $fecha_descompuesta = $this->descomponer_fecha();
                $gui = $this->render($dict_email, $gui);
                $gui = $this->render($fecha_descompuesta, $gui);
                
                $origen = "consultas@tonka.com.ar";
                $nombre = "TonKa Consultas - CIE";

                $mail = new PHPMailer();
                $mail->From = $origen;
                $mail->FromName = $nombre;
                foreach ($destinos_array as $clave=>$valor) $mail->AddAddress($valor);
                $mail->AddReplyTo($origen);
                $mail->IsHTML(true);
                $mail->Subject = utf8_decode($asunto);
                $mail->Body = utf8_decode($gui);
                $mail->IsSMTP();
                $mail->Host = '172.18.1.29';
                $mail->Send();
	}
}
?>