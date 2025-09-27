# Configuración de Idioma - Eventos Clínicas ILS

## Configuración Actual

El sistema está configurado por defecto en **español (es-ES)** con las siguientes características:

### 1. Idioma HTML
- Atributo `lang="es"` en todos los layouts
- Configuración regional española (es-ES)

### 2. Formatos Regionales
- **Formato de fecha**: DD/MM/YYYY
- **Formato de hora**: HH:mm (24 horas)
- **Zona horaria**: Europe/Madrid
- **Moneda por defecto**: EUR (€)
- **Separador decimal**: , (coma)
- **Separador de miles**: . (punto)

### 3. Componentes Localizados

#### DataTables
Los textos de las tablas están configurados en español:
- "Mostrando X a Y de Z registros"
- "No hay registros para mostrar"
- "Cargando..."
- Navegación: "Anterior", "Siguiente", "Primero", "Último"

#### Interfaz de Usuario
- Mensajes de validación en español
- Tooltips y ayudas contextuales
- Botones y acciones principales

### 4. Archivos de Configuración

#### Principales
- `src/assets/data/locale.json` - Configuración regional completa
- `src/assets/vendor/datatables/datatables.init.js` - Textos DataTables
- `src/html/pages/settings.astro` - Configuración de interfaz

#### Layouts
- `src/html/layouts/admin/admin-layout.astro`
- `src/html/layouts/admin/authentication-layout.astro`
- `src/html/layouts/admin/ifram-layout.astro`
- `src/html/pages/index.astro`

## Cambiar Idioma

### Para cambiar a otro idioma:

1. **Modificar layouts HTML**:
```astro
<html lang="en"> <!-- Cambiar "es" por el código de idioma deseado -->
```

2. **Actualizar DataTables**:
```javascript
// En datatables.init.js
language: {
  info: "Showing _START_ to _END_ of _TOTAL_ records", // Traducir textos
  // ... más configuraciones
}
```

3. **Configurar formatos regionales**:
```json
// En locale.json
{
  "defaultLanguage": "en",
  "locale": "en-US",
  "dateFormat": "MM/DD/YYYY",
  "currency": "USD"
}
```

4. **Actualizar configuración por defecto**:
```astro
<!-- En settings.astro -->
<option value="en" selected>English (US)</option>
```

## Agregar Nuevo Idioma

### 1. Actualizar locale.json
```json
{
  "languages": {
    "it": {
      "name": "Italiano",
      "code": "it",
      "flag": "🇮🇹",
      "dateFormat": "DD/MM/YYYY",
      "timeFormat": "HH:mm",
      "currency": "EUR"
    }
  }
}
```

### 2. Crear configuración DataTables
```json
{
  "dataTables": {
    "it": {
      "info": "Visualizzazione da _START_ a _END_ di _TOTAL_ record",
      "infoEmpty": "Nessun record da visualizzare",
      // ... más traducciones
    }
  }
}
```

### 3. Agregar a configuración
```astro
<!-- En settings.astro -->
<option value="it">Italiano</option>
```

## Mantenimiento

### Archivos a revisar al actualizar traducciones:
1. **Textos de interfaz**: Buscar en `src/html/` archivos `.astro`
2. **Scripts JavaScript**: Buscar textos hardcodeados en `src/assets/js/`
3. **Configuraciones**: Revisar archivos en `src/assets/data/`
4. **Librerías externas**: Actualizar configuraciones en `src/assets/vendor/`

### Comandos útiles:
```bash
# Buscar textos en inglés para traducir
grep -r "english\|English" src/

# Buscar atributos lang
grep -r 'lang="' src/

# Buscar configuraciones de fecha/hora
grep -r "dateFormat\|timeFormat" src/
```

## Validación

### Verificar configuración:
1. ✅ Atributo `lang` en layouts
2. ✅ Configuración DataTables en español
3. ✅ Formato de fecha DD/MM/YYYY
4. ✅ Mensajes de interfaz traducidos
5. ✅ Configuración regional por defecto

### Testing:
1. Abrir navegador en español
2. Verificar formato de fechas
3. Probar componentes DataTables
4. Revisar mensajes de validación
5. Comprobar tooltips y ayudas

---

**Nota**: Esta configuración garantiza una experiencia completamente en español para los usuarios del sistema Eventos Clínicas ILS.
