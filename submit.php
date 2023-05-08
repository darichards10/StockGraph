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

                    if($_SERVER["REQUEST_METHOD"] == "POST") {

                        $apiKey = "XSI0MA8T03B4KMMY";

                        $symbol = $_POST["textbox"];
                        

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


                       
                        
                    }

                    

                ?>
                    <h2> <?php echo $sym ?> </h2>
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




