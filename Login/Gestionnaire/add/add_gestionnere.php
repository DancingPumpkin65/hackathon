<?php
include '../../../includes/PHP/config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricule = $_POST['matricule'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM Gestionnaire WHERE Matricule = :matricule");
    $stmt->bindParam(':matricule', $matricule);
    $stmt->execute();
    $matriculeExists = $stmt->fetchColumn();

    if ($matriculeExists) {
        echo "<p class='error'>Error: Matricule already used.</p>";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO Gestionnaire (Matricule, Nom, Prenom, mdp) VALUES (:matricule, :nom, :prenom, :mdp)");
        $stmt->bindParam(':matricule', $matricule);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':mdp', $hashedPassword);

        if ($stmt->execute()) {
            echo "<p class='success'>Gestionnaire added successfully.</p>";
        } else {
            echo "<p class='error'>Error adding Gestionnaire.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Gestionnaire</title>
    <style>
        body {
            background-color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            box-sizing: border-box;
        }
        h2 {
            color: #0073e6; /* Darker blue */
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            color: #0073e6; 
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }
        .disabled {
        opacity: 0.5; 
        pointer-events: none;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #0073e6; 
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #005bb5; 
        }
        .success {
            color: green;
            text-align: center;
            margin-top: 20px;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 20px;
        }
        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }
            h2 {
                font-size: 24px;
            }
            input[type="text"], input[type="password"], input[type="submit"] {
                font-size: 14px;
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Gestionnaire</h2>
        <form method="post" action="">
            <label for="matricule">Matricule:</label>
            <input type="text" id="matricule" name="matricule" required>

            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>

            <label for="prenom">Prenom:</label>
            <input type="text" id="prenom" name="prenom" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Submit">
        </form>
    </div>
    <script>
    password_input = document.querySelector('#password');
    submit_button = document.querySelector('input[type="submit"]');

    password_input.addEventListener('change', () => {
        let password = password_input.value;
        let strength = 0;

        if (password.length >= 8) {
            strength++;
        }

        if (/[A-Z]/.test(password)) {
            strength++;
        }

        if (/[a-z]/.test(password)) {
            strength++;
        }

        if (/\d/.test(password)) {
            strength++;
        }

        if (/[^A-Za-z0-9]/.test(password)) {
            strength++;
        }

        if (strength >= 4) {
            submit_button.classList.remove('disabled'); 
            console.log("Password is strong");
        } else {
            submit_button.classList.add('disabled'); 
            console.log("Password is not strong enough");
        }
    });
</script>

</body>
</html>
