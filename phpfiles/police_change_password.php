<?php
include("connection.php");




if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Step 1: Validate that the new and confirm password match
    if ($new_password !== $confirm_password) {
        echo "<script>alert('New and Confirm Password do not match.');</script>";
        exit();
    }

    // Step 2: Check if email matches the one in the database
    $query = "SELECT * FROM login WHERE PId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $station_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Check if email from form matches the one in the database
        if ($row['Email'] === $email) {
            // Step 3: Hash the new password before updating
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            // Step 4: Update password with the hashed password
            $update = "UPDATE login SET Password = ? WHERE PId = ? AND Usertype = 'Police_officer'";
            $update_stmt = $conn->prepare($update);
            $update_stmt->bind_param("si", $hashed_password, $station_id);

            if ($update_stmt->execute()) {
                echo "<script>alert('Password updated successfully.'); window.location.href='police_home.php';</script>";
            } else {
                // Check for SQL errors
                echo "<script>alert('Error updating password: " . $update_stmt->error . "');</script>";
            }
        } else {
            echo "<script>alert('Email does not match your registered email.');</script>";
        }
    } else {
        echo "<script>alert('User not found.');</script>";
    }

    $stmt->close();
    $conn->close();
}
include("police_nav.php");
?>

<!-- The HTML form remains the same -->
<div class="container mt-5 cont">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg rounded">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Change Password</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Email</label>
                            <input type="email" class="form-control" id="current_password" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
