<?php

/**
 * @author Ruben Ramirez Rivera
 */

namespace App\Models;

use App\Models\DBAbstractModel;

class Users extends DBAbstractModel
{
    private static $instancia;
    public static function getInstancia()
    {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    public function __clone()
    {
        trigger_error('La clonación no es permitida!.', E_USER_ERROR);
    }

    public function login($usuario, $password)
    {
        $this->query = '
            SELECT * FROM usuarios 
            WHERE usuario = :usuario AND 
                  password = :password';

        // Cargamos los parametros
        $this->parametros['usuario'] = $usuario;
        $this->parametros['password'] = $password;

        // Ejecutamos la consulta que devuelve los registros
        $this->get_results_from_query();
        return $this->rows[0]??null;
    }

    public function get($id = '')
    {
    }
    public function set()
    {
    }
    public function edit()
    {
    }
    public function delete()
    {
    }
}
