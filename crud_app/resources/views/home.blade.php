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

  @auth
   <!-- If user is logged in -->
    <section class="section">
      <h2>Welcome, User <?= $user_id ?>.</h2>
      <form action="/logout" method="post">
        @csrf
        <button>Logout</button>
      </form>
    </section>

    <section class="section posts">
      <h2>Create a New Post</h2>
      <form action="/create-post" method="POST">
        @csrf
        <input type="text" name="title" placeholder="post title">
        <textarea name="body" placeholder="body content..."></textarea>
        <input type="submit" name="save-post" value="Save post">
      </form>
    </section>

    <section class="section">
      <h2>All Posts</h2>
      <div>
        @foreach($posts as $post)
        <div style="background-color:#f5f5f5; padding:1rem; margin-bottom: 2rem;">
          <h3 style="margin-bottom:.5rem;">
            {{ $post['title']}}
          </h3>
          <div style="margin-bottom:.5rem;">
            {{ $post['body']}}
          </div>
          <div style="margin-bottom:2rem;">
            Written by: {{ $post['user_id']}}
          </div>
        </div>
        @endforeach
      </div>
    </section>
  @else
  <!-- If user is not logged in -->
    <section class="section">
      <h2>Login</h2>
      <form action="/login" method="post">
        @csrf
        <input type="text" name="loginname" placeholder="name">
        <input type="text" name="loginpassword" placeholder="password">
        <input type="submit" name="loginsubmit" value="Login">
      </form>
    </section>

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
  @endauth

</body>
</html>
