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
    if (isset($_SESSION['username'])) {
        echo "<p>Logged in as: " . $_SESSION['username'] . "</p>";
        // echo '<a href="logout.php">Logout</a>';
    } else {
        echo '<a href="registration.php">Register</a> | ';
        echo '<a href="login.php">Login</a>';
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
            echo "<td>" . $song['artist'] . "</td>";
            echo "<td>" . $song['song'] . "</td>";
            echo "<td>" . $song['rating'] . "</td>";
            echo "<td>";
            if (isset($_SESSION['username']) && $_SESSION['username'] == $song['username']) {
                echo '<a href="edit.php?id=' . $song['id'] . '">Edit</a> | ';
                echo '<a href="delete.php?id=' . $song['id'] . '">Delete</a>';
            }
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <?php if (isset($_SESSION['username'])): ?>
        <a href="add_song.php">Add New Song</a>
    <?php endif; ?>

</body>

</html>