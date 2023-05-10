<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="style.css">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    </head>

    <body>
        <div class="container">

            <div class="textbox">
                <form method="post" action="submit.php">
                    <label for="textbox">Enter stock tag</label>
                    <input type="text" id="textbox" name="textbox" placeholder="AAPL" required>
                    <input type="submit" id="submit">
                </form>
            </div>


            <div class="display-container">
                <h1>Stock Information</h1>
                <hr class="green-hr">
        
                <?php

                    if($_SERVER['REQUEST_METHOD'] == 'POST') {

                        $apiKey = 'XSI0MA8T03B4KMMY';

                        $symbol = $_POST['textbox'];
                        

                        $url = "https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=". urlencode($symbol) .
                         "&interval=5min&apikey=" .  urlencode($apiKey);

                        $json = file_get_contents($url);

                        $data = json_decode($json, true);
                        
                        $metaData = $data['Meta Data'];


                        $info = $metaData['1. Information'];
                        $sym = $metaData['2. Symbol'];
                        $lastRefresh = $metaData['3. Last Refreshed'];
                        $timeZone = $metaData['6. Time Zone'];
                        
                        $ticks = $data['Time Series (5min)'];
                        
                        $closing_prices = array();

                        foreach ($data['Time Series (5min)'] as $time => $values) {
                            $closing_prices[] = $values['4. close'];
                            
                        }

                        $firstTime = reset($ticks); 
                        $closePrice = $firstTime['4. close']; 
                        
                    }

                    

                ?>

                <script type="text/javascript">
                     google.charts.load('current', {'packages':['corechart']});
                     google.charts.setOnLoadCallback(drawChart);

                     var priceArr = <?php echo '["' . implode('","', $closing_prices) . '"]' ?>;


                     function drawChart() {
                        
                        var data = new google.visualization.DataTable();

                        data.addColumn('number', 'X');
                        data.addColumn('number', 'Y');

                        priceArr.forEach((value, index) =>
                            data.addRow([index, parseFloat(value)])
                        );


                        var options = {
                            title: 'Chart Title'
                            
                        };

                        var chart = new google.visualization.LineChart(document.getElementById('linechart'));
                        chart.draw(data, options);
                     }
                </script>

                    <h2> <?php echo $sym ?> </h2>
                    <p> <?php echo $closePrice ?> </p>
                    <div class="chart_div" id="linechart"> 


                    </div>

                    <p> <?php echo $lastRefresh ?> </p>
                    
            </div>
                    
                    <form>
                        <button>Download CSV</button>
                    </form>
        </div>
    </body>
</html>




