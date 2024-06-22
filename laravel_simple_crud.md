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

Next, let's see if we can get data from an empty form submission.
To do that we pass in an argument that will contain the request object, and then we dump it to see what is in it.

```php
public function register(Request $request) {
    dd($request);
    return;
}
```


```php
+request:
Symfony\Component\HttpFoundation
\
InputBag {#38 ▼
    #parameters: array:5 [▼
      "_token" => "Ku3uIrNzrPMvs0IB1bXwBs16Y43vQChhtp7pdyli"
      "name" => null
      "email" => null
      "password" => null
      "submit" => "Submit"
    ]
  }
  ```

## Validating User Input from the Form

A very simple validation is to make sure all fields were filled in.

```php
  public function register(Request $request) {
      $incomingFields = $request->validate(
          [
              'name' => 'required',
              'email' => 'required',
              'password' => 'required'
          ]
      );
      return 'hello from controller';
  }
```

A more realistic approach is to ensure additional parameters.

Here we declare the username should be a minimum of two characters, and a maximum of 20.

The email should be in the pattern of an email address.

And the password should be between 8 and 200 characters long.

```php
 public function register(Request $request) {
    $incomingFields = $request->validate(
        [
            'name' => ['required', 'min:3', 'max:20'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'max:200']
        ]
    );
    return 'hello from controller';
}
```

## Connect Our App to a Local Database

First, log into PhpMyAdmin at `127.0.0.1/phpmyadmin` and create a new database for this project.

Database was named `laravel_crud_app_01`.
User was default root.
Password was default <no pass>.

### Laravel Migrations

Now we need table for our database. Instead of creating them in PhpMyAdmin, we will use Migrations to make our tables.

To see what Migrations are, run the migrations script.

```sh
php artisan migrate
```

Now look refresh the screen in PhpMyAdmin and you will see that there are a number of tables there. Each migrate scrips creates, modifies, or deletes a table.

One of the tables included in the default scripts is the `users` table. We will use this for our app.

Going forward, any time you run the migrate script Laravel will only run any new scripts that it finds.

### Models

In addition to the `users` table, Laravel gives us a User model as well. We will use this model to create a new instance of a User.

user #1 is tami, tami@dev.com, tami

```php
public function register(Request $request) {
    $incomingFields = $request->validate(
        [
            'name' => ['required', 'min:3', 'max:20'],
            'email' => 'required',
            'password' => 'required'
        ]
    );

    // Hash user's password before putting it into the db. The bcrypt() function is built into Laravel.
    $incomingFields['password'] = bcrypt($incomingFields['password']);

    // Create an instance of a User.
    User::create($incomingFields);

    return 'hello from controller';
}
```
