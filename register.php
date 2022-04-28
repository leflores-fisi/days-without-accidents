<?php
  session_start();
  # no session route
  if (isset($_SESSION["user"])) header("Location: app.php");
  else session_destroy();

  $register_error = null;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "database.php";

    $username = $_POST["username"];
    $password = $_POST["password"];

    $search_statement = $DBconnection->prepare("SELECT * FROM users
      WHERE username = :username
    ");
    $search_statement->execute(["username" => $username]);

    if ($search_statement->rowCount() > 0) {
      $register_error = "Username already registered!";
    }
    else {
      $create_statement = $DBconnection->prepare("INSERT INTO users
        (username, password)
        VALUES (:username, :password)
      ");
      $create_statement->execute([
        "username" => $username,
        "password" => password_hash($password, PASSWORD_BCRYPT)
      ]);
      # Setting up the session
      $search_statement->execute(["username" => $username]);
      $user = $search_statement->fetch(PDO::FETCH_ASSOC);
      session_start();
      unset($user["password"]);
      $_SESSION["user"] = $user;

      header("Location: app.php"); # app redirection
    }
  }
?>

<?php require_once "partials/header.php" ?>
<div class="w-full fullscreen bg-gray-50 flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
  <div class="w-full sm:max-w-md p-5 mx-auto">
    <h2 class="mb-12 text-center text-5xl font-extrabold">Register</h2>
    <form method="POST" action="register.php">
      <div class="mb-4">
        <label class="block mb-1" for="username">Username</label>
        <input id="username" type="text" name="username" class="py-2 px-3 border border-gray-300 focus:border-gray-300 focus:outline-none focus:ring focus:ring-gray-200 focus:ring-opacity-50 rounded-md shadow-sm disabled:bg-gray-100 mt-1 block w-full" />
      </div>
      <div class="mb-4">
        <label class="block mb-1" for="password">Password</label>
        <input id="password" type="password" name="password" class="py-2 px-3 border border-gray-300 focus:border-gray-300 focus:outline-none focus:ring focus:ring-gray-200 focus:ring-opacity-50 rounded-md shadow-sm disabled:bg-gray-100 mt-1 block w-full" />
      </div>
      <div class="mt-6">
        <button class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold capitalize text-white hover:bg-gray-700 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring focus:ring-gray-200 disabled:opacity-25 transition">Sign In</button>
      </div>
      <?php if ($register_error): ?>
        <span class="text-gray-600"><?= $register_error ?></span>
      <?php endif ?>
      <div class="mt-6 text-center">
        <a href="login.php" class="underline">Already have an account?</a>
      </div>
    </form>
  </div>
</div>
<?php require_once "partials/footer.php" ?>