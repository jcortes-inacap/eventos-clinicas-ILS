# Eventos Clínicas ILS - Documentación del Proyecto

## Descripción General

Este proyecto es un sistema de administración web basado en **AsteroAdmin**, un template Bootstrap 5 adaptado para la gestión de eventos de clínicas ILS. El sistema proporciona una interfaz de administración completa con soporte multiidioma, temas oscuro/claro, y componentes modulares.

## Tecnologías Utilizadas

### Frontend
- **Astro.js** - Framework de desarrollo web moderno
- **Bootstrap 5** - Framework CSS para diseño responsivo
- **SCSS/Sass** - Preprocesador CSS para estilos avanzados
- **Remix Icons** - Biblioteca de iconos
- **DataTables** - Plugin para tablas interactivas
- **CodeMirror** - Editor de código integrado

### Herramientas de Desarrollo
- **ESLint** - Linter para JavaScript
- **Prettier** - Formateador de código
- **PostCSS** - Herramienta de transformación CSS
- **Rollup** - Bundler de JavaScript
- **PNPM** - Gestor de paquetes

## Estructura del Proyecto

```
eventos-clinicas-ILS/
├── config/                     # Configuraciones del proyecto
│   ├── astro.config.mjs        # Configuración de Astro
│   ├── eslint.config.mjs       # Configuración de ESLint
│   ├── postcss.config.mjs      # Configuración de PostCSS
│   └── prettier.config.mjs     # Configuración de Prettier
├── src/
│   ├── assets/                 # Recursos estáticos
│   │   ├── data/              # Datos JSON (permisos, productos, usuarios)
│   │   ├── fonts/             # Fuentes tipográficas
│   │   ├── icons/             # Iconos del proyecto
│   │   ├── img/               # Imágenes
│   │   ├── js/                # Scripts JavaScript
│   │   └── vendor/            # Librerías de terceros
│   ├── html/                  # Archivos Astro/HTML
│   │   ├── components/        # Componentes reutilizables
│   │   ├── layouts/           # Layouts base
│   │   └── pages/             # Páginas del sistema
│   ├── scss/                  # Estilos SCSS
│   │   ├── base/              # Estilos base
│   │   ├── components/        # Estilos de componentes
│   │   ├── layout/            # Estilos de layout
│   │   ├── pages/             # Estilos específicos de páginas
│   │   └── variables/         # Variables SCSS
│   └── utils/                 # Utilidades JavaScript
├── tools/                     # Scripts de construcción
└── dist/                      # Archivos generados (producción)
```

## Características Principales

### 1. Sistema de Administración Completo
- Dashboard principal con métricas
- Gestión de usuarios y permisos
- Sistema de roles y permisos
- Configuraciones del sistema
- Logs de actividad

### 2. Interfaz Responsiva
- Diseño adaptativo para móviles, tablets y escritorio
- Sidebar colapsible
- Navegación intuitiva
- Componentes Bootstrap 5

### 3. Soporte Multiidioma
- Configuración de idioma por defecto
- Soporte para español, inglés, francés, alemán y portugués
- Textos localizados en componentes

### 4. Temas Personalizables
- Tema claro y oscuro
- Switcher de temas integrado
- Persistencia de preferencias en localStorage

### 5. Componentes Interactivos
- Tablas con DataTables
- Modales y formularios
- Componentes de vista previa de código
- Editor de código integrado

## Instalación y Configuración

### Prerrequisitos
- Node.js (versión 18 o superior)
- PNPM (recomendado) o NPM

### Instalación
```bash
# Clonar el repositorio
git clone [url-del-repositorio]

# Navegar al directorio
cd eventos-clinicas-ILS

# Instalar dependencias
pnpm install
# o
npm install
```

### Comandos Disponibles

```bash
# Desarrollo
pnpm dev          # Servidor de desarrollo
pnpm watch        # Modo watch para cambios

# Construcción
pnpm build        # Construir para producción
pnpm serve        # Servir archivos de producción

# Herramientas
pnpm lint         # Ejecutar linter
pnpm fixlint      # Corregir errores de linting
pnpm format:html  # Formatear archivos HTML
pnpm clean        # Limpiar archivos generados
```

