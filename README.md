# app gestión de usuarios

Esta applicacion web esta realizada con el stack laravel + inertia + vue js + tailwind css y como gestor de base de datos Mysql 
el objetivo de esta aplicacion web es poder crear la autenticacion de usuarios y que estos puedan ser gestionados con las acciones de un CRUD

## Requisitos Previos

- [Node.js](https://nodejs.org/) v18+
- [npm](https://www.npmjs.com/) v10+
- php 8.3 +

## Instalación

1. Clona el repositorio:
2. accede al directorio del proyecto ejemplo cd /www/app-users
3. abre la consola y ejecuta composer install 
4. ejecuta npm install 
5. ejecuta cp .env.example .env 
6. ejecutar php artisan key:generate
7. crea una base de datos y configura en las variables de entorno
8. ejecutar php artisan migrate o php artisan migrate:fresh
9. ejecuta npm run build
10. ejecuta php artisna serve y acceder a la ruta que comparira el servidor local
