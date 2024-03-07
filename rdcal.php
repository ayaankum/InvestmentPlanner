<?php
session_start();
include('navigation.php');

$m = '';
$conn = connect();
$id = $_SESSION['userid'];
$sq = "SELECT * FROM user_login WHERE user_id='$id'";
$thisUser = mysqli_fetch_assoc($conn->query($sq));

if (isset($_POST['submit'])) {
    $bankName = $_POST['bank_name'];
    $rdPrin = $_POST['rd_prin'];
    $rdTen = $_POST['rd_tenure'];
    $rdRate = $_POST['rd_rate'];

    $sql = "INSERT INTO rd(user_id, bank_name, rd_prin, rd_tenure, rd_rate) VALUES ('$id', '$bankName', '$rdPrin', '$rdTen', '$rdRate')";
    if ($conn->query($sql) === true) {
        $m = "Investment Inserted!";
    }
}

$sql = "SELECT * from rd WHERE user_id=$id"; // change name
$res = $conn->query($sql);

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
            <div class="card">
                <div class="text-center">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProduct">
                        Add RD New Investment Plan
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
                                    <h2 class="modal-title" id="exampleModalScrollableTitle">Add New Plan</h2>
                                </div>
                                <div class="modal-body">
                                    <!-- change file name -->
                                    <form method="POST" action="rdcal.php" enctype="multipart/form-data">
                                        <div class="form-group pt-20">
                                            <!-- changes start from here, change name and id -->
                                            <div class="col-sm-4">
                                                <label for="bank_name" class="pr-10"> Bank Name</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input name="bank_name" type="text" class="login-input" placeholder="Bank Name" id="bankName" required>
                                            </div>
                                        </div>
                                        <div class="form-group pt-20">
                                            <div class="col-sm-4">
                                                <label for="rd_prin" class="pr-10"> Monthly Investment </label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input name="rd_prin" type="number" step="any" class="login-input" placeholder="Enter Monthly Investment" id="rdPrin" required>
                                            </div>
                                        </div>
                                        <div class="form-group pt-20">
                                            <div class="col-sm-4">
                                                <label for="rd_rate" class="pr-10"> RD Annual Rate </label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input name="rd_rate" type="number" step="any" class="login-input" placeholder="Enter Annual Rate of Interest" id="rdRate" required>
                                            </div>
                                        </div>
                                        <div class="form-group pt-20">
                                            <div class="col-sm-4">
                                                <label for="rd_tenure" class="pr-10"> RD Tenure (in Years)</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input name="rd_tenure" type="number" step="any" class="login-input" placeholder="Enter Time in Years" id="rdTenure" required>
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
                    <h1 style="text-align: center;">RD Table</h1>
                    <div class="table-responsive">
                        <table class="table table-dark" id="table" data-toggle="table" data-search="true" data-filter-control="true" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                            <thead class="thead-light">
                                <tr>
                                    <!-- changes here -->
                                    <th data-field="bank_name" data-filter-control="select" data-sortable="true">Bank Name</th>
                                    <th data-field="rd_prin" data-filter-control="select" data-sortable="true"> Monthly Investment </th>
                                    <th data-field="rd_rate" data-sortable="true">Annual Rate of Interest (in %) </th>
                                    <th data-field="rd_tenure" data-sortable="true">Tenure (in years) </th>
                                    <th data-field="rd_return" data-sortable="true"> Maturity Amount </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($res) > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo "<tr>";
                                        // change name acc to db column names
                                        echo "<td>" . $row['bank_name'] . "</td>";

                                        echo "<td>" . $row['rd_prin'] . "</td>";

                                        echo "<td>" . $row['rd_rate'] . "</td>";

                                        echo "<td>" . $row['rd_tenure'] . "</td>";

                                        echo "<td>" . $row['rd_return'] . "</td>";

                                        echo "<td><a href='rdView.php?rd_id=" . $row['rd_id'] . "' class='btn btn-success btn-sm'>" .
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