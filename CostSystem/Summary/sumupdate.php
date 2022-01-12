<?php
    // Include config file 
    require_once "config.php";

    // Define variables and initialize with empty values
    $Items = $UnitsSold = $TotalCost = $SellingPrice = $Profit = "";
    $Items_err = $UnitsSold_err = $TotalCost_err = $SellingPrice_err = $SellingPricePerUnit_err
    ="";


    // Processing form data when form is submitted 
    if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];


    // Validate Items
    $input_Items = trim($_POST["Items"]); if(empty($input_Items)){
    $Items_err = "Please enter an Item.";
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
    $input_TotalCost = trim($_POST["TotalCost"]); if(empty($input_TotalCost)){
    $TotalCost_err = "Please enter the TotalCost.";
    } elseif(!ctype_digit($input_TotalCost)){
    $TotalCost_err = "Please enter a positive integer value.";
    } else{
    $TotalCost = $input_TotalCost;
    }


    //Validate SellingPrice
    $input_SellingPrice = trim($_POST["SellingPrice"]); if(empty($input_SellingPrice)){
    $SellingPrice_err = "Please enter the SellingPrice.";
    } elseif(!ctype_digit($input_SellingPrice)){
    $SellingPrice_err = "Please enter a positive integer value.";
    } else{
    $SellingPrice = $input_SellingPrice;
    }


    //Validate Profit
    $input_Profit = trim($_POST["Profit"]); if(empty($input_Profit)){
    $SellingPricePerUnit_err = "Please enter the Profit.";
    
    } elseif(!ctype_digit($input_Profit)){
    $Profit_err = "Please enter a positive integer value.";
    } else{
    $Profit = $input_Profit;
    }



    // Check input errors before inserting in database
    if(empty($Items_err) && empty($UnitsSold_err) && empty($TotalCost_err) && empty($SellingPrice_err) && empty($Profit_err)){
    // Prepare an update statement
    $sql = "UPDATE tbsum SET Items=?, UnitsSold=?, TotalCost=?, SellingPrice=?, Profit=?
    WHERE id=?";


    if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "sssssi", $param_Items, $param_UnitsSold,
    $param_TotalCost, $param_SellingPrice, $param_Profit, $param_id);


    // Set parameters
    $param_Items = $Items;
    $param_UnitsSold = $UnitsSold;
    $param_TotalCost = $TotalCost;
    $param_SellingPrice = $SellingPrice;
    $param_Profit = $Profit;
    $param_id = $id;


    // Attempt to execute the prepared statement 
    if(mysqli_stmt_execute($stmt)){
    // Records updated successfully. Redirect to landing page
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
    } else{
    // Check existence of id parameter before processing further 
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Get URL parameter
    $id = trim($_GET["id"]);


    // Prepare a select statement
    $sql = "SELECT * FROM tbsum WHERE id = ?"; if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters 
    mysqli_stmt_bind_param($stmt, "i", $param_id);

    // Set parameters
    $param_id = $id;


    // Attempt to execute the prepared statement 
    if(mysqli_stmt_execute($stmt)){
    $result = mysqli_stmt_get_result($stmt);
    
    if(mysqli_num_rows($result) == 1){
    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);


    // Retrieve individual field value
    $Items = $row["Items"];
    $UnitsSold = $row["UnitsSold"];
    $TotalCost = $row["TotalCost"];
    $SellingPrice = $row["SellingPrice"];
    $Profit = $row["Profit"];
    } else{
    // URL doesn't contain valid id. Redirect to error page 
    header("location: sumerror.php");
    exit();
    }


    } else{
    echo "Oops! Something went wrong. Please try again later.";
    }
    }


    // Close statement 
    mysqli_stmt_close($stmt);

    // Close connection 
    mysqli_close($link);
    } else{
    // URL doesn't contain id parameter. Redirect to error page 
    header("location: sumerror.php");
    exit();
    
    }
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .wrapper {
        width: 600px;
        margin: 0 auto;
    }
    </style>
</head>


<body background="images/coffee.jpg">
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the item summary.</p>
                    <form action="<?php	echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
                            <label>SellingPrice</label>
                            <input type="text" name="SellingPrice"
                                class="form-control <?php echo (!empty($SellingPrice_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $SellingPrice; ?>">
                            <span class="invalid-feedback"><?php echo $SellingPrice_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Profit</label>
                            <input type="text" name="Profit"
                                class="form-control <?php echo (!empty($Profit_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $Profit; ?>">
                            <span class="invalid-feedback"><?php echo $Profit_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="sumindex.php" class="btn btn-secondary ml-2">Cancel</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>