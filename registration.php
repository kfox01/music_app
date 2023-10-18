<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //should allow to connect to the sql since the var $conn in index.php is linking to sql
  include 'connection.php';
  //gets a username and password, as well as password confirmation
  $user = $_POST["username"];
  $pword = $_POST["password"];
  $cpword = $_POST["confirm password"];
  //access the sql table users and check username duplication
  $check_1 = "SELECT * from users where username = '$user'";
  $check_2 = mysqli_query($conn, $check_1);
  $check_3 = mysqli_num_rows($check_2);
  //When a duplicate cannot be found, must check passwords
//booleans that will be set to true with different conditions
  $success = false; //true when user is added
  $p_error = false; //true when passwords dont match
  $u_error = false; //true when username is a duplicate
  if ($check_3 == 0) {
    if ($pword == $cpword) {
      $pword_hash = password_hash($pword, PASSWORD_BCRYPT);
      //entering user into table after checks
      $enter_user = "INSERT INTO 'users' ('username', 'password') VALUES ('$user', '$pword_hash')";
      $result = mysqli_query($conn, $enter_user);
      if ($result) {
        $success = true; //user added
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

    echo ' <div class="success" role="alert"> 
        <strong>Success!</strong> Your account is  
        now created and you can login.  
        <button type="button" class="close"
            data-dismiss="alert" aria-label="Close">  
            <span aria-hidden="true">x</span>  
        </button>  
    </div> ';
  }

  if ($p_error) {

    echo ' <div class="wrong password" role="alert">  
    <strong>Error! Passwords dont match</strong>

   <button type="button" class="close" 
        data-dismiss="alert aria-label="Close"> 
        <span aria-hidden="true">x</span>  
   </button>  
 </div> ';
  }

  if ($u_error) {
    echo ' <div class="duplicate username" role="alert"> 

    <strong>Error! Username is taken</strong> 
    <button type="button" class="close" 
        data-dismiss="alert" aria-label="Close">  
        <span aria-hidden="true">x</span>  
    </button> 
   </div> ';
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
            <label for="confirm password">confirm password</label>
            <input type="password" class="form-control" id="password" name="password">
          </div>
          <button type="submit" class="submit_button">REGISTER</button>
        </form>
  </div>
</body>

</html>