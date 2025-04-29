<?php
include("police_nav.php");
include("connection.php"); // Ensure DB connection

// Get Complaint ID (cmId)
if (isset($_GET['id'])) {
    $Id = (int) $_GET['id']; // Safe cast to integer
} else {
    die("No Complaint ID provided.");
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = date('Y-m-d'); // Current date

    // Handle file upload
    if (isset($_FILES['proof']) && $_FILES['proof']['error'] == 0) {
        $targetDir = "../uploads/";
        $fileName = basename($_FILES["proof"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow only certain file formats
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array(strtolower($fileType), $allowedTypes)) {
            // Move the file to uploads folder
            if (move_uploaded_file($_FILES["proof"]["tmp_name"], $targetFilePath)) {
                // Insert into completed_crime table
                $sql = "INSERT INTO completed_crime (cmId, title, description, proof, Date)
                        VALUES ('$Id', '$title', '$description', '$targetFilePath', '$date')";

                if ($conn->query($sql) === TRUE) {
                    // Update Complete_Status to 1 in add_complaints table
                    $updateSql = "UPDATE add_complaints SET Complete_Status = 1 WHERE ID = '$Id'";

                    if ($conn->query($updateSql) === TRUE) {
                        // Success: Redirect to the police view cases page
                        echo "<script>
                            alert('Record inserted and case marked as completed!');
                            window.location.href = 'police_view_cases.php';
                        </script>";
                        exit();
                    } else {
                        echo "<script>alert('Error updating Complete_Status: " . $conn->error . "');</script>";
                    }
                } else {
                    echo "<script>alert('Database Error: " . $conn->error . "');</script>";
                }
            } else {
                echo "<script>alert('Failed to upload file.');</script>";
            }
        } else {
            echo "<script>alert('Only JPG, JPEG, PNG, and GIF files are allowed.');</script>";
        }
    } else {
        echo "<script>alert('Please upload a valid proof image.');</script>";
    }
}
?>

<!-- HTML Form to Add Completed Crime -->
<div class="container mt-5">
    <h2 class="text-center mb-4">Add Completed Crime Details</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea name="description" id="description" class="form-control" rows="5" required></textarea>
        </div>

        <div class="mb-3">
            <label for="proof" class="form-label">Proof (Image Upload):</label>
            <input type="file" name="proof" id="proof" class="form-control" accept="image/*" required>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
