<?php
// Include database connection file
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form was submitted, process the data here
    $title = $_POST["title"];
    $artist = $_POST["artist"];
    $rating = $_POST["rating"];
    $songID = urldecode($_GET['id']);

    // Validate the form data
    // ...

    // Update the song details in the database
    $updateQuery = "UPDATE songs SET title = '$title', artist = '$artist', rating = '$rating' WHERE id = '$songID'";

    if (mysqli_query($conn, $updateQuery)) {
        echo "Song updated successfully.";
    } else {
        echo "Error updating song: " . mysqli_error($conn);
    }
}

// Fetch the song details for the form
$songID = $_GET['id'];
$query = "SELECT * FROM songs WHERE id = $songID";
$result = mysqli_query($conn, $query);
$songDetails = mysqli_fetch_assoc($result);
?>

<!-- HTML form for updating song details -->
<form method="POST" action="update_song.php">
    <input type="hidden" name="song_id" value="<?php echo $songDetails['id']; ?>">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" value="<?php echo $songDetails['title']; ?>" required><br><br>

    <label for="artist">Artist:</label>
    <input type="text" id="artist" name="artist" value="<?php echo $songDetails['artist']; ?>" required><br><br>

    <label for="rating">Rating (1-5):</label>
    <input type="number" id="rating" name="rating" value="<?php echo $songDetails['rating']; ?>" min="1" max="5"
        required><br><br>

    <input type="submit" value="Update Song">
</form>