<?php
// Start the session to manage logged-in state
session_start();

// Database connection. Adjust parameters accordingly.
$host = 'localhost';
$db   = 'music_db';
$user = 'root'; // Default XAMPP user
$pass = '';     // No password by default in XAMPP
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$pdo = new PDO($dsn, $user, $pass);

// Fetch songs
$query = $pdo->query("SELECT * FROM ratings");
$songs = $query->fetchAll(PDO::FETCH_ASSOC);
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
        echo '<a href="logout.php">Logout</a>';
    } else {
        echo '<a href="register.php">Register</a> | ';
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
        foreach ($songs as $song) {
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
