<?php
include('koneksi_covid.php');
$data = mysqli_query($koneksi,"select * from tb_covid");
while($row = mysqli_fetch_array($data)){
  $country[] = $row['country'];
  $query = mysqli_query($koneksi,"select total_cases, total_deaths, total_recovered, active_cases, total_tests from tb_covid where id='".$row['id']."'");
  $row = $query->fetch_array();
  $total_cases[]     = $row['total_cases'];
  $total_deaths[]    = $row['total_deaths'];
  $total_recovered[] = $row['total_recovered'];
  $active_cases[]    = $row['active_cases'];
  $total_tests[]     = $row['total_tests'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Grafik Data 10 Negara Asia Covid-19</title>
<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
  <div style="width: 800px;height: 800px">
    <canvas id="myChart"></canvas>
  </div>
  <script>
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($country); ?>,
        datasets: [{
          label: 'total_cases',
          data:
          <?php echo json_encode($total_cases);?>,

          backgroundColor: 
          'rgba(255, 99, 132, 0.2)',
          
          borderColor: 
          'rgba(255,99,132,1)',

          borderWidth: 1
        }, {
          label: 'total_deaths',
          data:
          <?php echo json_encode($total_deaths);?>,

          backgroundColor: 
          'rgba(54, 162, 235, 0.2)',
          
          borderColor: 
          'rgba(54, 162, 235, 1)',

          borderWidth: 1
        }, {
          label: 'total_recovered',
          data:
          <?php echo json_encode($total_recovered);?>,

          backgroundColor: 
          'rgba(255, 206, 86, 0.2)',
          
          borderColor: 
          'rgba(255, 206, 86, 1)',

          borderWidth: 1
        }, {
          label: 'active_cases',
          data:
          <?php echo json_encode($active_cases);?>,

          backgroundColor: 
          'rgba(75, 192, 192, 0.2)',
          
          borderColor: 
          'rgba(75, 192, 192, 1)',

          borderWidth: 1
        }, {
          label: 'total_tests',
          data:
          <?php echo json_encode($total_tests);?>,

          backgroundColor: 
          'rgba(153, 102, 255, 0.2)',
          
          borderColor: 
          'rgba(153, 102, 255, 1)',

          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero:true
            }
          }]
        }
      }
    });
  </script>
</body>
</html>