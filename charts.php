<?php
session_start();

require_once "pdo.php";
//require_once "pdo_db_live.php";
require_once "util.php";

if ( ! isset($_SESSION['user_id']) ) {
    $login = 0;
} else {
    $login = 1;
}

$count = 0;

$table = array();
$table['cols'] = array(
  //Labels for the chart, these represent the column titles
  array('label' => 'Customer', 'type' => 'string'),
  array('label' => 'Orders', 'type' => 'number')
  );
$rows = array();

$stmt = $pdo->query("SELECT company.name, sum(orders.amount) as amount
                      FROM company, orders
                      Where company.company_id = orders.company_id
                      group by name order by amount desc");
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {

  $temp = array();

  //Values
  $temp[] = array('v' => (string) $row['name']);
  $temp[] = array('v' => (float) $row['amount']);
  $rows[] = array('c' => $temp);


}

$table['rows'] = $rows;
$jsonTable = json_encode($table);

?>


<!DOCTYPE html>
<html>
<head>
<title>Interactive Charts</title>
<?php
require_once "bootstrap.php";
?>

</head>
<body>

  <?php
  $page = 'charts';
  require_once "navbar.php";
   ?>

<div class="container">

<?php
  flashMessages();
?>

<h1 class="text-info">Interactive Charts</h1>

<div class="row">
  <div class="col-sm-6">
    <div id="PieChart"></div>
  </div> <!-- end coll sm-8 -->
  <div class="col-sm-6">
      <div id="BarChart"></div>
  </div>
</div>

</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
if( $(window).width() >= 641 ){

    // Load the Visualization API and the corechart package.
    google.charts.load('current', {'packages':['corechart']});

        setTimeout(function(){

            google.charts.setOnLoadCallback(drawChart);
            // Set a callback to run when the Google Visualization API is loaded.

            // Callback that creates and populates a data table,
            // instantiates the pie chart, passes in the data and
            // draws it.

        }, 800);

} // end if( $(window).width() >= 641 )



      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable(<?php echo $jsonTable; ?>);

         var formatter = new google.visualization.NumberFormat(
      {negativeColor: 'red', negativeParens: true, pattern: '$###,###'});
   formatter.format(data, 1);

        // Set chart options
        var options = {title: 'Pie Chart: Company Concentration of Total Orders',

                       legend:'left',
                       is3D:true,
                       width:400,
                       height:300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('PieChart'));
        chart.draw(data, options);


     var barchart_options = {
                       title: 'Bar Chart: Total Orders by Company',

                        vAxis: {format:'$###,###,###.00'},
                      width:400,
                       height:300,
                       legend: 'left'};

        var barchart = new google.visualization.ColumnChart(document.getElementById('BarChart'));
        barchart.draw(data, barchart_options);
      } // end draw chart
    </script>

</body>
</html>
