<?php
/**
 * @author Ruben Ramirez Rivera
 */

 namespace App\Controllers;

 use App\Models\Contacto;

class ContactosController {

private $requestMethod;
private $userId;
private $contactos;

public function __construct($requestMethod, $userId)
{

    $this->requestMethod = $requestMethod;
    $this->userId = $userId;
    $this->contactos = contacto::getInstancia();
}

public function processRequest(){
    switch ($this->requestMethod) {
        case 'GET':
            if ($this->userId) {
                $response = $this->getContactos($this->userId);
            } else {
                $response = $this->getAllContactos();
            };
            break;
        case 'POST':
            $response = $this->createContactosFromRequest();
            break;
        case 'PUT':
            $response = $this->updateContactosFromRequest($this->userId);
            break;
        case 'DELETE':
            $response = $this->deleteContactosFromRequest($this->userId);
            break;
        default:
            $response = $this->notFoundResponse();
            break;
    }
    header($response['status_code_header']);
    if ($response['body']) {
        echo $response['body'];
    }

}

private function getAllContactos(){
    $result = $this->contactos->getAll();
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($result);
    return $response;
}

private function getContactos($id){
    $result = $this->contactos->get($id);
    if (! $result) {
        return $this->notFoundResponse();
    }
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($result);
    return $response;
}

private function createContactosFromRequest(){
    $input = (array) json_decode(file_get_contents('php://input'), TRUE);

    $this->contacto->set($input);

    $response['status_code_header'] = 'HTTP/1.1 201 Created';
    $response['body'] = null;

    return $response;
}

private function updateContactosFromRequest($id){
    $result = $this->contacts->get($id);
    if (! $result) {
        return $this->notFoundResponse();
    }        
    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    $input += ["id" => $id];
    $this->contacts->edit($input);
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = null;
    return $response;
}

private function deleteContactosFromRequest($id){
    $result = $this->contacts->delete($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
}

private function unprocessableEntityResponse() {
    $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
    $response['body'] = json_encode([
        'error' => 'Invalid input'
    ]);
    return $response;
}

private function notFoundResponse(){
    $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
    $response['body'] = null;
    return $response;
}
}
