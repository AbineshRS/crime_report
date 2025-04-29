<?php include("admin_nav.php"); ?>

<div class="container text-center">
    <h1 class="text-center mt-3">Police Register</h1>
    <div class="row">
        <div class="col-md-6 mb-4">
            <img src="../images/image 16.png" alt="Station Image" class="img-fluid">
        </div>
        <div class="col-md-6 mt-5 text-start">
            <form method="POST" action="" onsubmit="return validateForm();">
                <?php
                include("connection.php");
                $email_error = $station_code_error = $name_error = $contact_error = "";

                if (isset($_POST['submit'])) {
                    $District = $_POST['District'] ?? '';
                    $Statio_name = $_POST['Statio_name'] ?? '';
                    $Registration_number = $_POST['Registration_number'] ?? '';
                    $Station_code = $_POST['Station_code'] ?? '';
                    $Address = $_POST['Address'] ?? '';
                    $Contact = $_POST['Contact'] ?? '';
                    $Email = $_POST['Email'] ?? '';
                    $Station_incharge_name = $_POST['Station_incharge_name'] ?? '';
                    $Station_incharge_contact = $_POST['Station_incharge_contact'] ?? '';
                    $password = "pwd@123"; 
                    $user_type = "Police_officer";

                    // Validations
                    if (!preg_match("/^[a-zA-Z\s]+$/", $Station_incharge_name)) {
                        $name_error = "Only letters and spaces are allowed in the name.";
                    }

                    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
                        $email_error = "Invalid email format.";
                    }

                    $station_code_check = "SELECT * FROM stationregistration WHERE Station_code = '$Station_code'";
                    $result_station_code = $conn->query($station_code_check);
                    if ($result_station_code->num_rows > 0) {
                        $station_code_error = "Station code already exists.";
                    }

                    if (!preg_match("/^\d{10}$/", $Contact)) {
                        $contact_error = "Contact number must be exactly 10 digits.";
                    }

                    if (empty($name_error) && empty($email_error) && empty($station_code_error) && empty($contact_error)) {
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                        // Check if email exists in login
                        $check = "SELECT * FROM login WHERE Email='$Email'";
                        $result = $conn->query($check);

                        if ($result->num_rows > 0) {
                            $email_error = "Email already exists.";
                        } else {
                            $sql = "INSERT INTO stationregistration (District, Registration_number, Station_code, Address, Contact, Station_incharge_name, Station_incharge_contact, Station_name)
                                    VALUES ('$District', '$Registration_number', '$Station_code', '$Address', '$Contact', '$Station_incharge_name', '$Station_incharge_contact', '$Statio_name')";

                            if ($conn->query($sql) === TRUE) {
                                $last_id = $conn->insert_id;
                                $login = "INSERT INTO login (PId, Email, Password, Status, Usertype)
                                          VALUES ('$last_id', '$Email', '$hashed_password', 'active', '$user_type')";

                                if ($conn->query($login) === TRUE) {
                                    echo "<script>alert('Registration successful');</script>";
                                } else {
                                    echo "<script>alert('Login insert failed: " . $conn->error . "');</script>";
                                }
                            } else {
                                echo "<script>alert('Register insert failed: " . $conn->error . "');</script>";
                            }
                        }
                    }
                }
                ?>

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Station Name</label>
                        <input type="text" name="Statio_name" class="form-control" id="Statio_name">
                        <span class="text-danger" id="Statio_name_error"><?php echo $name_error; ?></span>
                    </div>
                    <div class="col">
                        <label class="form-label">District</label>
                        <select name="District" class="form-select" id="District">
                            <option disabled selected value="">Select District</option>
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
                        </select>
                        <span class="text-danger" id="District_error"></span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Government Registration Number</label>
                    <input type="text" name="Registration_number" class="form-control" id="Registration_number">
                    <span class="text-danger" id="Registration_number_error"></span>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Station Code</label>
                        <input type="text" name="Station_code" class="form-control" id="Station_code">
                        <span class="text-danger" id="Station_code_error"><?php echo $station_code_error; ?></span>
                    </div>
                    <div class="col">
                        <label class="form-label">Address</label>
                        <input type="text" name="Address" class="form-control" id="Address">
                        <span class="text-danger" id="Address_error"></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="Contact" class="form-control" id="Contact">
                        <span class="text-danger" id="Contact_error"><?php echo $contact_error; ?></span>
                    </div>
                    <div class="col">
                        <label class="form-label">Email</label>
                        <input type="email" name="Email" class="form-control" id="Email">
                        <span class="text-danger" id="Email_error"><?php echo $email_error; ?></span>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col">
                        <label class="form-label">Station In-Charge Name</label>
                        <input type="text" name="Station_incharge_name" class="form-control" id="Station_incharge_name">
                        <span class="text-danger" id="Station_incharge_name_error"></span>
                    </div>
                    <div class="col">
                        <label class="form-label">In-Charge Contact Number</label>
                        <input type="text" name="Station_incharge_contact" class="form-control" id="Station_incharge_contact">
                        <span class="text-danger" id="Station_incharge_contact_error"></span>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function validateForm() {
        let isValid = true;
        function setError(id, message) {
            document.getElementById(id + "_error").innerText = message;
            if (message) isValid = false;
        }

        const fields = ["Statio_name", "District", "Registration_number", "Station_code", "Address", "Contact", "Email", "Station_incharge_name", "Station_incharge_contact"];
        const values = {};
        fields.forEach(id => values[id] = document.getElementById(id).value.trim());

        setError("Statio_name", values.Statio_name === "" ? "Station Name is required" : "");
        setError("District", values.District === "" ? "District is required" : "");
        setError("Registration_number", values.Registration_number === "" ? "Registration Number is required" : "");
        setError("Station_code", values.Station_code === "" ? "Station Code is required" : "");
        setError("Address", values.Address === "" ? "Address is required" : "");
        setError("Contact", values.Contact === "" || !/^\d{10}$/.test(values.Contact) ? "Contact must be 10 digits" : "");
        setError("Email", values.Email === "" || !/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/.test(values.Email) ? "Valid email is required" : "");
        setError("Station_incharge_name", values.Station_incharge_name === "" ? "Incharge Name is required" : "");
        setError("Station_incharge_contact", values.Station_incharge_contact === "" ? "Incharge Contact is required" : "");

        return isValid;
    }
</script>

<?php include("Footer.php"); ?>
