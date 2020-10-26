<?php
class Log {
    public function save($accion) {
        $fecha_sys = date("Y-m-d");
        $hora_sys = date("H:i:s");
        $ip = $_SERVER["REMOTE_ADDR"];
        $user = $_SESSION["data-login-" . APP_ABREV]["usuario-denominacion"];

        $sql = "INSERT INTO
                    log(fecha, hora, ipv4, usuario, accion)
                VALUES
                    (?, ?, ?, ?, ?)";
        $datos = array($fecha_sys, $hora_sys, $ip, $user, $accion);
        $resultados = execute_query($sql, $datos);
    }
}

function saveLog() { return new Log(); }
?>