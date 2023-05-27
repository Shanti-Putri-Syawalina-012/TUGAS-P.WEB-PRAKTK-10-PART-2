<?php
include('koneksi_covid.php');
$country = mysqli_query($koneksi, "select * from tb_covid");
while ($row = mysqli_fetch_array($country)) {
    $name_country[]    = $row['country'];
    $total_recovered[] = $row['total_recovered'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pie Chart</title>
    <script type="text/javascript" src="Chart.js"></script>
</head>
<body>
    <div id="canvas-holder" style="width:45%">
        <canvas id="chart-area"></canvas>
    </div>
    <script>
        var config = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: <?php echo json_encode($total_recovered);?>,

                    backgroundColor: [
                        'rgba(176, 196, 222, 0.3)',
                        'rgba(240, 128, 128, 0.2)',
                        'rgba(119, 136, 153, 0.2)',
                        'rgba(147, 112, 219, 0.2)',
                        'rgba(249, 0, 255, 0.2)',
                        'rgba(144, 238, 144, 0.2)',
                        'rgba(188, 143, 142, 0.2)',
                        'rgba(251, 160, 122, 0.2)',
                        'rgba(40, 178, 170, 0.2)',
                        'rgba(135, 206, 250, 0.5)'
                    ],
                    
                    borderColor: [
                        'rgba(176, 196, 222, 1)',
                        'rgba(240, 128, 128, 1)',
                        'rgba(119, 136, 153, 1)',
                        'rgba(147, 112, 219, 0.4)',
                        'rgba(249, 0, 255, 0.4)',
                        'rgba(144, 238, 144, 1)',
                        'rgba(188, 143, 142, 0.8)',
                        'rgba(251, 160, 122, 1)',
                        'rgba(40, 178, 170, 1)',
                        'rgba(135, 206, 250, 2)'
                    ],

                    label: 'total_recovered'
                }],
                labels: <?php echo json_encode($name_country); ?>
            },
            options: {
                responsive: true
            }
        };
        window.onload = function () {
            var ctx = document.getElementById('chart-area').getContext('2d');
            window.myPie = new Chart(ctx, config);
        };
        document.getElementById('randomizeData').addEventListener('click',
            function () {
                config.data.datasets.forEach(function (dataset) {
                    dataset.data = dataset.data.map(function () {
                        return randomScalingFactor();
                    });
                });
                window.myPie.update();
            });
        var colorNames = Object.keys(window.chartColors);
        document.getElementById('addDataset').addEventListener('click',

            function () {
                var newDataset = {
                    backgroundColor: [],
                    data: [],
                    label: 'New dataset ' +

                        config.data.datasets.length,
                };
                for (var index = 0; index < config.data.labels.length;
                    ++index) {
                    newDataset.data.push(randomScalingFactor());
                    var colorName = colorNames[index % colorNames.length];
                    var newColor = window.chartColors[colorName];
                    newDataset.backgroundColor.push(newColor);
                }
                config.data.datasets.push(newDataset);
                window.myPie.update();
            });
        document.getElementById('removeDataset').addEventListener('click',
            function () {
                config.data.datasets.splice(0, 1);
                window.myPie.update();
            });
    </script>
</body>
</html>