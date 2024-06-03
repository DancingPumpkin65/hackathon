<?php
include '../../includes/PHP/config.php';
$matricule = 29979; // Example Matricule
$nom = 'Doe'; // Example Nom
$prenom = 'John'; // Example Prenom
$password = '1234'; // Specify the password here

// Hash the password using the PASSWORD_BCRYPT algorithm
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Prepare an SQL statement to insert a new user into the Gestionnaire table
$sql = "INSERT INTO Gestionnaire (Matricule, Nom, Prenom, mdp) VALUES (:matricule, :nom, :prenom, :mdp)";

try {
    // Assuming $pdo is your PDO database connection
    $stmt = $pdo->prepare($sql);

    // Bind the parameters to the SQL query
    $stmt->bindParam(':matricule', $matricule, PDO::PARAM_INT);
    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $stmt->bindParam(':mdp', $hashedPassword, PDO::PARAM_STR);

    // Execute the statement
    $stmt->execute();

    echo "User added successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
