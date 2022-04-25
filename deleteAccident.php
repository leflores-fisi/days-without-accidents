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
  else {
    $delete_statement = $DBconnection->prepare("DELETE FROM accidents WHERE id = :id");
    $delete_statement->execute(["id" => $accident_id]);
    header("Location: app.php");
  }
?>