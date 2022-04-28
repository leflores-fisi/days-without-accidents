<?php session_start() ?>

<?php require_once "partials/header.php" ?>

<main class="container m-auto h-full">
  <div class="flex md:flex-row flex-col items-center flex-nowrap h-full font0 p-6 mt-32 md:px-8 lg:px-32 px-6 text-center justify-start">
    <div class="md:w-1/2 max-w-96 inline-flex flex-col justify-start">
      <h1 class="text-6xl mb-4 font-bold text-left tracking-wider">Days<wbr> without<br>accidents</h1>
      <h2 class="text-lg inline-flex text-left tracking-wide">Start counting and recording your accidents</h2>
    </div>
    <div class="md:w-1/2 max-w-96 inline-block md:mt-0 mt-8">
      <img class="app-banner" width="800px" height="400px" src="https://res.cloudinary.com/cloudinary-service/image/upload/v1651141153/github/days-without-banners_wyfour.jpg">
    </div>
  </div>
</main>

<?php require_once "partials/footer.php" ?>