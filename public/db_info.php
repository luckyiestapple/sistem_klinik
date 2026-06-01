<?php
$conn = new mysqli('localhost', 'root', '', 'db_klinik');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$result = $conn->query("SHOW CREATE VIEW v_laporan_kas");
if ($row = $result->fetch_assoc()) {
    echo $row['Create View'];
} else {
    echo "View not found or query failed.";
}
$conn->close();
?>
