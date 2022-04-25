<?php
  session_start();
  # protected route
  if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    return;
  }

  require_once "database.php";

  $accident_id = $_GET["id"];

  $search_statement = $DBconnection->prepare("SELECT * FROM accidents WHERE id = :id");
  $search_statement->execute(["id" => $accident_id]);

  if ($search_statement->rowCount() == 0) {
    http_response_code(404);
    echo "HTTP 404 NOT FOUND with id $accident_id";
  }
  $accident_to_delete = $search_statement->fetch(PDO::FETCH_ASSOC);

  # Check if the content belongs to the user
  if ($accident_to_delete["user_id"] !== $_SESSION["user"]["user_id"]) {
    http_response_code(403);
    echo "HTTP 403 NOT ALLOWED";
    die();
  }

  $delete_statement = $DBconnection->prepare("DELETE FROM accidents WHERE id = :id");
  $delete_statement->execute(["id" => $accident_id]);
  header("Location: app.php");
?>