<?php
include "../../includes/PHP/config.php";

// Fetch data for unverified laureates grouped by promotion
$sql_unverified = "SELECT promotion, COUNT(*) as num_laureates FROM laureat WHERE valide IS NULL OR valide = 0 GROUP BY promotion";
$stmt_unverified = $pdo->prepare($sql_unverified);

// Execute the prepared statement
try {
    $stmt_unverified->execute();
    $unverified_data = $stmt_unverified->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Calculate total number of unverified laureates
$sql_unverified_total = "SELECT COUNT(*) AS num_laureates FROM laureat WHERE valide IS NULL OR valide = 0";
$stmt_unverified_total = $pdo->prepare($sql_unverified_total);

try {
    $stmt_unverified_total->execute();
    $result_unverified_total = $stmt_unverified_total->fetch(PDO::FETCH_ASSOC);
    $num_unverified_total = $result_unverified_total['num_laureates'];
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Unverified Laureates Chart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header" style="font-size: 0.9rem; font-weight:600;">
            Non-vérifiée<img src="gestioner_index_page/unverified.png" style="width:45px;top:0; background: rgb(3,144,80);
background: linear-gradient(135deg, rgba(3,144,80,1) 0%, rgba(3,221,122,1) 100%);border-radius:100%;position:absolute;right:1rem;padding:0.7rem">
        </div>
        <div class="card-body">
            <div id="chart_div_unverified" style="width: 100%; height: 200px;"></div>
        </div>
        <div class="card-footer">
            <p class="mb-0" style="font-size: 0.7rem; font-weight:600;">Nombre total des personnes non-vérifiée: <?php echo $num_unverified_total; ?></p>
        </div>
    </div>
</div>

<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChartUnverified);

function drawChartUnverified() {
    // Prepare the data array
    var data = google.visualization.arrayToDataTable([
        ['Promotion Year', 'Number of Unverified Laureates'],
        <?php
        foreach ($unverified_data as $row) {
            echo "['" . $row['promotion'] . "', " . $row['num_laureates'] . "],";
        }
        ?>
    ]);

    var options = {
        title: 'Number of Unverified Laureates by Promotion',
        hAxis: {title: 'Year', titleTextStyle: {color: '#333'}},
        vAxis: {minValue: 0},
        legend: { position: 'none' },
        chartArea: {width: '70%', height: '70%'},
        colors: ['#1b9e77', '#00FF00', '#0000FF', '#FFFF00', '#FF00FF'] // Add your desired colors here
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_unverified'));
    chart.draw(data, options);
}
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
