<?php

    require_once __DIR__ .'/vendor/autoload.php';
    use \Firebase\JWT\JWT;
    require_once "./Entidades/response.php";
    require_once "./Entidades/registro.php";
    require_once "./Entidades/datos.php";
    require_once "./Entidades/precio.php";
    require_once "./Entidades/autos.php";

    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : "";
    $request_method = $_SERVER['REQUEST_METHOD'];
    $response = new response();
    $claveToken = "primerparcial";

    switch($request_method)
    {
        case "POST":
            switch($path_info)
            {
                case "/registro":
            
                    if(isset($_POST['email']) && isset($_POST['tipo']) && isset($_POST['password']))
                    {   
                        $email = $_POST['email'];
                        $tipo = $_POST['tipo'];
                        $password = $_POST['password'];
                        $emailCargado = registro::validarEmail("usuarios.json", $email);
                        $tipoUsuario = registro::validarUsuario($tipo);
                        
                        if($emailCargado == false && $tipoUsuario == true)
                        {
                            $registro = new registro($email, $tipo, $password);
                            $rta = $registro->guardar("usuarios.json");
                            $response->data = $rta;
                            echo json_encode($response);
                        }
                        else
                        {
                            $response->data = "El usuario no es valido";
                            $response->status = "fail";
                            echo json_encode($response);
                        }
                        
                    }
                    else{
                        $response->data = "Faltan datos";
                        $response->status = "fail";
                        echo json_encode($response);
                    }
                break;
                case "/login":

                    if(isset($_POST['email']) && isset($_POST['password']))
                    {
                        $email = $_POST['email'];
                        $key = $_POST['password'];
                        $registrado = registro::verificarUser($email, $key);
                        if($registrado == true)
                        {
                            $payload = registro::get_payload($key);
                            $jwt = JWT::encode($payload, $claveToken);
                            $response->data = $jwt;
                            echo json_encode($response);
                        }
                        else
                        {
                            $response->data = "Usuario no encontrado";
                            $response->status = "fail";
                            echo json_encode($response);
                        }
                    }
                    else
                    {
                        $response->data = "Faltan datos";
                        $response->status = "fail";
                        echo json_encode($response);
                    }
                break;
                case "/precio":

                    $headers = getallheaders();
                    $miToken = $headers['token'] ?? '';
                    
                    try
                    {
                        $decoded = JWT::decode($miToken, $claveToken, array('HS256'));
                        //var_dump($decoded);
                        if($decoded->tipo == "admin")
                        {
                           
                            if(isset($_POST['precio_hora']) && isset($_POST['precio_estadia'])  && isset($_POST['precio_mensual']))
                            {
                                $hora = $_POST['precio_hora'];
                                $estadia = $_POST['precio_estadia'];
                                $mensual = $_POST['precio_mensual'];
                                $precio = new precio($hora, $estadia, $mensual);
                                $rta = $precio->guardar("precio.json");
                                $response->data = $rta;
                                echo json_encode($response);   
                            }
                            else
                            {
                                $response->data = "Faltan datos";
                                $response->status = "fail";
                                echo json_encode($response);
                            }
                        }
                    }
                    catch(\Throwable $th)
                    {
                        echo $th->getMessage();
                    }                 
                break;
                case "/ingreso":

                    $headers = getallheaders();
                    $miToken = $headers['token'] ?? '';
                    
                    try
                    {
                        $decoded = JWT::decode($miToken, $claveToken, array('HS256'));
                        //var_dump($decoded);
                        if($decoded->tipo == "user")
                        {
                           
                            if(isset($_POST['patente']) && isset($_POST['tipo']))
                            {
                                $patente = $_POST['patente'];
                                $tipo = $_POST['tipo'];
                                $email = $decoded->email;
                                $hora = time();
                                $auto = new auto($patente, $hora, $tipo, $email);
                                $rta = $auto->guardar("autos.json");
                                $response->data = $rta;
                                echo json_encode($response);   
                            }
                            else
                            {
                                $response->data = "Faltan datos";
                                $response->status = "fail";
                                echo json_encode($response);
                            }
                        }
                        else
                        {
                            $response->data = "No es user";
                            $response->status = "fail";
                            echo json_encode($response);

                        }
                    }
                    catch(\Throwable $th)
                    {
                        echo $th->getMessage();
                    }                 
                break;
                default:
                echo "Path no reconocido";
                break;
            }
        break;
        case "GET":

            switch($path_info)
            {
                case "/retiro/{patente}":
                    $headers = getallheaders();
                    $miToken = $headers['token'] ?? '';
                    $variable = $_GET['patente'];
                    try
                    {
                        $decoded = JWT::decode($miToken, $claveToken, array('HS256'));
                        //echo "Token validado". PHP_EOL;
                        if($decoded->tipo == "user")
                        {
                            $response->data = $datosLeidos;
                            echo json_encode($response);
                        }
                        else
                        {
                            $response->data = "No es user";
                            $response->status = "fail";
                            echo json_encode($response);
                        }
                     
                    }
                    catch(\Throwable $th)
                    {
                        echo $th->getMessage();
                    }
                break;
                case "/ingresos":
                    $headers = getallheaders();
                    $miToken = $headers['token'] ?? '';
                    $variable = $_GET['patente'];
                    try
                    {
                        $decoded = JWT::decode($miToken, $claveToken, array('HS256'));
                        $autosOrdenados = autos::ordenar();
                        $response->data = $autosOrdenados;
                        echo json_encode($response);
                     
                    }
                    catch(\Throwable $th)
                    {
                        echo $th->getMessage();
                    }
                break;
            
                default:
                echo "Path no reconocido";
                break;
            }

        break;

        }




?>