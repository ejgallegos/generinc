<?php
require_once 'core/helpers/user.php';
require_once 'modules/usuario/model.php';


class SessionBaseHandler {
    function checkin() {
        $user = hash(ALGORITMO_USER, $_POST['usuario']);
        $clave = hash(ALGORITMO_PASS, $_POST['contrasena']);
        $hash = hash(ALGORITMO_FINAL, $user . $clave);
        $usuariodetalle_id = User::get_usuariodetalle_id($hash);

        if ($usuariodetalle_id != 0) {
            $usuario_id = User::get_usuario_id($usuariodetalle_id);
            if ($usuario_id != 0) {
                $um = new Usuario();
                $um->usuario_id = $usuario_id;
                $um->get();

                $data_login = array(
                    "usuario-usuario_id"=>$um->usuario_id,
                    "usuario-denominacion"=>$um->denominacion,
                    "usuario-nivel"=>$um->nivel->nivel,
                    "nivel-denominacion"=>$um->nivel->denominacion,
                    "usuariodetalle-nombre"=>$um->usuariodetalle->nombre,
                    "usuariodetalle-apellido"=>$um->usuariodetalle->apellido,
                    "usuariodetalle-gerencia_id"=>$um->usuariodetalle->centrocosto->gerencia->gerencia_id,
                    "usuariodetalle-sector"=>$um->usuariodetalle->centrocosto->gerencia->denominacion,
                    "usuariodetalle-departamento"=>$um->usuariodetalle->centrocosto->denominacion,
                    "usuariodetalle-distrito"=>$um->usuariodetalle->unicom->denominacion,
                    "usuariodetalle-correoelectronico"=>$um->usuariodetalle->correoelectronico,
                    "usuario-configuracionmenu"=>$um->configuracionmenu->configuracionmenu_id);

                $_SESSION["data-login-" . APP_ABREV] = $data_login;
                $_SESSION['login' . APP_ABREV] = true;
                $redirect = URL_APP . "/usuario/panel";
                saveLog()->save("Checkin.");
            }
        } else {
            $_SESSION['login' . APP_ABREV] = false;
            $redirect = URL_APP . LOGIN_URI . "/mError";
        }

        header("Location: $redirect");
    }

    function check_session() {
        if($_SESSION['login' . APP_ABREV] !== true) {
            $this->checkout();
        }
    }

    function check_panel($usr_nivel) { 
        switch ($usr_nivel) {
            case 1:
                $panel = "operador";
                break;
            case 3:
                $panel = "administrador";
                break;
            case 9:
                $panel = "administrador";
                break;
            default:
                $panel = "administrador";
                break;
        }

        return $panel;
    }

    function check_admin_level() {
        $level = $_SESSION["data-login-" . APP_ABREV]["usuario-nivel"];
        if ($level != 10) {
            $this->checkout();
        }
    }

    function check_level() {
        $level = $_SESSION["data-login-" . APP_ABREV]["usuario-nivel"];
        if ($level > 1 ) {
            $_SESSION['login' . APP_ABREV] = true;
        } else {
            $this->checkout();
        }
    }

    function checkout() {
        saveLog()->save("Checkout.");
        $_SESSION[] = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
        $_SESSION['login' . APP_ABREV] = false;
        header("Location:" . URL_APP . LOGIN_URI);
        exit;
    }
}

function SessionHandler() { return new SessionBaseHandler();}
