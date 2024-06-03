<?php
include "../../../includes/PHP/config.php";
include 'head.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function getPublicSouvenirsByYear($pdo, $year) {
    $stmt = $pdo->prepare("SELECT Souvenir.photo, Souvenir.datetime, Souvenir.description, Souvenir.IdSouvenir, Laureat.nom, Laureat.Prenom
                           FROM Souvenir
                           INNER JOIN Laureat ON Souvenir.identifiant = Laureat.Identifiant
                           WHERE Souvenir.visibility = 'public' AND YEAR(Souvenir.datetime) = :year
                           ORDER BY Souvenir.datetime DESC");
    $stmt->execute(['year' => $year]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllPublicSouvenirs($pdo) {
    $stmt = $pdo->query("SELECT Souvenir.photo, Souvenir.datetime, Souvenir.description, Souvenir.IdSouvenir, Laureat.nom, Laureat.Prenom
                           FROM Souvenir
                           INNER JOIN Laureat ON Souvenir.identifiant = Laureat.Identifiant
                           WHERE Souvenir.visibility = 'public'
                           ORDER BY Souvenir.datetime DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$year = isset($_GET['year']) ? $_GET['year'] : ''; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Souvenirs</title>
    <!-- Bootstrap CSS -->
</head>
<style>
        /* Form container */
        .form-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
            
        }

        /* Form style */
        form {
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 1px 1px 15px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            padding: 10px;
            background-color: white;
            margin-bottom: 3rem;
            margin-left: 20%;
            margin-right: 20%;
        }

        /* Label style */
        label {
            margin-right: 10px;
        }

        /* Input style */
        input[type="text"] {
            padding: 4px;
            border-radius: 3px;
            border-width: 1px;
            border: 1px solid white;
            box-shadow: 1px 1px 15px rgba(0, 0, 0, 0.1);
        }

        /* Button style */
        #tot button {
        border: 1px solid white;
        color: white;
        border-width: 1px;
        padding: 4px;
        width: 20%;
        border-radius: 0.3125rem; 
        background: rgb(29,122,208);
        background: linear-gradient(330deg, rgba(29,122,208,1) 0%, rgba(17,71,122,1) 100%);
        transition: background-color 0.8s, color 0.3s;
        box-shadow: 1px 1px 15px rgba(0, 0, 0, 0.1);
    }
    #tot button:hover {
    background: linear-gradient(190deg, rgba(29,122,208,1) 0%, rgba(17,71,122,1) 100%);
}
.no-publication {
    color: black;
    font-weight:400;
    opacity:0.7; /* Change text color to red */
    margin-top: 10px; /* Add some top margin */
}
.promo {
    color: black;
    font-weight:600;
    opacity:0.7; /* Change text color to red */
    margin-top: 10px; /* Add some top margin */
}
    </style>
<body>
    <div class="container">
        <h1 class="mt-5">Souvenirs</h1>

        <form method="GET" action="" id="tot">
            <label class="promo" for="year">Promotion: </label>
            <input type="text" name="year" id="year" value="<?php echo htmlspecialchars($year); ?>">
            <button type="submit">Chercher</button>
        </form>
        
        <?php
        if (!empty($year)) {
            $filteredSouvenirs = getPublicSouvenirsByYear($pdo, $year);
        } else {
            $filteredSouvenirs = getAllPublicSouvenirs($pdo);
        }

        if ($filteredSouvenirs) {
            $rowCount = 0;
            foreach ($filteredSouvenirs as $souvenir) {
                if ($rowCount % 3 == 0) {
                    echo '';
                }
                ?>
                <div class="row">
                    <div class="card">
                            <p class="card-text" id="p1">
                                <img style="height: 50px;width:50px;" src="../<?php echo htmlspecialchars($user_data['photo']); ?>">
                                <a class="card-link" href="../recherche/profile.php?id=<?php echo htmlspecialchars($user_data['Identifiant']); ?>">
                                    <?php echo htmlspecialchars($souvenir['nom'] . ' ' . $souvenir['Prenom']); ?>
                                </a>
                            </p>
                            <div id="img"><img src="./sevenir/<?php echo htmlspecialchars($souvenir['photo']); ?>" class="card-img-top" alt="Souvenir" class="img-fluid"></div>
                            <div class="likes">
                                <div class="gif-container">
                                    <img src="ups.png" alt="Static GIF" class="gif-static">
                                    <img src="ups.gif" alt="Animated GIF" class="gif-animated">
                                </div>
                                <div class="gif-container">
                                    <img src="downs.png" alt="Static GIF" class="gif-static">
                                    <img src="downs.gif" alt="Animated GIF" class="gif-animated">
                                </div>
                            </div>
                            <p class="card-text" id="p22"><?php echo htmlspecialchars($souvenir['description']); ?></p>
                            <p class="card-text" id="p2"><?php echo htmlspecialchars($souvenir['datetime']); ?></p>
                        
                </div>
                </div>
                <?php
                $rowCount++;
                if ($rowCount % 3 == 0) {
                    echo '</div>';
                }
            }
            if ($rowCount % 3 != 0) {
                echo '</div>';
            }
        } else {
            echo "<p class='no-publication'>Pas de publication pour cette promotion.</p>";
        }
        ?>
    </div>

</body>
</html>
<style>
    .container {}
    .gif-container {
        display: inline-block;
        cursor: pointer;
    }
    .gif-container img {
        display: block;
    }
    .gif-container .gif-static {
        display: block;
    }
    .gif-container .gif-animated {
        display: none;
    }
    .gif-container:hover .gif-static {
        display: none;
    }
    .gif-container:hover .gif-animated {
        display: block;
    }
    .likes {
        margin-top: 1rem;
    }
    .likes img {
        height: 30px;
        margin-left: 1rem;
    }
    
    .card {
        border-radius: 10px;
    }
    .card-text {
        margin-top: 1rem;
        margin-left: 1rem;
    }
    .card-text a {
        color: black;
        font-weight: 600;
    }
    .card-img-top {
        height: auto;
        border-radius: 0;
    }
    .dead {
        width: 100%;
    }
    .stacked-images {
        position: absolute;
        right: 12%;
        bottom: 15%;
    }
    
    .stacked-images img:nth-child(1) {
        position: absolute;
        top: 0;
        width: 20px;
        transform: translateX(0);
        opacity: 0.3;
    }

    .stacked-images img:nth-child(2) {
        position: absolute;
        width: 20px;
        transform: translateX(10px);
        opacity: 0.6;
    }
    .stacked-images img:nth-child(3) {
        position: absolute;
        width: 20px;
        transform: translateX(20px);
    }
    body {
        background-color: rgb(244, 247, 250);
    }   
    .row {
        border-radius: 10px;
        margin-bottom: 2rem;
        position: relative;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: white;
        box-shadow: 1px 1px 30px rgba(0,0,0,0.1);
    }
    .mt-5 {
        font-weight: 400;
        font-size: 4rem;
    }
    .row .card {
        margin: auto 0;
        border: none;
    }
    .row .card .card-body {
        width: 100%;
        border: none;
    }
    .row .card .card-body #img {
        width: auto;
        height: auto;
        overflow: hidden;
        position: relative;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center; 
        box-shadow: 5px 15px 30px rgba(0,0,0,0.1);
    }
    .row .card .card-body img { 
    }
    .row .card .card-body #img img {
        max-width: 100%;
        max-height: 20rem;
    }
    .row .card .card-body .card-text {
        margin: 0;
    }
    .row .card .card-body .card-link {
        border: 1px solid white;
        color: white;
        padding: 0.2rem 1.1rem; 
        width: 9rem;
        border-radius: 0.3125rem; 
        background: rgb(29,122,208);
        background: linear-gradient(330deg, rgba(29,122,208,1) 0%, rgba(17,71,122,1) 100%);
        transition: background-color 0.8s, color 0.3s;
    }   
    .row .card .card-body .card-link:hover{
        border: 1px solid white;
        color: white;
        padding: 0.2rem 1.1rem; 
        width: 9rem;
        border-radius: 0.3125rem; 
        background: rgb(29,122,208);
        background: linear-gradient(135deg, rgba(29,122,208,1) 0%, rgba(17,21,122,1) 100%);
    }
    .row .card .card-body #p1 {
        margin-top: 1rem;
        font-weight: 600;
        font-size: 1rem;
        color: rgba(0,0,0,0.7);
    }
    .row .card .card-body #p2 {
        font-weight: 600;
        font-size: 0.8rem;
        color: rgba(0,0,0,0.5);
        margin-bottom: 1rem;
    }
</style>
