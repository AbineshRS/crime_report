<style>
    .cont {
        min-height: 490px;
    }
</style>

<?php
include("police_nav.php");
include("connection.php");

// Get case ID from URL (from the form page that links with ?id=xxx)
if (!isset($_GET['id'])) {
    die("Case ID is missing.");
}
$caseId = $_GET['id'];

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $file = $_FILES['file'];

    if (!empty($file['name'])) {
        $uploadDir = "../uploads/"; // Change path as needed
        $filename = basename($file["name"]);
        $targetFile = $uploadDir . time() . "_" . $filename;
        $dateNow = date("Y-m-d H:i:s");
        // Create uploads folder if not exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            // File path to save in database (you can remove "../" if not needed)
            $filePath = str_replace("../", "", $targetFile);

            // Insert into DB
            $stmt = $conn->prepare("INSERT INTO case_evidence (case_Id, Title, Files,Time_stamp) VALUES (?, ?, ?,?)");
            $stmt->bind_param("ssss", $caseId, $title, $filePath,$dateNow);

            if ($stmt->execute()) {
                echo "<script>alert('Evidence uploaded successfully.'); window.location.href='police_view_cases.php';</script>";
            } else {
                echo "<script>alert('Failed to save evidence in database.');</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('Failed to upload file.');</script>";
        }
    } else {
        echo "<script>alert('No file selected.');</script>";
    }
}

$conn->close();
?>


<div class="container cont py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h5 class="mb-0">Add Evidence</h5>
                </div>
                <div class="card-body">
                    <form  method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">File</label>
                            <input type="file" name="file" id="file" class="form-control" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success" name="submit">Upload Evidence</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("Footer.php"); ?>
