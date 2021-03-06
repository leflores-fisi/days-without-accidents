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

  if ($accidents->rowCount() > 0) {
    $search_statement = $DBconnection->query("SELECT timestamp FROM accidents WHERE user_id = {$_SESSION["user"]["user_id"]} ORDER BY timestamp DESC LIMIT 1");
    $last_accident_timestamp = $search_statement->fetch(PDO::FETCH_ASSOC)["timestamp"] ?? null;
  }
  else {
    $search_timestamp_statement = $DBconnection->query("SELECT counting_from FROM users WHERE user_id = {$_SESSION["user"]["user_id"]}");
    $last_accident_timestamp = $search_timestamp_statement->fetch(PDO::FETCH_ASSOC)["counting_from"] ?? null;
  }

  function level_color(int $level): string {
    return match($level) {
      1 => 'yellow',
      2 => 'orange',
      3 => 'red',
      default => 'gray'
    };
  }
  function timestampToDate($timestamp) {
    $date = new DateTime();
    $date->setTimestamp($timestamp);
    $date->setTimezone(new DateTimeZone("UTC"));
    return $date->format("Y, M d h:m e");
  }
?>

<?php require_once "partials/header.php" ?>
<script defer src="static/js/counter.js" type="text/javascript"></script>

<main class="h-full mb-16">
  <div class="flex justify-center items-center h-64 bg-gray-200">
    <?php if ($last_accident_timestamp): ?>
      <div id="counter" data-timestamp="<?= $last_accident_timestamp ?>" class="flex items-start bg-gray-300 px-32 py-6 my-6 rounded-md">
        <div>
          <div id="days-counter" class="text-9xl font-bold text-center h-36 px-6 rounded-md bg-gray-200"></div>
          <div class="flex items-center gap-1 justify-center">
            <span id="hours-counter"   class="text-2xl font-sans"></span>:
            <span id="minutes-counter" class="text-2xl font-sans"></span>:
            <span id="seconds-counter" class="text-2xl font-sans"></span>
          </div>
        </div>
        <div class="text-center ml-6 mt-4">
          <div class="font-extrabold text-8xl">DAYS</div>
          <div class="text-3xl font-semibold font-sans">without accidents</div>
        </div>
      </div>
    <?php else: ?>
      <span class="whitespace-pre text-lg">Log accidents to start counting or </span>
      <a href="start_counter.php" class="underline text-lg font-semibold">start now</a>
    <?php endif ?>
  </div>
  <div class="container m-auto p-3">
    <?php if ($accidents->rowCount() > 0): ?>
      <?php foreach ($accidents as $accident) : ?>
        <div class="w-full max-w-2xl px-4 py-3 mx-auto bg-white mt-4">
          <div class="flex items-center justify-between">
            <span class="text-xs font-mono font-light text-gray-500"><?= timestampToDate($accident["timestamp"]) ?></span>
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
            <a href="delete.php?id=<?= $accident["id"] ?>" class="text-red-600 underline">
              Delete
            </a>
            <a href="edit.php?id=<?= $accident["id"] ?>" class="text-gray-600 underline">
              Edit
            </a>
          </div>
        </div>
      <?php endforeach ?>
    <?php else: ?>
      <div class="text-center">No accidents to show!</div>
    <?php endif ?>
  </div>
  <a href="add.php" class="m-auto w-32 justify-center border-y border-x border-black cursor-pointer flex items-center px-2 py-2 font-normal tracking-wide capitalize transition-colors duration-200 transform bg-white hover:bg-gray-100 rounded-md focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
  <svg class="w-5 h-5 mx-1 text-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
    <path d="M432 256c0 17.69-14.33 32.01-32 32.01H256v144c0 17.69-14.33 31.99-32 31.99s-32-14.3-32-31.99v-144H48c-17.67 0-32-14.32-32-32.01s14.33-31.99 32-31.99H192v-144c0-17.69 14.33-32.01 32-32.01s32 14.32 32 32.01v144h144C417.7 224 432 238.3 432 256z"/>
  </svg>
    <span class="mx-1 text-black text-sm">Add new</span>
  </a>
</main>

<?php require_once "partials/footer.php" ?>