## Configuración de Idioma

### Idioma por Defecto
El sistema está configurado para usar **español** como idioma por defecto. La configuración se encuentra en:

1. **Layouts HTML**: Atributo `lang="es"` en todas las páginas
2. **DataTables**: Textos en español para paginación y filtros
3. **Componentes**: Mensajes y tooltips en español
4. **Configuración Regional**: Formato de fecha DD/MM/YYYY, zona horaria, etc.

### Archivos de Configuración de Idioma
- `src/assets/data/locale.json` - Configuración regional
- `src/assets/vendor/datatables/datatables.init.js` - Textos de DataTables
- `src/html/pages/settings.astro` - Configuración de idioma en interfaz

## Estructura de Componentes

### Layouts Principales
1. **admin-layout.astro** - Layout principal para páginas de administración
2. **authentication-layout.astro** - Layout para páginas de autenticación
3. **ifram-layout.astro** - Layout para iframes y previsualizaciones

### Componentes Comunes
- **page-header.astro** - Encabezado de página con breadcrumbs
- **sidebar.astro** - Barra lateral de navegación
- **topbar.astro** - Barra superior con búsqueda y notificaciones
- **modals/** - Modales reutilizables

### Páginas Principales
- **dashboard.astro** - Panel principal
- **settings.astro** - Configuraciones del sistema
- **users/** - Gestión de usuarios
- **roles-permissions/** - Gestión de roles y permisos

## Personalización

### Temas y Colores
Los colores y temas se pueden personalizar en:
- `src/scss/variables/` - Variables SCSS
- `src/scss/components/_colors.scss` - Paleta de colores
- CSS custom properties en `src/scss/layout/_base.scss`

### Iconos
El proyecto utiliza Remix Icons. Para agregar nuevos iconos:
1. Buscar en [Remix Icon](https://remixicon.com/)
2. Usar la clase CSS correspondiente: `ri-[nombre-icono]-[variante]`

### Componentes Personalizados
Para crear nuevos componentes:
1. Crear archivo `.astro` en `src/html/components/`
2. Agregar estilos en `src/scss/components/`
3. Importar y usar en las páginas

## Desarrollo y Contribución

### Estructura de Archivos
- **Un archivo por componente** en `src/html/components/`
- **Estilos modulares** en `src/scss/components/`
- **Scripts organizados** por funcionalidad en `src/assets/js/`

### Convenciones de Código
- **Indentación**: 2 espacios
- **Nombres de archivos**: kebab-case
- **Clases CSS**: BEM methodology cuando sea apropiado
- **JavaScript**: ES6+ con módulos

### Testing
El proyecto incluye configuración para:
- Validación de HTML
- Linting de JavaScript/CSS
- Formateo automático de código

## Despliegue

### Construcción para Producción
```bash
pnpm build
```

Los archivos se generan en:
- `dist/pages/` - Páginas HTML
- `dist/css/` - Archivos CSS minificados
- `dist/js/` - Archivos JavaScript minificados
- `dist/assets/` - Recursos estáticos

### Configuración del Servidor
- Servir archivos estáticos desde `dist/`
- Configurar redirects para SPA si es necesario
- Habilitar compresión gzip/brotli

## Soporte y Mantenimiento

### Logs y Debugging
- Logs de desarrollo en consola del navegador
- Logs de construcción en terminal
- Panel de logs de actividad en `/settings/system/logs/activity`

### Actualizaciones
1. Revisar dependencias: `pnpm outdated`
2. Actualizar: `pnpm update`
3. Probar funcionalidad
4. Ejecutar tests: `pnpm lint`

### Problemas Comunes
1. **Error de compilación**: Verificar sintaxis en archivos `.astro`
2. **Estilos no aplicados**: Revisar importaciones en `style.scss`
3. **JavaScript no funciona**: Verificar errores en consola

## Contacto y Soporte

Para soporte técnico o preguntas sobre el proyecto:
- Revisar documentación en `/docs/`
- Crear issue en el repositorio
- Contactar al equipo de desarrollo

---

**Versión**: 1.0.9  
**Última actualización**: Septiembre 2025  
**Licencia**: MIT
