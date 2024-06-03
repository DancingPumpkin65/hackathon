<?php
include "../../includes/PHP/config.php";

// Fetch data for all laureates grouped by promotion
$sql_all = "SELECT promotion, COUNT(*) as num_laureates FROM laureat GROUP BY promotion";
$stmt_all = $pdo->prepare($sql_all);

// Execute the prepared statement
try {
    $stmt_all->execute();
    $laureate_data = $stmt_all->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Calculate total number of laureates
$sql_total = "SELECT COUNT(*) AS num_laureates FROM laureat";
$stmt_total = $pdo->prepare($sql_total);

try {
    $stmt_total->execute();
    $result_total = $stmt_total->fetch(PDO::FETCH_ASSOC);
    $num_laureates_total = $result_total['num_laureates'];
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Laureates Chart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Promotion Year', 'Number of Laureates'],
            <?php
            foreach ($laureate_data as $row) {
                echo "['" . $row['promotion'] . "', " . $row['num_laureates'] . "],";
            }
            ?>
        ]);

        var options = {
            title: 'Number of Laureates by Promotion',
            hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0},
            legend: { position: 'none' },
            chartArea: {width: '70%', height: '70%'},
            colors: ['#00529B'] // Add your desired color here
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }

    </script>
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header" style="font-size: 0.9rem; font-weight:600;">
            Promotion<img src="gestioner_index_page/laureat.png" style="width:45px;top:0; background: rgb(9,56,98);background: linear-gradient(135deg, rgba(9,56,98,1) 0%, rgba(17,102,176,1) 100%);border-radius:100%;position:absolute;right:1rem;padding:0.7rem">
        </div>
        <div class="card-body">
            <div id="chart_div" style="width: 100%; height: 100%;"></div>
        </div>
        <div class="card-footer">
            <p class="mb-0" style="font-size: 0.7rem; font-weight:600;">Nombres total des lauréats: <?php echo $num_laureates_total; ?></p>
        </div>
    </div>
</div>

<style>
    .card-body{
        height: 250px;
    }
    @media only screen and (max-width: 600px){
        .card-body{
        height: 10rem;
        width: calc(50vw);
        display: none;
        }
        .card-footer{
            display: none;
        }
    
    
    }
</style>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
