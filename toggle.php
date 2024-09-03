<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$device_id = $_POST['device_id'];
$new_state = $_POST['state'];

$update_sql = "UPDATE Devices SET state = ? WHERE id = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param('si', $new_state, $device_id);
$update_stmt->execute();

if ($update_stmt->affected_rows > 0) {
    echo "Device state changed successfully.";
} else {
    echo "Failed to change device state.";
}

$conn->close();
?>
