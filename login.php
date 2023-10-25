<?php
$success = false;
$p_error = false;
$u_error = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include 'connection.php';
  $user = $_POST["username"];
  $entered_pword = trim($_POST["password"]);

  $select_query = "SELECT * from users where username = ?";
  $check_select = $conn->prepare($select_query);
  $check_select->bind_param("s", $user);
  $check_select->execute();
  $check_select->store_result();

  if ($check_select->num_rows == 1) {
    //$get_entry = mysqli_fetch_assoc($check_select);
    //$stored_pword = $get_entry['password'];
    $check_select->bind_result($username, $stored_pword); // Bind the result columns
    $check_select->fetch(); // Fetch the result
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
    session_start();
    $_SESSION['username'] = $user;
    header("Location: index.php");
    exit();
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