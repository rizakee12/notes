<?php
include('includes/session.php');
include('includes/config.php');

// Check if note ID is provided in the URL
if(isset($_GET['edit'])) {
    $note_id = $_GET['edit'];

    // Fetch note data from the database
    $query = "SELECT * FROM notes WHERE note_id = $note_id AND user_id = $session_id";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1) {
        $note = mysqli_fetch_assoc($result);

        // Handle form submission
        if(isset($_POST['submit'])) {
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $content = mysqli_real_escape_string($conn, $_POST['content']);

            // Update the note in the database
            $update_query = "UPDATE notes SET title = '$title', note = '$content' WHERE note_id = $note_id";
            if(mysqli_query($conn, $update_query)) {
                $update_message = "Note updated successfully";
            } else {
                $update_error = 'Error updating note: ' . mysqli_error($conn);
            }
        }
    } else {
        $update_error = "Note not found";
    }
} else {
    // Redirect if note ID is not provided in the URL
    header("Location: notebook.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Note</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f0f0;
            padding-top: 20px;
            padding-bottom: 20px;
            background-image: url("q2.png");
            background-size: cover; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 600px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            background-image: url("q7.png");
            background-size: cover; 
        }

        h2 {
            margin-bottom: 20px;
            color: white;
            text-align: center;
        }

        .form-label {
            font-weight: bold;
            color: white;
        }

        textarea {
            resize: vertical;
        }

        .btn-primary {
            margin-right: 10px;
        }

        .success-message {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: hsl(228deg 11.63% 8.43%);
            padding: 10px 0;
            text-align: center;
            color: white;
            font-weight: bold;
            z-index: 9999;
        }
    </style>
</head>
<body>
    <?php if(isset($update_message)): ?>
        <div class="success-message"><?php echo $update_message; ?></div>
    <?php endif; ?>

    <div class="container">
        <h2 class="control-label" style="font-size: 40px;">Edit Note</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="title" class="form-label" style="font-size: 18px;">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $note['title']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label" style="font-size: 18px;">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" required><?php echo $note['note']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Update</button>
            <a href="notebook.php" class="btn btn-secondary">Back</a>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
