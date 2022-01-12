<?php
    // Include config file 
    require_once "config.php";

    // Define variables and initialize with empty values
    $Items = $UnitsSold = $TotalCost= $SellingPrice = $Profit = "";
    $Items_err = $UnitsSold_err = $TotalCost_err = $SellingPrice_err = $Profit_err = "";

    // Processing form data when form is submitted 
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate Items
    
    $input_Items = trim($_POST["Items"]); if(empty($input_Items)){
    $Items_err = "Please enter an item.";
    } else{
    $Items = $input_Items;
    }

    // Validate UnitsSold
    $input_UnitsSold = trim($_POST["UnitsSold"]); if(empty($input_UnitsSold)){
    $UnitsSold_err = "Please enter the UnitsSold.";
    } else{
    $UnitsSold = $input_UnitsSold;
    }

    // Validate TotalCost
    $input_TotalCost= trim($_POST["TotalCost"]); if(empty($input_TotalCost)){
    $Units_err = "Please enter the TotalCost.";
    } elseif(!ctype_digit($input_TotalCost)){
    $TotalCost_err = "Please enter a positive integer value.";
    } else{
    $TotalCost= $input_TotalCost;
    }

    // Validate SellingPrice
    $input_SellingPrice = trim($_POST["SellingPrice"]); if(empty($input_SellingPrice)){
    $SellingPrice_err = "Please enter the SellingPrice.";
    } elseif(!ctype_digit($input_SellingPrice)){
    $SellingPrice_err = "Please enter a positive integer value.";
    } else{
    $SellingPrice= $input_SellingPrice;
    }
    // Validate Profit
    $input_Profit = trim($_POST["Profit"]); if(empty($input_Profit)){
    $Profit_err = "Please enter the Profit.";
    } elseif(!ctype_digit($input_Profit)){
    $Profit_err = "Please enter a positive integer value.";
    
    } else{
    $Profit = $input_Profit;
    }


    // Check input errors before inserting in database
    if(empty($Items_err) && empty($UnitsSold_err) && empty($TotalCost_err) && empty($SellingPrice_err) && empty($Profit_err)){
    // Prepare an insert statement
    $sql = "INSERT INTO tbsum (Items, UnitsSold, TotalCost, SellingPrice
    , Profit) VALUES (?, ?, ?,?,?)";

    if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters 
    mysqli_stmt_bind_param($stmt, "sssss", $param_Items, $param_UnitsSold,
    $param_TotalCost, $param_SellingPrice
    , $param_Profit);

    // Set parameters
    $param_Items = $Items;
    $param_UnitsSold = $UnitsSold;
    $param_TotalCost= $TotalCost;
    $param_SellingPrice = $SellingPrice;
    $param_Profit = $Profit;

    // Attempt to execute the prepared statement 
    if(mysqli_stmt_execute($stmt)){
    // Records created successfully. Redirect to landing page 
    header("location: sumindex.php");
    exit();
    } else{
    echo "Oops! Something went wrong. Please try again later.";
    }
    }

    // Close statement 
    mysqli_stmt_close($stmt);
    }

    // Close connection
    
    mysqli_close($link);
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .wrapper {
        width: 600px;
        margin: 0 auto;
    }
    </style>

    <script>

    </script>

</head>

<body background="images/coffee.jpg">
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add item summary to the
                        database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Items</label>
                            <input type="text" name="Items"
                                class="form-control <?php echo (!empty($Items_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $Items; ?>">
                            <span class="invalid-feedback"><?php echo $Items_err;?></span>
                        </div>
                        <div class="form-group">

                            <label>UnitsSold</label>
                            <input type="text" name="UnitsSold"
                                class="form-control <?php echo (!empty($UnitsSold_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $UnitsSold; ?>">
                            <span class="invalid-feedback"><?php echo $UnitsSold_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>TotalCost</label>
                            <input type="text" name="TotalCost"
                                class="form-control <?php echo (!empty($TotalCost_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $TotalCost; ?>">
                            <span class="invalid-feedback"><?php echo $TotalCost_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>SellingPrice
                            </label>
                            <input type="text" name="SellingPrice" onkeyup="mult(this.value)"
                                class="form-control <?php echo (!empty($SellingPrice_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $SellingPrice; ?>">
                            <span class="invalid-feedback"><?php echo $SellingPrice_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Profit</label>
                            <input type="text" name="Profit" jAutoCalc="{SellingPrice} * {UnitsSold}" class="form-control <?php echo (!empty($Profit_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $Profit; ?>">
                            <span class="invalid-feedback"><?php echo $Profit_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="sumindex.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>