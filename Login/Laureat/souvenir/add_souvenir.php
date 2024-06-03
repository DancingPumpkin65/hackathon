<?php
include "../../../includes/PHP/config.php";
include 'head.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$errorMsg = '';
$successMsg = '';

function getLastTenImages($pdo, $userId)
{
    $stmt = $pdo->prepare("SELECT photo, dateS, visibility, description, IdSouvenir FROM Souvenir WHERE identifiant = :identifiant ORDER BY dateS DESC LIMIT 10");
    $stmt->bindParam(':identifiant', $userId);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// echo "<p>before delete</p>";
include 'del_souvenir.php';

// Check if form is submitted
// var_dump($_FILES);
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["photo"])) {
    // echo "<p>enter submit action</p>";
    if (empty($_FILES["photo"]["name"])) {
        echo "<p>emty file rror</p>";
        $errorMsg = "Please select a file.";
    } else {
        // echo "<p>file exixts</p>";
        $targetDir = "./sevenir/";

        if ($_FILES["photo"]["error"] != UPLOAD_ERR_OK) {
            // echo "<p>error uploading the thing</p>";
            $errorMsg = "Sorry, there was an error uploading your file. Error code: " . $_FILES["photo"]["error"];
        } else {
            // echo "<p>nor upload error so far</p>";
            if (!file_exists($targetDir)) {
                if (!mkdir($targetDir, 0777, true)) {
                    $errorMsg = "Failed to create directory";
                }
            }

            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION));
            $targetFile = $targetDir . basename($_FILES["photo"]["name"]);

            $check = getimagesize($_FILES["photo"]["tmp_name"]);
            if ($check === false) {
                $errorMsg = "File is not an image.";
                $uploadOk = 0;
            }

            if ($_FILES["photo"]["size"] > 500000) {
                $errorMsg = "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            $allowedFormats = array("jpg", "jpeg", "png", "gif");
            if (!in_array($imageFileType, $allowedFormats)) {
                $errorMsg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                $errorMsg = "Sorry, your file was not uploaded.";
                // echo "<p>image error upload 0</p>";
            } else {
                $visibility = $_POST['visibility'];
                $description = $_POST['description'];

                if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
                    // echo "<p>image added</p>";
                    $userId = $_SESSION['user_data']['Identifiant'];
                    $stmt = $pdo->prepare("INSERT INTO Souvenir (photo, dateS, identifiant, visibility, description) VALUES (:photo, NOW(), :identifiant, :visibility, :description)");
                    // echo "<p>stmt prepare</p>";
                    $stmt->bindParam(':photo', $_FILES["photo"]["name"]);
                    $stmt->bindParam(':identifiant', $userId);
                    $stmt->bindParam(':visibility', $visibility);
                    $stmt->bindParam(':description', $description);

                    if ($stmt->execute()) {
                        // echo "<p>added succes</p>";
                        $successMsg = "The file " . htmlspecialchars(basename($_FILES["photo"]["name"])) . " has been uploaded.";
                    } else {
                        $errorMsg = "Sorry, there was an error uploading your file to the database.";
                    }
                } else {
                    $errorMsg = "Sorry, there was an error moving your uploaded file.";
                }
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Photo</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet">
    <script>
        function hideMessages() {
            setTimeout(function () {
                document.getElementById('successMsg').style.display = 'none';
                document.getElementById('errorMsg').style.display = 'none';
            }, 2000);
        }
    </script>
</head>
<style>
    #photo {
        cursor: pointer;
        width: 90%;
        margin: 1rem;
    }

    form {
        border-radius: 10px;
        margin-left: 30%;
        margin-right: 30%;
        box-shadow: 1px 1px 15px rgba(0, 0, 0, 0.1);
    }

    select,
    textarea,
    #sub {
        width: 90%;
        margin-bottom: 10px;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    textarea {
        resize: vertical;
        height: 100px;
    }

    #sub {
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
    }

    #sub:hover {
        background-color: #45a049;
    }

    #errorMsg,
    #successMsg {
        margin-top: 10px;
    }

    #errorMsg {
        color: red;
    }

    #successMsg {
        color: green;
    }

    h1 {
        margin-left: 20%;
        margin-bottom: 3rem;
        margin-top: 3rem;
    }

    #sub {
        border: 1px solid white;
        color: white;
        padding: 0.2rem 1.1rem;
        width: 90%;
        border-radius: 0.3125rem;
        background: rgb(29, 122, 208);
        background: linear-gradient(330deg, rgba(29, 122, 208, 1) 0%, rgba(17, 71, 122, 1) 100%);
        transition: background-color 0.8s, color 0.3s;
    }

    #sub:hover {
        background: linear-gradient(190deg, rgba(29, 122, 208, 1) 0%, rgba(17, 71, 122, 1) 100%);
    }
