<?php
  $servername = "server_name";
  $username = "user_name";
  $password = "user_password";
  $dbname = "database_name";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $_SESSION["connection"] = $conn;
?>
