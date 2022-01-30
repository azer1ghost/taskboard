## Task Board

For installing project follow all steps.

First download project as zip and extract go inside project folder and run commands

- <code> composer install </code>
- <code> npm install </code>
- <code> npm run prod </code>
  
For creating sql table
- <code> mysql -u root -p </code>
Enter database password then press enter. After all enter this line. 
- <code> CREATE DATABASE taskboard; </code>
- <code> exit</code>

Then go project folder enter terminal run commands
- <code> php -r "file_exists('.env') || copy('.env.example', '.env');" </code>

Now enter .env file and enter db configs

DB_DATABASE=taskboard  
DB_USERNAME=root  
DB_PASSWORD=pass


- <code> php artisan migrate</code>
- <code> php artisan serve</code>

Enjoy 😊

If you add dummy data run
- <code> php artisan migrate --seed </code>

user@gmail.com  
password
