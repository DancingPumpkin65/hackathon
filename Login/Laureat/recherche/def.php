<?php
$servername = "localhost";
$username = "root";
$password = "Suck-mydick-299";
$database = "copains";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$default_picture_path = 'profile.png'; 
$default_picture_binary = file_get_contents($default_picture_path);

// Alter the table to modify the photo column to VARBINARY
$sql = "ALTER TABLE Laureat MODIFY photo VARBINARY(3000)";
if ($conn->query($sql) === TRUE) {
    echo "Table altered successfully<br>";
} else {
    echo "Error altering table: " . $conn->error;
}

// Update existing rows to set default photo
$sql = "UPDATE Laureat SET photo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("b", $default_picture_binary);
if ($stmt->execute()) {
    echo "Default photo set successfully";
} else {
    echo "Error setting default photo: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
