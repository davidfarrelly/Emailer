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
  <div class="login container">
    <form id="login_form" method="post" action="index.php">
      <input type="text" name="username" class="input" placeholder="Your Username!" ><br>
      <input type="password" name="pass" class="input" placeholder="Your Password!" ><br>
      <input type="submit" name="submit" value="Log in" class="action-btn">
      <input type="submit" name="register" value="Register" class="action-btn">
    </form>
  </div>

<?php
  include 'connect.php';

  if(isset($_POST['submit'])) {
    $name=$_POST['username'];
    $pass = $_POST['pass'];
    $hash = hash('sha512',$pass);

    $sql = "SELECT name,password FROM users WHERE name='$name' AND password='$hash'";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
      // Set session variables
      $_SESSION["name"] = $name;
      $_SESSION["mail"] = $mail;

      $sql = "SELECT id FROM users WHERE name ='$name'";
      $result = $conn->query($sql);

      if($result->num_rows > 0) {
          $row = mysqli_fetch_array($result);
          $_SESSION["user_id"] = $row["id"];
          header('Location: emailer.php');
      }
      else {
        echo "Unknown Error!";
      }
    }
    else {
      echo "Incorrect username or password. Please try again!";
    }
  }
  if(isset($_POST['register'])) {
    header('Location: register.php');
  }
?>
</body>
</html>
