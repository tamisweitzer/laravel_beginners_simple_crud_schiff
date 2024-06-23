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

We can add a constraint to our table that ensures a new username and email are unique.

```php
// 'name' => ['required', 'min:3', 'max:20', Rule::unique('tablename', 'columnname')],
'name' => ['required', 'min:3', 'max:20', Rule::unique('users', 'name')],
```


## Create Ability to Logout of App

1. In the template, create a form with a button labelled logout. The form method  goes to route '/logout'.
2. In the routes, create a route called logout that uses a function called 'logout' in the UserController.
3. In the controller, create a 'logout' function that calls the globally available `auth()` function, look inside it and call the `logout` function.

```php
// Template: '/resources/views/home.blade.php'.
<form action="/logout" method="post">
  @csrf
  <button>Logout</button>
</form>

// Routes: '/routes/web.php'.
Route::post('/logout', [UserController::class, 'logout']);

// Controller: '/app/Http/Controllers/UserController.php'
public function logout() {
  auth()->logout();
  redirect('/');
}
```

## Max Password Length

Originally, I had set the max password length to be 100 characters. This broke caused user registration to fail.

It turns out that the dcrypt script allows a max length of 72 characters.

```text
Password hashing in Laravel is done with bcrypt , and internally bcrypt has a maximum password length of 72 characters. Anything beyond that is truncated.Feb 5, 2024
Source: https://masteringlaravel.io/daily/2024-02-05-why-does-laravel-offer-a-max-password-length-validation-rule#:~:text=Password%20hashing%20in%20Laravel%20is,Anything%20beyond%20that%20is%20truncated.
```


```php
 $incomingFields = $request->validate(
   [
       'name' => ['required', 'min:3', 'max:20', Rule::unique('users', 'name')],
       'email' => ['required', Rule::unique('users', 'email')],
       'password' => ['required', 'min:8', 'max:72']
   ]
);
```

Still not working.

Turned ON debugging messages in `/config/app.php`.

```php
- 'debug' => (bool) env('APP_DEBUG', false),
+ 'debug' => (bool) env('APP_DEBUG', true),
```

For whatever reason, I cannot set a min or max password length in the validate function. There must have been a change in Laravel since this video was recorded, because as of today, the only thing that works is the required parameter.

```php
 $incomingFields = $request->validate(
   [
       'name' => ['required', 'min:3', 'max:20', Rule::unique('users', 'name')],
       'email' => ['required', Rule::unique('users', 'email')],
       'password' => ['required']
   ]
);
```

I don't see any specific errors in the error logs, `/storage/logs/laravel.log`, or in the web page.
