<?php
include '../../../includes/PHP/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $option = $_POST['options'];
    $inputText = $_POST['inputText'];

    try {
        if ($option === 'filiere') {
            $stmt = $pdo->prepare("INSERT INTO Filiere (CodeF, LibelleF) VALUES (:code, :libelle)");
            $code = generateCode('F');  
            $stmt->bindParam(':code', $code);
            $stmt->bindParam(':libelle', $inputText);
        } elseif ($option === 'etablissement') {
            $stmt = $pdo->prepare("INSERT INTO EFP (CodeE, LibelleE) VALUES (:code, :libelle)");
            $code = generateCode('E'); 
            $stmt->bindParam(':code', $code);
            $stmt->bindParam(':libelle', $inputText);
        } else {
            throw new Exception("Invalid option selected.");
        }

        $stmt->execute();
        echo "Record inserted successfully.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function generateCode($type) {
    return $type . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Record</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <form action="" method="post">
            <label for="options">Choose an option:</label>
            <select id="options" name="options">
                <option value="filiere">Filiere</option>
                <option value="etablissement">Etablissement</option>
            </select>
            <br><br>
            <label for="inputText">Enter text:</label>
            <input type="text" id="inputText" name="inputText" required>
            <br><br>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}
:root {
    --body-color: #E4E9F7;
    --sidebar-color: #FFF;
    --primary-color: #695CFE;
    --primary-color-light: #F6F5FF;
    --toggle-color: #DDD;
    --text-color: #707070;
}
body {
    height: 100vh;
    display: flex;
    background-color: var(--body-color);
}
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 250px;
    background: var(--sidebar-color);
    padding: 10px 14px;
    transition: width 0.5s;
    z-index: 10000;
}
.sidebar.close {
    width: 88px;
}
.sidebar .image-text {
    display: flex;
    align-items: center;
}
.sidebar .image-text .logo-text {
    display: flex;
    flex-direction: column;
    align-items: center;
}
.sidebar .image-text .name {
    margin-top: 2px;
    font-size: 18px;
    font-weight: 600;
}
.sidebar .toggle {
    position: absolute;
    top: 50%;
    right: -25px;
    transform: translateY(-50%) rotate(180deg);
    height: 25px;
    width: 25px;
    background-color: var(--primary-color);
    color: var(--sidebar-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    cursor: pointer;
    transition: transform 0.5s;
}
.sidebar.close .toggle {
    transform: translateY(-50%) rotate(0deg);
}
.sidebar .menu {
    margin-top: 40px;
}
.sidebar .menu-links {
    list-style: none;
    padding: 0;
}
.sidebar .menu-links li {
    margin-top: 10px;
}
.sidebar .menu-links a {
    display: flex;
    align-items: center;
    padding: 10px;
    text-decoration: none;
    color: var(--text-color);
    transition: background-color 0.3s, color 0.3s;
}
.sidebar .menu-links a:hover {
    background-color: var(--primary-color-light);
    color: var(--primary-color);
}
.sidebar .menu-links .icon {
    font-size: 24px;
    margin-right: 10px;
}
.home {
    flex-grow: 1;
    padding: 20px;
    transition: margin-left 0.5s;
}
.sidebar.close ~ .home {
    margin-left: 88px;
}
.form-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
}
form {
    max-width: 600px;
    width: 100%;
    padding: 2rem;
    background: var(--sidebar-color);
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
form label {
    display: block;
    margin-bottom: 0.5rem;
    color: var(--text-color);
    font-weight: 500;
}
form input[type="text"], form select {
    width: 100%;
    padding: 0.5rem;
    margin-bottom: 1rem;
    border: 1px solid #ccc;
    border-radius: 4px;
}
form input[type="submit"] {
    padding: 0.5rem 1rem;
    background: var(--primary-color);
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background 0.3s;
}
form input[type="submit"]:hover {
    background: var(--primary-color-light);
    color: var(--primary-color);
}

</style>