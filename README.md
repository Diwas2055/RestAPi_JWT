## REST API  using JWT Token 

## VERSION USE

- Laravel =  ^8.0 
- JWT Auth = ^1.0
- PHP = ^7.4.*

## Project Setup

 1. Clone the repo 
 `git clone https://github.com/Diwas2055/RestAPi_JWT.git`
 2. Open your terminal and move to the cloned project.
 3. Install composer dependencies 
  `composer install`
 4. Copy the .env.example file and rename it to .env
 5. In mysql create a new database and update the variable in .env file accordingly.
 6. Run the migrations 
 `php artisan migrate`
 7. Import Data into mysql  
 `php artisan db:seed`
 8. Run Project 
 `php artisan serve`
 9. To login in the app  add /login to the APP_URL ( i.e :: http::localhost:8000/api/login)
 10.  Check Using PostMan.

## API URL WITH METHOD AND ACTIONS 

| METHOD        | URL                                               | ACTION  |
| ------------- | -------------                                     | --------    |
| `GET / POST`  | http://127.0.0.1:8000/api/tasks/{id}              | `FETCH ALL / SEARCH`|
| `POST`        | http://127.0.0.1:8000/api/tasks/                  | `STORE`|
| `GET`         | http://127.0.0.1:8000/api/tasks/{id}              | `SHOW`    |
| `POST`        | http://127.0.0.1:8000/api/tasks/{id}              | `UPDATE`    |
| `DELETE`      | http://127.0.0.1:8000/api/tasks/{id}              | `DELETE`   |
| `POST `       | http://127.0.0.1:8000/api/tasks/deleteMultiple    | `DELETE SELECTED DATA` |


## API COLLECTION FOR POSTMAN

File Name = Tasks_collection 
