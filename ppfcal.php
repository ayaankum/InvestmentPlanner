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
    $ppfPrin = $_POST['ppf_prin'];
    $ppfYear = $_POST['ppf_year'];
    $ppfRate = $_POST['ppf_rate'];

    $sql = "INSERT INTO ppf(user_id, bank_name, ppf_prin, ppf_year, ppf_rate) VALUES ('$id', '$bankName', '$ppfPrin', '$ppfYear', '$ppfRate')";
    if ($conn->query($sql) === true) {
        $m = "Investment Inserted!";
    }
}

$sql = "SELECT * from ppf WHERE user_id=$id"; // change name
$res = $conn->query($sql);

?>

<html>

<head>
    <title> PPF </title>
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
                        Add PPF New Investment Plan
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
                                    <!-- change file name -->
                                    <form method="POST" action="ppfcal.php" enctype="multipart/form-data">
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
                                                <label for="ppf_prin" class="pr-10"> Yearly Investment</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input name="ppf_prin" type="number" min="500" max="150000" step="any" class="login-input" placeholder="Enter Prinicpal Amount" id="ppfPrin" required>
                                            </div>
                                        </div>
                                        <div class="form-group pt-20">
                                            <div class="col-sm-4">
                                                <label for="ppf_rate" class="pr-10"> Annual Rate of Interest </label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input name="ppf_rate" type="number" step="any" class="login-input" placeholder="Enter Annual Rate of Interest" id="ppfRate" required>
                                            </div>
                                        </div>
                                        <div class="form-group pt-20">
                                            <div class="col-sm-4">
                                                <label for="ppf_year" class="pr-10"> Duration (in Years) </label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input name="ppf_year" type="number" step="any" min="15" class="login-input" placeholder="Enter Time (Min 15 years)" id="ppfYear" required>
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
                    <h1 style="text-align: center;">PPF Table</h1>
                    <div class="table-responsive">
                        <table class="table table-dark" id="table" data-toggle="table" data-search="true" data-filter-control="true" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                            <thead class="thead-light">
                                <tr>
                                    <!-- changes here -->
                                    <th data-field="bank_name" data-filter-control="select" data-sortable="true">Bank Name</th>
                                    <th data-field="ppf_prin" data-filter-control="select" data-sortable="true"> Yearly Investment </th>
                                    <th data-field="ppf_rate" data-sortable="true">Annual Rate of Interest (in %)</th>
                                    <th data-field="ppf_year" data-sortable="true">Duration (in Years) </th>
                                    <th data-field="ppf_return" data-sortable="true">Maturity Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($res) > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo "<tr>";
                                        // change name acc to db column names
                                        echo "<td>" . $row['bank_name'] . "</td>";

                                        echo "<td>" . $row['ppf_prin'] . "</td>";

                                        echo "<td>" . $row['ppf_rate'] . "</td>";

                                        echo "<td>" . $row['ppf_year'] . "</td>";

                                        echo "<td>" . $row['ppf_return'] . "</td>";

                                        echo "<td><a href='ppfView.php?ppf_id=" . $row['ppf_id'] . "' class='btn btn-success btn-sm'>" .
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