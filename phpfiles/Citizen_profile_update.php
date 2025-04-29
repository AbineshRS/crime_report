
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

<?php include("Citizen_nav.php") ?>

<div class="container text-center mt-5">
    <div class="row mt-5">
        <div class="col-12 col-md-5 mb-5">
            <img src="../images/citizenreg 1.png" alt="Citizen Registration" class="img-fluid">
        </div>
        <div class="col-12 col-md-7">
            <form action="" method="post" novalidate>
                <?php
                include("connection.php");

                $Pid = $_SESSION['Pid'] ?? null;
                $station_data = [];

                // Fetch station data
                if ($Pid) {
                    $query = "SELECT * FROM citizen WHERE Id = '$Pid'";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        $data = $result->fetch_assoc();
                    }
                }
                ?>
                <?php
                if (isset($_POST['submit'])) {
                    // Get form data
                    $name = $_POST['Name'];
                    $contact = $_POST['Contact'];
                    $gender = $_POST['Gender'];
                    $dob = $_POST['DOB'];
                    $district = $_POST['District'];
                    $aadhar = $_POST['Aadhar'];
                    $address = $_POST['Address'];

                    // Update query
                    $updateQuery = "UPDATE citizen SET 
                    Name = ?, 
                    Contact = ?, 
                    Gender = ?, 
                    DOB = ?, 
                    District = ?, 
                    Aadhar = ?, 
                    Address = ? 
                    WHERE Id = ?";

                    // Prepare the statement
                    if ($stmt = $conn->prepare($updateQuery)) {
                        // Bind parameters
                        $stmt->bind_param("sssssssi", $name, $contact, $gender, $dob, $district, $aadhar, $address, $Pid);

                        // Execute the query
                        if ($stmt->execute()) {
                            echo "<script>
                            alert('Update successful!');
                            window.location.href = 'Citizen_profile_update.php'
                            </script>";
                        } else {
                            echo "<script>alert('Error updating information. Please try again.');</script>";
                        }

                        // Close the statement
                        $stmt->close();
                    } else {
                        echo "<script>alert('Error in preparing the query.');</script>";
                    }
                }
                ?>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="float-start">Name</label>
                        <input type="text" name="Name" id="name" class="form-control"
                            value="<?= $data['Name'] ?? '' ?>">
                        <span class="text-danger small" id="name-error"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="contact" class="float-start">Contact</label>
                        <input type="number" name="Contact" id="contact" class="form-control"
                            value="<?= $data['Contact'] ?? '' ?>">
                        <span class="text-danger small" id="contact-error"></span>
                    </div>
                </div>

                <div class="row mb-3">

                    <div class="col-md-6">
                        <label for="gender" class="float-start">Gender</label>
                        <select class="form-select" name="Gender" required>
                            <option disabled <?= !isset($data['Gender']) ? 'selected' : '' ?>>select</option>
                            <option value="Male" <?= (isset($data['Gender']) && $data['Gender'] == "Male") ? 'selected' : '' ?>>Male</option>
                            <option value="Female" <?= (isset($data['Gender']) && $data['Gender'] == "Female") ? 'selected' : '' ?>>Female</option>
                            <option value="Trans-gender" <?= (isset($data['Gender']) && $data['Gender'] == "Trans-gender") ? 'selected' : '' ?>>Trans-gender</option>
                        </select>

                    </div>
                    <div class="col-md-6">
                        <label for="dob" class="float-start">DOB</label>
                        <input type="date" name="DOB" id="dob" class="form-control"
                            value="<?= $data['District'] ?? '' ?>">
                    </div>
                </div>

                <div class="row mb-3">

                    <div class="col-md-6">
                        <label for="district" class="float-start">District</label>
                        <select name="District" id="district" class="form-select" required>
                            <option disabled <?= !isset($data['District']) ? 'selected' : '' ?>>Select District</option>
                            <option value="Alappuzha" <?= (isset($data['District']) && $data['District'] == "Alappuzha") ? 'selected' : '' ?>>Alappuzha</option>
                            <option value="Ernakulam" <?= (isset($data['District']) && $data['District'] == "Ernakulam") ? 'selected' : '' ?>>Ernakulam</option>
                            <option value="Idukki" <?= (isset($data['District']) && $data['District'] == "Idukki") ? 'selected' : '' ?>>Idukki</option>
                            <option value="Kottayam" <?= (isset($data['District']) && $data['District'] == "Kottayam") ? 'selected' : '' ?>>Kottayam</option>
                            <option value="Kozhikode" <?= (isset($data['District']) && $data['District'] == "Kozhikode") ? 'selected' : '' ?>>Kozhikode</option>
                            <option value="Malappuram" <?= (isset($data['District']) && $data['District'] == "Malappuram") ? 'selected' : '' ?>>Malappuram</option>
                            <option value="Palakkad" <?= (isset($data['District']) && $data['District'] == "Palakkad") ? 'selected' : '' ?>>Palakkad</option>
                            <option value="Pathanamthitta" <?= (isset($data['District']) && $data['District'] == "Pathanamthitta") ? 'selected' : '' ?>>Pathanamthitta</option>
                            <option value="Thiruvananthapuram" <?= (isset($data['District']) && $data['District'] == "Thiruvananthapuram") ? 'selected' : '' ?>>Thiruvananthapuram
                            </option>
                            <option value="Thrissur" <?= (isset($data['District']) && $data['District'] == "Thrissur") ? 'selected' : '' ?>>Thrissur</option>
                            <option value="Wayanad" <?= (isset($data['District']) && $data['District'] == "Wayanad") ? 'selected' : '' ?>>Wayanad</option>
                            <option value="Kannur" <?= (isset($data['District']) && $data['District'] == "Kannur") ? 'selected' : '' ?>>Kannur</option>
                            <option value="Kasargod" <?= (isset($data['District']) && $data['District'] == "Kasargod") ? 'selected' : '' ?>>Kasargod</option>
                            <option value="Kollam" <?= (isset($data['District']) && $data['District'] == "Kollam") ? 'selected' : '' ?>>Kollam</option>
                            <option value="Punalur" <?= (isset($data['District']) && $data['District'] == "Punalur") ? 'selected' : '' ?>>Punalur</option>
                        </select>

                    </div>
                    <div class="col-md-6">
                        <label for="aadhar" class="float-start">Aadhar No</label>
                        <input type="number" name="Aadhar" id="aadhar" class="form-control"
                            value="<?= $data['Aadhar'] ?? '' ?>">
                        <span class="text-danger small" id="aadhar-error"></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="address" class="float-start">Address</label>
                        <input type="text" name="Address" id="address" class="form-control"
                            value="<?= $data['Address'] ?? '' ?>">
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100" name="submit">Update</button>
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

        document.querySelector("form").addEventListener("submit", function (e) {
            let valid = true;

            const name = document.getElementById("name");
            const contact = document.getElementById("contact");
            const email = document.getElementById("email");
            const aadhar = document.getElementById("aadhar");

            const nameError = document.getElementById("name-error");
            const contactError = document.getElementById("contact-error");
            const emailError = document.getElementById("email-error");
            const aadharError = document.getElementById("aadhar-error");

            nameError.textContent = "";
            contactError.textContent = "";
            emailError.textContent = "";
            aadharError.textContent = "";

            const nameRegex = /^[A-Za-z\s]+$/;
            const contactRegex = /^\d{11}$/;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const aadharRegex = /^\d{14}$/;

            if (!nameRegex.test(name.value.trim())) {
                nameError.textContent = "Name should contain only letters.";
                name.focus();
                valid = false;
            }

            if (!emailRegex.test(email.value.trim())) {
                emailError.textContent = "Please enter a valid email address.";
                email.focus();
                valid = false;
            }

            if (!contactRegex.test(contact.value.trim())) {
                contactError.textContent = "Contact number must be exactly 11 digits.";
                contact.focus();
                valid = false;
            }

            if (!aadharRegex.test(aadhar.value.trim())) {
                aadharError.textContent = "Aadhar number must be exactly 14 digits.";
                aadhar.focus();
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
            }
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

</body>

