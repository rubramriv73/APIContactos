<?php
/**
 * @author Ruben Ramirez Rivera
 * 
 *  
 */

 namespace App\Models;

 use App\Models\DBAbstractModel;

 class Contacto extends DBAbstractModel {
    /*CONSTRUCCIÓN DEL MODELO SINGLETON*/
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

        private $id;
        private $nombre;
        private $telefono;
        private $email;
        private $created_at;
        private $updated_at;

        public function setNombre($nombre) {
            $this->nombre = $nombre;
        }

        public function setTelefono($telefono) {
            $this->telefono = $telefono;
        }

        public function setEmail($email) {
            $this->email = $email;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function getNombre() {
            return $this->nombre;
        }

        public function getTelefono() {
            return $this->telefono;
        }

        public function getEmail() {
            return $this->email;
        }

        public function getId() {
            return $this->id;
        }

        public function set($user_data=array()) {
            foreach ($user_data as $campo=>$valor) {
                $$campo = $valor;
            }
            $this->query = "INSERT INTO contactos(nombre, telefono, email)
                            VALUES(:nombre, :telefono, :email)";
            $this->parametros['nombre']= $this->nombre;
            $this->parametros['velocidad']= $this->telefono;
            $this->parametros['email']=$this->email;
            $this->get_results_from_query();
            $this->mensaje = 'SH agregado correctamente';

        }

        public function get($id='')
        {
            if($id != '') {
                $this->query = "
                SELECT *
                FROM contactos
                WHERE id = :id";
                //Cargamos los parámetros.
                $this->parametros['id']= $id;
                //Ejecutamos consulta que devuelve registros.
                $this->get_results_from_query();
                }
                if(count($this->rows) == 1) {
                foreach ($this->rows[0] as $propiedad=>$valor) {
                $this->$propiedad = $valor;
                }
                $this->mensaje = 'Contacto encontrado';
                }
                else {
                $this->mensaje = 'Contacto no encontrado';
                }
                return $this->rows;
                
        }

        // Método para editar un superheroe
        public function edit($user_data=array()) {
            $fecha = new \DateTime();

            foreach ($user_data as $campo=>$valor) {
                $$campo = $valor;
                }

                $this->query = "
                UPDATE contactos
                SET nombre=:nombre,
                    telefono=:telefono,
                    email=:email,
                    updated_at=:fecha
                WHERE id = :id
                ";

                $this->parametros['id']=$id;
                $this->parametros['nombre']=$nombre;
                $this->parametros['telefono']=$telefono;
                $this->parametros['email']=$email;

                $this->parametros['fecha']= date('Y-m-d H:i:s',$fecha->getTimestamp());
                $this->get_results_from_query();
                $this->mensaje = 'sh modificado';
        }

        // Método para eliminar un superheroe
        public function delete($id='')
        {
            $this->query = "DELETE FROM contactos
            WHERE id = :id";
            $this->parametros['id']=$id;
            $this->get_results_from_query();
            $this->mensaje = 'SH eliminado';
        }

 }

?>