<?php
// Include config file
require_once "studentconfig.php";
 
// Define variables and initialize with empty values
$username = $email = $password = "";
$username_err = $email_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    
    // Validate username
    $input_username = trim($_POST["username"]);
    if(empty($input_username)){
        $username_err = "Please enter username.";     
    } else{
        $username = $input_username;
    }
    
    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email )){
        $email_err = "Please enter email .";     
    } else{
        $email  = $input_email ;
    }

    // Validate password
    $input_password = trim($_POST["password"]);
    if(empty($input_password )){
        $password_err = "Please enter password.";     
    } else{
        $password  = $input_password ;
    }
    // Check input errors before inserting in database
    if(empty($username_err) && empty($email_err) && empty($password_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_email = $email;
            $param_password = $password;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
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
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add student account to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                            <span class="help-block"><?php echo $username_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                            <span class="help-block"><?php echo $password_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="studentindex.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
<style>
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
</html>

