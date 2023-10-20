<?php
// Start the session to manage logged-in state
session_start();

include 'connection.php';

// Fetch songs
$result = $conn->query("SELECT * FROM ratings");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Music App - Home</title>
</head>

<body>
    <h1>Welcome to Music App</h1>

    <?php
    $user_current = $_SESSION['username'];
    if (isset($user_current)) {
        echo "<p>Logged in as: " . $user_current . "</p>";
        // echo '<a href="logout.php">Logout</a>';
    } else {
        header("Location: login.php");
    }
    ?>

    <h2>All Songs</h2>
    <table border="1">
        <tr>
            <th>Artist</th>
            <th>Song</th>
            <th>Rating</th>
            <th>Actions</th>
        </tr>
        <?php
        while ($song = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $song['title'] . "</td>";
            echo "<td>" . $song['artist'] . "</td>";
            echo "<td>" . $song['rating'] . "</td>";
            echo "<td>";
            if (isset($_SESSION['username']) && $_SESSION['username'] == $song['user']) {
                echo '<a href="edit.php?id=' . $song['id'] . '">Edit</a> | ';
                echo '<a href="delete.php?id=' . $song['id'] . '">Delete</a>';
            }
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <?php if (isset($_SESSION['username'])): ?>
        <a href="add_song.php?username=<?php echo urlencode($user_current); ?>">Add New Song</a>
    <?php endif; ?>

</body>

</html>