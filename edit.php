<?php
  session_start();
  # protected route
  if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    return;
  }

  require "database.php";
  $accident_id = $_GET["id"]; # Query uri param
  $submit_error = null;

  $search_statement = $DBconnection->prepare("SELECT * FROM accidents WHERE id = :id");
  $search_statement->execute(["id" => $accident_id]);

  if ($search_statement->rowCount() == 0) {
    http_response_code(404);
    echo "HTTP 404 NOT FOUND with id $accident_id";
    die();
  }

  # Exist in database
  $accident_to_edit = $search_statement->fetch(PDO::FETCH_ASSOC);

  # Check if the content belongs to the user
  if ($accident_to_edit["user_id"] !== $_SESSION["user"]["user_id"]) {
    http_response_code(403);
    echo "HTTP 403 NOT ALLOWED";
    die();
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $edited_accident = $_POST;

    # Extracting information
    $title = $edited_accident["title"];
    // $date  = $edited_accident["date"];
    $level = intval($edited_accident["level"]);
    if ($level < 1 || $level > 3) $level = 1;
    $description = $edited_accident["description"];

    if (empty($title) || empty($level) || empty($description)) {
      $submit_error = "All inputs must be filled";
    }
    else {
      # Inserting a new row TODO: validations
      $insert_statement = $DBconnection->prepare("UPDATE accidents
        SET title = :title,
            level = :level,
            description = :description
        WHERE id = :id
      ");
      $insert_statement->execute([
        "title" => $title,
        "level" => $level,
        "description" => $description,
        "id" => $accident_id
      ]);
      header("Location: app.php"); # redirection
    }
  }
?>

<?php require_once "partials/header.php" ?>
<main class="container m-auto px-16">
  <h2 class="text-2xl font-bold font-sans mt-6 mb-6">Edit accident</h2>
  <form id="accident_form" action="edit.php?id=<?= $accident_id ?>" method="POST">
    <div class="grid xl:grid-rows-2 xl:gap-6">
      <div class="flex relative z-0 mb-6 w-full group">
        <input type="text" value="<?= $accident_to_edit["title"] ?>" name="title" id="floating_first_name" class="block pt-2.5 pb-1.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
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
            aria-label=".form-select-sm level"
          >
            <option selected>Select a level</option>
            <option <?= $accident_to_edit["level"] == 1 ? "selected" : "" ?> value="1">Slight</option>
            <option <?= $accident_to_edit["level"] == 2 ? "selected" : "" ?> value="2">Moderate</option>
            <option <?= $accident_to_edit["level"] == 3 ? "selected" : "" ?> value="3">Fatal</option>
          </select>
        </div>
      </div>
    </div>

    <div class="w-full mb-6">
      <label
        for="description"
        class="block mb-2 text-sm font-medium text-gray-800"
      >
        Describe the accident
      </label>
      <textarea
        name="description"
        class="block w-full h-40 px-4 py-2 text-gray-700 bg-white border rounded-md focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40"
      ><?= $accident_to_edit["description"] ?></textarea>
    </div>

    <?php if ($submit_error): ?>
    <div class="text-red-600"><?= $submit_error ?></div>
    <?php endif ?>

    <button type="submit" class="m-auto w-32 justify-center border-y border-x border-black cursor-pointer flex items-center px-2 py-2 font-normal tracking-wide capitalize transition-colors duration-200 transform bg-white hover:bg-gray-100 rounded-md focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
      <svg class="w-5 h-5 mx-1 text-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
        <path d="M433.1 129.1l-83.9-83.9C342.3 38.32 327.1 32 316.1 32H64C28.65 32 0 60.65 0 96v320c0 35.35 28.65 64 64 64h320c35.35 0 64-28.65 64-64V163.9C448 152.9 441.7 137.7 433.1 129.1zM224 416c-35.34 0-64-28.66-64-64s28.66-64 64-64s64 28.66 64 64S259.3 416 224 416zM320 208C320 216.8 312.8 224 304 224h-224C71.16 224 64 216.8 64 208v-96C64 103.2 71.16 96 80 96h224C312.8 96 320 103.2 320 112V208z"/>
      </svg>
      <span class="mx-1 text-black text-sm">Edit</span>
    </button>
  </form>
</main>
<?php require_once "partials/footer.php" ?>