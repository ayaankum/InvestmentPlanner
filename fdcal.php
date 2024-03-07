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
    $fdPrin = $_POST['fd_prin'];
    $fdDur = $_POST['fd_dur'];
    $fdComp = $_POST['compounding'];
    $fdRate = $_POST['fd_rate'];

    $sql = "INSERT INTO fd(user_id, bank_name, fd_prin, fd_dur, compounding, fd_rate) VALUES ('$id', '$bankName', '$fdPrin', '$fdDur', '$fdComp', '$fdRate')";
    if ($conn->query($sql) === true) {
        $m = "Investment Inserted!";
    }
}

$sql = "SELECT * from fd WHERE user_id=$id"; // change name
$res = $conn->query($sql);

?>

<html>

<head>
    <title> FD </title>
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
                        Add FD New Investment Plan
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
                                    <h2 class="modal-title" id="exampleModalScrollableTitle">Add New Investment</h2>
                                </div>
                                <div class="modal-body">
                                    <datalist id="complist">
                                        <option value="1">
                                        <option value="2">
                                        <option value="4">
                                        <option value="12">
                                    </datalist>
                                    <!-- change file name -->
                                    <form method="POST" action="fdcal.php" enctype="multipart/form-data">
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
                                                <label for="fd_prin" class="pr-10"> FD Investment Payout</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input name="fd_prin" type="number" step="any" class="login-input" placeholder="Enter Prinicpal Amount" id="fdPrin" required>
                                            </div>
                                        </div>
                                        <div class="form-group pt-20">
                                            <div class="col-sm-4">
                                                <label for="fd_rate" class="pr-10"> FD Annual Rate (in %)</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input name="fd_rate" type="number" step="any" class="login-input" placeholder="Enter Annual Rate of Interest" id="fdRate" required>
                                            </div>
                                        </div>
                                        <div class="form-group pt-20">
                                            <div class="col-sm-4">
                                                <label for="fd_dur" class="pr-10"> Time Period (in Years) </label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input name="fd_dur" type="number" step="any" class="login-input" placeholder="Enter Time in years" id="fdDur" required>
                                            </div>
                                        </div>
                                        <div class="form-group pt-20">
                                            <div class="col-sm-4">
                                                <label for="compounding" class="pr-10"> Compounding Frequency </label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input name="compounding" type="number" list="complist" class="login-input" placeholder="1:Yr, 2:HlfYr, 4:Qtr, 12:Mnth" id="fdComp" required>
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
                    <h1 style="text-align: center;">FD Table</h1>
                    <div class="table-responsive">
                        <table class="table table-dark" id="table" data-toggle="table" data-search="true" data-filter-control="true" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                            <thead class="thead-light">
                                <tr>
                                    <!-- changes here -->
                                    <th data-field="bank_name" data-filter-control="select" data-sortable="true">Bank Name</th>
                                    <th data-field="fd_prin" data-filter-control="select" data-sortable="true"> Investment Payout </th>
                                    <th data-field="fd_rate" data-sortable="true">Annual Rate of Interest (in %)</th>
                                    <th data-field="fd_dur" data-sortable="true">Time Period of Investment (in Years)</th>
                                    <th data-field="compounding" data-sortable="true">Compounding Frequency</th>
                                    <th data-field="fd_return" data-sortable="true"> Maturity Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($res) > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo "<tr>";
                                        // change name acc to db column names
                                        echo "<td>" . $row['bank_name'] . "</td>";

                                        echo "<td>" . $row['fd_prin'] . "</td>";

                                        echo "<td>" . $row['fd_rate'] . "</td>";

                                        echo "<td>" . $row['fd_dur'] . "</td>";

                                        echo "<td>" . $row['compounding'] . "</td>";

                                        echo "<td>" . $row['fd_return'] . "</td>";

                                        echo "<td><a href='fdView.php?fd_id=" . $row['fd_id'] . "' class='btn btn-success btn-sm'>" .
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
                <h2><b>Fixed Deposit Calculator</b></h2>
                <p>
                    NOTE: Compounding Frequency values are 1: Annual, 2: Half-Yearly, 4:Quarterly, 12: Monthly.
                </p>
                <p>
                    Our calculator follows Cumulative Scheme. In a cumulative fixed deposit scheme, the interest amount is compounded a Lump Sum invested ONCE the term of the deposit and paid at maturity.
                </p>
                <h4><b>Currrent FD rates at different Banks</b></h4>
                <a href="#sbi" class="btn btn-info" data-toggle="collapse">SBI</a>
                <div id="sbi" class="collapse">
                    <div class="table_container">
                        <table class="table table-dark" id="table">
                            <tr>
                                <td>less than 1 year</td>
                                <td>4.4%</td>
                            </tr>
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
                                <td>5.1%</td>
                            </tr>
                            <tr>
                                <td>1 to 2 years</td>
                                <td>5.25%</td>
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
                                <td>4.4%</td>
                            </tr>
                            <tr>
                                <td>1 to 2 years</td>
                                <td>5%</td>
                            </tr>
                            <tr>
                                <td>2+ to 3 years</td>
                                <td>5.2%</td>
                            </tr>
                            <tr>
                                <td>3+ to 10 years</td>
                                <td>5.45%</td>
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