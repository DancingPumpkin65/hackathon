<?php
include "../includes/PHP/config.php";
include "../includes/PHP/functions.php";
include "../includes/PHP/need.php";

$errorMessage = null;
$successMessage = null;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (!empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["email"]) && !empty($_POST["mdp"]) && !empty($_POST["tel"]) && !empty($_POST["promotion"]) && !empty($_POST["filiere"]) && !empty($_POST["etablissement"])) {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $mdp = $_POST["mdp"];
        $tel = $_POST["tel"];
        $promotion = $_POST["promotion"];
        $filiere = $_POST["filiere"];
        $etablissement = $_POST["etablissement"];
        $employeur = !empty($_POST["employeur"]) ? $_POST["employeur"] : null;
        $photo = !empty($_POST["photo"]) ? $_POST["photo"] : 'profil.png';
        $post_actuel = !empty($_POST["Fonction"]) ? $_POST["Fonction"] : null;

        $hashed_password = password_hash($mdp, PASSWORD_DEFAULT);

        if (isEmailExists($pdo, $email)) {
            $errorMessage = "L'adresse e-mail existe déjà!";
        } else {
            try {
                $stmt = $pdo->prepare("INSERT INTO Laureat (nom, prenom, email, mdp, tel, promotion, filiere, etablissement, Fonction, employeur, photo) 
                          VALUES (:nom, :prenom, :email, :mdp, :tel, :promotion, :filiere, :etablissement, :fonction, :employeur, :photo)");
                $stmt->execute([
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'email' => $email,
                    'mdp' => $hashed_password,
                    'tel' => $tel,
                    'promotion' => $promotion,
                    'filiere' => $filiere,
                    'etablissement' => $etablissement,
                    'fonction' => $post_actuel,
                    'employeur' => $employeur,
                    'photo' => $photo
                ]);

                $successMessage = "Votre compte a été créé avec succès!";
                header("refresh:2;url=../Login/Laureat/login.php");
                exit;
            } catch (PDOException $e) {
                $errorMessage = "Erreur d'insertion : " . $e->getMessage();
            }
        }
    } else {
        $errorMessage = "Veuillez remplir tous les champs du formulaire.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire</title>
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
            max-width: 70%;
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
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 20px 0;
        }
        .input-box {
            display: flex;
            flex-wrap: wrap;
            width: 50%;
            padding-bottom: 15px;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        .input-box:nth-child(2n) {
            justify-content: end;
        }
        .input-box:last-child {
            align-items: center;
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
        #photo {
            border: none;
            height: 40px;
            width: 95%;
            padding: 0 10px;
            border-radius: 5px;
            border: 1px solid rgba(0, 0, 0, 0.2);
            box-shadow: 1px 1px 15px rgba(0, 0, 0, 0.05);
            outline: none;
            background: white;
        }
        .custom-file-upload {
            height: 40px;
            width: 95%;
            padding: 0 10px;
            border-radius: 5px;
            border: 1px solid rgba(0, 0, 0, 0.2);
            box-shadow: 1px 1px 15px rgba(0, 0, 0, 0.05);
            outline: none;
            background: white;
            cursor: pointer;
            text-align: left;
            color: rgba(0, 0, 0, 0.6);
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
        @media (max-width: 600px) {
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
        }
    </style>
</head>
<body>
    <div id="Container">
        <div class="Container">
            <form action="signup.php" method="post">
                <a href="../index.php"><img src="left.png" alt="Dernière session"></a>
                <h2>Fiche d'inscription<br><span style="opacity:0.7;font-size:1rem;font-weight:400;">Les champs marqués d'un (*) doivent être remplis obligatoirement.</span></h2>

                <div class="content">
                    <div class="input-box">
                        <input type="text" placeholder="Nom *" name="nom" required>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="Prenom *" name="prenom" required>
                    </div>
                    <div class="input-box">
                        <input type="email" placeholder="Email *" name="email" required>
                    </div>
                    <div class="input-box">
                        <input type="number" placeholder="Promotion *" name="promotion" required>
                    </div>
                    <div class="input-box">
                        <input type="password" placeholder="Mot de passe *" name="mdp" id="mdp" required>
                    </div>
                    <div class="input-box">
                        <input type="password" placeholder="Confirmez le mot de passe *" name="rmdp" id="rmdp" required>
                        <p id="p_password" style="display: none; color: red; font-size: 0.75rem; font-weight: 500; width:95%;"></p>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="Filière *" name="filiere" required>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="Etablissement *" name="etablissement" required>
                    </div>
                    <div class="input-box">
                        <input type="tel" placeholder="Téléphone *" name="tel" required>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="Post actuel" name="Fonction">
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="Entreprise" name="employeur">
                    </div>
                    <div class="input-box">
                        <input type="file" placeholder="Photo (opt)" name="photo" id="photo" class="photo">
                    </div>
                </div>
                <div class="md">
                    <?php if (isset($errorMessage)): ?>
                        <div class="div_message">
                            <p class="er"><?= $errorMessage ?></p>
                        </div>
                    <?php elseif (isset($successMessage)): ?>
                        <div class="div_message">
                            <p class="message"><?= $successMessage ?></p>
                        </div>
                    <?php endif; ?>
                    <button id="sub" type="submit">S'inscrire</button>
                    <p>Vous avez déjà un compte? <a href="../Login/Laureat/login.php" style="text-decoration:none;">Connecter</a></p>
                </div>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var customFileUpload = document.querySelector('.custom-file-upload');
            var photoInput = document.querySelector('.photo');

            if (customFileUpload) {
                customFileUpload.addEventListener('click', function() {
                    if (photoInput) {
                        photoInput.click();
                    }
                });
            }

            if (photoInput) {
                photoInput.addEventListener('change', function() {
                    var filename = document.getElementById('photo').files[0].name;
                    document.getElementById('photo-filename').textContent = filename;
                });
            }

            var input_password = document.querySelector('#mdp');
            var input_password_res = document.querySelector('#rmdp');
            var p_password = document.querySelector('#p_password');

            if (input_password && input_password_res && p_password) {
                input_password.addEventListener('input', function() {
                    if (input_password.value !== input_password_res.value) {
                        p_password.style.display = 'block';
                        p_password.innerText = 'Les mots de passe ne correspondent pas.';
                    } else {
                        p_password.style.display = 'none';
                    }
                });

                input_password_res.addEventListener('input', function() {
                    if (input_password.value !== input_password_res.value) {
                        p_password.style.display = 'block';
                        p_password.innerText = 'Les mots de passe ne correspondent pas.';
                    } else {
                        p_password.style.display = 'none';
                    }
                });
            }
        });
    </script>
</body>
</html>
