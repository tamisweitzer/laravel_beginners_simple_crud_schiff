<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Basic CRUD</title>
  <link rel="stylesheet" href="./styles.css">
</head>
<body>
  <h1>Simple CRUD in Laravel</h1>

  <section class="section">
    <h2>Register</h2>
    <form action="/register" method="post">
      @csrf
      <input type="text" name="name" placeholder="name">
      <input type="text" name="email" placeholder="email">
      <input type="text" name="password" placeholder="password">
      <input type="submit" name="submit" value="Submit">
    </form>
  </section>
</body>
</html>
