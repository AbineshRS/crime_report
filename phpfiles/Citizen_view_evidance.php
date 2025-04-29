<style>
    .cont {
        min-height: 530px;
    }

    .card-img-bottom {
        height: 200px;
        object-fit: cover;
        width: 100%;
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
</style>

<?php 
include("Citizen_nav.php");
include("connection.php"); // Assuming this contains DB connection

$complaint_id = $_GET['id'];

$query = "SELECT Title, Files FROM case_evidence WHERE case_id = '$complaint_id'";
$result = mysqli_query($conn, $query);
?>
<div class="container cont py-4">
<p class="fs-3 text-center fw-semibold">Evidance</p>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['Title']); ?></h5>
                    </div>
                    <img src="../<?php echo htmlspecialchars($row['Files']); ?>" class="card-img-bottom" alt="Evidence Image">
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php include("Footer.php") ?>
