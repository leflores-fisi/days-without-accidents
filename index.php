<?php session_start() ?>

<?php require_once "partials/header.php" ?>

<main class="container m-auto h-full">
  <div class="flex md:flex-row flex-col items-center flex-nowrap h-full font0 p-6 mt-32 md:px-8 lg:px-32 px-6 text-center justify-start">
    <div class="md:w-1/2 max-w-96 inline-flex flex-col justify-start">
      <h1 class="text-6xl mb-4 font-bold text-left tracking-wider">Days<wbr> without<br>accidents</h1>
      <h2 class="text-lg inline-flex text-left tracking-wide">Start counting and recording your accidents.</h2>
      <h2 class="text-lg inline-flex text-left tracking-wide">Minimalist tool for your enjoyment.</h2>
      <?php if (!isset($_SESSION["user"])): ?>
        <a class="inline-block my-3 bg-gray-600 text-left font-thin w-fit border border-gray-400 px-6 py-1 text-sm text-gray-100 rounded-sm" href="register.php">
          Try for free
        </a>
      <?php endif ?>
      <span class="text-left">
        <span class="text-black text-xs whitespace-pre">Wanna something? <a class="text-gray-600 text-xs underline" target="blank" href="https://github.com/leflores-fisi/days-without-accidents">Check our repository</a></span>
      </span>
    </div>
    <div class="md:w-1/2 max-w-96 inline-block md:mt-0 mt-8">
      <img class="app-banner" width="800px" height="400px" src="https://res.cloudinary.com/cloudinary-service/image/upload/v1651141153/github/days-without-banners_o5q8gu.jpg">
    </div>
  </div>
</main>

<?php require_once "partials/footer.php" ?>