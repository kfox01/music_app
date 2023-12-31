<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
$success = false; //true when user is added
$p_error = false; //true when passwords dont match
$u_error = false; //true when username is a duplicate
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //should allow to connect to the sql since the var $conn in index.php is linking to sql
  include 'connection.php';
  //gets a username and password, as well as password confirmation
  $user = $_POST["username"];
  $pword = trim($_POST["password"]);
  $cpword = trim($_POST["confirm_password"]);
  //access the sql table users and check username duplication
  $select_query = "SELECT * from users where username = ?";
  $check_select = $conn->prepare($select_query);
  $check_select->bind_param("s", $user);
  $check_select->execute();
  $check_select->store_result();
  //When a duplicate cannot be found, must check passwords
//booleans that will be set to true with different conditions
  if ($check_select->num_rows == 0) {
    if (($pword == $cpword) and $success == false) {
      $pword_hash = password_hash($pword, PASSWORD_BCRYPT);
      //entering user into table after checks
      $insert_query = "INSERT INTO `users` (`username`, `password`) VALUES (?, ?)";
      $check_insert = $conn->prepare($insert_query);
      $check_insert->bind_param("ss", $user, $pword_hash);
      if ($check_insert->execute()) {
        $success = true; //user added
        //echo "Successful submission";
      }
    } else {
      $p_error = true; //password check failure
    }
  }
  if ($check > 1) {
    $u_error = true;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration</title>
</head>

<body>
  <?php

  if ($success) {
    echo "Account created, you can now continue to login page";
    header('login.php');
  }

  if ($p_error) {
    echo "Error, passwords dont match";
  }

  if ($u_error) {
    echo "Error, username is taken";
  }

  ?>

  <div class="container">
    <a href="login.php">
      <button>Log In</button>
    </a>
    <h3>REGISTER HERE<h3>
        <form action="registration.php" method="post">
          <!-- username entry -->
          <div class="entries">
            <label for="username">username</label>
            <input type="text" class="form-control" id="username" name="username">
          </div>
          <!-- password entry -->
          <div class="entries">
            <label for="password">password</label>
            <!-- should hide the password while inputting for security -->
            <input type="password" class="form-control" id="password" name="password">
          </div>
          <!-- confirm password entry -->
          <div class="entries">
            <label for="confirm_password">confirm password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
          </div>
          <button type="submit" class="submit_button">REGISTER</button>
        </form>
  </div>
</body>

</html>