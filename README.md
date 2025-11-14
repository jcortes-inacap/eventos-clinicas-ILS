# Nombre del Proyecto
Clinicas penkas

## Estructura del Proyecto

El proyecto está dividido en tres componentes principales:

### Backend (/back-end)
API REST desarrollada con Laravel que maneja la lógica del negocio y la comunicación con la base de datos.

### Frontend (/front-end)
Interfaz de usuario desarrollada con Astro.

### Base de Datos (Postgres sql)
Scripts SQL para la creación y población inicial de la base de datos PostgreSQL.

## Requisitos
- PHP >= 8.1
- Node.js >= 16
- PostgreSQL >= 14

## Instalación

1. Clona el repositorio -> git clone -b master https://github.com/jcortes-inacap/eventos-clinicas-ILS.git
2. Configura el backend (en la carpeta back-end -> composer install -> php artisan serve --port=3000 y npm install -> npm run dev)
3. Configura el frontend (en la carpeta back-end -> npm install -> npm run dev)
4. Ejecuta los scripts SQL en postgressql

## IMPORTANTE

1. Para las rutas api se usa el archivo front-end/src/services/api.js 
2. El sidebar principal se encuentra en front-end/src/html/layouts/admin/partials/_sidebar/_nav-tree.astro
3. Las "Paginas" van en la carpeta html/pages
4. Los ejemplos siguiendo los puntos anteriores se encuentran en la carpeta users/assignment y eventos/

# Última actualización - 14/11/2025