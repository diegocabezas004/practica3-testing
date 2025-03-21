# Proyecto de Práctica 3: Testing en Laravel

Este proyecto consiste en una aplicación desarrollada en Laravel que implementa un sistema de gestión de publicaciones. El objetivo principal es aplicar técnicas de Desarrollo Guiado por Pruebas (TDD) utilizando Pest para garantizar la calidad y funcionalidad del sistema.

## Entidades del Proyecto

El sistema está compuesto por las siguientes entidades:

1. **User**: Representa a los usuarios de la aplicación.
   - `id`: Identificador único.
   - `name`: Nombre del usuario.
   - `email`: Correo electrónico del usuario.
   - `password`: Contraseña del usuario.
   - `created_at`: Fecha de creación.
   - `updated_at`: Fecha de actualización.

2. **Post**: Representa las publicaciones realizadas por los usuarios.
   - `id`: Identificador único.
   - `title`: Título de la publicación.
   - `slug`: Identificador único generado a partir del título.
   - `excerpt`: Extracto de la publicación.
   - `content`: Contenido completo de la publicación.
   - `user_id`: Identificador del usuario autor de la publicación.
   - `created_at`: Fecha de creación.
   - `updated_at`: Fecha de actualización.

3. **Category**: Representa las categorías asignables a las publicaciones.
   - `id`: Identificador único.
   - `name`: Nombre de la categoría.
   - `created_at`: Fecha de creación.
   - `updated_at`: Fecha de actualización.

## Funcionalidades Principales

- **Crear Publicación**: Endpoint para la creación de nuevas publicaciones.
  - **URI**: `POST /api/v1/posts`
  - **Requisitos**:
    - Autenticación requerida.
    - Todos los campos son obligatorios.
    - Al menos una categoría debe ser asignada.
    - El `slug` se genera automáticamente a partir del título y debe ser único.
    - Posibilidad de asociar múltiples categorías a una publicación.
    - El `user_id` se asigna automáticamente al usuario autenticado.

## Instalación y Configuración

1. **Clonar el repositorio**:

   ```bash
   git clone https://github.com/diegocabezas004/practica3-testing.git
   ```

2. **Navegar al directorio del proyecto**:

   ```bash
   cd practica3-testing
   ```

3. **Instalar las dependencias de PHP**:

   ```bash
   composer install
   ```

4. **Copiar el archivo de entorno y configurar las variables necesarias**:

   ```bash
   cp .env.example .env
   ```

5. **Generar la clave de la aplicación**:

   ```bash
   php artisan key:generate
   ```

6. **Configurar la base de datos en el archivo `.env` y ejecutar las migraciones**:

   ```bash
   php artisan migrate
   ```

7. **Iniciar el servidor de desarrollo**:

   ```bash
   php artisan serve
   ```

## Pruebas

El proyecto utiliza Pest para la realización de pruebas automatizadas siguiendo los principios de TDD. Para ejecutar las pruebas, utiliza el siguiente comando:

```bash
./vendor/bin/pest
```

## Contribuciones

Si deseas contribuir a este proyecto, por favor sigue los siguientes pasos:

1. Realiza un fork del repositorio.
2. Crea una nueva rama (`git checkout -b feature/nueva-funcionalidad`).
3. Realiza tus cambios y haz commits descriptivos.
4. Envía un pull request para su revisión.

## Licencia

Este proyecto está bajo la licencia MIT. Consulta el archivo `LICENSE` para más detalles.
