<?php
    // Include config file 
    require_once "config.php";

    // Define variables and initialize with empty values
    $Ingredients = $Quantity = $Units = $Price = $PricePerGram = "";
    $Ingredients_err = $Quantity_err = $Units_err = $Price_err = $PricePerGram_err = "";

    // Processing form data when form is submitted 
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate Ingredients
    $input_Ingredients = trim($_POST["Ingredients"]); if(empty($input_Ingredients)){
    $Ingredients_err = "Please enter an Ingredient.";
    } else{
    $Ingredients = $input_Ingredients;
    }

    // Validate Quantity
    
    $input_Quantity = trim($_POST["Quantity"]); if(empty($input_Quantity)){
    $Quantity_err = "Please enter a Quantity.";
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

    // Validate Price
    $input_Price = trim($_POST["Price"]); if(empty($input_Price)){
    $Price_err = "Please enter the Price amount.";
    } elseif(!ctype_digit($input_Price)){
    $Price_err = "Please enter a positive integer value.";
    } else{
    $Price = $input_Price;
    }
    // Validate PricePerGram
    $input_PricePerGram = trim($_POST["PricePerGram"]); if(empty($input_PricePerGram)){
    $PricePerGram_err = "Please enter the PricePerGram amount.";
    } elseif(!ctype_digit($input_PricePerGram)){
    $PricePerGram_err = "Please enter a positive integer value.";
    } else{
    $PricePerGram = $input_PricePerGram;
    }


    // Check input errors before inserting in database
    if(empty($Ingredients_err) && empty($Quantity_err) && empty($Units_err) && empty($Price_err) && empty($PricePerGram_err)){
    
    // Prepare an insert statement
    $sql = "INSERT INTO tbint (Ingredients, Quantity, Units, Price, PricePerGram) VALUES (?, ?, ?,?,?)";

    if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters 
    mysqli_stmt_bind_param($stmt, "sssss", $param_Ingredients, $param_Quantity,
    $param_Units, $param_Price, $param_PricePerGram);

    // Set parameters
    $param_Ingredients = $Ingredients;
    $param_Quantity = $Quantity;
    $param_Units = $Units;
    $param_Price = $Price;
    $param_PricePerGram = $PricePerGram;

    // Attempt to execute the prepared statement 
    if(mysqli_stmt_execute($stmt)){
    // Records created successfully. Redirect to landing page 
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

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the
                        database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>