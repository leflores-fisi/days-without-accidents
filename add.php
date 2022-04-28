<?php
  session_start();
  # protected route
  if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    return;
  }

  require_once "database.php";
  $submit_error = null;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_accident = $_POST;

    # Extracting information
    $title = $new_accident["title"];
    $timestamp = time();
    $level = intval($new_accident["level"]);
    if ($level < 1 || $level > 3) $level = 1;
    $description = $new_accident["description"];

    $submit_error = null;

    if (empty($title) || empty($level) || empty($description)) {
      $submit_error = "All inputs must be filled";
    }
    else {
      # Inserting a new row TODO: validations
      $insert_statement = $DBconnection->prepare("INSERT INTO accidents
        (user_id, title, timestamp, level, description)
        VALUES ({$_SESSION["user"]["user_id"]}, :title, $timestamp, :level, :description)
      ");
      $insert_statement->execute([
        "title" => $title,
        "level" => $level,
        "description" => $description
      ]);

      header("Location: app.php"); # redirection
    }
  }
?>

<?php require_once "partials/header.php" ?>
<main class="container m-auto px-16">
  <h2 class="text-2xl font-bold font-sans mt-6 mb-6">Report new accident</h2>
  <form id="accident_form" action="add.php" method="POST">
    <div class="grid xl:grid-rows-2 xl:gap-6">
      <div class="flex relative z-0 mb-6 w-full group">
        <input type="text" name="title" id="floating_first_name" class="block pt-2.5 pb-1.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
        <label for="title" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
          What
        </label>
      </div>
      <div class="grid xl:grid-cols-2 xl:gap-6">
        <div class="relative z-0 mb-6 w-full group">
          <label for="level" class="block mb-2 text-sm font-medium text-gray-800">Fatality level</label>
          <select
            name="level"
            form="accident_form"
            class="form-select form-select-sm appearance-none block w-full px-2 py-1
              text-sm
              font-normal
              text-gray-700
              bg-white bg-clip-padding bg-no-repeat
              border border-solid border-gray-300
              rounded
              transition
              ease-in-out
              m-0
              focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
            aria-label=".form-select-sm example"
          >
            <option selected>Select a level</option>
            <option value="1">Slight</option>
            <option value="2">Moderate</option>
            <option value="3">Fatal</option>
          </select>
        </div>
      </div>
    </div>

    <div class="w-full mb-6">
      <label for="description" class="block mb-2 text-sm font-medium text-gray-800">Describe the accident</label>
      <textarea name="description" class="block w-full h-40 px-4 py-2 text-gray-700 bg-white border rounded-md focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40"></textarea>
    </div>

    <?php if ($submit_error): ?>
    <div class="text-red-600"><?= $submit_error ?></div>
    <?php endif ?>

    <button type="submit" class="m-auto w-32 justify-center border-y border-x border-black cursor-pointer flex items-center px-2 py-2 font-normal tracking-wide capitalize transition-colors duration-200 transform bg-white hover:bg-gray-100 rounded-md focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
    <svg class="w-5 h-5 mx-1 text-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512">
      <path d="M64 352c17.69 0 32-14.32 32-31.1V64.01c0-17.67-14.31-32.01-32-32.01S32 46.34 32 64.01v255.1C32 337.7 46.31 352 64 352zM64 400c-22.09 0-40 17.91-40 40s17.91 39.1 40 39.1s40-17.9 40-39.1S86.09 400 64 400z"/>
    </svg>
      <span class="mx-1 text-black text-sm">Report</span>
    </button>
  </form>
</main>
<?php require_once "partials/footer.php" ?>