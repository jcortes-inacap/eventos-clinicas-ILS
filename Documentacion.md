# Eventos Clínicas ILS

Sistema de administración web para la gestión de eventos de clínicas ILS, basado en AsteroAdmin con Bootstrap 5 y Astro, completamente localizado en español.

[![Eventos Clínicas ILS](https://raw.githubusercontent.com/asterodigital/bootstrap-admin-template/main/.github/images/feature-image.png)](https://astero-admin.asterodigital.com/pages/dashboard)

## Descripción General

Eventos Clínicas ILS es una aplicación web moderna y responsiva diseñada específicamente para la gestión integral de eventos médicos y clínicos. Construida sobre la base de AsteroAdmin, ofrece una interfaz de administración completa, intuitiva y altamente personalizable en español.

## Características Principales

- ✨ **Construido con Astro** - Generador de sitios estáticos moderno para máximo rendimiento
- 🎨 **Bootstrap 5.3.3** - Última versión para un diseño limpio y profesional
- 📱 **Completamente Responsivo** - Funciona perfectamente en todos los dispositivos
- 🌙 **Modo Claro/Oscuro** - Cambio fácil entre temas
- 🇪🇸 **Completamente en Español** - Interfaz, mensajes y configuración regional
- 🚀 **Sistema de Compilación Optimizado** - Usa ESBuild, LightningCSS, PostCSS
- 📦 **Arquitectura Modular** - Componentes SCSS, JS y Astro bien organizados
- 🔧 **Altamente Personalizable** - Fácil adaptación mediante variables SCSS
- 📊 **Componentes para Dashboard** - Gráficos, tablas, formularios incluidos
- ⚡ **Optimizado para Rendimiento** - Tiempos de carga rápidos
- 🔄 **Recarga en Vivo** - Vista previa instantánea durante desarrollo
- 📚 **Ejemplos de Componentes** - Ejemplos claros para elementos UI
- 🔒 **Diseños de Autenticación** - Páginas de login y registro listas
- 🌐 **Soporte RTL** - Funciona perfectamente para idiomas de derecha a izquierda
- 📁 **Estructura de Carpetas Lógica** - Navegación fácil para desarrolladores
- 🧩 **Componentes UI Extensos** - Amplia colección de elementos pre-construidos
- 📱 **Navbar Offcanvas** - Navegación moderna para móvil y escritorio

## Demo

Consulta la demo en vivo: [AsteroAdmin Demo](https://astero-admin.asterodigital.com/pages/dashboard)

## Configuración Regional

### Idioma por Defecto: Español
El sistema está completamente configurado en español:
- 🏷️ **Atributo lang="es"** en todas las páginas HTML
- 📅 **Formato de fecha**: DD/MM/YYYY
- ⏰ **Formato de hora**: HH:mm (24 horas)
- 💰 **Moneda por defecto**: EUR (€)
- 🌍 **Zona horaria**: Europe/Madrid
- 📊 **DataTables**: Textos de interfaz en español
- 💬 **Mensajes y tooltips**: Completamente traducidos

## Comenzando

### Prerrequisitos

- Node.js (v18 o superior recomendado)
- PNPM o npm como gestor de paquetes

### Instalación

Puedes instalar Eventos Clínicas ILS de la siguiente manera:

#### 1. Usando PNPM (recomendado)

```bash
# Clonar el repositorio
git clone https://github.com/jcortes-inacap/eventos-clinicas-ILS.git
cd eventos-clinicas-ILS
```

#### 2. Usando NPM

```bash
# Clonar el repositorio
git clone https://github.com/jcortes-inacap/eventos-clinicas-ILS.git
cd eventos-clinicas-ILS
```

2. Instalar dependencias:

```bash
# Con PNPM (recomendado)
pnpm install

# O con NPM
npm install
```

3. Iniciar el servidor de desarrollo:

```bash
# Con PNPM
pnpm dev

# O con NPM
npm run dev
```

El servidor de desarrollo se iniciará en `http://localhost:1234`

## Sistema de Compilación

Eventos Clínicas ILS utiliza un sistema de compilación personalizado y optimizado que maneja:

- Compilación de SCSS con source maps
- Bundling y minificación de JavaScript
- Optimización de assets
- Recarga en vivo durante desarrollo
- Builds de producción optimizados

### Scripts Disponibles

| Comando | Descripción |
|---------|-------------|
| `pnpm dev` | Iniciar servidor de desarrollo con hot reloading |
| `pnpm build` | Compilar archivos optimizados para producción |
| `pnpm css` | Compilar SCSS a CSS con prefijos de navegador |
| `pnpm js` | Empaquetar y optimizar archivos JavaScript |
| `pnpm assets` | Procesar y optimizar assets estáticos |
| `pnpm lint` | Ejecutar verificaciones de calidad de código |
| `pnpm fixlint` | Corregir automáticamente errores de linting |
| `pnpm format:html` | Formatear archivos HTML usando Prettier |
| `pnpm clean` | Eliminar archivos de compilación |
| `pnpm watch` | Observar archivos para cambios |
| `pnpm serve` | Servir los archivos compilados localmente |
| `pnpm bundlewatch` | Verificar tamaños de bundles contra límites |

## Estructura del Proyecto

```plaintext
.
├── config/             # Configuraciones de herramientas (PostCSS, Rollup, etc.)
├── dist/               # Archivos compilados (generados por el proceso de build)
├── src/                # Archivos fuente
│   ├── assets/         # Assets estáticos (imágenes, fuentes, datos, etc.)
│   ├── html/           # Componentes, layouts y páginas Astro (.astro files)
│   │   ├── components/ # Componentes UI reutilizables (Astro)
│   │   ├── layouts/    # Layouts de página (Astro)
│   │   └── pages/      # Páginas del sitio (Astro)
│   ├── js/             # Archivos JavaScript fuente
│   │   ├── components/ # JS para componentes específicos
│   │   ├── layout/     # JS para características de layout (modo oscuro, sidebar)
│   │   └── main.js     # Punto de entrada principal de JavaScript
│   ├── scss/           # Hojas de estilo SCSS
│   │   ├── base/       # Base styles (typography, reset)
│   │   ├── components/ # Component-specific styles
│   │   ├── core/       # Core mixins and utilities
│   │   ├── layout/     # Layout styles (header, sidebar, footer)
│   │   ├── pages/      # Page-specific styles
│   │   ├── utilities/  # Utility classes
│   │   ├── variables/  # SCSS variables (colors, fonts, config)
│   │   └── style.scss  # Main SCSS entry point
│   └── utils/          # Utility functions (JS)
├── tools/              # Build system scripts (.mjs files)
├── .browserslistrc     # Target browsers for CSS prefixes
├── .editorconfig       # Editor configuration
├── .gitignore          # Files ignored by Git
├── eslint.config.js    # ESLint configuration
├── index.html          # Redirect or simple landing page (if used)
├── LICENSE             # Project license (MIT)
├── package.json        # Project dependencies and scripts
├── pnpm-lock.yaml      # PNPM lock file (if using PNPM)
└── README.md           # This file
```

## Customization

### Themes

AsteroAdmin comes with both light and dark themes. You can customize the themes by modifying the variables in `src/scss/variables/`. The dark mode provides a sleek, eye-friendly experience that:

- Is easier on the eyes
- Improves readability
- Minimizes distractions
- Enhances visual appeal

### Components

All UI components are modular and can be found in `src/scss/components/` and `src/scss/extra-components/`. You can easily modify or extend these components to match your requirements.

### Creating New Pages

To create a new page:

1. Create a new `.astro` file in the `src/html/pages/` directory.
2. Use existing Astro components from `src/html/components/` and layouts from `src/html/layouts/`.
3. Import necessary CSS and JS as needed.
4. Run `npm run dev` to see your changes live.

## Dashboard Layouts

AsteroAdmin offers multiple dashboard layouts to suit different needs:

- **Analytics Dashboard** - For data visualization and metrics
- **Compact Sidebar** - Space-efficient navigation
- **Dark Mode** - Eye-friendly interface for low-light environments
- **Various Components** - Extensive UI element collection
- **Offcanvas Navbar** - Modern responsive navigation

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)

## Technologies Used

- **Astro (^5.5.5)** - Static site generator for building fast websites.
- **Bootstrap (^5.3.3)** - Front-end component library.
- **Sass (Embedded) (^1.86.0)** - CSS preprocessor.
- **ESBuild (^0.25.1)** - JavaScript bundler and minifier.
- **Rollup (^4.36.0)** - JavaScript module bundler (used alongside ESBuild).
- **LightningCSS (^1.29.3)** - CSS parser, transformer, bundler, and minifier.
- **PostCSS (^8.5.3)** - Tool for transforming CSS with JavaScript plugins.
- **SimpleBar (^6.3.0)** - Custom scrollbar plugin.
- **Prettier (^3.5.3)** - Code formatter.
- **ESLint (^9.23.0)** - Code linter for JavaScript and Astro.
- **Stylelint (^16.16.0)** - CSS linter.

## Performance Optimization

AsteroAdmin is optimized for performance:

- Minified CSS and JavaScript
- Optimized asset loading
- Efficient build process
- Code splitting where appropriate
- Vendor prefixing for cross-browser compatibility

## Frequently Asked Questions

**What is included in the theme?**  
The package includes a full set of templates, and documentation.

**Is the theme mobile-friendly?**  
Absolutely, the theme is designed to be responsive across devices.

**Can I customize the design?**  
Yes, the theme is fully customizable to match your branding needs.

**How do I install the theme?**  
Installation is simple and comes with detailed instructions in the docs.

## Change Log

**Version 1.0.5** - April 3, 2025

- Updated dependencies (Bootstrap 5.3.3, Astro 5.5.5, etc.)
- Refreshed project structure in README
- Updated build tools and configurations
- Added `bundlewatch` script

**Version 1.0.0** - March 13, 2025

- Initial release

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

For support, please visit [https://asterodigital.com/bootstrap-admin-template](https://asterodigital.com/bootstrap-admin-template) or create an issue in the GitHub repository.

## Author

AsteroDigital - [https://asterodigital.com](https://asterodigital.com)

---

Made with ❤️ by AsteroDigital
#   D a s h b o a r d _ C l i n i c a 
 
 #   e v e n t o s - c l i n i c a s - I L S 
 
 #   e v e n t o s - c l i n i c a s - I L S 
 
 #   e v e n t o s - c l i n i c a s - I L S 
 
 
