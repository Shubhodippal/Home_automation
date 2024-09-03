<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT password FROM admin WHERE email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($storedPassword);
$stmt->fetch();
$stmt->close();

if ($password === $storedPassword) {
    echo 'success';
    $signInTime = date('Y-m-d H:i:s');
    $insertSql = "INSERT INTO SignInRecords (email, sign_in_time) VALUES (?, ?)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param("ss", $email, $signInTime);
    $insertStmt->execute();
    $insertStmt->close();
    $conn->close();
    
} else {
    echo 'fail';
}
?>
