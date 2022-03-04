<?php
/**
 * @author Ruben Ramirez Rivera
 */
require "../bootstrap.php";

use App\Controllers\AuthController;
use App\Core\Router;
use App\Controllers\ContactosController;
use \Firebase\JWT\JWT; 
use \Firebase\JWT\Key;

//Cabeceras
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Recuperamos el método utilizado.
$requestMethod = $_SERVER["REQUEST_METHOD"];

//Parseamos la dirección de entrada
$request= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $request );

//Si existe recuperamos el id del usuario.
$userId = null;
if (isset($uri[2])) {
    $userId = (int) $uri[2];
}

//Proceso de login
if ($request == '/login') {
    $auth = new AuthController($requestMethod);
    if (!$auth->loginFromRequest()){
        exit(http_response_code(401));
    };
}

$input = (array) json_decode(file_get_contents('php://input'), TRUE);
$autHeader =  $_SERVER['HTTP_AUTHORIZATION'];

$arr = explode(" ",$autHeader);
$jwt = $arr[1];

if($jwt){

    try {
        //Si no es posible decodificar el token generamos un error
        //Se podría crear en la clase un método de verificación. 
        $decoded = (JWT::decode($jwt, new Key(KEY,'HS256')));
    } catch (Exception $e){
      
      echo json_encode(array(
           "message" => "Access denied.",
           "error" => $e->getMessage()));
      exit(http_response_code(401));
   
  }
}


//Definimos las ruta válidas.
$router = new Router();
$router->add(array(
    'name'=>'home', 
    'path'=>'/^\/contactos(\/[0-9])?$/',
    'action'=>ContactosController::class));


$route =$router->match($request);
if ($route) {
    $controllerName = $route['action'];
    $controller = new $controllerName($requestMethod, $userId);
    $controller->processRequest();
     
} else {
    echo "no ruta";
    $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
    $response['body'] = null;
    echo json_encode($response);
}