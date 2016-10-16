<?php
session_start();
?>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
</head>

<body>
  <div id ="logo-container">
      <img src="emailer-logo.png" class ="site-logo"alt="Logo">
  </div>
  <div class="register container">
    <form id="register_form" method="post" action="register.php">
      <input type="text" name="username" class="input" placeholder="Your Username!" required><br>
      <input type="email" name="email" class="input" placeholder="Your Email Address!" required><br>
      <input type="password" name="pass" class="input" placeholder="Your Password!" required><br>
      <input type="submit" name="submit" value="Register" class="action-btn">
    </form>
  </div>

<?php
  include 'connect.php';

  if(isset($_POST['submit'])) {
    $name=$_POST['username'];
    $mail=$_POST['email'];
    $pass = $_POST['pass'];
    $hash = hash('sha512',$pass);

    $sql = "INSERT INTO users (name, email, password) VALUES ('$name','$mail','$hash')";

    if ($conn->query($sql) === TRUE) {
      mail($mail,'Welcome','Thank you for signing up with Emailer','From: dfarrelly96@gmail.com');
      header('Location: index.php');
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
?>
</body>
</html>
