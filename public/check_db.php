<?php
$mysqli = new mysqli("localhost", "root", "", "db_klinik");

if ($mysqli->connect_error) {
  die("Connection failed: " . $mysqli->connect_error);
}

$result = $mysqli->query("SHOW TABLES");
$tables = [];
while ($row = $result->fetch_array()) {
    $table = $row[0];
    $tables[$table] = [];
    $colResult = $mysqli->query("DESCRIBE `$table`");
    while ($col = $colResult->fetch_assoc()) {
        $tables[$table][] = $col;
    }
}

echo json_encode($tables, JSON_PRETTY_PRINT);
$mysqli->close();
