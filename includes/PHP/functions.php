<?php

function isEmailExists($pdo, $email)
{
    $req = "SELECT COUNT(*) FROM Laureat WHERE email = ?";
    $stmt = $pdo->prepare($req);

    $stmt->bindParam(1, $email);

    $stmt->execute();

    $result = $stmt->fetchColumn();

    if ($result > 0) {
        return true; 
    } else {
        return false; 
    }
}
