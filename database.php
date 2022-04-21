<?php
$host = "localhost";
$database = "accidents_app";

try {
  $DBconnection = new PDO(
    dsn: "mysql:host=$host;dbname=$database",
    username: "root",
    password: "",
  );
}
catch (PDOException $error) {
  print_r("Some bad happened" . $error);
  log(json_encode($error));
  die();
}
