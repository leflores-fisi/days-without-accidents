<?php
  session_start();
  # protected route
  if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    return;
  }

  require_once "database.php";

  # Getting all the accidents data
  $accidents = $DBconnection->query("SELECT * FROM accidents WHERE user_id = {$_SESSION["user"]["user_id"]}");

  $search_date_statement = $DBconnection->query("SELECT date FROM accidents ORDER BY date DESC LIMIT 1");
  $last_accident_date = $search_date_statement->fetch(PDO::FETCH_ASSOC)["date"];
  $last_accident_date = new DateTime($last_accident_date);

  $days_without = (time() - $last_accident_date->getTimestamp())/60/60/24;

  function level_color(int $level): string {
    return match($level) {
      1 => 'yellow',
      2 => 'orange',
      3 => 'red',
      default => 'gray'
    };
  }
?>

<?php require_once "partials/header.php" ?>

<main class="h-full mb-16">
  <div class="flex justify-center items-center bg-gray-600 h-64">
    <div class="text-9xl font-mono mr-4"><?= $days_without ?></div>
    <div class="text-2xl font-sans">days without accidents</div>
  </div>
  <div class="container m-auto p-3">
    <?php foreach ($accidents as $accident) : ?>
      <div class="w-full max-w-2xl px-4 py-3 mx-auto bg-white mt-4">
        <div class="flex items-center justify-between">
          <span class="text-xs font-mono font-light text-gray-500"><?= $accident["date"] ?></span>
          <span class="px-3 py-1 text-xs text-white-800 uppercase bg-<?= level_color($accident["level"]) ?>-300 rounded-md">Level: <?= $accident["level"] ?></span>
        </div>

        <div>
          <h1 class="text-xl font-semibold text-gray-800"><?= $accident["title"] ?></h1>
          <p class="text-base text-gray-800"><?= $accident["description"] ?></p>
        </div>
        <?php if (isset($accident["more_info"])) : ?>
          <div>
            <div class="flex items-center mt-2 text-gray-700">
              <span>More info on:</span>
              <a class="mx-2 text-blue-600 cursor-pointer hover:underline">example.com</a>
            </div>
          </div>
        <?php endif ?>
        <div class="flex gap-2 text-xs mt-2">
          <a href="deleteAccident.php?id=<?= $accident["id"] ?>" class="text-red-600 underline">
            Delete
          </a>
          <a href="editAccident.php?id=<?= $accident["id"] ?>" class="text-gray-600 underline">
            Edit
          </a>
        </div>
      </div>
    <?php endforeach ?>
  </div>
  <a href="addAccident.php" class="m-auto w-32 justify-center border-y border-x border-black cursor-pointer flex items-center px-2 py-2 font-normal tracking-wide capitalize transition-colors duration-200 transform bg-white hover:bg-gray-100 rounded-md focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
    <svg class="w-5 h-5 mx-1 text-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
      <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
    </svg>
    <span class="mx-1 text-black text-sm">Add new</span>
  </a>
</main>

<?php require_once "partials/footer.php" ?>