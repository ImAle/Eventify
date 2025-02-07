# Aplicación Eventify
Eventify es una aplicación que permite la publicacion de eventos y que los usuarios puedan ver dichos eventos, unirse y recibir notificaciones de aquellos a los que se han inscrito.

La aplicacion dispone de las siguientes caracteristicas:
* Gestión de usuarios
* Gestión de eventos
* Inscripciones a los eventos
* Busqueda y filtrado para los eventos
* Notificaciones

### Índice
1. [Requisitos necesarios para uso de Eventify](#id1) <br>
1.1 [Requisitos de conexión](#id2) <br>
1.2 [Requisitos de uso](#id3) <br>
2. [Registro en la aplicación](#id4) <br>
3. [Gestión de eventos (usuario organizador)](#id5) <br>
3.1 [Creacion de eventos](#id6) <br>
3.2 [Actualizar y borrar eventos](#id7) <br>
4. [Gestión de eventos (usuarios)](#id8) <br>
5. [Manual técnico de Eventify](#id9) <br>
6. [API Rest de Eventify](#id10) <br>
6.1 [Endpoints](#id11) <br>
7. [Pruebas unitarias](#id12) <br>
7.1 [Directorio de pruebas](#id13)

<hr>
## Url de la aplicación
http://http://eventify6.duckdns.org/
## Manual de usuario

Este manual tiene como función dar a los usuarios una guía para que permita a sus usuarios el manejo correcto de la aplicación y asi aprovechar al maximo sus caracteristicas.
<a id="id1"></a>
### Requisitos necesarios para uso de Eventify
Para hacer uso de la aplicación es necesario:
<a id="id2"></a>
#### Requisitos de conexión
* Conexión a internet
* Navegador (Chrome, Edge, Firefox)
<a id="id3"></a>
#### Requisitos de uso
Para hacer uso de la aplicación es necesario tener una cuenta, en caso de no tener una cuenta deberá registrarse.
<a id="id4"></a>
#### Registro en la aplicación
Pulse en el boton **Register** para ir al apartado.
![Pantalla de inicio](/imagenesManual/mainViewRegistro.png)

Una vez este en el formulario de registro deberá rellenar los campos que le aparecen.
![Formulario de registro](/imagenesManual/formularioRegistro.png)

Cuando finalice de insertar sus datos pulse en el boton **Register**. Una vez finalizado el registro se le enviará a su correo una confirmación de registro, compruebe su correo electrónico (si no encuentra el correo revise el apartado de spam o no deseado).

Deberá esperar que el administrador le active la cuenta, una vez la tenga activida podrá utilizar la aplicación.
<a id="id5"></a>
### Gestión de eventos (usuario organizador)

Como usuario organizador dispone de la opciones de crear nuevos eventos y clasificarlos por categorias. Para los eventos ya creados puede actualizarlos en cualquier momento.

Cuando inicie sesion con su cuenta de organizador verá lo siguiente:
![Pantalla de inicio del organizador](/imagenesManual/homeViewOrganizador.png)

En la pantalla le indica cual es su rol y que se inicio sesión correctamente. Por otro lado, en la parte superior derecha verá su nombre de usuario y un desplegable.
En el desplegable verá las opciones de **logout** y **Eventos**, este ultimo tendrá su propio desplegable.<br>
![Pantalla de inicio](/imagenesManual/desplegabloUsuario.png)

Si abre el desplegable de **Eventos** le saldrá las categorias en las que se clasifica los eventos, si pulsa en **Eventos** directamente le llevará a la pagina donde puede ver los eventos creados y la opcion de crear uno nuevo.
![Listado de eventos de organizador](/imagenesManual/listaEventosOrganizador.png)
<a id="id6"></a>
### Creación de eventos
Para la creación de eventos iremos al boton de **Crear Nuevo Evento** situado en la parte superior central de la pagina de **Eventos**.
Cuando le demos nos abrira un formulario en el cual debemos rellenar para crear el evento, una vez esten todos los campos completos le daremos al boton de **Crear Evento**.

![Formulario de creación de evento](/imagenesManual/formularioCreacionEvento.png)
<a id="id7"></a>
### Actualizar y borrar eventos

Previamente vimos la creación de eventos, ahora veremos el apartado de actualizar y borrar eventos. Si nos situamos en la página donde se muestran los eventos podemos ver que en el lateral derecho se encuentran dos botones, **Actualizar** y **Borrar**.

![Botones de actualizar y borrar evento](/imagenesManual/ActualizarBorrarEvento.png)

Cuando le demos en el boton de actualizar se nos abrira un formulario, donde se visualizan los datos actuales del evento seleccionado, ahi podremos hacer los cambios que veamos oportunos.

![Formulario de actualizar evento](/imagenesManual/formularioActualizarEvento.png)

Para borrar el evento con darle al boton de **Borrar** será suficiente para eliminarlo.
<a id="id8"></a>
### Gestión de eventos (usuarios)

Para los usuarios no organizadores los eventos se mostrarán directamente en la pantalla principal, estos tienen en el lado derecho un boton **Registrarse** con el cual poder unirse a dicho evento.

![Pantalla de inicio del usuario](/imagenesManual/homeViewUsuarios.png)

Una vez se registre en un evento este desaparece de la pantalla, para visualizar los eventos a los que se unió tendrá que irse al desplegable que tiene en su nombre de usuario en la parte superior derecha.

![Desplegable del usuario](/imagenesManual/desplegableEventosUsuario.png)

Cuando pase el raton por encima de **Mis Eventos** le saldra un nuevo desplegable con las opciones de **Eventos disponible** y **Eventos registrados**. 
En el primero le aparrecen todos los eventos que hay, mientras que en el segundo le aparecerá los eventos a los que se registró.

Si hace clic sobre la segunda opcion del desplegable le llevará a los eventos que se registro, tambien, le aparecerá un botón para generar un pdf.

![Desplegable del usuario](/imagenesManual/eventosRegistradoUsuario.png)

<a id="id9"></a>
## Manual técnico de Eventify
<a id="id10"></a>
### API Rest de Eventify

La API desarrollada permite a los usuarios manejar la aplicación de manera eficiente haciendo uso de cada una de sus funcionalidades
<a id="id11"></a>
### Endpoints

- Inicio de sesión (POST) http://eventify6.duckdns.org/api/login <br>
- Los datos a enviar son:<br>
   > email<br>
   > password
<br>
- Devuelve lo siguiente:
```
{
    "success": true,
    "data": {
        "token",
        "name",
    },
    "message": "User login successfully."
}
```

En caso de error:
```
{
    "success": false,
    "message": "Unauthorised.",
    "data": {
        "error": "Unauthorised"
    }
}
```
- Registro de usuario (POST) http://eventify6.duckdns.org/api/register <br>
- Los datos a enviar son:<br>
   > name<br>
   > email<br>
   > password<br>
   > password_confirmed<br>
   > role
- Devuelve lo siguiente:
```
{
    "success": true,
    "data": {
        "name",
        "email",
        "actived",
        "role",
        "email_confirmed",
        "updated_at",
        "created_at",
        "id",
    },
    "message": "User created successfully"
}
```
En caso de error:
Email ya registrado.
```
{
    "success": false,
    "message": "Validation Error.",
    "data": {
        "email": [
            "The email has already been taken."
        ]
    }
}
```
El campo del correo vacio
```
{
    "success": false,
    "message": "Validation Error.",
    "data": {
        "email": [
            "The email field is required."
        ]
    }
}
```

Confirmacion de contraseña vacio
```
{
    "success": false,
    "message": "Validation Error.",
    "data": {
        "password": [
            "The password field confirmation does not match."
        ]
    }
}
```
- Mostrar los eventos (GET) http://eventify6.duckdns.org/api/events<br>
Devuelve lo siguiente:
```
{
    "success": true,
    "data": [
        {
            "id",
            "organizer_id",
            "title",
            "description",
            "category_id",
            "start_time",
            "end_time",
            "location",
            "latitude",
            "longitude",
            "max_attendees",
            "price",
            "image_url",
            "deleted": 0,
            "created_at",
            "updated_at",
        }
        ],
    "message": "Events retrieved successfully"
}
```
- Crear eventos (POST) http://eventify6.duckdns.org/api/events<br>
- Los datos a enviar son:<br>
    > title<br>
    > description <br>
    > category<br>
    > start_time<br>
    > end_time<br>
    > location<br>
    > latitude<br>
    > max_attendees<br>
    > longitude<br>
    > price<br>
    > image_url
- Devuelve lo siguiente:
```
{
    "success": true,
    "data": {
        "organizer_id",
        "title",
        "description",
        "category_id",
        "start_time",
        "end_time",
        "location",
        "latitude",
        "max_attendees",
        "longitude",
        "price",
        "image_url",
        "deleted",
        "updated_at",
        "created_at",
        "id",
    },
    "message": "Event created successfully"
}
```
- Actualizar eventos (PUT) http://eventify6.duckdns.org/api/events<br>
- Los datos a enviar son:<br>
    > title<br>
    > description <br>
    > category<br>
    > start_time<br>
    > end_time<br>
    > location<br>
    > latitude<br>
    > max_attendees<br>
    > longitude<br>
    > price<br>
    > image_url
- Devuelve lo siguiente:
```
{
    "success": true,
    "data": {
        "id",
        "organizer_id",
        "title",
        "description",
        "category_id",
        "start_time",
        "end_time",
        "location",
        "latitude",
        "longitude",
        "max_attendees",
        "price",
        "image_url",
        "deleted",
        "created_at",
        "updated_at",
    },
    "message": "Event updated successfully."
}
```

- Eliminar eventos (DELETE) http://eventify6.duckdns.org/api/events<br>
Devuelve lo siguiente:
```
{
    "success": true,
    "data": {
        "id",
        "organizer_id",
        "title",
        "description",
        "category_id",
        "start_time",
        "end_time",
        "location",
        "latitude",
        "longitude",
        "max_attendees",
        "price",
        "image_url",
        "deleted",
        "created_at",
        "updated_at",
    },
    "message": "Event deleted successfully"
}
```
- Mostrar los usuarios (GET) http://eventify6.duckdns.org/api/users/<br>
Devuelve lo siguiente:
```
{
    "success": true,
    "data": {
        "id",
        "name",
        "email",
        "email_verified_at",
        "role",
        "profile_picture",
        "actived",
        "email_confirmed",
        "deleted",
        "created_at",
        "updated_at",
    },
    "message": "User retrieved successfully."
}
```
<a id="id12"></a>
## Pruebas unitarias

Las pruebas unitarias son utilizadas para comprobar que la aplicación funciona de manera correcta.
Durante las pruebas, se introducen datos de ejemplo para comprobar el correcto funcionamiento y tambien los errores.

 ### Directorio de pruebas unitarias <a id="id13"></a>
```
tests/
├── Feature/
│   └── EventTest.php
|   └── RegisterTest.php
├── Unit/
    └── LoginTest.php
```
Las pruebas se han hecho a partir de los archivos de **EventTest.php** y **RegisterTest.php**.

En **EventTest** se han realizado las pruebas correspondiente a los eventos. Se realizando las pruebas a la creación de eventos por parte de un usuario organizador (es quien puede realizar dicha tarea) y la creación de eventos por un usuario no organizador.

Se realiza tambien las pruebas, para ambos tipos de usuario el poder eliminar o no los eventos.

Por ultimo se comprueba que el usuario administrador no puede eliminar eventos.

En **RegisterTest** se realizan las pruebas que corresponden al registro de usuarios, haciendo comprobación de que el usuario se registra o no según la situación, ya sea con datos incorrectos, que ese usuario este ya registrado.

Para ejecutar las pruebas unitarias es necesario ejecutar el siguiente comando:
```
php artisan test
```