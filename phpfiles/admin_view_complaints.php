<style>
    .cont {
        min-height: 450px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table thead {
        background-color: #4e73df;
        color: #fff;
    }

    .table td, .table th {
        vertical-align: middle;
    }

    .table a {
        text-decoration: none;
    }

    .btn-custom {
        border-radius: 50px;
        padding: 8px 16px;
    }

    .header-title {
        font-size: 1.25rem;
        font-weight: 600;
    }

    .custom-card {
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .custom-card .card-body {
        padding: 2rem;
    }
</style>

<?php include("admin_nav.php") ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="container mt-4">
    <p class="header-title text-primary">Complaints List</p>
</div>

<div class="container mt-3 p-4 cont custom-card">
    <div class="table-responsive">
        <?php
        include("connection.php");

        $sql = "SELECT * FROM add_complaints order by ID desc";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        ?>

        <table class="table ">
            <thead>
                <tr>
                    <th style="min-width: 150px;">Station Name</th>
                    <th style="min-width: 200px;">Type Of Crime</th>
                    <th style="min-width: 150px;">Location Of Incident</th>
                    <th style="min-width: 120px;">Suspected Perpetrator</th>
                    <th style="min-width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Police_Station']); ?></td>
                    <td><?php echo htmlspecialchars($row['Type_of_Crime']); ?></td>
                    <td><?php echo htmlspecialchars($row['Location_of_Incident']);  ?></td>
                    <td><?php echo htmlspecialchars($row['Suspected_Perpetrator']); ?></td>
                    <td>
                        <a href="admin_view_detailed_complaints.php?id=<?php echo $row['ID']; ?>"
                            class="btn btn-outline-primary btn-custom">
                            <i class="bi bi-eye-fill"></i> View
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php
        } else {
            echo "<div class='alert alert-info'>No complaints found.</div>";
        }
        ?>
    </div>
</div>

<?php include('Footer.php') ?>
