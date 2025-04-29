<?php
include("admin_nav.php");
include("connection.php");

$complaint_id = $_GET['id'];

$sql = "
    SELECT DISTINCT 
        cm.Complainant_Description, cm.Date_time, cm.Type_of_Crime, cm.Location_of_Incident, 
        cm.Suspected_Perpetrator, cm.Police_Station, ev.Title AS Evidence_Title, ev.Document
    FROM add_complaints cm
    INNER JOIN evidance_report ev ON cm.ID = ev.Pid
    WHERE cm.ID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $complaint_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "<p class='text-center fs-3 mt-5'>No complaint details found for this ID.</p>";
    exit;
}

// Fetch police evidence (optional)
$sql2 = "SELECT DISTINCT * FROM case_evidence WHERE case_Id = ?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("i", $complaint_id);
$stmt2->execute();
$result2 = $stmt2->get_result();

$policeEvidenceExists = $result2->num_rows > 0;
if ($policeEvidenceExists) {
    $row2 = $result2->fetch_assoc();
}
?>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f7f9fc;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1200px;
    }

    .cont {
        min-height: 510px;
        background: linear-gradient(to right, #ffffff, #f1f3f6);
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        text-align: center;
        font-size: 2rem;
        margin-bottom: 2rem;
        color: #333;
        font-weight: 700;
    }

    .premium-card {
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        background: #ffffff;
        padding: 20px;
        margin: 15px 0;
        border: 1px solid #f0f1f6;
    }

    .premium-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .premium-card .card-title {
        font-size: 1.5rem;
        color: #3e4a59;
        margin-bottom: 12px;
    }

    .premium-card .card-subtitle {
        font-size: 1.2rem;
        color: #6c757d;
    }

    .premium-card img {
        width: 100%;
        max-height: 200px;
        object-fit: contain;
    }

    @media (max-width: 768px) {
        .section-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="container text-center cont mb-5">
    <p class="section-title">Complaint Details</p>
    <div class="row justify-content-center">
        <!-- Column 1 -->
        <div class="col-md-6">
            <div class="premium-card">
                <h5 class="card-title">Complainant Description</h5>
                <h6 class="card-subtitle"><?php echo htmlspecialchars($row['Complainant_Description']); ?></h6>
            </div>
            <div class="premium-card">
                <h5 class="card-title">Date & Time</h5>
                <h6 class="card-subtitle"><?php echo htmlspecialchars($row['Date_time']); ?></h6>
            </div>
            <div class="premium-card">
                <h5 class="card-title">Suspected Perpetrator</h5>
                <h6 class="card-subtitle"><?php echo htmlspecialchars($row['Suspected_Perpetrator']); ?></h6>
            </div>
        </div>

        <!-- Column 2 -->
        <div class="col-md-6">
            <div class="premium-card">
                <h5 class="card-title">Type of Crime</h5>
                <h6 class="card-subtitle"><?php echo htmlspecialchars($row['Type_of_Crime']); ?></h6>
            </div>
            <div class="premium-card">
                <h5 class="card-title">Location of Incident</h5>
                <h6 class="card-subtitle"><?php echo htmlspecialchars($row['Location_of_Incident']); ?></h6>
            </div>
            <div class="premium-card">
                <h5 class="card-title">Police Station</h5>
                <h6 class="card-subtitle"><?php echo htmlspecialchars($row['Police_Station']); ?></h6>
            </div>
        </div>
    </div>

    <p class="section-title text-start mt-4">Evidence Added by Citizen</p>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="premium-card">
                <h5 class="card-title">Evidence Title</h5>
                <h6 class="card-subtitle"><?php echo htmlspecialchars($row['Evidence_Title']); ?></h6>
            </div>
        </div>
        <div class="col-md-6">
            <div class="premium-card">
                <h5 class="card-title">Document</h5>
                <img src="<?php echo htmlspecialchars($row['Document']); ?>" alt="Citizen Document">
            </div>
        </div>
    </div>

    <?php if ($policeEvidenceExists): ?>
        <p class="section-title text-start mt-4">Evidence Added by Police</p>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="premium-card">
                    <h5 class="card-title">Case Evidence Title</h5>
                    <h6 class="card-subtitle"><?php echo htmlspecialchars($row2['Case_Title']); ?></h6>
                </div>
            </div>
            <div class="col-md-6">
                <div class="premium-card">
                    <h5 class="card-title">Document</h5>
                    <img src="../<?php echo htmlspecialchars($row2['Files']); ?>" alt="Police Document">
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include("Footer.php"); ?>
