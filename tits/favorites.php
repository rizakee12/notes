<?php
include('includes/session.php');
include('includes/config.php');

// Handle delete request if any
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    $sql = "DELETE FROM favorites WHERE favorite_id = $delete"; // Update table name to "favorites"
    $result = mysqli_query($conn, $sql);
    if ($result) {
        // No need for alert, redirect directly
        header("Location: favorites.php"); // Update to "favorites.php"
        exit(); // Prevent further execution
    }
}

// Fetch favorite notes
$query = "SELECT favorite_id, title, note, favorited_at FROM favorites WHERE user_id = '$session_id'"; // Update table name to "favorites" and remove the escape for $session_id

if(mysqli_query($conn, $query)){
    // Get the query result
    $result = mysqli_query($conn, $query);

    // Fetch result in array format
    $notesArray = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    // Failure
    echo 'Query error: '. mysqli_error($conn);
}
?>

<<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorites</title> <!-- Update title to "Favorites" -->
    <style>
         /* Your existing CSS styles */
         body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: hsl(0deg 0% 1.96%); /* Background color specified */
        }

        .container {
            flex: 1;
            max-width: 2000px;
            margin-left: 120px; /* Adjust margin to accommodate expanded sidebar */
            margin-top: 10px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            background-image: url("a4.png");
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #fff; /* Set text color to white */
        }

        .note {
            background-color: #f9f9f9;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .note h3 {
            margin-top: 0;
            color: #000; /* Set archive text color to black */
        }

        .note p {
            color: #666;
        }

        .note .note-actions {
            margin-top: 10px;
        }

        .note .note-actions a {
            text-decoration: none;
            color: #007bff;
            margin-right: 10px;
        }

        .note .note-actions a:hover {
            text-decoration: underline;
        }

        .note .time {
            color: #999;
            font-size: 12px;
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 200px; /* Expanded width of the sidebar */
            background-color: hsl(0deg 0% 1.96%);
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px;
            margin-right: 20px; /* Add margin to the right */
        }

        .back-button {
            margin-top: auto; /* Push the button to the bottom */
            text-align: center;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        .nav-item {
            margin-bottom: 10px;
        }

        .nav-link {
            color: #fff;
            text-decoration: none;
        }

        .nav-link:hover {
            text-decoration: underline;
        }
        
    </style>
</head>
<body>
    <div class="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item">
            <a class="nav-link" href="notebook.php">All notes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="favorites.php">Favorites</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="archives.php">Archives</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
            <br>
        </ul>
        <!-- Back button -->
        <a href="javascript:history.back()" class="back-button">Back</a>
    </div>
    <div class="container">
        <h1>Favoritess</h1>
        <?php foreach($notesArray as $note): ?>
        <div class="note">
            <h3><?php echo $note['title'] ?></h3>
            <p><?php echo substr($note['note'], 0, 200) ?></p>
            <div class="note-actions">
                <a href="#">Archive</a>
                <a href="#">Favorite</a>
                <span class="time"><?php echo $note['archived_at'] ?></span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
