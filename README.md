# Nombre del Proyecto

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



## Detalles módulo-areas/carreras

1. Conflicto con CORS, tuve que añadir la ruta del proyectp.
2. Conflicto con Token de Middleware, deshabilité el uso de CSRF Token desde el Verify añadiendo las rutas que se usaban con api/* como base
3. Pendiente detalles de nombres y rutas con nuevos nombres y seguros
4. Pendiente posibles usos de checkboxs para múltiples areas/carreras al mismo tiempo
5. Switch alerts decentes