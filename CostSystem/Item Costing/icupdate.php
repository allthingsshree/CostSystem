<?php
    // Include config file 
    require_once "config.php";

    // Define variables and initialize with empty values
    $item = $servings = $cost = $costperunit = $sellingprice = "";
    $item_err = $servings_err = $cost_err = $costperunit_err = $sellingprice_err = "";

    // Processing form data when form is submitted 
    if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

    // Validate item
    $input_item = trim($_POST["item"]); if(empty($input_item)){
    $item_err = "Please enter a item.";
    }	elseif(!filter_var($input_item,	FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
    $item_err = "Please enter a valid item.";
    } else{
    $item = $input_item;
    }
    

    // Validate servings
    $input_servings = trim($_POST["servings"]); if(empty($input_servings)){
    $servings_err = "Please enter an servings.";
    } elseif(!ctype_digit($input_servings)){
    $servings_err = "Please enter a positive integer value.";

    } else{
    $servings = $input_servings;
    }

    // Validate cost
    $input_cost = trim($_POST["cost"]); if(empty($input_cost)){
    $cost_err = "Please enter the cost amount.";
    } elseif(!ctype_digit($input_cost)){
    $cost_err = "Please enter a positive integer value.";
    } else{
    $cost = $input_cost;
    }

    // Validate costperunit
    $input_costperunit = trim($_POST["costperunit"]); if(empty($input_costperunit)){
    $costperunit_err = "Please enter the costperunit amount.";
    } elseif(!ctype_digit($input_costperunit)){
    $costperunit_err = "Please enter a positive integer value.";
    } else{
    $costperunit = $input_costperunit;
    }

    // Validate sellingprice
    $input_sellingprice = trim($_POST["cost"]); if(empty($input_sellingprice)){
    $sellingprice_err = "Please enter the sellingprice amount.";
    } elseif(!ctype_digit($input_sellingprice)){
    $sellingprice_err = "Please enter a positive integer value.";
    } else{
    $sellingprice = $input_sellingprice;
    
    }


    // Check input errors before inserting in database
    if(empty($item_err)	&&	empty($servings_err)	&&	empty($cost_err) && empty($costperunit_err) && empty($sellingprice_err)){
    // Prepare an update statement
    $sql = "UPDATE employees SET item=?, servings=?, cost=?, costperunit=?, sellingprice=? WHERE id=?";

    if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters 
    mysqli_stmt_bind_param($stmt, "sssssi", $param_item, $param_servings,
    $param_cost, $param_costperunit, $param_sellingprice);

    // Set parameters
    $param_item = $item;
    $param_servings = $servings;
    $param_cost = $cost;
    $param_costperunit = $costperunit;
    $param_sellingprice = $sellingprice;
    $param_id = $id;



    // Attempt to execute the prepared statement 
    if(mysqli_stmt_execute($stmt)){
    // Records updated successfully. Redirect to landing page 
    header("location: icindex.php");
    exit();
    } else{
    echo "Oops! Something went wrong. Please try again later.";
    }
    }

    // Close statement 
    mysqli_stmt_close($stmt) ;

    }
    

    // Close connection 
    mysqli_close($link);
    } else{
    // Check existence of id parameter before processing further 
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Get URL parameter
    $id = trim($_GET["id"]);

    // Prepare a select statement
    $sql = "SELECT * FROM tbic WHERE id = ?"; if($stmt = mysqli_prepare($link, $sql)){
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
    $item = $row["item"];
    $servings = $row["servings"];
    $cost = $row["cost"];
    $costperunit = $row["costperunit"];
    $sellingprice = $row["sellingprice"];
    } else{
    // URL doesn't contain valid id. Redirect to error page 
    header("location: icerror.php");
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
    header("location: icerror.php");
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

    body {
        background-repeat: repeat;
        background-size: contain;
    }

    body,
    html {
        height: 100%;
    }
    </style>
</head>

<body background="images/greenlemon.jpg">
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the item record.</p>
                    <form action="<?php	echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">

                        <div class="form-group">
                            <label>item</label>
                            <input type="text" name="item"
                                class="form-control <?php echo (!empty($item_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $item; ?>">
                            <span class="invalid-feedback"><?php echo $item_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>servings</label>
                            <textarea name="servings"
                                class="form-control <?php echo (!empty($servings_err)) ? 'is-invalid' : ''; ?>"><?php echo $servings; ?></textarea>
                            <span class="invalid-feedback"><?php echo $servings_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>cost</label>
                            <input type="text" name="cost"
                                class="form-control <?php echo (!empty($cost_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $cost; ?>">
                            <span class="invalid-feedback"><?php echo $cost_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>costperunit</label>
                            <input type="text" name="costperunit"
                                class="form-control <?php echo (!empty($cost_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $costperunit; ?>">
                            <span class="invalid-feedback"><?php echo $costperunit_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>sellingprice</label>

                            <input type="text" name="sellingprice"
                                class="form-control <?php echo (!empty($cost_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $sellingprice; ?>">
                            <span class="invalid-feedback"><?php echo $sellingprice_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="icindex.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br><br>
    <div>
        <h2 align="center"> <a href="icindex.php">ITEMS</a></h2>
        <iframe src="icindex.php" height="800px" width="1455px" title="Item"></iframe>
    </div>

</body>

</html>