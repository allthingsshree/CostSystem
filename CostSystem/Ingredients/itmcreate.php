<?php
    // Include config file 
    require_once "config.php";

    // Define variables and initialize with empty values
    $ingredients = $quantity = $costpergram = $totalcost = "";
    $ingredients_err = $quantity_err = $costpergram_err = $totalcost_err = "";

    // Processing form data when form is submitted 
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate ingredients
    $input_ingredients = trim($_POST["ingredients"]); if(empty($input_ingredients)){
    $ingredients_err = "Please enter a ingredients.";
    }	elseif(!filter_var($input_ingredients,	FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
    $ingredients_err = "Please enter a valid ingredients.";
    } else{
    $ingredients = $input_ingredients;
    }
    

    // Validate quantity
    $input_quantity = trim($_POST["quantity"]); if(empty($input_quantity)){
    $quantity_err = "Please enter an quantity.";
    } elseif(!ctype_digit($input_quantity)){
    $quantity_err = "Please enter a positive integer value.";

    } else{
    $quantity = $input_quantity;
    }



    // Validate costpergram
    $input_costpergram = trim($_POST["costpergram"]); if(empty($input_costpergram)){
    $costpergram_err = "Please enter the costpergram amount.";
    } elseif(!ctype_digit($input_costpergram)){
    $costpergram_err = "Please enter a positive integer value.";
    } else{
    $costpergram = $input_costpergram;
    }

    // Validate totalcost
    $input_totalcost = trim($_POST["totalcost"]); if(empty($input_totalcost)){
    $totalcost_err = "Please enter the totalcost amount.";
    } elseif(!ctype_digit($input_totalcost)){
    $totalcost_err = "Please enter a positive integer value.";
    } else{
    $totalcost = $input_totalcost;
    }

    // Check input errors before inserting in database
    if(empty($ingredients_err) && empty($quantity_err) && empty($costpergram_err) && empty($totalcost_err)){
    // Prepare an insert statement
    $sql = "INSERT INTO tbitm (ingredients, quantity, costpergram, totalcost) VALUES (?, ?, ?, ?)";
    

    if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters 
    mysqli_stmt_bind_param($stmt, "ssss", $param_ingredients, $param_quantity,
    $param_costpergram, $param_totalcost);

    // Set parameters
    $param_ingredients = $ingredients;
    $param_quantity = $quantity;
    $param_costpergram = $costpergram;
    $param_totalcost = $totalcost;

    // Attempt to execute the prepared statement 
    if(mysqli_stmt_execute($stmt)){
    // Records created successfully. Redirect to landing page 
    header("location: itmindex.php");
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

    h2 {
        color: white;
    }
    </style>
</head>

<body background="images/greenlemon.jpg">
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add ingredients record to the
                        database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>ingredients</label>
                            <input type="text" name="ingredients"
                                class="form-control <?php echo (!empty($ingredients_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $ingredients; ?>">
                            <span class="invalid-feedback"><?php echo $ingredients_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>quantity</label>
                            <textarea name="quantity"
                                class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>"><?php echo $quantity; ?></textarea>
                            <span class="invalid-feedback"><?php echo $quantity_err;?></span>

                        </div>

                        <div class="form-group">
                            <label>costpergram</label>
                            <input type="text" name="costpergram"
                                class="form-control <?php echo (!empty($cost_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $costpergram; ?>">
                            <span class="invalid-feedback"><?php echo $costpergram_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>totalcost</label>
                            <input type="text" name="totalcost"
                                class="form-control <?php echo (!empty($cost_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $totalcost; ?>">
                            <span class="invalid-feedback"><?php echo $totalcost_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="itmindex.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>

</html>