<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
<?php
include("police_nav.php");
include("connection.php");

$Pid = $_SESSION['Pid'] ?? null;
$station_data = [];

// Fetch station data
if ($Pid) {
    $query = "SELECT * FROM stationregistration WHERE ID = '$Pid'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $station_data = $result->fetch_assoc();
    }
}

// Error message variables
$station_code_error = $name_error = $contact_error = "";

// Handle form submission
if (isset($_POST['submit'])) {
    $District = $_POST['District'] ?? '';
    $Statio_name = $_POST['Statio_name'] ?? '';
    $Registration_number = $_POST['Registration_number'] ?? '';
    $Station_code = $_POST['Station_code'] ?? '';
    $Address = $_POST['Address'] ?? '';
    $Contact = $_POST['Contact'] ?? '';
    $Station_incharge_name = $_POST['Station_incharge_name'] ?? '';
    $Station_incharge_contact = $_POST['Station_incharge_contact'] ?? '';

    // Validations
    if (!preg_match("/^[a-zA-Z\s]+$/", $Station_incharge_name)) {
        $name_error = "Only letters and spaces are allowed in the name.";
    }

    $station_code_check = "SELECT * FROM stationregistration WHERE Station_code = '$Station_code' AND ID != '$Pid'";
    $result_station_code = $conn->query($station_code_check);
    if ($result_station_code->num_rows > 0) {
        $station_code_error = "Station code already exists.";
    }

    if (!preg_match("/^\d{11}$/", $Contact)) {
        $contact_error = "Contact number must be exactly 11 digits.";
    }

    if (empty($name_error) && empty($station_code_error) && empty($contact_error)) {
        $sql = "UPDATE stationregistration SET
                    District = '$District',
                    Registration_number = '$Registration_number',
                    Station_code = '$Station_code',
                    Address = '$Address',
                    Contact = '$Contact',
                    Station_incharge_name = '$Station_incharge_name',
                    Station_incharge_contact = '$Station_incharge_contact',
                    Station_name = '$Statio_name'
                WHERE ID = '$Pid'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
            alert('Update successful!');
            window.location.href = 'police_update_profile.php';
        </script>";
        } else {
            echo "<script>alert('Station update failed: " . $conn->error . "');</script>";
        }
    }
}
?>

<div class="container text-center">
    <h1 class="text-center mt-3">Update</h1>
    <div class="row">
        <div class="col-md-6">
            <img src="../images/image 16.png" alt="Station Image" class="img-fluid">
        </div>
        <div class="col-md-6 mt-5 text-start mt-5">
            <form method="POST" action="">
                <div class="row mb-3 mt-5">
                    <div class="col">
                        <label class="form-label">Station Name</label>
                        <input type="text" name="Statio_name" class="form-control"
                            value="<?= $station_data['Station_name'] ?? '' ?>">
                    </div>
                    <div class="col">
                        <label for="district" class="form-label">District</label>
                        <select name="District" id="district" class="form-select" required>
                            <option disabled>Select District</option>
                            <?php
                            $districts = [
                                "Alappuzha",
                                "Ernakulam",
                                "Idukki",
                                "Kottayam",
                                "Kozhikode",
                                "Malappuram",
                                "Palakkad",
                                "Pathanamthitta",
                                "Thiruvananthapuram",
                                "Thrissur",
                                "Wayanad",
                                "Kannur",
                                "Kasargod",
                                "Kollam",
                                "Punalur"
                            ];
                            foreach ($districts as $district) {
                                $selected = ($station_data['District'] ?? '') == $district ? 'selected' : '';
                                echo "<option value=\"$district\" $selected>$district</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Government Registration Number</label>
                    <input type="text" name="Registration_number" class="form-control"
                        value="<?= $station_data['Registration_number'] ?? '' ?>">
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Station Code</label>
                        <input type="text" name="Station_code" class="form-control"
                            value="<?= $station_data['Station_code'] ?? '' ?>">
                        <span class="text-danger"><?= $station_code_error ?></span>
                    </div>
                    <div class="col">
                        <label class="form-label">Contact Number</label>
                        <input type="number" name="Contact" class="form-control"
                            value="<?= $station_data['Contact'] ?? '' ?>">
                        <span class="text-danger"><?= $contact_error ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Address</label>
                        <input type="text" name="Address" class="form-control"
                            value="<?= $station_data['Address'] ?? '' ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Station In-Charge Name</label>
                        <input type="text" name="Station_incharge_name" class="form-control"
                            value="<?= $station_data['Station_incharge_name'] ?? '' ?>">
                        <span class="text-danger"><?= $name_error ?></span>
                    </div>
                    <div class="col">
                        <label class="form-label">In-Charge Contact Number</label>
                        <input type="text" name="Station_incharge_contact" class="form-control"
                            value="<?= $station_data['Station_incharge_contact'] ?? '' ?>">
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<?php include("Footer.php") ?>