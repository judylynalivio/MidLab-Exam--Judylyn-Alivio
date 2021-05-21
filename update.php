<?php
// Include config file
require_once "studentconfig.php";
 
// Define variables and initialize with empty values
$username = $email = $password = "";
$username_err = $email_err = $password_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    
    // Validate username
    $input_username = trim($_POST["username"]);
    if(empty($input_username)){
        $username_err = "Please enter your username.";     
    } else{
        $username = $input_username;
    }
    

    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter your email.";     
    } else{
        $email = $input_email;
    }
    
    // Validate password
    $input_password = trim($_POST["password"]);
    if(empty($input_password)){
        $password_err = "Please enter your password.";     
    } else{
        $password = $input_password;
    }
    
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($email_err) && empty($password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET username=?, email=?, password=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_username, $param_email, $param_password, $param_id);
            
            // Set parameters
            $param_username = $username;
            $param_email = $email;
            $param_password = $password;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: studentindex.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
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
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM users WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
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
                    $username = $row["username"];
                    $email = $row["email"];
                    $password = $row["password"];
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
    }  else{
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
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
</head>
<body>
    <img src="logo.png" style="width:600px; height="600px;">

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                            <span class="help-block"><?php echo $username_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <textarea name="email" class="form-control"><?php echo $email; ?></textarea>
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                            <span class="help-block"><?php echo $password_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="studentindex.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>