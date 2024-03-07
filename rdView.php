<?php
session_start();
include 'navigation.php';

$conn = connect();
$id = $_SESSION['userid'];
$sq = "SELECT * FROM user_login WHERE user_id='$id'";
$thisUser = mysqli_fetch_assoc($conn->query($sq));
// change rd_id to __id
if (isset($_GET['rd_id'])) {
    $id = $_GET['rd_id'];

    $sql = "SELECT * from rd WHERE rd_id=$id limit 1";
    $res = mysqli_fetch_assoc($conn->query($sql));
}
?>

<html>

<head>
    <title> RD </title>
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
                        <!-- add changes -->
                        <h2> RD Investment Plan Details</h2>
                    </div>
                    <div class="row pt-20">
                        <div class="col-sm-7">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="pull-left">
                                        <h4> Bank Name:</h4>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <h4 ><?php echo ucwords($res['bank_name']) ?></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="pull-left">
                                        <h4> Monthly Investment Amount:</h4>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <h4 ><?php echo $res['rd_prin'] ?></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="pull-left">
                                        <h4> Annual Rate of Interest (in %):</h4>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <h4 ><?php echo $res['rd_rate'] ?></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="pull-left">
                                        <h4> Tenure (in Years)</h4>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <h4 ><?php echo $res['rd_tenure'] ?></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="pull-left">
                                        <h4> Maturity Amount:</h4>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <h4 ><?php echo $res['rd_return'] ?></h4>
                                </div>
                            </div>


                            <div class="row text-center">
                                <!-- change rd_id to __id, change even the links-->
                                <a href="rdEdit.php?rd_id=<?php echo $res['rd_id']; ?>"><button class="btn btn-warning">Edit</button></a>
                                <a href="rdDelete.php?rd_id=<?php echo $res['rd_id']; ?>"><button class="btn btn-danger">Delete</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="rightcolumn">
            <div class="card text-center">
                <h2><b>Recurring Deposit Calculator</b></h2>
                <p>
                    Investors can choose the tenure of the deposit and the minimum monthly payment they wish to make according to their convenience.
                    Interest on RD is compounded quarterly, in most banks.
                </p>
                <h4><b>Currrent RD rates at different Banks</b></h4>
                <a href="#sbi" class="btn btn-info" data-toggle="collapse">SBI</a>
                <div id="sbi" class="collapse">
                    <div class="table_container">
                        <table class="table table-dark" id="table">
                            <tr>
                                <td>1 to 2 years</td>
                                <td>5%</td>
                            </tr>
                            <tr>
                                <td>2+ to 3 years</td>
                                <td>5.1%</td>
                            </tr>
                            <tr>
                                <td>3+ to 5 years</td>
                                <td>5.3%</td>
                            </tr>
                            <tr>
                                <td>5+ to 10 years</td>
                                <td>5.4%</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <a href="#axis" class="btn btn-info" data-toggle="collapse">AXIS</a>
                <div id="axis" class="collapse">
                    <div class="table_container">
                        <table class="table table-dark" id="table">
                            <tr>
                                <td>less than 1 year</td>
                                <td>4.4%</td>
                            </tr>
                            <tr>
                                <td>1 to 2 years</td>
                                <td>5.2%</td>
                            </tr>
                            <tr>
                                <td>2+ to 5 years</td>
                                <td>5.4%</td>
                            </tr>
                            <tr>
                                <td>5+ to 10 years</td>
                                <td>5.75%</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <a href="#icici" class="btn btn-info" data-toggle="collapse">ICICI</a>
                <div id="icici" class="collapse">
                    <div class="table_container">
                        <table class="table table-dark" id="table">
                            <tr>
                                <td>less than 1 year</td>
                                <td>4.9%</td>
                            </tr>
                            <tr>
                                <td>1 to 2 years</td>
                                <td>5.5%</td>
                            </tr>
                            <tr>
                                <td>2+ to 5 years</td>
                                <td>5.7%</td>
                            </tr>
                            <tr>
                                <td>5+ to 10 years</td>
                                <td>6.35%</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php') ?>
</body>

</html>