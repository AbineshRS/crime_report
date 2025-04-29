<?php
session_start();
include("connection.php");

$errorMessage = "";
$emailError = "";
$passwordError = "";

$adminEmail = "admin@crime.com";
$adminPassword = "admin123";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (strtolower($email) === strtolower($adminEmail) && $password === $adminPassword) {
        $_SESSION['email'] = $adminEmail;
        $_SESSION['usertype'] = 'ADMIN';
        echo "<script>alert('Admin login successful!'); window.location.href = 'admin_dashboard.php';</script>";
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM login WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // If status is inactive
        if (strtolower($row['Status']) !== 'active') {
            $errorMessage = "Your account is not active. Please contact the administrator.";
            echo "<script>alert('$errorMessage');</script>";  // Show error in alert box
        } elseif (password_verify($password, $row['Password'])) {
            $_SESSION['email'] = $row['Email'];
            $_SESSION['Pid'] = $row['PId'];
            $_SESSION['usertype'] = $row['Usertype'];

            $usertype = strtolower($row['Usertype']);

            if ($usertype === 'citizen') {
                echo "<script>alert('Login successful!'); window.location.href = 'Citizen_home.php';</script>";
                exit();
            } elseif ($usertype === 'police_officer') {
                echo "<script>alert('Login successful!'); window.location.href = 'police_home.php';</script>";
                exit();
            } else {
                $errorMessage = "Unknown user type. Please contact support.";
                echo "<script>alert('$errorMessage');</script>";  // Show error in alert box
            }
        } else {
            // If password is wrong, show error in password field
            $passwordError = "Invalid password.";
        }
    } else {
        // If email is incorrect, show error under the email field
        $emailError = "Invalid email address.";
    }
}

include("Nav.php");
?>

<!-- Responsive Login Form -->
<div class="container mt-5 cont">
    <div class="row justify-content-center align-items-center">
        <!-- Image Section -->
        <div class="col-lg-6 mb-4 text-center">
            <img src="../images/image 17.png" alt="Login" class="img-fluid w-75">
        </div>

        <!-- Form Section -->
        <div class="col-lg-5">
            <div class="card shadow-lg p-4 rounded-3">
                <h4 class="mb-4 text-center">Login</h4>
                <form method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label float-start">Email</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                        <?php if (!empty($emailError)): ?>
                            <span class="text-danger"><?= $emailError ?></span> <!-- Show error below the email input -->
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label float-start">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                        <?php if (!empty($passwordError)): ?>
                            <span class="text-danger"><?= $passwordError ?></span> <!-- Show error below the password input -->
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-primary w-100" type="submit" name="login">Login</button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <p>New user? <a href="Citizen_register.php">Register here</a></p>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include("Footer.php") ?>
