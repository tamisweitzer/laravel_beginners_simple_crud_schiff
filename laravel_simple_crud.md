# Laravel Tutorial For Beginners (Simple User CRUD App)
by Brad Schiff

 https://www.youtube.com/watch?v=cDEVWbz2PpQ&t=2067s

--------------------------------------------------------

This is a simple CRUD app to learn the basics of Laravel. We will cover routing and MVC architecture.


## Create new project

```sh
composer create-project laravel/laravel .
```

## Start Dev Server

```sh
php artisan serve
```

Project is served on 127.0.0.1:8000 or 8001.

# Controllers

Instead of placing the routing function inline, in the route file, we will move the functions out into a controller file in `app/Http/Controllers/`.

## Make a New Controller

Make a new controller using artisan. The name of the controller should match the class/model name.

```sh
php artisan make:controller NameController
```

Now we need the register route in the routes file, `routes/web.php`, will point to a controller instead of using an inline function.

This tells us that when we make a POST request to the `/register` route, we will look in the UserController for the `register` function.

```php
Route::post('/register', [UserController::class, 'register']);
```

When we use a controller in our route, we also need to add a using statement at the top of the file.

```php
use App\Http\Controllers\UserController;
```

Now, in the controller, we can return a string as a test to make sure it is working.

```php
public function register() {
    return 'hello from controller';
}
```