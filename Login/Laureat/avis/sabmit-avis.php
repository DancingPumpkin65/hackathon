<?php
// Start session
session_start();

// Include the database configuration file
include "../../../includes/PHP/config.php";
include "head.php";

if (!isset($_SESSION['user_data'])) {
    // Redirect to login page or display an error message
    header("Location: login.php");
    exit();
}

// Initialize variables
$avis = '';
$error = '';
$success_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the input
    $avis = htmlspecialchars(trim($_POST['avis']));

    // Check if the avis is not empty
    if (empty($avis)) {
        $error = "Please enter your feedback.";
    } else {
        // Check if the user has already submitted feedback
        $userId = $_SESSION['user_data']['Identifiant'];
        $stmt = $pdo->prepare("SELECT * FROM Avis WHERE identifiant = :identifiant");
        $stmt->bindParam(':identifiant', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $existingFeedback = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingFeedback) {
            // Update the existing feedback
            $sql = "UPDATE Avis SET Avis = :avis, dateA = NOW() WHERE identifiant = :identifiant";
        } else {
            // Insert new feedback
            $sql = "INSERT INTO Avis (identifiant, Avis, dateA) VALUES (:identifiant, :avis, NOW())";
        }

        // Prepare the statement
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':identifiant', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':avis', $avis, PDO::PARAM_STR);

        // Execute the statement
        if ($stmt->execute()) {
            // Feedback submitted or updated successfully
            $success_message = "Your feedback has been ";
            $success_message .= $existingFeedback ? "updated" : "submitted";
            $success_message .= " successfully.";

            // Empty the textarea after successful submission
            $avis = '';
        } else {
            $error = "Error occurred while submitting your feedback. Please try again later.";
        }
    }
}

$userId = $_SESSION['user_data']['Identifiant'];
$stmt = $pdo->prepare("SELECT Avis, dateA FROM Avis WHERE identifiant = :identifiant");
$stmt->bindParam(':identifiant', $userId, PDO::PARAM_INT);
$stmt->execute();
$userFeedback = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
            color: #007bff;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .avi{
            text-align: center;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
        }

        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            resize: vertical;
            background-color: #e9f0f9;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        #success_message,
        #error_message {
            margin-top: 10px;
            padding: 10px;
            border-radius: 6px;
        }

        #success_message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        #error_message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        
        .comment-box {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        .comment {
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .comment p {
            margin: 0;
        }

        .comment p:last-child {
            margin-bottom: 5px;
        }

        .comment .date {
            color: #999;
            font-size: 0.9em;
        }
    </style>
    <script>
        // Function to hide success and error messages after 2 seconds
        function hideMessages() {
            setTimeout(function () {
                document.getElementById('success_message').style.display = 'none';
                document.getElementById('error_message').style.display = 'none';
            }, 2000); // 2 seconds
        }
    </script>
</head>
<body onload="hideMessages()">
    <h1>Submit Feedback</h1>
    <form method="post">
        <label for="avis">Your Feedback:</label><br>
        <textarea id="avis" name="avis" rows="4" cols="50"><?php echo $avis; ?></textarea><br>
        <input type="submit" value="Submit">
        <?php if (!empty($error)): ?>
            <p id="error_message"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <p id="success_message"><?php echo $success_message; ?></p>
        <?php endif; ?>
    </form>

    <?php if ($userFeedback): ?>
        <div class="comment-box">
            <h2>Your Feedback</h2>
            <div class="comment">
                <p><?php echo $userFeedback['Avis']; ?></p>
                <p class="date">Submitted on: <?php echo date('Y-m-d ', strtotime($userFeedback['dateA'])); ?></p>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>
