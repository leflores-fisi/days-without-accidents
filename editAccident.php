<?php
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
  $accident_to_edit = $search_statement->fetch();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $edited_accident = $_POST;

    # Extracting information
    $title = $edited_accident["title"];
    $date  = $edited_accident["date"];
    $level = intval($edited_accident["level"]);
    if ($level < 1 || $level > 3) $level = 1;
    $description = $edited_accident["description"];

    if (empty($title) || empty($date) || empty($level) || empty($description)) {
      $submit_error = "All inputs must be filled";
    }
    else if (!strtotime($date)) {
      $submit_error = "Date must have a valid format";
    }
    else {
      # Inserting a new row TODO: validations
      $insert_statement = $DBconnection->prepare("UPDATE accidents
        SET title = :title,
            date = :date,
            level = :level,
            description = :description
        WHERE id = :id
      ");
      $insert_statement->execute([
        "title" => $title,
        "date" => $date,
        "level" => $level,
        "description" => $description,
        "id" => $accident_id
      ]);
      header("Location: index.php"); # redirection
    }
  }
?>

<?php require_once "partials/header.php" ?>
<main class="container m-auto px-16">
  <h2 class="text-2xl font-bold font-sans mt-6 mb-6">Edit accident</h2>
  <form id="accident_form" action="editAccident.php?id=<?= $accident_id ?>" method="POST">
    <div class="grid xl:grid-rows-2 xl:gap-6">
      <div class="flex relative z-0 mb-6 w-full group">
        <input type="text" value="<?= $accident_to_edit["title"] ?>" name="title" id="floating_first_name" class="block pt-2.5 pb-1.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
        <label for="title" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
          What
        </label>
      </div>
      <div class="grid xl:grid-cols-2 xl:gap-6">
        <div class="relative z-0 mb-6 w-full group">
          <input
            type="date"
            value="<?= $accident_to_edit["date"] ?>"
            name="date"
            id="floating_first_name"
            class="block pt-2.5 pb-1.5  px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
            placeholder=" "
            required />
          <label
            for="date"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
            Date
          </label>
        </div>
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
      <svg class="w-5 h-5 mx-1 text-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
        <path
          fill-rule="evenodd"
          d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
          clip-rule="evenodd" />
      </svg>
      <span class="mx-1 text-black text-sm">Edit</span>
    </button>
  </form>
</main>
<?php require_once "partials/footer.php" ?>