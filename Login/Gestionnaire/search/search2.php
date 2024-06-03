<html>
    <style>
table {
    width: 20%;
    border-collapse: collapse;
    font-size: 1rem;
    text-align: left;
    margin-left: 5%;
    margin-top: 2rem;
    margin-bottom: 2rem;
}

table th, table td {
    padding: 10px 10px;
    border: 1px solid black;
}

table thead {
    background-color: black;
}
table tr:nth-child() {
    background-color: black;
}
table tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tr:hover {
    background-color: #f1f1f1;
}
button {
    background-color: #ff4c4c;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
}

button:hover {
    background-color: #ff1a1a;
}
    </style>
</html>
<?php
include "../../../includes/PHP/config.php";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $valid_fields = array('Identifiant', 'nom', 'Prenom', 'email', 'Tel', 'promotion', 'Filiere', 'Etablissement', 'Fonction', 'Employeur');

    $statement = $pdo->prepare("SELECT Identifiant, nom, Prenom, email, Tel, promotion, Filiere, Etablissement, Fonction, Employeur FROM laureat");

    function fetchDataAsTable($pdo, $statement) {
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $html = '<table border="1">';
        $html .= '<tr><th>Identifiant</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Tel</th><th>Promotion</th><th>Filière</th><th>Etablissement</th><th>Fonction</th><th>Employeur</th><th>Action</th></tr>';
        
        foreach ($result as $row) {
            $html .= '<tr>';
            $html .= '<td>' . $row['Identifiant'] . '</td>';
            $html .= '<td>' . $row['nom'] . '</td>';
            $html .= '<td>' . $row['Prenom'] . '</td>';
            $html .= '<td>' . $row['email'] . '</td>';
            $html .= '<td>' . $row['Tel'] . '</td>';
            $html .= '<td>' . $row['promotion'] . '</td>';
            $html .= '<td>' . $row['Filiere'] . '</td>';
            $html .= '<td>' . $row['Etablissement'] . '</td>';
            $html .= '<td>' . $row['Fonction'] . '</td>';
            $html .= '<td>' . $row['Employeur'] . '</td>';
            $html .= '<td><form method="post" action="delete.php"><input type="hidden" name="id" value="' . $row['Identifiant'] . '"><button type="submit">Delete</button></form></td>';
            $html .= '</tr>';
        }
        
        $html .= '</table>';
        return $html;
    }

    if(isset($_GET['search']) && !empty($_GET['search']) && isset($_GET['field']) && in_array($_GET['field'], $valid_fields)) {
        $search_value = $_GET['search'];
        $field = $_GET['field'];
        $statement = $pdo->prepare("SELECT Identifiant, nom, Prenom, email, Tel, promotion, Filiere, Etablissement, Fonction, Employeur FROM laureat WHERE $field LIKE :search_value");
        $search_value_with_wildcard = '%' . $search_value . '%';
        $statement->bindParam(':search_value', $search_value_with_wildcard);
        echo fetchDataAsTable($pdo, $statement);
    } else {
        echo fetchDataAsTable($pdo, $statement);
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
