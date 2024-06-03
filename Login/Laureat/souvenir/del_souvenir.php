<?php
ob_start(); // Start output buffering at the very top

include '../../../includes/PHP/config.php'; // Ensure this file and 'head.php' have no output or whitespace before PHP tags


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['delete']) && isset($_SESSION['user_data']['Identifiant'])) {
    $filename = $_GET['delete'];

    $stmt = $pdo->prepare("DELETE FROM Souvenir WHERE photo = :filename");
    $stmt->bindParam(':filename', $filename, PDO::PARAM_STR);

    $stmt->execute();

    exit();
}

ob_end_flush(); // End output buffering and flush the output
?>
