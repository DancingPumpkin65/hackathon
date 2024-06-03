<?php
include "../../../includes/PHP/config.php";

if(isset($_POST['id']) && !empty($_POST['id'])) {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $pdo->beginTransaction();

        $deleteAvisStatement = $pdo->prepare("DELETE FROM avis WHERE identifiant = :id");
        $deleteAvisStatement->bindParam(':id', $_POST['id']);
        $deleteAvisStatement->execute();

        $deleteSouvenirStatement = $pdo->prepare("DELETE FROM souvenir WHERE identifiant = :id");
        $deleteSouvenirStatement->bindParam(':id', $_POST['id']);
        $deleteSouvenirStatement->execute();

        $deleteLaureatStatement = $pdo->prepare("DELETE FROM laureat WHERE Identifiant = :id");
        $deleteLaureatStatement->bindParam(':id', $_POST['id']);
        $deleteLaureatStatement->execute();

        $pdo->commit();

        header("Location: search.php");
        exit();
    } catch(PDOException $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: search.php");
    exit();
}
?>
