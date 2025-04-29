<?php
session_start();
include("connection.php");

$errorMessage = ""; // Avoid undefined variable

// Hardcoded admin credentials
$adminEmail = "admin@example.com";
$adminPassword = "admin123";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Admin login (case-insensitive)
    if (strtolower($email) === strtolower($adminEmail) && $password === $adminPassword) {
        $_SESSION['email'] = $adminEmail;
        $_SESSION['usertype'] = 'ADMIN';

        echo "<script>alert('Admin login successful!'); window.location.href = 'admin_dashboard.php';</script>";
        exit();
    }

    // User login from DB
    $stmt = $conn->prepare("SELECT * FROM login WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (strtolower($row['Status']) !== 'active') {
            $errorMessage = "Your account is not active. Please contact the administrator.";
        } elseif (password_verify($password, $row['Password'])) {
            $_SESSION['email'] = $row['Email'];
            $_SESSION['Pid'] = $row['Pid'];
            $_SESSION['usertype'] = $row['Usertype'];

            $usertype = strtolower($row['Usertype']);

            if ($usertype === 'citizen') {
                echo "<script>alert('Login successful!'); window.location.href = 'Citizen_home.php';</script>";
                exit();
            } elseif ($usertype === 'police_officer') {
                echo "<script>alert('Login successful!'); window.location.href = 'mentor_home_page.php';</script>";
                exit();
            } else {
                $errorMessage = "Unknown user type. Please contact support.";
            }
        } else {
            $errorMessage = "Invalid password.";
        }
    } else {
        $errorMessage = "Invalid email address.";
    }
}

include("Nav.php");
?>

<div class="container text-center mt-5">
    <div class="row">
        <div class="col mb-5">
            <img src="../images/image 17.png" alt="" class="img-fluid">
        </div>

        <div class="col">
            <form action="" method="post">
                <div class="row mb-3">
                    <div class="col">
                        <label class="float-start">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label class="float-start">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <button class="btn btn-primary w-100" type="submit" name="login">Login</button>
                    </div>
                </div>
            </form>

            <?php if (!empty($errorMessage)): ?>
                <span class="text-danger"><?= $errorMessage ?></span>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include("Footer.php") ?>
