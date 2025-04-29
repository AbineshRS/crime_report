<?php include("Citizen_nav.php"); ?>
<?php include("connection.php");

$districts = $conn->query("SELECT DISTINCT district FROM stationregistration");
$userid = $_SESSION['Pid'];
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container my-4">
    <h2 class="text-center mb-4">Crime Complaint Registration Form</h2>
    <div class="row g-4 shadow-lg p-4 mt-3 rounded-4">
        <div class="col-lg-8 mx-auto">
            <form method="post" enctype="multipart/form-data">
                <?php
                if (isset($_POST['submit'])) {
                    $Complainant = $_POST['Complainant'];
                    $inputDateTime = $_POST['date_time'];
                    $formattedDateTime = date("Y-m-d H:i:s", strtotime($inputDateTime)); // ✅ formatted for MySQL
                    $crime_type = $_POST['crime_type'];
                    $location = $_POST['Location'];
                    $suspect = $_POST['suspect'];
                    $station_id = $_POST['station_name'];
                    $name = $_POST['name'];
                    $gender = $_POST['victim-gender'];
                    $email = $_POST['email'];
                    $address = $_POST['Address'];
                    $title = $_POST['title'];
                    $district = $_POST['district'];
                    $stationIdDisplay = $_POST['stationIdDisplay'];
                    $Status = 0;

                    $station_query = $conn->query("SELECT station_name FROM stationregistration WHERE id = $station_id");
                    $station_row = $station_query->fetch_assoc();
                    $station_name = $station_row['station_name'];
                    $currentDate = date('Y-m-d'); // Format: YYYY-MM-DD
                
                    $stmt = $conn->prepare("INSERT INTO add_complaints (Complainant_Description, Date_time, Type_of_Crime, Location_of_Incident, Suspected_Perpetrator, Police_Station, Name, Gender, Email, Address, Station_id, Status, UserId,district,Complete_Status,Date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?)");
                    $stmt->bind_param("sssssssssssissss", $Complainant, $formattedDateTime, $crime_type, $location, $suspect, $station_name, $name, $gender, $email, $address, $stationIdDisplay, $Status, $userid, $district, $Status, $currentDate);

                    if ($stmt->execute()) {
                        $complaint_id = $stmt->insert_id;

                        if (isset($_FILES['proof']) && $_FILES['proof']['error'] === 0) {
                            $allowed_types = ['image/jpeg', 'image/png', 'application/pdf', 'video/mp4'];
                            $file_type = $_FILES['proof']['type'];
                            $file_tmp = $_FILES['proof']['tmp_name'];

                            if (in_array($file_type, $allowed_types)) {
                                $target_dir = "../uploads/";
                                if (!file_exists($target_dir)) {
                                    mkdir($target_dir, 0777, true);
                                }

                                $file_name = time() . "_" . basename($_FILES["proof"]["name"]);
                                $target_file = $target_dir . $file_name;

                                if (move_uploaded_file($file_tmp, $target_file)) {
                                    $stmt2 = $conn->prepare("INSERT INTO evidance_report (Pid, Title, Document) VALUES (?, ?, ?)");
                                    $stmt2->bind_param("iss", $complaint_id, $title, $target_file);
                                    $stmt2->execute();
                                } else {
                                    echo "<script>alert('File upload failed. Please try again.');</script>";
                                }
                            } else {
                                echo "<script>alert('Invalid file type. Only JPG, PNG, PDF, MP4 are allowed.');</script>";
                            }
                        }

                        echo "<script>alert('Complaint registered successfully!'); window.location.href='Citizen_add_complain.php';</script>";
                    } else {
                        echo "<script>alert('Error registering complaint.');</script>";
                    }

                    $stmt->close();
                    $conn->close();
                }
                ?>
                <div class="mb-3">
                    <label class="form-label">District</label>
                    <select id="districtSelect" name="district" class="form-select" required>
                        <option selected disabled>Select District</option>
                        <?php while ($row = $districts->fetch_assoc()): ?>
                            <option value="<?= $row['district'] ?>"><?= $row['district'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>


                <div class="mb-3">
                    <label class="form-label">Police Station</label>
                    <select id="stationSelect" name="station_name" class="form-select" required>
                        <option selected disabled>Select Police Station</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Complainant Description</label>
                    <textarea class="form-control" name="Complainant" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date & Time</label>
                    <input type="datetime-local" class="form-control" name="date_time" max="<?= date('Y-m-d\TH:i') ?>"
                        required>
                </div>


                <div class="mb-3">
                    <label class="form-label">Type of Crime</label>
                    <select name="crime_type" class="form-select" required>
                        <option selected disabled>Select Type</option>
                        <option>Theft</option>
                        <option>Assault</option>
                        <option>Fraud</option>
                        <option>Cybercrime</option>
                        <option>Harassment</option>
                        <option>Other</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Location of Incident</label>
                    <input type="text" class="form-control" name="Location" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Suspected Perpetrator</label>
                    <input type="text" class="form-control" name="suspect">
                </div>



                <div class="mb-3">
                    <input type="hidden" id="stationIdDisplayInput" name="stationIdDisplay">
                </div>

                <hr class="my-4">

                <h5 class="text-muted">Victim Information</h5>

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gender</label>
                    <select name="victim-gender" class="form-select" required>
                        <option selected disabled>Select Gender</option>
                        <option>Male</option>
                        <option>Female</option>
                        <option>Other</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="Address" class="form-control" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Evidence Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Proof (Image, Video, or Document)</label>
                    <input type="file" name="proof" class="form-control" required>
                </div>

                <div class="text-center">
                    <button class="btn btn-primary" type="submit" name="submit">Submit Complaint</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery and AJAX for dependent dropdown -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#districtSelect').on('change', function () {
            var selectedDistrict = $(this).val();
            $.ajax({
                url: 'get_stations.php',
                type: 'POST',
                data: { district: selectedDistrict },
                dataType: 'json',
                success: function (data) {
                    var $stationSelect = $('#stationSelect');
                    $stationSelect.empty().append('<option selected disabled>Select Police Station</option>');
                    $.each(data, function (index, station) {
                        $stationSelect.append('<option value="' + station.id + '" data-id="' + station.id + '">' + station.station_name + '</option>');
                    });
                    $('#stationIdDisplayInput').val('');
                }
            });
        });

        $('#stationSelect').on('change', function () {
            var selectedId = $(this).find('option:selected').data('id');
            $('#stationIdDisplayInput').val(selectedId);
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

<?php include("Footer.php"); ?>