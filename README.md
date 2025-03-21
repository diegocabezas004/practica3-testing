# Proyecto de Práctica 3: Testing en Laravel

Este proyecto es una aplicación desarrollada en Laravel con el objetivo de practicar y aplicar técnicas de testing automatizado. A través de este proyecto, se busca asegurar la calidad y fiabilidad del código mediante pruebas unitarias y funcionales.

## Características

- **Framework**: Laravel
- **Pruebas automatizadas**: PHPUnit para pruebas unitarias y funcionales
- **Integración continua**: Configuración para ejecutar pruebas automáticamente en cada commit

## Requisitos

- PHP >= 7.3
- Composer
- Base de datos (MySQL, PostgreSQL, etc.)

## Instalación

1. Clona el repositorio:

   ```bash
   git clone https://github.com/diegocabezas004/practica3-testing.git
   ```

2. Navega al directorio del proyecto:

   ```bash
   cd practica3-testing
   ```

3. Instala las dependencias de PHP:

   ```bash
   composer install
   ```

4. Copia el archivo de entorno y configura las variables necesarias:

   ```bash
   cp .env.example .env
   ```

5. Genera la clave de la aplicación:

   ```bash
   php artisan key:generate
   ```

6. Configura la base de datos en el archivo `.env` y luego ejecuta las migraciones:

   ```bash
   php artisan migrate
   ```

## Uso

- **Servidor de desarrollo**: Inicia el servidor local con:

  ```bash
  php artisan serve
  ```

- **Pruebas**: Ejecuta las pruebas con:

  ```bash
  php artisan test
  ```

## Estructura del Proyecto

- `app/`: Contiene el código fuente de la aplicación
- `config/`: Archivos de configuración
- `database/`: Migraciones y seeds de la base de datos
- `resources/`: Vistas y archivos de recursos
- `routes/`: Definición de rutas
- `tests/`: Pruebas unitarias y funcionales

## Contribuciones

Si deseas contribuir a este proyecto, por favor sigue los siguientes pasos:

1. Haz un fork del repositorio
2. Crea una nueva rama (`git checkout -b feature/nueva-funcionalidad`)
3. Realiza tus cambios y haz commits descriptivos
4. Envía un pull request

## Licencia

Este proyecto está bajo la licencia MIT. Consulta el archivo `LICENSE` para más detalles.
