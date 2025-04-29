<style>
    .cont {
        min-height: 250px;
    }
</style>
<?php
include("police_nav.php");
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

<div class="container">
    <p class="text-danger fs-4 ms-3 mt-4">Recent Cases</p>
</div>

<div class="container mt-3 p-3 cont">
    <div class="table-responsive">
        <?php
        include("connection.php");
        if (isset($_SESSION['Pid']) && !empty($_SESSION['Pid'])) {
            $station_id = $_SESSION['Pid'];

            $sql = "SELECT * FROM add_complaints WHERE Station_id = $station_id and Complete_Status=0";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                ?>

                <table class="table align-middle">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th style="min-width: 150px;">Victim Name</th>
                            <th style="min-width: 200px;">Type of Crime</th>
                            <th style="min-width: 150px;">Date</th>
                            <th style="min-width: 120px;">Location</th>
                            <th style="min-width: 120px;">Add Evidance</th>
                            <th style="min-width: 150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['Name']; ?></td>
                                <td><?php echo $row['Type_of_Crime']; ?></td>
                                <td><?php echo date('Y-m-d', strtotime($row['Location_of_Incident'])); ?></td>
                                <td><?php echo $row['Location_of_Incident']; ?></td>
                                <td>
                                    <a href="police_add_evidance.php?id=<?php echo $row['ID']; ?>"
                                        class="btn btn-outline-secondary btn-sm ms-2">
                                        <i class="bi bi-paperclip"></i>Add Evidence
                                    </a>
                                <td>
                                    <a href="police_approve_complaints.php?id=<?php echo $row['ID']; ?>"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye-fill"></i> View
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "<div class='alert alert-info text-center'>Not found.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Station ID is not set in session.</div>";
        }
        ?>
    </div>
</div>
<div class="container">
    <p class="text-danger fs-4 ms-3 ">completed Cases</p>
</div>

<div class="container  p-3 mb-5">
    <div class="table-responsive">
        <?php
        include("connection.php");
        if (isset($_SESSION['Pid']) && !empty($_SESSION['Pid'])) {
            $station_id = $_SESSION['Pid'];

            $sql = "SELECT * FROM add_complaints WHERE Station_id = $station_id and Complete_Status=1";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                ?>

                <table class="table align-middle">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th style="min-width: 150px;">Victim Name</th>
                            <th style="min-width: 200px;">Type of Crime</th>
                            <th style="min-width: 150px;">Date</th>
                            <th style="min-width: 120px;">Location</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['Name']; ?></td>
                                <td><?php echo $row['Type_of_Crime']; ?></td>
                                <td><?php echo date('Y-m-d', strtotime($row['Location_of_Incident'])); ?></td>
                                <td><?php echo $row['Location_of_Incident']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "<div class='alert alert-info text-center'>Not found.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Station ID is not set in session.</div>";
        }
        ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

<?php include('Footer.php') ?>