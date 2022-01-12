<?php
    // Include config file 
    require_once "config.php";

    // Define variables and initialize with empty values
    $Ingredients = $Quantity = $Units = $Price = $PricePerGram = "";
    $Ingredients_err = $Quantity_err = $Units_err = $Price_err = $PricePerUnit_err ="";

    // Processing form data when form is submitted 
    if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

    // Validate Ingredients
    $input_Ingredients = trim($_POST["Ingredients"]); if(empty($input_Ingredients)){
    $Ingredients_err = "Please enter an Ingredients.";
    } else{
    $Ingredients = $input_Ingredients;
    }

    // Validate Quantity
    $input_Quantity = trim($_POST["Quantity"]); if(empty($input_Quantity)){
    $Quantity_err = "Please enter an Quantity.";
    } else{
    $Quantity = $input_Quantity;
    }

    // Validate Units
    
    $input_Units = trim($_POST["Units"]); if(empty($input_Units)){
    $Units_err = "Please enter the Units amount.";
    } elseif(!ctype_digit($input_Units)){
    $Units_err = "Please enter a positive integer value.";
    } else{
    $Units = $input_Units;
    }

    //Validate Price
    $input_Price = trim($_POST["Price"]); if(empty($input_Price)){
    $Price_err = "Please enter the Price amount.";
    } elseif(!ctype_digit($input_Price)){
    $Price_err = "Please enter a positive integer value.";
    } else{
    $Price = $input_Price;
    }

    //Validate PricePerGram
    $input_PricePerGram = trim($_POST["PricePerGram"]); if(empty($input_PricePerGram)){
    $PricePerUnit_err = "Please enter the PricePerGram amount.";
    } elseif(!ctype_digit($input_PricePerGram)){
    $PricePerGram_err = "Please enter a positive integer value.";
    } else{
    $PricePerGram = $input_PricePerGram;
    }


    // Check input errors before inserting in database
    if(empty($Ingredients_err) && empty($Quantity_err) && empty($Units_err) && empty($Price_err) && empty($PricePerGram_err)){
    // Prepare an update statement
    $sql = "UPDATE tbint SET Ingredients=?, Quantity=?, Units=?, Price=?, PricePerGram=? WHERE id=?";

    if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    
    mysqli_stmt_bind_param($stmt, "sssi", $param_Ingredients, $param_Quantity,
    $param_Units, $param_Price, $param_PricePerGram, $param_id);

    // Set parameters
    $param_Ingredients = $Ingredients;
    $param_Quantity = $Quantity;
    $param_Units = $Units;
    $param_Price = $Price;
    $param_PricePerGram = $PricePerGram;
    $param_id = $id;

    // Attempt to execute the prepared statement 
    if(mysqli_stmt_execute($stmt)){
    // Records updated successfully. Redirect to landing page 
    header("location: index.php");
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
    $sql = "SELECT * FROM tbint WHERE id = ?"; if($stmt = mysqli_prepare($link, $sql)){
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
    $Ingredients = $row["Ingredients"];
    $Quantity = $row["Quantity"];
    $Units = $row["Units"];
    $Price = $row["Price"];
    $PricePerGram = $row["PricePerGram"];
    } else{
    // URL doesn't contain valid id. Redirect to error page 
    header("location: error.php");
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
    header("location: error.php");
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

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee
                        record.</p>
                    <form action="<?php	echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Ingredients</label>
                            <input type="text" name="Ingredients"
                                class="form-control <?php echo (!empty($Ingredients_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $Ingredients; ?>">
                            <span class="invalid-feedback"><?php echo $Ingredients_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="text" name="Quantity"
                                class="form-control <?php echo (!empty($Quantity_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $Quantity; ?>">
                            <span class="invalid-feedback"><?php echo $Quantity_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Units</label>

                            <input type="text" name="Units"
                                class="form-control <?php echo (!empty($Units_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $Units; ?>">
                            <span class="invalid-feedback"><?php echo $Units_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" name="Price"
                                class="form-control <?php echo (!empty($Price_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $Price; ?>">
                            <span class="invalid-feedback"><?php echo $Price_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>PricePerGram</label>
                            <input type="text" name="PricePerGram"
                                class="form-control <?php echo	(!empty($PricePerGram_err))	?	'is-invalid'	:	'';	?>"
                                value="<?php	echo $PricePerGram; ?>">
                            <span class="invalid-feedback"><?php echo $PricePerGram_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>