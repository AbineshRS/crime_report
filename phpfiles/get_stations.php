<?php
include("connection.php");

if (isset($_POST['district'])) {
    $district = $_POST['district'];

    $stmt = $conn->prepare("SELECT id, station_name FROM stationregistration WHERE district = ?");
    $stmt->bind_param("s", $district);
    $stmt->execute();
    $result = $stmt->get_result();

    $stations = [];
    while ($row = $result->fetch_assoc()) {
        $stations[] = $row;
    }

    echo json_encode($stations);
}
?>
