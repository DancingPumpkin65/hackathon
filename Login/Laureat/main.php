<?php
session_start(); 

if (!isset($_SESSION['isUserLoggedIn']) || $_SESSION['isUserLoggedIn'] !== true) {
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    
    if ($_SESSION['userType'] == 'laureat') {
        include 'head.php';
    } else {
        echo 'We need time to fix it';
    }
    ?>
    
    <?php include 'need.php' ?>
    <?php include '../../includes/PHP/config.php' ?>

