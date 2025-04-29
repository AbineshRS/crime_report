<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Citizen Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
</head>

<body>

    <?php include("Nav.php") ?>

    <div class="container text-center mt-5">
        <div class="row mt-5">
            <div class="col-12 col-md-5 mb-5">
                <img src="../images/citizenreg 1.png" alt="Citizen Registration" class="img-fluid">
            </div>
            <div class="col-12 col-md-7">
                <form action="" method="post" novalidate>
                    <?php
                    include("connection.php");

                    $email_error = "";
                    $alert_message = "";
                    $alert_type = "";

                    if (isset($_POST['submit'])) {
                        $Name = $_POST['Name'];
                        $Contact = $_POST['Contact'];
                        $Gender = $_POST['Gender'];
                        $DOB = $_POST['DOB'];
                        $District = $_POST['District'];
                        $Address = $_POST['Address'];
                        $Aadhar = $_POST['Aadhar'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $Confirm_Password = $_POST['Confirm_Password'];
                        $user_type = "Citizen";
                        $Status = 0;

                        // Server-side validations
                        if (!preg_match("/^\d{14}$/", $Aadhar)) {
                            $alert_message = "Aadhar number must be exactly 14 digits.";
                            $alert_type = "danger";
                        } elseif (!preg_match("/^\d{10}$/", $Contact)) {
                            $alert_message = "Contact number must be exactly 10 digits.";
                            $alert_type = "danger";
                        } elseif ($password !== $Confirm_Password) {
                            $alert_message = "Passwords do not match!";
                            $alert_type = "danger";
                        } else {
                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                            $check = "SELECT * FROM login WHERE Email='$email'";
                            $result = $conn->query($check);

                            if ($result->num_rows > 0) {
                                $email_error = "Email already exists.";
                            } else {
                                $sql = "INSERT INTO `citizen` (`Name`, `Contact`, `Gender`, `DOB`, `District`, `Address`, `Aadhar`) 
                                    VALUES ('$Name', '$Contact', '$Gender', '$DOB', '$District', '$Address', '$Aadhar')";

                                if ($conn->query($sql) === TRUE) {
                                    $last_id = $conn->insert_id;
                                    $login = "INSERT INTO `login`(`PId`,`Email`,`Password`,`Status`,`Usertype`)
                                          VALUES ('$last_id', '$email', '$hashed_password', 'active', '$user_type')";
                                    if ($conn->query($login) === TRUE) {
                                        $alert_message = "Registration successful!";
                                        $alert_type = "success";

                                        // Redirect to login page after 2 seconds
                                        echo "<script>
                                            alert('Registration successful! Redirecting to login page...');
                                            window.location.href = 'Login.php';
                                        </script>";
                                        exit(); // Always use exit after header or JS redirect
                                    } else {
                                        $alert_message = "Login insert failed: " . $conn->error;
                                        $alert_type = "danger";
                                    }

                                } else {
                                    $alert_message = "Register insert failed: " . $conn->error;
                                    $alert_type = "danger";
                                }
                            }
                        }

                        if (!empty($alert_message)) {
                            echo '<div class="alert alert-' . $alert_type . ' alert-dismissible fade show" role="alert">
                                ' . $alert_message . '
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                        }
                    }
                    ?>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="float-start">Name</label>
                            <input type="text" name="Name" id="name" class="form-control" required>
                            <span class="text-danger small" id="name-error"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="float-start">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                            <span class="text-danger small" id="email-error"><?php echo $email_error; ?></span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="contact" class="float-start">Contact</label>
                            <input type="number" name="Contact" id="contact" class="form-control" required>
                            <span class="text-danger small" id="contact-error"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="gender" class="float-start">Gender</label>
                            <select class="form-select" name="Gender" required>
                                <option selected disabled>select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Trans-gender">Trans-gender</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="dob" class="float-start">DOB</label>
                            <input type="date" name="DOB" id="dob" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="district" class="float-start">District</label>
                            <select name="District" id="district" class="form-select" required>
                                <option disabled selected>Select District</option>
                                <option value="Alappuzha">Alappuzha</option>
                                <option value="Ernakulam">Ernakulam</option>
                                <option value="Idukki">Idukki</option>
                                <option value="Kottayam">Kottayam</option>
                                <option value="Kozhikode">Kozhikode</option>
                                <option value="Malappuram">Malappuram</option>
                                <option value="Palakkad">Palakkad</option>
                                <option value="Pathanamthitta">Pathanamthitta</option>
                                <option value="Thiruvananthapuram">Thiruvananthapuram</option>
                                <option value="Thrissur">Thrissur</option>
                                <option value="Wayanad">Wayanad</option>
                                <option value="Kannur">Kannur</option>
                                <option value="Kasargod">Kasargod</option>
                                <option value="Kollam">Kollam</option>
                                <option value="Punalur">Punalur</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="address" class="float-start">Address</label>
                            <input type="text" name="Address" id="address" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="aadhar" class="float-start">Aadhar No</label>
                            <input type="number" name="Aadhar" id="aadhar" class="form-control" required>
                            <span class="text-danger small" id="aadhar-error"></span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="float-start">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="confirm-password" class="float-start">Confirm Password</label>
                            <input type="password" name="Confirm_Password" id="confirm-password" class="form-control"
                                required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100" name="submit" id="submit-btn" disabled>Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include("Footer.php") ?>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const dobInput = document.getElementById("dob");
            const today = new Date().toISOString().split("T")[0];
            dobInput.setAttribute("max", today);

            const nameInput = document.getElementById("name");
            const contactInput = document.getElementById("contact");
            const emailInput = document.getElementById("email");
            const aadharInput = document.getElementById("aadhar");
            const submitButton = document.getElementById("submit-btn");

            // Validation logic for each input field individually
            function validateInput(event) {
                let valid = true;

                const nameRegex = /^[A-Za-z\s]+$/;
                const contactRegex = /^\d{10}$/;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                const aadharRegex = /^\d{14}$/;

                const inputId = event.target.id;

                // Name validation
                if (inputId === "name" && !nameRegex.test(nameInput.value.trim())) {
                    document.getElementById("name-error").textContent = "Name can only contain letters and spaces.";
                    valid = false;
                } else {
                    document.getElementById("name-error").textContent = "";
                }

                // Contact validation
                if (inputId === "contact" && !contactRegex.test(contactInput.value.trim())) {
                    document.getElementById("contact-error").textContent = "Contact number must be exactly 10 digits.";
                    valid = false;
                } else {
                    document.getElementById("contact-error").textContent = "";
                }

                // Email validation
                if (inputId === "email" && !emailRegex.test(emailInput.value.trim())) {
                    document.getElementById("email-error").textContent = "Please enter a valid email address.";
                    valid = false;
                } else {
                    document.getElementById("email-error").textContent = "";
                }

                // Aadhar validation
                if (inputId === "aadhar" && !aadharRegex.test(aadharInput.value.trim())) {
                    document.getElementById("aadhar-error").textContent = "Aadhar number must be exactly 14 digits.";
                    valid = false;
                } else {
                    document.getElementById("aadhar-error").textContent = "";
                }

                // Enable/disable submit button based on overall form validity
                submitButton.disabled = !valid;
            }

            // Add event listeners for each input field
            nameInput.addEventListener("input", validateInput);
            contactInput.addEventListener("input", validateInput);
            emailInput.addEventListener("input", validateInput);
            aadharInput.addEventListener("input", validateInput);
        });
    </script>

</body>

</html>
