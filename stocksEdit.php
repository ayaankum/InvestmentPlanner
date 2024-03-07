<?php
session_start();
include 'navigation.php';

$conn = connect();
$m = '';

$id = $_SESSION['userid'];
$sq = "SELECT * FROM user_login WHERE user_id='$id'";
$thisUser = mysqli_fetch_assoc($conn->query($sq));
// change rdId
if (isset($_GET['stock_id'])) {
    $stockId = $_GET['stock_id'];
    $sql = "SELECT * from stocks WHERE stock_id='$stockId' limit 1";
    $res = mysqli_fetch_assoc($conn->query($sql));
}
// change everything including links VERY CAREFULLY!!!!
elseif (isset($_POST['stock_id'])) {
    $stockId = $_POST['stock_id'];
    $stockName = $_POST['stock_name'];
    $sOpen = floatval($_POST['open_price']);
    $sClose = floatval($_POST['close_price']);
    $sDividend = floatval($_POST['dividend']);
    $sVolume = floatval($_POST['volume']);

    if (isset($_POST['Submit'])) {
        $sql = "UPDATE stocks SET stock_name= '$stockName', open_price= '$sOpen', close_price= '$sClose', dividend= '$sDividend', volume= '$sVolume'  WHERE stock_id = '$stockId';";
        if ($conn->query($sql) === true) {
            header('Location: stockscal.php');
        } else {
            $m = "Connection Failure!";
            header("Location: stocksEdit.php?stock_id=$stockId");
        }
    }
}
// make sure you have floatval()
?>

<html>

<head>
    <title> Stocks </title>
    <!-- change title -->
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
            <div class="pt-20 pl-20">
                <div class="col-sm-12">
                    <div class="text-center">
                        <h2> Edit Stocks </h2>
                        <!-- change title -->
                        <h4> <?php echo $m; ?> </h4>
                    </div>
                    <div class="row pt-20">
                        <div class="col-sm-7">
                            <form method="POST" action="stocksEdit.php">
                                <!-- edit link above -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="pull-left">
                                            <h4> Stock Name:</h4>
                                            <!-- from here, change all h4-->
                                        </label>
                                    </div>
                                    <div class="col-sm-6 form-input pt-10">
                                        <!-- change name, value, placeholder -->
                                        <input type="text" class="login-input" name="stock_name" value="<?php echo $res['stock_name']; ?>" placeholder="Stock Name">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="pull-left">
                                            <h4> Purchase Price:</h4>
                                        </label>
                                    </div>
                                    <div class="col-sm-6 form-input pt-10">
                                        <input type="number" step="any" class="login-input" name="open_price" value="<?php echo $res['open_price']; ?>" placeholder="Opening Price">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="pull-left">
                                            <h4> Market Current Price:</h4>
                                        </label>
                                    </div>
                                    <div class="col-sm-6 form-input pt-10">
                                        <input type="number" step="any" class="login-input" name="close_price" value="<?php echo $res['close_price']; ?>" placeholder="Closing Price">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="pull-left">
                                            <h4> Dividend Yield (in %):</h4>
                                        </label>
                                    </div>
                                    <div class="col-sm-6 form-input pt-10">
                                        <input type="number" step="any" class="login-input" name="dividend" value="<?php echo $res['dividend']; ?>" placeholder="Dividend">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="pull-left">
                                            <h4> Volume of Stocks:</h4>
                                        </label>
                                    </div>
                                    <div class="col-sm-6 form-input pt-10">
                                        <input type="number" step="any" class="login-input" name="volume" value="<?php echo $res['volume']; ?>" placeholder="Volume">
                                    </div>
                                </div>
                                <!-- here change rdId after echo and again name -->
                                <input type="hidden" value="<?php echo $stockId; ?>" name="stock_id">
                                <div class="row">
                                    <div class="text-center">
                                        <input class="btn btn-success" type="submit" name="Submit" value="Submit">
                                    </div>
                                </div>
                            </form>
                        </div>
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