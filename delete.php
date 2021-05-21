<?php
// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Include config file
    require_once "studentconfig.php";
    
    // Prepare a delete statement
    $sql = "DELETE FROM users WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_POST["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: studentindex.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
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
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <img src="logo.png" style="width:600px; height="600px;">

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Delete Record</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Are you sure you want to delete this record?</p><br>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="studentindex.php" class="btn btn-default">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
<style type="text/css">
    .wrapper{
            width: 500px;
            margin: 0 auto;
        }
a {text-align:center;}
.block {
  display: block;
  width: 50%;
  border: none;
 
  color: gold;
  padding: 14px 28px;
  font-size: 25px;
  cursor: pointer;
  text-align: center;
}

.block:hover {
  background-color:gold;
  color: black;
}
body {background-image: url(BG.jpg); 
background-size:cover;
color:white;
font-size: 30px;
}
img{display: block;
  margin-left: auto;
  margin-right: auto;
  width: 100%;
}
a {color:black; font-family:castellar;}
.button {
    float: right ;
    margin-top:30px;
    transform: translate(-10%, -10%); 
}
.btn {
    border: 1px solid;
    padding: 30px 50px;
    color: white;
    font-family: Arial;
    
    background-color: gold;
}
</style>
</html>