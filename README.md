# Instalación de solati_front

## Project setup

```
cd solati_front
```

```
Abrir el archivo index.html
```

# Instalación de solati_api

### Pre-requisitos 

_Que cosas necesitas para poner en marcha el proyecto y como instalarlos_

* GIT [Link](https://git-scm.com/downloads)
* Entorno de servidor local, Ej: [Laragon](https://laragon.org/download/), [XAMPP](https://www.apachefriends.org/es/index.html) o [LAMPP](https://bitnami.com/stack/lamp/installer).
* PHP Version 8.0 [Link](https://www.php.net/downloads.php).
* Manejador de dependencias de PHP [Composer](https://getcomposer.org/download/).

### Instalación 🔧

Paso a paso de lo que debes ejecutar para tener el proyecto ejecutandose

 1. Ingrese a la carpeta del repositorio
    ```
    cd solati_api
    ```
 2. Instale las dependencias del proyecto
    ```
    composer install
    ```
 3. Cree el archivo ".env" y cambie valores de base de datos.

    ```
    Cree la base de datos en el servidor de base de datos postgresql con el nombre de solati_api
    ```

    ```
    Cree la base de datos en el servidor de base de datos postgresql un usuario llamado 'root' y con contraseña 'root'
    ```

    ```
    Reemplace la siguiente configuracion en el .env

    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=solati_api
    DB_USERNAME=root
    DB_PASSWORD=root
    ```

 4. Ejecute las migraciones
    ```
    php artisan migrate --seed
    ```
 5. Inicialice el servidor local
    ```
    php artisan serve --port=8000
    ```  

 6. Validar pruebas
   ```
    php artisan test
   ```

## Construido con 🛠️

* Framework de PHP [Laravel](https://laravel.com/docs/10.x).