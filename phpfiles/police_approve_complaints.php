<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

<?php
include("police_nav.php");
include("connection.php"); // Ensure DB connection
?>

<style>
    .box {
        width: 100%;
        max-width: 1129px;
        height: 70px;
        background-color: rgb(10, 1, 67);
        margin: 40px auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<?php
if (isset($_GET['id'])) {
    $Id = (int) $_GET['id']; // Cast to int for safety

    $sqlComplaint = "SELECT * FROM add_complaints WHERE ID = $Id";
    $resultComplaint = $conn->query($sqlComplaint);
    if ($resultComplaint->num_rows > 0) {
        $complaint = $resultComplaint->fetch_assoc();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['approve'])) {
                $status = 1; // Approve
            } elseif (isset($_POST['reject'])) {
                $status = 0; // Reject
            }

            // Update status in the database
            $sqlUpdate = "UPDATE add_complaints SET Status = $status WHERE ID = $Id";
            if ($conn->query($sqlUpdate) === TRUE) {
                echo "<p class='text-center text-success'>Status updated successfully.</p>";
            } else {
                echo "<p class='text-center text-danger'>Error updating status: " . $conn->error . "</p>";
            }
        }
        ?>

        <div class="container">
            <div class="box">
                <p class="text-white text-center m-0 fs-3 fw-semibold">Case ID: <?php echo $complaint['ID']; ?></p>
            </div>

            <!-- Complainant Description & Date/Time -->
            <div class="row mb-4">
                <div class="col-sm-12 col-md-6 mb-3">
                    <div class="card p-3">
                        <h6>Complainant Description</h6>
                        <p><?php echo $complaint['Complainant_Description']; ?></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 mb-3">
                    <div class="card p-3">
                        <h6>Date & Time of Incident</h6>
                        <p><?php echo $complaint['Date_time']; ?></p>
                    </div>
                </div>
            </div>

            <!-- Type of Crime & Location -->
            <div class="row mb-4">
                <div class="col-sm-12 col-md-6 mb-3">
                    <div class="card p-3">
                        <h6>Type of Crime</h6>
                        <p><?php echo $complaint['Type_of_Crime']; ?></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 mb-3">
                    <div class="card p-3">
                        <h6>Location of Incident</h6>
                        <p><?php echo $complaint['Location_of_Incident']; ?></p>
                    </div>
                </div>
            </div>

            <!-- Perpetrator & Police Station -->
            <div class="row mb-4">
                <div class="col-sm-12 col-md-6 mb-3">
                    <div class="card p-3">
                        <h6>Suspected Perpetrator</h6>
                        <p><?php echo $complaint['Suspected_Perpetrator']; ?></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 mb-3">
                    <div class="card p-3">
                        <h6>Police Station Name</h6>
                        <p><?php echo $complaint['Police_Station']; ?></p>
                    </div>
                </div>
            </div>

            <!-- Victim Info -->
            <div class="row mb-2">
                <div class="col">
                    <h5 class="text-start">Victim</h5>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-sm-12 col-md-6 mb-3">
                    <div class="card p-3">
                        <h6>Name</h6>
                        <p><?php echo $complaint['Name']; ?></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 mb-3">
                    <div class="card p-3">
                        <h6>Address</h6>
                        <p><?php echo $complaint['Address']; ?></p>
                    </div>
                </div>
            </div>

            <!-- Evidence -->
            <?php
            $sqlEvidence = "SELECT * FROM evidance_report WHERE Pid = {$complaint['ID']}";
            $resultEvidence = $conn->query($sqlEvidence);

            if ($resultEvidence->num_rows > 0) {
                $evidence = $resultEvidence->fetch_assoc();
                ?>
                <div class="row mb-2">
                    <div class="col">
                        <h5 class="text-start">Evidence</h5>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-12 col-md-6 mb-3">
                        <div class="card p-3">
                            <h6>Title</h6>
                            <p><?php echo $evidence['Title']; ?></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 mb-3">
                        <div class="card p-3">
                            <h6>Proof</h6>
                            <img src="<?php echo $evidence['Document']; ?>" alt="Evidence Image"
                                class="img-fluid object-fit-cover" />
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <p class="text-danger">No evidence found.</p>
            <?php } ?>

            <!-- Approve/Reject Buttons -->
            <div class="row mb-5">
                <form action="" method="post" class="d-flex justify-content-between flex-column flex-md-row">
                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <button type="submit" class="btn btn-primary w-100" name="approve">Approve</button>
                    </div>
                    <div class="col-12 col-md-6">
                        <button type="submit" class="btn btn-danger w-100" name="reject">Reject</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row justify-content-center mb-5">
        <a href="police_add_completed_Complain.php?id=<?php echo $Id; ?>" class="btn btn-success col-6">Complete</a>
        </div>
        <?php
    } else {
        echo "<p class='text-center text-danger'>No complaint details found.</p>";
    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

<?php include("Footer.php"); ?>
