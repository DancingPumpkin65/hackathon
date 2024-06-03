<?php
session_start();
if (isset($_SESSION['isUserLoggedIn']) && $_SESSION['userType'] === 'gestionnaire') {
?>

<?php
include "../../../includes/PHP/config.php";

if (isset($_POST['delete_laureate'])) {
    $laureate_id = $_POST['laureate_id'];
    $delete_stmt = $pdo->prepare("DELETE FROM laureat WHERE Identifiant = ?");
    try {
        $delete_stmt->execute([$laureate_id]);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

if (isset($_POST['accept_laureate'])) {
    $laureate_id = $_POST['laureate_id'];
    $accept_stmt = $pdo->prepare("UPDATE laureat SET valide = 1 WHERE Identifiant = ?");
    try {
        $accept_stmt->execute([$laureate_id]);
    
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

$sql = "SELECT Identifiant, nom, Prenom, email, Tel, promotion, Filiere, Etablissement, Fonction, Employeur FROM laureat WHERE valide = 0 ";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute();
    $laureates = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Header</title>
    <?php include "head_unverified.php"; ?>
    <script src="https://cdn.emailjs.com/dist/email.min.js"></script>
    <script>
    emailjs.init("vKxMHYKJvJKYG8DeL");

    function sendEmail(email) {
        var templateParams = {
            to_email: email,
            message: "Congratulations! Your application has been accepted."
        };

        emailjs.send("service_fc6af2r", "template_ifz7p24", templateParams)
            .then(function(response) {
                console.log("Notification email sent successfully!", response);
                location.reload();
            }, function(error) {
                console.error("Notification email could not be sent", error);
            });
    }

</script>
    <script>
        function deleteLaureate(id) {
            if (confirm("Are you sure you want to delete this laureate?")) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "<?php echo $_SERVER['PHP_SELF']; ?>");
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        location.reload();
                    }
                };
                xhr.send("delete_laureate=1&laureate_id=" + id);
            }
        }

    function acceptLaureate(id, button) {
    if (confirm("Are you sure you want to accept this laureate?")) {
        var email = button.parentNode.parentNode.cells[2].textContent; 

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "<?php echo $_SERVER['PHP_SELF']; ?>");
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                sendEmail(email);
                
            }
        };
        xhr.send("accept_laureate=1&laureate_id=" + id);
    }
}
    </script>

    <style>
        .conteur_gestioner {
            height: 15rem;
            width: 15rem;
            background-color: aqua;
        }

        .main_gestioner {
            padding: 5rem 2rem ;
            padding-top: 5rem;
            width: 100%;
            padding-left: 1rem
        }
    </style>

</body>

</html>
<?php
} else {
    header("Location: login.php");
    exit();
}
?>
