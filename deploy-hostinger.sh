#!/bin/bash

# Script para crear un archivo zip con los archivos necesarios para Hostinger
# Excluye archivos de desarrollo y dependencias que deben instalarse en el servidor

echo "🗜️  Creando archivo zip para deployment en Hostinger..."

# Nombre del archivo zip con timestamp
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
ZIP_NAME="polijubweb_hostinger_${TIMESTAMP}.zip"

# Crear el zip excluyendo archivos innecesarios
zip -r "$ZIP_NAME" . \
  -x "*.git*" \
  -x "*node_modules*" \
  -x "*.DS_Store" \
  -x "*.env" \
  -x "*.log" \
  -x "*storage/logs/*" \
  -x "*storage/framework/cache/*" \
  -x "*storage/framework/sessions/*" \
  -x "*storage/framework/views/*" \
  -x "*tests/*" \
  -x "*phpunit.xml" \
  -x "*.editorconfig" \
  -x "*deploy-hostinger.sh" \
  -x "*package-lock.json" \
  -x "*vite.config.js" \
  -x "*dev/*" \
  -x "*.gitignore" \
  -x "*.gitattributes" \
  -x "*README.md"

if [ $? -eq 0 ]; then
    echo "✅ Archivo creado exitosamente: $ZIP_NAME"
    echo ""
    echo "📦 Archivos incluidos:"
    echo "   - /app (código de la aplicación)"
    echo "   - /public (archivos públicos)"
    echo "   - /config (configuración)"
    echo "   - /database (migraciones y seeders)"
    echo "   - /resources (vistas y assets)"
    echo "   - /routes (rutas)"
    echo "   - /storage (estructura de directorios)"
    echo "   - /vendor (dependencias PHP)"
    echo "   - /bootstrap"
    echo "   - composer.json, composer.lock"
    echo "   - artisan"
    echo "   - .env.example"
    echo ""
    echo "⚠️  IMPORTANTE: Después de subir a Hostinger:"
    echo "   1. Crea tu archivo .env con las credenciales de producción"
    echo "   2. Ejecuta: php artisan key:generate"
    echo "   3. Ejecuta: php artisan migrate"
    echo "   4. Ejecuta: php artisan storage:link"
    echo "   5. Configura los permisos: chmod -R 775 storage bootstrap/cache"
    echo "   6. Apunta el dominio a la carpeta /public"
else
    echo "❌ Error al crear el archivo zip"
    exit 1
fi
