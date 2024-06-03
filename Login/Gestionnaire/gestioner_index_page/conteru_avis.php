<?php
include "../../includes/PHP/config.php";

$sql_avis = "SELECT dateA, COUNT(*) as num_avis FROM avis GROUP BY dateA";
$stmt_avis = $pdo->prepare($sql_avis);

try {
    $stmt_avis->execute();
    $avis_data = $stmt_avis->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

$sql_total_avis = "SELECT COUNT(*) AS avis FROM avis";
$stmt_total_avis = $pdo->prepare($sql_total_avis);

try {
    $stmt_total_avis->execute();
    $result_total_avis = $stmt_total_avis->fetch(PDO::FETCH_ASSOC);
    $avis_total = $result_total_avis['avis'];
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Graph</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header"  style="font-size: 0.9rem; font-weight:600;">
            Avis<img src="gestioner_index_page/avis.png" style="width:45px; background: rgb(104,105,107);
background: linear-gradient(135deg, rgba(104,105,107,1) 0%, rgba(162,162,162,1) 100%);border-radius:100%;position:absolute;right:1rem;padding:0.7rem;top:0;">
        </div>
        <div class="card-body d-flex justify-content-center align-items-center">
            <div id="chart_div_avis" style="width: 70%; height: 200px;"></div>
        </div>
        <div class="card-footer">
            <p class="mb-0" style="font-size: 0.7rem; font-weight:600;">Nombre total des avis: <?php echo $avis_total; ?></p>
        </div>
    </div>
</div>

<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChartAvis);

function drawChartAvis() {
    var data = google.visualization.arrayToDataTable([
        ['Date', 'Number of Avis'],
        <?php
        foreach ($avis_data as $row) {
            echo "['" . $row['dateA'] . "', " . $row['num_avis'] . "],";
        }
        ?>
    ]);

    var options = {
        title: 'Number of Avis by Date',
        hAxis: {title: 'Date', titleTextStyle: {color: '#333'}},
        vAxis: {minValue: 0},
        legend: { position: 'none' },
        chartArea: {width: '70%', height: '70%'},
        colors: ['#9A9B9F', '#d95f02', '#7570b3'] 
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_avis'));
    chart.draw(data, options);
}

</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
