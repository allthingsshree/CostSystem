<?php include_once("navbar.html"); ?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>Dashboard</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }

        table tr td:last-child {
            width: 120px;
        }

        body {
            background-repeat: repeat;
            background-size: contain;
        }

        tbody,
        thead {
            background-color: white;
        }

        body,
        html {
            height: 100%;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<body background="images/greenlemon.jpg">

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Item Costing</h2>
                        <a href="iccreate.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Item</a>
                    </div>
                    <?php
                    // Include config file require_once "config.php";

                    // Attempt select query execution
                    $sql = "SELECT * FROM tbic";
                    if ($result = mysqli_query($link, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            echo '<table class="table table-bordered table-striped">';
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>#</th>";
                            echo "<th>Item</th>";
                            echo "<th>Servings</th>";
                            echo "<th>Cost</th>";
                            echo "<th>Costperunit</th>";
                            echo "<th>Sellingprice</th>";
                            echo "<th>Action</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['item'] . "</td>";
                                echo "<td>" . $row['servings'] . "</td>";
                                echo "<td>" . $row['cost'] . "</td>";
                                echo "<td>" . $row['costperunit'] . "</td>";
                                echo "<td>" . $row['sellingprice'] . "</td>";
                                echo "<td>";

                                echo '<a href="icread.php?id=' . $row['id'] . '" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                echo '<a href="icupdate.php?id=' . $row['id'] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                echo '<a href="icdelete.php?id=' . $row['id'] . '" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            // Free result set mysqli_free_result($result);
                        } else {
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close connection mysqli_close($link);
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>