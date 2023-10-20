<?php

include 'connection.php';
$id = urldecode($_GET['id']);
$delete_query = "DELETE FROM ratings WHERE id = ?";
$check_delete = $conn->prepare($delete_query);
$check_delete->bind_param("i", $id);


if ($check_delete->execute()) {
  echo "Row deleted successfully.";
  header("Location: index.php");
} else {
  echo "Error deleting row: " . mysqli_error($conn);
}
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>

</body>

</html>