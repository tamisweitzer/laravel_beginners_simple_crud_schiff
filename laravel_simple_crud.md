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
