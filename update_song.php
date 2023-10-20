<?php

// Include database connection file
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form was submitted, process the data here
    $title = $_POST["title"];
    $artist = $_POST["artist"];
    $rating = $_POST["rating"];
    $songID = isset($_POST['song_id']) ? (int) $_POST['song_id'] : null;

    // Check if the songID is valid (non-null and positive integer)
    if (!$songID || $songID <= 0) {
        echo "Invalid song ID.";
    } else {
        $updateQuery = "UPDATE ratings SET title = ?, artist = ?, rating = ? WHERE id = ?";
        //used chatGPT to discover this preparation tactic which fixed our error
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssii", $title, $artist, $rating, $songID);

        if ($stmt->execute()) {
            echo "Song updated successfully.";
            header("Location: index.php");
            exit();
        } else {
            echo "Error updating song: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Fetch the song details for the form
$songID = isset($_GET['id']) ? (int) $_GET['id'] : null;

if ($songID && $songID > 0) {
    $query = "SELECT * FROM ratings WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $songID);
    $stmt->execute();
    $result = $stmt->get_result();
    $songDetails = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "Invalid song ID.";
}
?>

<!-- HTML form for updating song details -->
<form action="update_song.php" method="post">
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