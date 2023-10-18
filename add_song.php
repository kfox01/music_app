<?php

//Include database connection file
include 'connection.php'


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $rating = $_POST['rating'];
    $user = $_SESSION["username"];

//If not all field are filled out, echo an error.
    if (empty($title) || empty($artist) || empty($rating)) {
        echo "All fields are required.";

//If ratings arent between the parameters i.e. between 1 and 5 , echo an error
    } elseif (!is_numeric($rating) || $rating < 1 || $rating > 5) {
        echo "Invalid rating. Please enter a number between 1 and 5.";
    } else {
//Check if the song has already been inputed by the user
        $checkQuery = "SELECT * FROM ratings WHERE title = '$title' AND user = '$user'";
        $checkResult = mysqli_query($conn, $checkQuery);
        $checkRows = mysqli_num_rows($checkResult);

//If the song has already been inputed by the user echo an error, if it hasn't then add the song to the database.     
        if ($checkRows == 0) {
            $insertQuery = "INSERT INTO ratings (user, title, artist, rating) VALUES ('$user', '$title', '$artist', '$rating')";
            if (mysqli_query($conn, $insertQuery)) {
                echo "Song added successfully.";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "This song already exists in the database for this user.";
        }
    }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Song</title>
</head>
<body>
    <h1>Add a New Song</h1>
    <form method="POST" action="">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>

        <label for="artist">Artist:</label>
        <input type="text" id="artist" name="artist" required><br><br>

        <label for="rating">Rating (1-5):</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required><br><br>

        <input type="submit" value="Add Song">
    </form>
</body>
</html>






