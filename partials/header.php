<?php
  $fileName = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);  
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Days without accidents</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="static/css/main.css">
</head>

<body class="h-full min-h-full">
  <header>
    <nav class="bg-gray-200 px-2 sm:px-4 py-2.5 border-b border-gray-400">
      <div class="container flex flex-wrap justify-between items-center mx-auto">
        <a href="index.php" class="flex items-center">
          <div class="mr-3 h-6 sm:h-9 w-8 text-2xl" alt="DWA Logo"/>🌚</div>
          <span class="text-gray-800 font-sans font-semibold whitespace-nowrap">Days without accidents</span>
        </a>
        <?php if ($fileName != "login.php" && $fileName != "register.php"): ?>
          <div class="flex md:order-2 items-center">
            <?php if (isset($_SESSION["user"])): ?>
              <div class="mr-2">Logged as <span class="font-semibold"><?= $_SESSION["user"]["username"] ?></span></div>
              <a class="inline-block m-auto bg-gray-400 text-white font-thin w-fit border border-gray-400 px-6 mx-2 py-1 text-sm rounded-sm" href="logout.php">
                Log out  
              </a>
            <?php else: ?>
              <a class="inline-block m-auto bg-gray-100 font-thin w-fit border border-gray-400 px-6 mx-2 py-1 text-sm text-gray-600 rounded-sm" href="login.php">
                Log in
              </a>
              <a class="inline-block m-auto bg-gray-600 font-thin w-fit border border-gray-400 px-6 py-1 text-sm text-gray-100 rounded-sm" href="register.php">
                Try for free
              </a>
            <?php endif ?>
          </div>
        <?php endif ?>
      </div>
    </nav>
  </header>