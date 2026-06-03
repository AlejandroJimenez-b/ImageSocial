# ImageSocial

**ImageSocial** es una red social desarrollada con Laravel como proyecto de aprendizaje avanzado y como mi primer proyecto completo basado en una base de datos relacional real.

El objetivo principal del proyecto fue construir una aplicación web funcional que integrara autenticación de usuarios, relaciones sociales, interacción en tiempo real y gestión de contenido multimedia utilizando tecnologías modernas del ecosistema Laravel.

---

## Características principales

### Gestión de usuarios

* Registro de usuarios.
* Inicio y cierre de sesión.
* Eliminación de cuenta.
* Edición de perfil.
* Avatar personalizado.
* Gestión de datos personales.

### Publicaciones

* Subida de imágenes al feed.
* Eliminación de publicaciones propias.
* Vista detallada de cada publicación.
* Descripción asociada a cada imagen.
* Información del autor y fecha de publicación.

### Sistema de interacciones

* Likes y dislikes en tiempo real mediante AJAX.
* Sistema de favoritos en tiempo real mediante AJAX.
* Contador dinámico de interacciones.
* Comentarios sin recarga de página.
* Eliminación de comentarios propios.

### Modal de comentarios

* Apertura dinámica desde el feed.
* Carga de comentarios mediante AJAX.
* Actualización automática tras publicar o eliminar comentarios.

### Sistema de amistades

* Envío de solicitudes de amistad.
* Solicitudes pendientes.
* Aceptación y eliminación de amistades.
* Vista dedicada para visualizar todos los amigos del usuario.

### Exploración de usuarios

* Sección "Gente" para descubrir usuarios registrados.
* Acciones dinámicas según el estado de la relación entre usuarios.

### Favoritos

* Guardado de publicaciones favoritas.
* Vista exclusiva para consultar imágenes guardadas.

### Chat en tiempo real

* Mensajería privada entre usuarios que sean amigos.
* Comunicación en tiempo real mediante WebSockets.
* Implementado utilizando Laravel Reverb.
* Actualización instantánea de mensajes sin recargar la página.

> Nota: actualmente los mensajes no están cifrados de extremo a extremo.

### Feed dinámico

* Scroll infinito implementado mediante AJAX.
* Sistema alternativo de paginación.
* Carga progresiva de contenido.

### Sidebar de actividad

* Visualización de usuarios conectados recientemente.
* Basado en actividad registrada durante los últimos 15 minutos.

---

## Tecnologías utilizadas

### Backend

* PHP
* Laravel
* MySQL

### Frontend

* Blade
* JavaScript
* AJAX
* Tailwind CSS

### Tiempo real

* Laravel Reverb
* WebSockets

---

## Objetivos del proyecto

Durante el desarrollo de ImageSocial se trabajaron conceptos como:

* Arquitectura MVC.
* Relaciones Eloquent complejas.
* Autenticación y autorización.
* Eventos y broadcasting.
* Comunicación en tiempo real.
* Manipulación del DOM mediante JavaScript.
* Peticiones AJAX.
* Scroll infinito.
* Optimización de consultas.
* Seguridad básica en aplicaciones web.

---

## Estado del proyecto

Proyecto funcional y completamente operativo.

Desarrollado como proyecto personal con fines de aprendizaje y consolidación de conocimientos en Laravel, bases de datos relacionales y desarrollo web full stack.
