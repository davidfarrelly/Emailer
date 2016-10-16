<?php
  session_start();
  if (!isset($_SESSION['name']) || empty($_SESSION['name'])) {
        header('Location: index.php');
        exit();
  }
?>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
</head>

<body>
  <div class="content">
    <div id="left" class= "left-section">  <!--Displays all of a users contacts-->
      <h1>Contact List</h1>
      <?php
        include 'connect.php';
        $user = $_SESSION["name"];
        $sql = "SELECT * FROM emails";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
        ?>
        <table valign="top">
        <?php
        while($row = mysqli_fetch_array($result)) {
        ?>
           <tr>
              <td>
                <a href="?link=<?php echo $row["email"];?>" name="link">
                  <i class="fa fa-times" aria-hidden="true"></i>
                </a>
              </td>
              <td>
                <?php echo $row["email"];?>
              </td>
           </tr>
           <?php
         }
         ?>
         </table>
         <?php
       } else if($result->num_rows < 1) {  /*If user does not have anyone in their contacts list, display "you have no contacts*/
         ?>
            <h2><?php echo "You have no contacts" ?></h2>
         <?php
         }
         ?>
    </div>

    <div id="right" class= "right-section"> <!--Section to add a new contact-->
      <h1>New Contact</h1>
      <form id="add_contact_form" method="post" action="emailer.php">
        <textarea id="name" name="name" class="input" placeholder="Contact Name!"></textarea>
        <textarea id="email" name="email" class="input" placeholder="Contact Email!"></textarea>
        <input type="submit" name="add" value="Add Contact" class="action-btn">
      </form>
    </div>

    <div id="right" class= "right-section"> <!--Section to send email to everyone in contacts list-->
      <h1>Compose Email</h1>
      <form id="compose_email_form" method="post" action="emailer.php">
        <textarea id="subject" name="subject" class="input" placeholder="Email subject!"></textarea>
        <textarea id="note" name="body" class="input" placeholder="Add your body here!"></textarea>
        <input type="submit" name="submit" value="Send Email!" class="action-btn">
        <input type="submit" name="logout" value="Logout!" class="action-btn">
      </form>
    </div>
  </div>


  <?php
    include 'connect.php';
    if(isset($_POST['submit'])) {
      $body=$_POST['body'];
      $subject=$_POST['subject'];
      $user = $_SESSION["name"];
      $user_id = $_SESSION["user_id"];
      $sql = "SELECT * FROM emails WHERE user_id = '$user_id'";
      $result = $conn->query($sql);
      while($row = mysqli_fetch_array($result)){
          $email = $row["email"];
          mail($email,$subject,$body,'From:myemail@gmail.com');
      }
    }
    $user = $_SESSION["name"];
    $user_id = $_SESSION["user_id"];

      if(isset($_POST['add'])) {
        $contact_name=$_POST['name'];
        $contact_email=$_POST['email'];
        //$date = date("Y/m/d");

        $contact_name = mysqli_real_escape_string($conn, $contact_name);
        $contact_email = mysqli_real_escape_string($conn, $contact_email);

        $sql = "INSERT INTO emails (user_id, name, email) VALUES ('$user_id','$contact_name','$contact_email')";
        if ($conn->query($sql) === TRUE) {
          header('Location: emailer.php');

        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      }
      if(isset($_GET['link'])) {
          $link = $_GET['link'];
          $var = $row["contact_email"];
          $sql = "DELETE FROM emails WHERE `email` = '$link'";
          if ($conn->query($sql) === TRUE) {
            header('Location: emailer.php');
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
      }
      if(isset($_POST['logout'])) {
        session_destroy();
        $_SESSION = array();
        header('Location: index.php');
      }
  ?>

</body>
</html>
