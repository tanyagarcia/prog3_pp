<?php    
    
    include_once "./Entidades/datos.php";

    class registro
    {
        public $email;
        public $tipoUsuario;
        public $password;

        public function __construct($email, $tipoUsuario, $password)
        {
            $this->email = $email;
            $this->tipoUsuario = $tipoUsuario;
            $this->password = $password;
        }

        public static function validarEmail($archivo, $email)
        {
            $lista = datos::leer($archivo);
            $emailEncontrado = false;

            foreach($lista as $value)
            {
                if($value->email == $email)
                {
                    $emailEncontrado = true;
                    break;
                }
            }

            return $emailEncontrado;
            
        }

        public static function validarUsuario($usuario)
        {
            $respuesta = false;
            if($usuario == "admin" || $usuario == "user")
            {
                $respuesta = true;
            }

            return $respuesta;
        }


        public function guardar($archivo)
        {
            return datos::guardar($archivo, $this);
        }

        public static function verificarUser($email, $clave)
        {
            $lista = registro::leer();
            $userEncontrado = false;
            foreach($lista as $value)
            {
               
                if($value->password == $clave && $value->email == $email)
                {
                    $userEncontrado = true;
                    break;
                }
            }

            return $userEncontrado;
            
        }


        public function leer()
        {
            $lista = datos::leer("usuarios.json");
            return $lista;
        }

        public static function get_payload($clave)
        {
            $payload = "";
            $usuario = registro::buscarUsuarioPorClave($clave);
            if($usuario != null)
            {
                $payload = array(
                "email" => $usuario->email,
                "clave" => $usuario->password,
                "tipo" => $usuario->tipoUsuario
                );
            }
           return $payload;

        }

        public static function buscarUsuarioPorClave($key)
        {
            $lista = registro::leer();
            $userEncontrado = "";

            foreach($lista as $value)
            {
                if($value->password == $key)
                {
                    $userEncontrado = $value;
                    break;
                }
            }

            return $userEncontrado;
            
        }

    }

?>

