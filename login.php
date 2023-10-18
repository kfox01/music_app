<?php
$success = false;
$p_error = false;
$u_error = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include 'connection.php';
  $user = $_POST["username"];
  $entered_pword = trim($_POST["password"]);
  $check_1 = "SELECT * from users where username='$user'";
  $check_2 = mysqli_query($conn, $check_1);
  $check_3 = mysqli_num_rows($check_2);
  if ($check_3 == 1) {
    $get_entry = mysqli_fetch_assoc($check_2);
    $stored_pword = $get_entry['password'];
    if (password_verify($entered_pword, $stored_pword)) {
      $success = true;
    } else {
      $p_error = true;
    }
  } else {
    $u_error = true;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
</head>

<body>
  <?php
  if ($success) {
    echo "Welcome '$user";
  }
  if ($p_error) {
    echo "Error, incorrect password entered";
  }
  if ($u_error) {
    echo "Error, entered username does not exist";
  }
  ?>

  <div class="container">
    <a href="registration.php">
      <button>Register</button>
    </a>
    <h3>LOGIN<h3>
        <form action="login.php" method="post">
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
          <button type="submit" class="submit_button">REGISTER</button>
        </form>
  </div>
</body>

</html>