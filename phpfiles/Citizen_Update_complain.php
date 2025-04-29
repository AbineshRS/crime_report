<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
<?php
include("Citizen_nav.php");
include("connection.php");

// Fetch the complaint data based on ID (assuming ID is passed in the URL)
$complaint_id = $_GET['id'];

// Fetch the complaint details from the database
$complaint_query = $conn->prepare("SELECT * FROM add_complaints WHERE ID = ?");
$complaint_query->bind_param("i", $complaint_id);
$complaint_query->execute();
$complaint_result = $complaint_query->get_result();
$complaint_data = $complaint_result->fetch_assoc();

// Fetch the evidence title and document for this complaint
$evidence_query = $conn->prepare("SELECT Title, Document FROM evidance_report WHERE Pid = ?");
$evidence_query->bind_param("i", $complaint_id);
$evidence_query->execute();
$evidence_result = $evidence_query->get_result();
$evidence_data = $evidence_result->fetch_assoc();
?>

<div class="container my-4">
    <h2 class="text-center mb-4">View & Update Crime Complaint</h2>
    <div class="row g-4 shadow-lg p-4 mt-3 rounded-4">
        <div class="col-lg-8 mx-auto">
            <form method="post" enctype="multipart/form-data">
                <?php
                if (isset($_POST['submit'])) {
                    // Get updated data from form
                    $title = $_POST['title'];
                    $document = $evidence_data['Document'];  // Keep the old document path if no new file is uploaded
                    $com_desc = $_POST['Complainant'];
                    $date_time = $_POST['date_time'];
                    $crime_type = $_POST['Type_of_Crime'];
                    $location = $_POST['Location'];
                    $suspect = $_POST['suspect'];
                    $name = $_POST['name'];
                    $gender = $_POST['victim-gender'];
                    $email = $_POST['email'];
                    $address = $_POST['Address'];

                    // If a new file is uploaded, process it
                    if (isset($_FILES['proof']) && $_FILES['proof']['error'] === 0) {
                        $allowed_types = ['image/jpeg', 'image/png', 'application/pdf', 'video/mp4'];
                        $file_type = mime_content_type($_FILES['proof']['tmp_name']);
                        $file_tmp = $_FILES['proof']['tmp_name'];

                        if (in_array($file_type, $allowed_types)) {
                            $target_dir = "../uploads/";
                            if (!file_exists($target_dir)) {
                                mkdir($target_dir, 0777, true);
                            }

                            $file_name = time() . "_" . basename($_FILES["proof"]["name"]);
                            $file_name = preg_replace("/[^A-Za-z0-9_.-]/", "", $file_name); // Clean file name
                            $target_file = $target_dir . $file_name;

                            if (move_uploaded_file($file_tmp, $target_file)) {
                                $document = $target_file;  // Update document path with new file
                            } else {
                                echo "<script>alert('File upload failed. Please try again.');</script>";
                            }
                        } else {
                            echo "<script>alert('Invalid file type. Only JPG, PNG, PDF, MP4 are allowed.');</script>";
                        }
                    }

                    // Update the complaint data and evidence
                    $update_complaint_stmt = $conn->prepare("UPDATE add_complaints SET Complainant_Description = ?, Date_time = ?, Type_of_Crime = ?, Location_of_Incident = ?, Suspected_Perpetrator = ?, Name = ?, Gender = ?, Email = ?, Address = ? WHERE ID = ?");
                    $update_complaint_stmt->bind_param("sssssssssi", $com_desc, $date_time, $crime_type, $location, $suspect, $name, $gender, $email, $address, $complaint_id);
                    
                    if ($update_complaint_stmt->execute()) {
                        // Update evidence title and document
                        $update_evidence_stmt = $conn->prepare("UPDATE evidance_report SET Title = ?, Document = ? WHERE Pid = ?");
                        $update_evidence_stmt->bind_param("ssi", $title, $document, $complaint_id);

                        if ($update_evidence_stmt->execute()) {
                            echo "<script>alert('Complaint and evidence updated successfully!'); window.location.href='Citizen_view_Complain.php';</script>";
                        } else {
                            echo "<script>alert('Error updating evidence.');</script>";
                        }
                    } else {
                        echo "<script>alert('Error updating complaint.');</script>";
                    }

                    $update_complaint_stmt->close();
                    $update_evidence_stmt->close();
                    $conn->close();
                }
                ?>
                <div class="row text-center">
                    <p class="fs-3">Police Station Name</p>
                    <p class="fs-4"><?php echo $complaint_data['Police_Station'] ?></php>
                </div>


                <div class="mb-3">
                    <label class="form-label">Complainant Description</label>
                    <textarea class="form-control" name="Complainant"><?= $complaint_data['Complainant_Description'] ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date & Time</label>
                    <input type="datetime-local" class="form-control" name="date_time" value="<?= date('Y-m-d\TH:i', strtotime($complaint_data['Date_time'])) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Type of Crime</label>
                    <input type="text" class="form-control" name="Type_of_Crime" value="<?= $complaint_data['Type_of_Crime'] ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Location of Incident</label>
                    <input type="text" class="form-control" name="Location" value="<?= $complaint_data['Location_of_Incident'] ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Suspected Perpetrator</label>
                    <input type="text" class="form-control" name="suspect" value="<?= $complaint_data['Suspected_Perpetrator'] ?>">
                </div>

                <hr class="my-4">

                <h5 class="text-muted">Victim Information</h5>

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="<?= $complaint_data['Name'] ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Gender</label>
                    <input type="text" name="victim-gender" class="form-control" value="<?= $complaint_data['Gender'] ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= $complaint_data['Email'] ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="Address" class="form-control"><?= $complaint_data['Address'] ?></textarea>
                </div>

                <hr class="my-4">

                <h5 class="text-muted">Update Evidence</h5>

                <div class="mb-3">
                    <label class="form-label">Evidence Title</label>
                    <input type="text" name="title" class="form-control" value="<?= $evidence_data['Title'] ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Uploaded Proof</label>
                    <a href="<?= $evidence_data['Document'] ?>" target="_blank">View Current Evidence</a>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload New Proof (Optional)</label>
                    <input type="file" name="proof" class="form-control">
                </div>

                <?php if ($complaint_data['Status'] == 0): ?>
                    <div class="text-center">
                        <button type="submit" name="submit" class="btn btn-primary">Update Complaint & Evidence</button>
                    </div>
                <?php endif; ?>

                <hr class="my-4">

                <div class="text-center">
                    <a href="Citizen_view_Complain.php" class="btn btn-secondary">Back to Complaints</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
