# ImageSocial

<p align="center">
  <img src="C:\Users\alext\OneDrive\Escritorio\Capturas de pantalla ImgeSocial\logo.png">
</p>

<p align="center">
  Red social moderna desarrollada con Laravel que incluye publicación de imágenes, sistema de amistades, chat en tiempo real, interacciones mediante AJAX y scroll infinito.
</p>

---

## 📸 Capturas de pantalla

### Feed principal

[CAPTURA]

### Perfil de usuario

[CAPTURA]

### Sistema de amistades

[CAPTURA]

### Favoritos

[CAPTURA]

### Chat en tiempo real

[CAPTURA]

---

## Características:

### Gestión de usuarios

* Registro de usuarios.
* Inicio y cierre de sesión.
* Eliminación de cuenta.
* Edición de perfil.
* Avatar personalizado.
* Búsqueda avanzada de usuarios.

### Publicaciones

* Subida de imágenes.
* Eliminación de publicaciones propias.
* Vista detallada de publicaciones.
* Feed principal dinámico.

### Interacciones

* Likes y dislikes mediante AJAX.
* Sistema de favoritos mediante AJAX.
* Comentarios dinámicos en modal.
* Actualización de contadores sin recarga.
*  Notificaciones en tiempo real.

### Sistema social

* Solicitudes de amistad.
* Gestión de amigos.
* Vista dedicada para amistades.

### Mensajería

* Chat privado entre amigos.
* Comunicación en tiempo real.
* Laravel Reverb + WebSockets.

### Rendimiento

* Scroll infinito mediante AJAX.
* Paginación alternativa.
* Usuarios conectados recientemente(no tiempo real).

---

## Tecnologías utilizadas:

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

## Base de datos

El proyecto utiliza MySQL como sistema de gestión de bases de datos.

Principales entidades:

* Users
* Images
* Comments
* Likes
* Favorites
* Friendships
* Messages

---

## Instalación

```bash
git clone <repositorio>
cd ImageSocial

composer install

npm install

cp .env.example .env

php artisan key:generate

php artisan migrate

npm run build

php artisan serve
```

---

## Objetivos del proyecto

Este proyecto fue desarrollado con el objetivo de profundizar en:

* Arquitectura MVC.
* ORM
* Laravel Framework.
* Relaciones Eloquent.
* AJAX.
* WebSockets.
* Desarrollo Full Stack.
* Bases de datos relacionales.
* Seguridad básica en aplicaciones web.

---

## Mejoras futuras

* Sistema de grupos.
* Compartir publicaciones.
* Cifrado de mensajes.
* Aplicación móvil.

---

## Autor

Alejandro Jiménez

Proyecto desarrollado con fines de aprendizaje y consolidación de conocimientos en desarrollo web Full Stack utilizando Laravel.
