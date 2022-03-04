# Desarrollo Entorno Servidor
#### Rubén Ramírez Rivera
## Acceso a la API de Contactos

### Para el uso de la api hay que acceder desde el cliente de Postman con la ruta apirestcontactos.local junto con la ruta del metodo que queramos obtener

| Metodo | Ruta | Accion | Cuerpo(Json)
| --- | --- | --- | --- |
| GET | /login | Login del usuario (usuario,password)| {"usuario": "admin","password": "admin"} |
| GET | /contactos | Seleccionar todos los contactos|
| GET | /contactos/ {id} | Seleccionar 1 contacto por su id|
| POST | /contactos | Añadir un contacto | {"nombre": "Benito","telefono": "666111222","email": "benito69@gmail.com"} |
| PUT | /contactos/ {id} | Actualizar contacto por su id | {"nombre": "Benito","telefono": "666111222","email": "benito69@gmail.com"} |
| DELETE | /contactos/ {id} | Borrar un contacto por su id |

## VirtualHost Usado

    <VirtualHost *> 
        ServerName apirestcontactos.local 
        DocumentRoot "/opt/lampp/htdocs/contactos/public" 

        <Directory "/opt/lampp/htdocs/contactos/public" > 
            Options All 
            AllowOverride All 
            Require all granted 
        </Directory> 
    </VirtualHost>
