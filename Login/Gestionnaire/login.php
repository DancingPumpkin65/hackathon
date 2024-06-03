<?php 
include "../../includes/PHP/config.php"; 
include "../../includes/PHP/need.php";

session_start();

$matricule_error = "";
$password_error = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!empty($_POST['matricule']) && !empty($_POST['password'])) {
        $Matricule = $_POST['matricule'];
        $Password = $_POST['password'];
        
        if (ctype_digit($Matricule)) { 
            try {
                $stmt = $pdo->prepare("SELECT * FROM Gestionnaire WHERE Matricule = ?");
                $stmt->execute([$Matricule]);
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch();
                    $hashed_password = $row['mdp'];
                    if (password_verify($Password, $hashed_password)) {
                        $_SESSION['isUserLoggedIn'] = true;
                        $_SESSION['userType'] = 'gestionnaire';
                        $_SESSION['user_data'] = $row;
                        header('Location: main.php');
                        exit;
                    } else {
                        $password_error = "Mot de passe incorrect.";
                    }
                } else {
                    $matricule_error = "Matricule non trouvé.";
                }
            } catch(PDOException $e) {
                error_log("Database Error: " . $e->getMessage()); 
                $password_error = "Erreur de connexion. Veuillez réessayer.";
            }
        } else {
            $matricule_error = "Veuillez saisir un numéro de matricule valide.";
        }
    } else {
        if (empty($_POST['matricule'])) {
            $matricule_error = "Veuillez saisir votre numéro de matricule.";
        }
        if (empty($_POST['password'])) {
            $password_error = "Veuillez saisir votre mot de passe.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - Gestionnaire</title>
    <style>
        #Container {
            background-color: rgb(244, 247, 250);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: black;
            background-image: url(signup2.png);
            background-size: contain;
        }
        .Container {
            width: 40%;
            padding: 28px;
            margin: 0 28px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 1px 1px 15px rgba(0, 0, 0, 0.1);
            background-color: white;
            position: relative;
        }
        h2 {
            font-weight: 700;
            text-align: center;
            padding-bottom: 3rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            font-size: 2.5rem;
        }
        .content {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px 0;
        }
        .input-box {
            display: flex;
            flex-direction: column;
            width: 100%;
            padding-bottom: 15px;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        .input-box input {
            height: 40px;
            width: 95%;
            padding: 0 10px;
            border-radius: 5px;
            border: 1px solid rgba(0, 0, 0, 0.2);
            box-shadow: 1px 1px 15px rgba(0, 0, 0, 0.05);
            outline: none;
            background: white;
        }
        .input-box label {
            margin-bottom: 0.7rem;
            font-weight: 600;
            color: rgba(0,0,0,0.7);
        }
        #sub {
            width: 50%;
            padding: 0.5rem 0;
            background: linear-gradient(330deg, rgba(29, 122, 208, 1) 0%, rgba(17, 71, 122, 1) 100%);
            color: white;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 5px;
            border: none;
            margin-bottom: 1rem;
            cursor: pointer;
        }
        .md {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .Container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 30px;
            margin: 1rem;
        }
        @media (max-width: 830px) {
            .Container {
                min-width: 280px;
            }
            .content {
                max-height: 380px;
                overflow: auto;
            }
            .input-box {
                width: 100%;
            }
            .input-box:nth-child(2n) {
                justify-content: space-between;
            }
            h2 {
                font-size: 1.5rem;
            }
            .error-message {
                font-size: 0.7rem;
            }
            .md p {
                font-size: 0.7rem;
            }
        }
    </style>
</head>
<body>
    <div id="Container">
        <div class="Container">
            <form action="login.php" method="post">
                <a href="../../index.php"><img src="left.png" alt="Dernière session"></a>
                <h2>Se connecter</h2>
                <div class="content">
                    <div class="input-box">
                        <label for="matricule">Matricule</label>
                        <input type="text" placeholder="Matricule" name="matricule" required>
                        <?php if(!empty($matricule_error)) { ?>
                            <div class="error-message" style="color:red;text-align:left;margin-top: 0.5rem;"><?php echo $matricule_error; ?></div>
                        <?php } ?>
                    </div>
                    <div class="input-box">
                        <label for="password">Mot de passe</label>
                        <input type="password" placeholder="Mot de passe" name="password" required>
                        <?php if(!empty($password_error)) { ?>
                            <div class="error-message" style="color:red;text-align:left;margin-top: 0.5rem;"><?php echo $password_error; ?></div>
                        <?php } ?>
                    </div>
                </div>
                <div class="md">
                    <button id="sub" type="submit">Se connecter</button>
                </div>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
