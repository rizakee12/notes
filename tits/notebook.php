<?php
include('includes/session.php');
include('includes/config.php');

if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    $sql = "DELETE FROM notes where note_id = $delete";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        // No need for alert, redirect directly
        header("Location: notebook.php");
        exit(); // Prevent further execution
    }
}

if(isset($_POST['submit'])){
    $title=mysqli_real_escape_string($conn,$_POST['title']);
    $note=mysqli_real_escape_string($conn,$_POST['note']);

    date_default_timezone_set("Africa/Accra");
    $time_now = date("h:i:sa");

    // make sql query
    $query = "INSERT INTO notes(user_id,title,note,time_in) VALUES('$session_id','$title','$note','$time_now')";

    if(mysqli_query($conn, $query)){
        // No need for alert, redirect directly
        header("Location: notebook.php");
        exit(); // Prevent further execution
    }else{
        //failure
        echo 'query error: '. mysqli_error($conn);
    }
}

$query = "SELECT note_id,title,note,time_in FROM notes WHERE user_id = $session_id ";

if(mysqli_query($conn, $query)){
    // get the query result
    $result = mysqli_query($conn, $query);

    // fetch result in array format
    $notesArray= mysqli_fetch_all($result , MYSQLI_ASSOC);
}else{
    //failure
    echo 'query error: '. mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html lang="en" class="app">
<head>
    <meta charset="utf-8" />
    <title>User Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-image: url("q2.png");
            background-size: cover; 
        }

        .sidebar {
            background-color: #007bff;
            color: #fff;
            height: 100vh;
            padding: auto;
            background-image: url("q2.png");
            border: 2px solid black; /* Add border */
            background-size: cover; 
        }

        .sidebar a {
            color: #fff;
            display: block;
            margin-bottom: 10px;
        }

        .sidebar a:hover {
            text-decoration: none;
            color: #ccc;
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
            width: 31%; /* Set width for better layout */
            position: relative; /* Add this to position the favorite icon */
        }
        .note-card:hover {
    transform: translateY(-5px); /* Add slight elevation on hover */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); /* Enhance box shadow on hover */
}
        @media (max-width: 768px) {
            .note-card {
                width: 48%;
            }
        }

        @media (max-width: 576px) {.note-card {
                width: 100%;
            }
        }

        .note-card:hover {
            background-color: #f0f0f0;
        }

        .note-card h3 {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 30px; /* Increase margin-bottom for more space */
        }

        .note-card p {
            color: #666;
            margin-bottom: 30px;
            font-size: 21px;
        }
        .note-card .btn-group button.edit-btn {
    color: #007bff; /* Change color for edit button */
    border-color: #007bff; /* Change border color for edit button */
}

.note-card .btn-group button.edit-btn:hover {
    color: #0056b3; /* Darken text color on hover */
    border-color: #0056b3; /* Darken border color on hover */
}

.note-card .btn-group button.delete-btn {
    color: #dc3545; /* Change color for delete button */
    border-color: #dc3545; /* Change border color for delete button */
}

.note-card .btn-group button.delete-btn:hover {
    color: #bb2d3b; /* Darken text color on hover */
    border-color: #bb2d3b; /* Darken border color on hover */
}

.note-card .btn-group button.archive-btn {
    color: #ffc107; /* Change color for archive button */
    border-color: #ffc107; /* Change border color for archive button */
}

.note-card .btn-group button.archive-btn:hover {
    color: #e0a800; /* Darken text color on hover */
    border-color: #e0a800; /* Darken border color on hover */
}

.note-card .btn-group {
    position: auto;
    top: auto;
    right: auto;
}
.note-card .btn-group button.favorite-btn {
    color: #ffc107; /* Change color for favorite button */
    border-color: #ffc107; /* Change border color for favorite button */
    border-radius: 50%; /* Make the button round */
    padding: 5px; /* Adjust padding for better appearance */
}

.note-card .btn-group button.favorite-btn:hover {
    color: #e0a800; /* Darken text color on hover */
    border-color: #e0a800; /* Darken border color on hover */
}


    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
                <div class="container py-4">
                    <!-- Sidebar Menu -->
                    <h3 class="my-4">Notes</h3>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">All Notes</a>
                        </li>
                        <li class="nav-item">
    <a class="nav-link" href="favorites.php">Favorites</a>
</li>
                        <li class="nav-item">
    <a class="nav-link" href="archives.php">Archives</a>
</li>
                <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li><br>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Add Your Note</a>
                        </li>
                    </ul>
                    <!-- Add Note Form -->
                    <form method="POST">
                        <div class="input-box">
                            <input name="title" type="text" placeholder="Enter Title" class="input-sm form-control">
                        </div><br>
                        <div class="input-box">
                            <textarea name="note" class="form-control note-text-box" rows="8" data-minwords="8" data-required="true" placeholder="Enter Note ..."></textarea>
                        </div><br><br>
                        <div class="m-t-lg"><button class="btn btn-sm btn-primary" name="submit" type="submit">Add Note</button></div>
                    </form>
                </div>
            </div>
            <!-- Main Content -->
            <div class="col-md-9">
    <section class="text-center">
        <div class="container">
            <h1 class="text-center my-4"style="font-size: 45px; color: white;">All Notes</h1>
            <div class="note-box">
                <?php foreach($notesArray as $index => $note): ?>
                    <div class="note-card <?php echo ($index % 2 == 0) ? 'float-start' : 'float-end'; ?>">
                        <h3><?php echo $note['title'] ?></h3>
                        <p><?php echo substr($note['note'], 0, 200)?></p>
                       
                        <div class="btn-group">
    <a href="edit_note.php?edit=<?php echo $note['note_id'];?>" class="btn btn-sm btn-secondary edit-btn" title="Edit"><i class="fas fa-edit"></i></a>
    <a href="notebook.php?delete=<?php echo $note['note_id'];?>" class="btn btn-sm btn-danger delete-btn" title="Delete"><i class="fas fa-trash-alt"></i></a>
    <a href="notebook.php?archive=<?php echo $note['note_id']; ?>" class="btn btn-sm btn-warning archive-btn" title="Archive"><i class="fas fa-archive"></i></a>
    <a href="notebook.php?favorite=<?php echo $note['note_id']; ?>" class="btn btn-sm btn-primary favorite-btn" title="Favorites"><i class="fas fa-star"></i></a>
    <small class="block text-muted"><i class="fa fa-clock-o"></i> <?php echo $note['time_in'] ?></small>
</div>

                      
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.2.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>