</style>

<body onload="hideMessages()" style="background-color: rgb(244, 247, 250);">
    <h1 style="margin-left: 20%; margin-bottom: 2rem; margin-top: 3rem;">My Souvenir</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data"
        style="cursor: pointer; display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <label for="photo">
            <input type="file" id="photo" name="photo" id="photo" />
        </label>
        <select name="visibility">
            <option value="public">Public</option>
            <option value="private">Private</option>
        </select>
        <textarea name="description" placeholder="Enter description"></textarea>
        <input type="submit" name="submit" value="Envoyer" id="sub">
        <span id="errorMsg" style="color: red;"><?php echo $errorMsg; ?></span>
        <span id="successMsg" style="color: green;"><?php echo $successMsg; ?></span>
    </form>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.js"></script>
    <script
        src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script
        src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>


    <?php
    // Include Bootstrap CSS
    echo '<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">';

    if (isset($_SESSION['user_data']['Identifiant'])) {
        $userId = $_SESSION['user_data']['Identifiant'];
        $lastTenImages = getLastTenImages($pdo, $userId);

        if ($lastTenImages) {
            echo "<h2 class='my-4' style='margin-left: 20%; margin-bottom: 2rem; margin-top: 3rem;'>Last 10 Posts:</h2>";
            echo "<div class='container'>";
            echo "<div class='row'>";
            foreach ($lastTenImages as $image) {
                echo "<div class='col-md-6 col-lg-4 mb-4'>";
                echo "<div class='card'  style='box-shadow: 1px 1px 15px rgba(0, 0, 0, 0.2);'>";
                echo "<img src='sevenir/{$image['photo']}' class='card-img-top' alt='Image'>";
                echo "<div class='card-body'>";
                echo "<p class='card-text'><strong>Date:</strong> {$image['dateS']}</p>";
                echo "<p class='card-text'><strong>Visibility:</strong> " . ucfirst($image['visibility']) . "</p>"; // Display visibility
                echo "<p class='card-text'><strong>Description:</strong> {$image['description']}</p>"; // Display description
                ?>
                <form action="" method="post" class="mb-2" style="margin:0; padding:0;">
                    <input type="hidden" name="photo_id" value="<?php echo $image['IdSouvenir']; ?>">
                    <div class="form-group">
                        <select name="visibility" class="form-control">
                            <option value="public" <?php if ($image['visibility'] == 'public')
                                echo 'selected'; ?>>Public</option>
                            <option value="private" <?php if ($image['visibility'] == 'private')
                                echo 'selected'; ?>>Privé</option>
                        </select>
                    </div>
                    <button type="submit" class="deb" name="update_visibility" class="btn btn-primary btn-block">Changer la
                        confidentialité</button>
                </form>
                <?php
                echo "<a href='?delete={$image['photo']}' class='btn btn-danger btn-block deb' onclick='return confirm(\"Are you sure you want to delete this souvenir?\")'>Supprimer</a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
            echo "</div>";
        }
    }
    ?>

</body>

</html>
<style>
    .deb {
        border: 1px solid white;
        color: white;
        padding: 0.2rem 1.1rem;
        width: 100%;
        border-radius: 0.3125rem;
        background: rgb(29, 122, 208);
        background: linear-gradient(330deg, rgba(29, 122, 208, 1) 0%, rgba(17, 71, 122, 1) 100%);
        transition: background-color 2s, color 0.3s;
        border: none;
    }

    .deb:hover {
        background: linear-gradient(190deg, rgba(29, 122, 208, 1) 0%, rgba(17, 71, 122, 1) 100%);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: white;
        padding: 0.625rem 1.25rem;
        color: black;
        position: relative;
        width: 100vw;
        border-bottom: 1px solid rgba(128, 128, 128, 0.212);
    }

    #part1 {
        display: flex;
        align-items: center;
    }

    .active {
        color: #00529B;
    }

    #part1 img {
        height: 3.125rem;
        margin-right: 1.25rem;
    }

    #part1 ul {
        list-style: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1.25rem;
        margin-bottom: 0;
    }

    #part1 ul li {
        margin-left: 2rem;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: color 0.3s;
    }

    #part1 ul li:hover {
        color: #047de7;
    }

    #part1 ul li a {
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: color 0.3s;
        color: #00529B;
    }

    #part1 ul li:hover {
        color: #047de7;
    }

    #part2 {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        position: relative;
    }

    #part2 .connect {
        background: none;
        border: 1px solid white;
        color: #00529B;
        padding: 0rem 0.5rem;
        width: 13rem;
        height: 3rem;
        border-radius: 0.3125rem;
        border: 1px solid rgba(128, 128, 128, 0.212);
        transition: background-color 0.3s, color 0.3s;
        display: flex;
        align-items: center;
        justify-items: center;
    }

    #part2 .insc {
        border: 1px solid white;
        color: white;
        padding: 0.3125rem 0;
        width: 9rem;
        border-radius: 0.3125rem;
        background: rgb(29, 122, 208);
        background: linear-gradient(330deg, rgba(29, 122, 208, 1) 0%, rgba(17, 71, 122, 1) 100%);
        transition: background-color 0.3s, color 0.3s;
    }

    #part2 .insc:hover {
        cursor: pointer;
    }

    #part2 .connect:hover {
        background-color: rgba(128, 128, 128, 0.212);
        color: #333;
        cursor: pointer;
    }

    #part2 .toggle {
        display: none;
        position: absolute;
        top: 105%;
        left: 0;
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 0.3125rem;
        flex-direction: column;
        width: 13rem;

    }

    #part2 .toggle a {
        margin: 0.125rem;
        padding: 0.1875rem 0.8125rem;
        font-size: 0.8rem;
        color: #00529B;
        background-color: white;
        text-decoration: none;
        border-radius: 0.3125rem;
        transition: background-color 0.3s;
    }

    #part2 .toggle a:hover {
        background-color: rgba(128, 128, 128, 0.212);
        color: #333;
    }

    #part1 a {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    #menuIcon {
        display: none;
        font-size: 1.5rem;
        color: #00529B;
        cursor: pointer;
        position: absolute;
        top: 50%;
        right: 1.25rem;
        transform: translateY(-50%);
    }

    @media (max-width: 800px) {

        #part1 ul,
        #part2 {
            display: none;
        }

        #menuIcon {
            display: block;
        }

        nav.expanded #part1 ul,
        nav.expanded #part2 {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            position: absolute;
            top: calc(100% + 0.625rem);
            left: 0;
            width: 100%;
            background-color: white;
            padding: 1rem;
            gap: 1rem;
        }
    }

    .show {
        display: none;
    }

    #connectBtn {
        display: flex;
        align-items: center;
        justify-content: space-around;
        position: relative;
    }

    #connectBtn img {
        width: 3rem;
        height: 3rem;
        border: 1px solid black;
        border-radius: 5px;
        border: none;
    }
</style>