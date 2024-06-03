<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profil {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }

        /* Style for popup form */
        .popup-form {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: #fefefe;
            padding: 20px;
            border: 1px solid #888;
            border-radius: 5px;
            z-index: 9999;
        }
    </style>
</head>
<?php include 'HEADER.php'; ?>
<body>

    <div class="container" style="display:flex;flex-direction:column;padding-left:20%;padding-right:20%;">
        <h1 class="text-center">Profile</h1>
        <?php
        // Include the database configuration file
        include '../../../includes/PHP/config.php';
        $user_data = $_SESSION['user_data'];
        
        // Function to sanitize input data
        function sanitize($data) {
            return htmlspecialchars(trim($data));
        }
            // Prepare the SQL statement
            $rq = 'SELECT * FROM Laureat WHERE Identifiant = :id';

            // Prepare the statement
            $stmt = $pdo->prepare($rq);

            // Bind the parameter
            $stmt->bindParam(':id', $user_data['Identifiant'], PDO::PARAM_INT);

            // Execute the query
            $stmt->execute();

            // Fetch the row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if row exists
            if ($row) {
                // Function to update user data
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
                    // Sanitize input data
                    $nom = sanitize($_POST['nom']);
                    $prenom = sanitize($_POST['prenom']);
                    $email = sanitize($_POST['email']);
                    $tel = sanitize($_POST['tel']);
                    $promotion = sanitize($_POST['promotion']);
                    $filiere = sanitize($_POST['filiere']);
                    $etablissement = sanitize($_POST['etablissement']);
                    $fonction = sanitize($_POST['fonction']);
                    $employeur = sanitize($_POST['employeur']);
                    
                    // Check if a new photo is uploaded
                    if (!empty($_FILES['photo']['name'])) {
                        // File upload path
                        $targetDir = "../../images_profil/";
                        $fileName = basename($_FILES["photo"]["name"]);
                        $targetFilePath = $targetDir . $fileName;
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                        // Allow certain file formats
                        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                        if (in_array($fileType, $allowTypes)) {
                            // Upload file to server
                            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
                                // File uploaded successfully, update database with file path
                                $photo = "images_profil/" . $fileName;
                            } else {
                                $errorMessage = "Sorry, there was an error uploading your file.";
                            }
                        } else {
                            $errorMessage = 'Sorry, only JPG, JPEG, PNG, GIF files are allowed to upload.';
                        }
                    } else {
                        // No new photo uploaded, retain the existing photo path
                        $photo = $row['photo'];
                    }
                    
                    // Update the user's data in the database
                    $updateStmt = $pdo->prepare("UPDATE Laureat SET nom = :nom, Prenom = :prenom, email = :email, Tel = :tel, promotion = :promotion, Filiere = :filiere, Etablissement = :etablissement, Fonction = :fonction, Employeur = :employeur, photo = :photo WHERE Identifiant = :id");
                    $updateStmt->bindParam(':nom', $nom, PDO::PARAM_STR);
                    $updateStmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
                    $updateStmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $updateStmt->bindParam(':tel', $tel, PDO::PARAM_STR);
                    $updateStmt->bindParam(':promotion', $promotion, PDO::PARAM_INT);
                    $updateStmt->bindParam(':filiere', $filiere, PDO::PARAM_STR);
                    $updateStmt->bindParam(':etablissement', $etablissement, PDO::PARAM_STR);
                    $updateStmt->bindParam(':fonction', $fonction, PDO::PARAM_STR);
                    $updateStmt->bindParam(':employeur', $employeur, PDO::PARAM_STR);
                    $updateStmt->bindParam(':photo', $photo, PDO::PARAM_STR);
                    $updateStmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
                    $updateStmt->execute();

                    // Redirect to the same page to refresh the data
                    header("Location: profil.php?id=" . $_GET['id']);
                    exit();
                }
                ?>
                <div class="text-center">
                    <img class="profil img-thumbnail" src="<?php echo '../../' . $row['photo']; ?>" alt="image-profil">
                </div>
                <p><strong>Name:</strong> <?php echo $row['nom'] . ' ' . $row['Prenom']; ?></p>
                <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
                <p><strong>Telephone:</strong> <?php echo $row['Tel']; ?></p>
                <p><strong>Promotion Year:</strong> <?php echo $row['promotion']; ?></p>
                <p><strong>Filiere:</strong> <?php echo $row['Filiere']; ?></p>
                <p><strong>Etablissement:</strong> <?php echo $row['Etablissement']; ?></p>
                <p><strong>Post actuel:</strong> <?php echo $row['Fonction']; ?></p>
                <p><strong>Employeur:</strong> <?php echo $row['Employeur']; ?></p>
                <!-- Add other profile information here -->

                <!-- Button to open the popup form -->
                <button class="btn btn-primary" onclick="openForm()">Edit</button>

                <!-- Popup form for editing additional information -->
                <div class="popup-form" id="editForm">
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="nom">Nom:</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $row['nom']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prénom:</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $row['Prenom']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="tel">Téléphone:</label>
                            <input type="text" class="form-control" id="tel" name="tel" value="<?php echo $row['Tel']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="promotion">Année de promotion:</label>
                            <input type="text" class="form-control" id="promotion" name="promotion" value="<?php echo $row['promotion']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="filiere">Filière:</label>
                            <input type="text" class="form-control" id="filiere" name="filiere" value="<?php echo $row['Filiere']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="etablissement">Etablissement:</label>
                            <input type="text" class="form-control" id="etablissement" name="etablissement" value="<?php echo $row['Etablissement']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="fonction">Poste actuel:</label>
                            <input type="text" class="form-control" id="fonction" name="fonction" value="<?php echo $row['Fonction']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="employeur">Employeur:</label>
                            <input type="text" class="form-control" id="employeur" name="employeur" value="<?php echo $row['Employeur']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo:</label>
                            <input type="file" class="form-control-file" id="photo" name="photo">
                        </div>
                        <button type="submit" name="update" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-secondary" onclick="closeForm()">Close</button>
                    </form>
                </div>

                <!-- Script to open and close the popup form -->
                <script>
                    function openForm() {
                        document.getElementById("editForm").style.display = "block";
                    }

                    function closeForm() {
                        document.getElementById("editForm").style.display = "none";
                    }
                </script>
            <?php
            } else {
                echo "No records found.";
            }
        ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>