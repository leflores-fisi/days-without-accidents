<?php
  session_start();
  # protected route
  if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    return;
  }

  require_once "database.php";
  $user_id = $_SESSION["user"]["user_id"];
  $statement = $DBconnection->query("SELECT counting_from FROM users WHERE user_id = $user_id");
  $counting_from = $statement->fetch(PDO::FETCH_ASSOC)["counting_from"];

  if (!$counting_from) {
    $timestamp = time();
    $statement = $DBconnection->query("UPDATE users SET counting_from = $timestamp WHERE user_id = $user_id");
  }
  header("Location: app.php");
?>
