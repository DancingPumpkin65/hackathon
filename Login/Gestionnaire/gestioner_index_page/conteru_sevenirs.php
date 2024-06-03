<?php
include "../../includes/PHP/config.php";

// Fetch data for souvenirs grouped by dateS
$sql_souvenirs = "SELECT dateS, COUNT(*) as num_souvenirs FROM souvenir GROUP BY dateS";
$stmt_souvenirs = $pdo->prepare($sql_souvenirs);

// Execute the prepared statement
try {
    $stmt_souvenirs->execute();
    $souvenirs_data = $stmt_souvenirs->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Calculate total number of souvenirs
$sql_total_souvenirs = "SELECT COUNT(*) AS souvenir FROM souvenir";
$stmt_total_souvenirs = $pdo->prepare($sql_total_souvenirs);

try {
    $stmt_total_souvenirs->execute();
    $result_total_souvenirs = $stmt_total_souvenirs->fetch(PDO::FETCH_ASSOC);
    $souvenir_total = $result_total_souvenirs['souvenir'];
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Souvenir Chart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header" style="font-size: 0.9rem; font-weight:600;">
            Souvenirs<img src="gestioner_index_page/souvenir.png" style="width:45px;top:0; background: rgb(167,29,29);
background: linear-gradient(135deg, rgba(167,29,29,1) 0%, rgba(244,116,116,1) 100%);border-radius:100%;position:absolute;right:1rem;padding:0.7rem">
        </div>
        <div class="card-body">
            <div id="chart_div_souvenirs" style="width: 100%; height: 200px;"></div>
        </div>
        <div class="card-footer">
            <p class="mb-0" style="font-size: 0.7rem; font-weight:600;">Nombre total des souvenirs: <?php echo $souvenir_total; ?></p>
        </div>
    </div>
</div>

<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChartSouvenirs);

function drawChartSouvenirs() {
    var data = google.visualization.arrayToDataTable([
        ['Date', 'Number of Souvenirs'],
        <?php
        foreach ($souvenirs_data as $row) {
            echo "['" . $row['dateS'] . "', " . $row['num_souvenirs'] . "],";
        }
        ?>
    ]);

    var options = {
        title: 'Number of Souvenirs by Date',
        hAxis: {title: 'Date', titleTextStyle: {color: '#333'}},
        vAxis: {minValue: 0},
        legend: { position: 'none' },
        chartArea: {width: '70%', height: '70%'},
        colors: ['#f65a5a', '#00FF00', '#0000FF', '#FFFF00', '#FF00FF'] // Add your desired colors here
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_souvenirs'));
    chart.draw(data, options);
}
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
