<?php
include '../../../includes/PHP/config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $sql = "SELECT * FROM Laureat WHERE Identifiant = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $laureate = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($laureate) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $subject = htmlspecialchars($_POST['subject']);
            $message = htmlspecialchars($_POST['message']);
            $laureateEmail = htmlspecialchars($laureate['email']);

            // Save the message in the database
            $sql = "INSERT INTO message (laureate_id, subject, message) VALUES (:laureate_id, :subject, :message)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':laureate_id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
            $stmt->bindParam(':message', $message, PDO::PARAM_STR);
            $stmt->execute();

            // Prepare the email headers
            $headers = "From: yourname@example.com\r\n";
            $headers .= "Reply-To: yourname@example.com\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();

            // Send the email
            if (mail($laureateEmail, $subject, $message, $headers)) {
                $response = ['status' => 'success', 'message' => 'Message sent successfully!'];
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to send the message.'];
            }

            echo json_encode($response);
            exit;
        }

        // Display laureate details
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laureate Profile</title>
    <style>
        /* Container */
        .containere {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: #e9f0f7;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding-top: 100px;
        }

        /* Profile Header */
        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-header .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }

        .profile-header h1 {
            font-size: 2em;
            color: #333;
        }

        /* Profile Details */
        .profile-details {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 20px;
            text-align: center;
        }

        .profile-details .profile-column {
            flex: 0 0 50%;
            padding: 10px;
        }

        .profile-details p {
            font-size: 1.1em;
            color: #555;
        }

        .profile-details p strong {
            color: #000;
        }

        /* Message Form */
        h2 {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 1.1em;
            color: #333;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
            color: #333;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1.1em;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .alert {
            padding: 20px;
            background-color: #f44336;
            color: white;
            border-radius: 4px;
            text-align: center;
            margin-top: 20px;
        }

        .alert-success {
            background-color: #4CAF50;
        }

        .alert-danger {
            background-color: #f44336;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .profile-details .profile-column {
                flex: 0 0 100%;
            }
        }

        @media (max-width: 480px) {
            .profile-header .profile-img {
                width: 100px;
                height: 100px;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="containere">
        <div class="profile-header">
            <img src="<?php echo !empty($laureate['photo']) ? '../../images_profil/' . htmlspecialchars($laureate['photo']) : 'default-profile.png'; ?>" alt="Profile Picture of <?php echo htmlspecialchars($laureate['nom']); ?>" class="profile-img mb-4">
            <h1 tabindex="0"><?php echo htmlspecialchars($laureate['nom'] . ' ' . $laureate['Prenom']); ?></h1>
        </div>
        <div class="profile-details row">
            <div class="profile-column">
                <p tabindex="0"><strong>Promotion:</strong> <?php echo htmlspecialchars($laureate['promotion']); ?></p>
                <p tabindex="0"><strong>Filiere:</strong> <?php echo htmlspecialchars($laureate['Filiere']); ?></p>
                <p tabindex="0"><strong>Etablissement:</strong> <?php echo htmlspecialchars($laureate['Etablissement']); ?></p>
            </div>
            <div class="profile-column">
                <p tabindex="0"><strong>Fonction:</strong> <?php echo htmlspecialchars($laureate['Fonction']); ?></p>
                <p tabindex="0"><strong>Employeur:</strong> <?php echo htmlspecialchars($laureate['Employeur']); ?></p>
            </div>
        </div>

        <!-- Message Form -->
        <h2 class="mt-5" tabindex="0">Send a Message</h2>
        <form id="messageForm">
            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" class="form-control" id="subject" name="subject" aria-required="true" required>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea class="form-control" id="message" name="message" rows="5" aria-required="true" required></textarea>
            </div>
            <button type="submit" class="btn">Send Email</button>
        </form>

        <div id="response" class="alert" style="display:none;"></div>

        <script>
            document.getElementById('messageForm').addEventListener('submit', function(event) {
                event.preventDefault();

                var form = event.target;
                var formData = new FormData(form);

                fetch('', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    var responseDiv = document.getElementById('response');
                    responseDiv.style.display = 'block';
                    responseDiv.textContent = data.message;
                    responseDiv.className = data.status === 'success' ? 'alert alert-success' : 'alert alert-danger';
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        </script>
    </div>
</body>
</html>
<?php
    } else {
        echo "<div class='containere'><p class='alert alert-danger mt-3'>Laureate not found.</p></div>";
    }
} else {
    echo "<div class='containere'><p class='alert alert-danger mt-3'>Invalid ID.</p></div>";
}
?>
