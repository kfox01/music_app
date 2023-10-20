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
            <th>Song</th>
            <th>Artist</th>
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
            if (isset($_SESSION['username']) && $_SESSION['username'] == $song['user']) { ?>
                <a href="update_song.php?id=<?php echo urlencode($song['id']); ?>">Edit</a> |
                <a href="delete.php?id=<?php echo urlencode($song['id']); ?>">Delete</a>
            <?php }
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