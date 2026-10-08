PHP 8.5 MySQL 8.4

Steps to start the project:

1. Clone the project to yourself
2. Copy .env.example to .env in root directory
3. Copy .env.example to .env in registration-form directory
4. Open a terminal in registration-form directory  
5. Start docker if you didn't it before  
6. Enter the commands in the terminal:     
   1)docker compose up nginx -d  
   2)docker comose run --rm npm install    
   3)docker compose run --rm npm run dev  
   4)docker compose run --rm composer install  
   5)docker compose run --rm artisan key:generate  
   6)docker compose run --rm artisan migrate --seed   
7. And after the steps above the app will be available at http://localhost:8000

Url to get admin panel: http://localhost:8000/admin/panel  
Credentials to admin panel:    
username: admin  
password: admin
