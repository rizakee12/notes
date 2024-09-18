<?php
include('includes/session.php');
include('includes/config.php');

// Handle delete request if any
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    $sql = "DELETE FROM archives WHERE archive_id = $delete";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        // No need for alert, redirect directly
        header("Location: archives.php");
        exit(); // Prevent further execution
    }
}

// Handle unarchive request if any
if (isset($_GET['unarchive'])) {
    $unarchive = $_GET['unarchive'];
    $sql = "UPDATE archives SET archived = 0 WHERE archive_id = $unarchive";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        // No need for alert, redirect directly
        header("Location: archives.php");
        exit(); // Prevent further execution
    }
}

// Fetch archived notes
$query = "SELECT archive_id, title, note, archived_at FROM archives WHERE user_id = \"$session_id\"";

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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archives</title>
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
        <h1>Archives</h1>
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
          <!-- .note-box {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    align-items: flex-start; /* Ensure items start at the top */
 flex-direction: column; /* Lay out items vertically */
flex-direction: row; /* Lay out items vertically */
}

.note-card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 1px 6px rgba(0, 0, 0, 1);
    padding: 20px;
    margin-bottom: 30px; /* Increase margin-bottom for more space */
    border: 2px solid #ced4da; /* Add border */
    width: calc(31% - 20px); /* Adjust width to accommodate gap */
    position: relative; /* Add this to position the favorite icon */
}
    .note-box {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.note-card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 1px 6px rgba(0, 0, 0, 1);
    padding: 20px;
    margin-bottom: 30px; /* Increase margin-bottom for more space */
    border: 2px solid #ced4da; /* Add border */
    flex-grow: auto; /* Make the note card grow to fill available space */
    position: relative; /* Add this to position the favorite icon */
}
      <a href="notebook.php?favorite=<?php echo $note['note_id']; ?>" class="btn btn-sm btn-primary" title="Favorites"><i class="fas fa-favorites"></i></a>
-->
