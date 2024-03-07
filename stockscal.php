<?php
session_start();
include('navigation.php');

$m = '';
$conn = connect();
$id = $_SESSION['userid'];
$sq = "SELECT * FROM user_login WHERE user_id='$id'";
$thisUser = mysqli_fetch_assoc($conn->query($sq));

if (isset($_POST['submit'])) {
    $stockName = $_POST['stock_name'];
    $sOpen = $_POST['open_price'];
    $sClose = $_POST['close_price'];
    $sDividend = $_POST['dividend'];
    $sVolume = $_POST['volume'];

    $sql = "INSERT INTO stocks(user_id, stock_name, open_price, close_price, dividend, volume) VALUES ('$id', '$stockName', '$sOpen', '$sClose', '$sDividend', '$sVolume')";
    if ($conn->query($sql) === true) {
        $m = "Stock Inserted!";
    }
}

$sql = "SELECT * from stocks WHERE user_id=$id "; // change name
$res = $conn->query($sql);

?>

<html>

<head>
    <title> Stock </title>
    <link rel="stylesheet" type="text/css" href="css/products.css">
</head>

<body>
    <div class="row" style="padding-top: 50px;">
        <div class="leftcolumn">
            <div class="row">
                <section style="padding-left: 20px; padding-right: 20px;">
                    <div class="col-sm-3">
                        <div class="card card-yellow">
                            <a href="rdcal.php">RD Calculator</a>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card card-yellow">
                            <a href="fdcal.php">FD Calculator</a>
                        </div>
                    </div>
                    <div class="col-sm-3 ">
                        <div class="card card-yellow">
                            <a href="ppfcal.php">PPF Calculator</a>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card card-yellow">
                            <a href="stockscal.php">Stocks Calculator</a>
                        </div>
                    </div>
                </section>
            </div>
            <div class="card">
                <div class="text-center">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProduct">
                        Add Stock Performance
                    </button>
                    <!-- change name above -->
                    <h2><?php echo $m; ?></h2>
                    <div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <button style="background-color: #609ee5;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h2 class="modal-title" id="exampleModalScrollableTitle">Add New Stock</h2>
                                </div>
                                <div class="modal-body">
                                    <!-- change file name -->
                                    <form method="POST" action="stockscal.php" enctype="multipart/form-data">
                                        <div class="form-group pt-20">
                                            <!-- changes start from here, change name and id -->
                                            <div class="col-sm-4">
                                                <label for="stock_name" class="pr-10"> Stock Name</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input name="stock_name" type="text" class="login-input" placeholder="Stock Name" id="StockName" required>
                                            </div>
                                        </div>
                                        <div class="form-group pt-20">
                                            <div class="col-sm-4">
                                                <label for="open_price" class="pr-10"> Stock Purchase Price </label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input name="open_price" type="number" step="any" class="login-input" placeholder="Enter Stock Opening Price" id="sOpen" required>
                                            </div>
                                        </div>
                                        <div class="form-group pt-20">
                                            <div class="col-sm-4">
                                                <label for="close_price" class="pr-10"> Stock Market Current Price </label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input name="close_price" type="number" step="any" class="login-input" placeholder="Enter Stock Closing Price" id="sClose" required>
                                            </div>
                                        </div>
                                        <div class="form-group pt-20">
                                            <div class="col-sm-4">
                                                <label for="dividend" class="pr-10"> Dividend Yield (in %)</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input name="dividend" type="number" step="any" class="login-input" placeholder="Enter Stock Dividend" id="sDividend" required>
                                            </div>
                                        </div>
                                        <div class="form-group pt-20">
                                            <div class="col-sm-4">
                                                <label for="volume" class="pr-10"> Volume of Stocks Bought </label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input name="volume" type="number" step="any" class="login-input" placeholder="Enter Volume of Stocks bought" id="sVolume" required>
                                            </div>
                                        </div>
                                        <div class="form-group" style="text-align: center;">
                                            <button type="submit" value="submit" name="submit" class="btn btn-success">Add</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table_container">
                    <!-- change to FD.. table -->
                    <h1 style="text-align: center;">Stocks Performance Table</h1>
                    <div class="table-responsive">
                        <table class="table table-dark" id="table" data-toggle="table" data-search="true" data-filter-control="true" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                            <thead class="thead-light">
                                <tr>
                                    <!-- changes here -->
                                    <th data-field="stock_name" data-filter-control="select" data-sortable="true">Stock Name</th>
                                    <th data-field="open_price" data-filter-control="select" data-sortable="true"> Purchase Price</th>
                                    <th data-field="close_price" data-sortable="true">Market Current Price</th>
                                    <th data-field="dividend" data-sortable="true">Dividend Yield (in %)</th>
                                    <th data-field="volume" data-sortable="true">Volume of Stocks </th>
                                    <th data-field="stock_return" data-sortable="true"> Return on Investment (ROI in %)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($res) > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo "<tr>";
                                        // change name acc to db column names
                                        echo "<td>" . $row['stock_name'] . "</td>";

                                        echo "<td>" . $row['open_price'] . "</td>";

                                        echo "<td>" . $row['close_price'] . "</td>";

                                        echo "<td>" . $row['dividend'] . "</td>";

                                        echo "<td>" . $row['volume'] . "</td>";

                                        echo "<td>" . $row['stock_return'] . "</td>";

                                        echo "<td><a href='stocksView.php?stock_id=" . $row['stock_id'] . "' class='btn btn-success btn-sm'>" .
                                            "<span class='glyphicon glyphicon-eye-open'></span> </a>";
                                    }
                                } else {
                                    echo "No results found!";
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="rightcolumn">
            <div class="card text-center">
                <h2><b>Stocks and Their Return</b></h2>
                <p>
                    Total return is expressed as a percentage of the amount invested. For example, a total return of 20% means the security increased by 20% of its original value due to a price increase, distribution of dividends (if a stock), coupons (if a bond), or capital gains (if a fund).
                </p>
                <p>
                    Assuming that the stock is purchased, ROI is calculated as Current Dividend Yield + Capital Gains Yield.
                </p>
                <a href="https://www.reliancesmartmoney.com/stocks/exotic/high-dividend-payers" class="btn btn-info" target="_blank">High Dividend Yield Stocks</a>
                <p>
                      
                </p>
                <a href="https://money.rediff.com/companies/market-capitalisation" class="btn btn-info" target="_blank">Current Price of Top Stocks</a>
            </div>
        </div>
    </div>
    <?php include('footer.php') ?>

</body>

</html>