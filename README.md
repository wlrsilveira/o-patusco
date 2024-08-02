# Patusco API 

This project uses Docker Compose to set up a development environment for a API. Below are the details on how to get started.

## Requisites

Ensure you have Docker and Docker Compose installed on your machine. You can follow the installation instructions on their official websites:

- [Docker Installation](https://docs.docker.com/get-docker/)
- [Docker Compose Installation](https://docs.docker.com/compose/install/)

## Docker Compose Configuration

The `docker-compose.yml` file sets up the following services:

1. **Redis**: In-memory data structure store.
   - **Image**: `redis:alpine`

2. **MariaDB**: Database server.
   - **Image**: `mariadb:11.0`
   - **Environment Variables**:
     - `MYSQL_ROOT_PASSWORD`: Root password for MariaDB.
     - `MYSQL_DATABASE`: Name of the database to create.
     - `MYSQL_USER`: User for accessing the database.
     - `MYSQL_PASSWORD`: Password for the user.
   - **Ports**: Exposes MariaDB on port `8003` (mapped to `3306` inside the container).

3. **Webserver**: Nginx server.
   - **Image**: `nginx:alpine`
   - **Volumes**:
     - Mounts the current directory to `/application` in the container.
     - Mounts a custom Nginx configuration file.
   - **Ports**: Exposes Nginx on port `8000` (mapped to `80` inside the container).

4. **PHP-FPM**: PHP FastCGI Process Manager.
   - **Build**: Custom Dockerfile located in `phpdocker/php-fpm`.
   - **Volumes**:
     - Mounts the current directory to `/application` in the container.
     - Mounts a custom PHP configuration file.

## Getting Started

1. **Clone the Repository**
   `
   git clone <repository-url>
   cd <repository-directory>
   `

3. **Build and Start the Containers**

`docker-compose up --build`

3. **Access the PHP-FPM Container**

`docker-compose exec o-patusco_php-fpm_1 /bin/sh`

4. **Install Dependencies and Set Up the Application**

`composer install
php artisan key:generate
php artisan jwt:secret
php artisan migrate --seed`

5. **Create the Admin User**
    - Replace <nome_user>, <email_user>, and <password> with your desired user details:
    `php artisan admin:create <nome_user> <email_user> <password>`

6. **Access the Application**

    - http://localhost:8003/api/v1

7. **Create API Documentation**
    `php artisan scribe:generate`   
