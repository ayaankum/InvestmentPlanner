<?php
session_start();
include 'navigation.php';

$conn = connect();
$id = $_SESSION['userid'];
$sq = "SELECT * FROM user_login WHERE user_id='$id'";
$thisUser = mysqli_fetch_assoc($conn->query($sq));
// change rd_id to __id
if (isset($_GET['ppf_id'])) {
    $id = $_GET['ppf_id'];

    $sql = "SELECT * from ppf WHERE ppf_id=$id limit 1";
    $res = mysqli_fetch_assoc($conn->query($sql));
}
?>

<html>

<head>
    <title> PPF </title>
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
                        <h2> PPF Investment Plan Details</h2>
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
                                        <h4> Yearly Investment:</h4>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <h4 ><?php echo $res['ppf_prin'] ?></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="pull-left">
                                        <h4> Annual Rate of Interest (in %):</h4>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <h4 ><?php echo $res['ppf_rate'] ?></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="pull-left">
                                        <h4> Duration (in Years):</h4>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <h4 ><?php echo $res['ppf_year'] ?></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="pull-left">
                                        <h4> Maturity Amount:</h4>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <h4 ><?php echo $res['ppf_return'] ?></h4>
                                </div>
                            </div>


                            <div class="row text-center">
                                <!-- change rd_id to __id, change even the links-->
                                <a href="ppfEdit.php?ppf_id=<?php echo $res['ppf_id']; ?>"><button class="btn btn-warning">Edit</button></a>
                                <a href="ppfDelete.php?ppf_id=<?php echo $res['ppf_id']; ?>"><button class="btn btn-danger">Delete</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="rightcolumn">
            <div class="card text-center">
                <h2><b>Public Provident Fund Calculator</b></h2>
                <p>
                    PPF has a minimum tenure of 15 years which can be extended indefinitely in blocks of 5 years. Furthermore, the minimum investment in PPF account is Rs. 500 and maximum is Rs. 1,50,000. Investments can be made in lump sum or in installments. Our PPF Calculator works for yearly installments of PPF.
                </p>
                <p>
                    <b>
                        The current interest rate on PPF is 7.1% compounded annually.
                    </b>
                </p>
            </div>
        </div>
    </div>

    <?php include('footer.php') ?>
</body>

</html>