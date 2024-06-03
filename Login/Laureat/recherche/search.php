<?php
include '../../../includes/PHP/config.php';

$searchTerm = '';
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$totalPages = 0;
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];

    $sql = "SELECT * FROM Laureat WHERE 1=1";
    $params = [];
    if (!empty($searchTerm)) {
        $sql .= " AND (nom LIKE :searchTerm OR prenom LIKE :searchTerm OR promotion LIKE :searchTerm OR Filiere LIKE :searchTerm OR Etablissement LIKE :searchTerm OR Fonction LIKE :searchTerm OR Employeur LIKE :searchTerm)";
        $params[':searchTerm'] = "%$searchTerm%";
    }

    $countSql = "SELECT COUNT(*) FROM ($sql) AS total";
    $stmt = $pdo->prepare($countSql);
    $stmt->execute($params);
    $totalResults = $stmt->fetchColumn();

    $sql .= " LIMIT :limit OFFSET :offset";
    $params[':limit'] = $limit;
    $params[':offset'] = $offset;

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    if (!empty($searchTerm)) {
        $stmt->bindParam(':searchTerm', $params[':searchTerm'], PDO::PARAM_STR);
    }
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $totalPages = ceil($totalResults / $limit);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Laureates</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>

        
        .laureate {
            border: 1px solid #ccc6;
            padding: 10px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            background-color: #f8f9fa; /* Couleur de fond */
            border-radius: 5px; /* Coins arrondis */
            box-shadow: 0 0px 7px rgba(0, 0, 0, 0.01); /* Ombre */
            min-width: fit-content;
        }
        .laureate img {
            max-width: 100px;
            margin-right: 10px;
            border-radius: 50%; 
        }
        .laureate h3 a {
            color: #007bff; /* Couleur du lien */
            text-decoration: none; /* Supprime le soulignement du lien */
        }
        .laureate h3 a:hover {
            text-decoration: underline; /* Soulignement du lien au survol */
        }
        .pagination {
            justify-content: center; /* Centre la pagination horizontalement */
            
            padding: 10px; /* Ajout de marge intérieure pour l'ombre */
            background-color: #fff; /* Fond blanc pour l'ombre */
            border-radius: 5px; /* Coins arrondis */
        }
        .pagination .page-item .page-link {
            color: #007bff; /* Couleur des numéros de page */
            background-color: transparent; /* Fond transparent */
            border: none; /* Supprime la bordure */
            transition: background-color 0.3s, color 0.3s; /* Transition lors du survol */
        }
        .pagination .page-item .page-link:hover {
            background-color: #007bff; /* Couleur de fond au survol */
            color: #fff; /* Couleur du texte au survol */
        }
        .pagination .page-item.active .page-link {
            background-color: #007bff; /* Couleur de fond pour la page active */
            color: #fff; /* Couleur du texte pour la page active */
        }

         /* Responsive styles */
         @media screen and (max-width: 400px) {
            form {
                padding: 10px;
            }

            textarea {
                width: calc(100% - 20px); /* Adjust for padding */
            }

            input[type="submit"] {
                width: 100%;
            }
        }
    </style>
</head>
<body >
<?php include 'header.php'; ?><br><br><br><br>
<div style="display: flex;flex-direction:column;
        align-items: center;
        justify-content: center;" class="container">
    <h1 style="margin-bottom:2rem;" class="mt-5">Rechercher lauréats</h1>

    <!-- Display Search Results -->
    <div class="row">
        <?php if (!empty($results)): ?>
            <?php foreach ($results as $row): ?>
                <div class="col-md-6 this">
                    <div class="laureate">
                        <img style="width: 70px; border-radius: 5px; height: 70px; box-shadow: 1px 1px 15px rgba(0,0,0,0.1);" src="../<?php echo htmlspecialchars($row['photo']); ?>" alt="Profile Picture">
                        <div>
                            <h3 class="min">
                                <a style="text-decoration: none; font-weight: 600; font-size: 1.3rem;" href="profile.php?id=<?php echo htmlspecialchars($row['Identifiant']); ?>">
                                    <?php echo htmlspecialchars($row['nom'] . ' ' . $row['Prenom']); ?><br>
                                    <span style="text-decoration: none; font-weight: 400; font-size: 1rem; color:black; opacity:0.5;"><?php echo htmlspecialchars($row['Filiere']); ?></span>
                                </a>
                            </h3>
                            <!-- Additional details can be added here -->
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col"><p>No laureates found</p></div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <nav style='background-color: rgba(205,231,255,0.1); width:50%;' style="display: flex;
        align-items: center;
        justify-content: center;" aria-label="Page navigation">
        <ul style="margin-left:46%;margin-right:30%;" class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?search=<?php echo urlencode($searchTerm); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
</body>
</html>
<style>
    .this {
        background-color: white;
        
    }
</style>