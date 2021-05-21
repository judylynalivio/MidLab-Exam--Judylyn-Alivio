<!DOCTYPE html>
<html lang="en">
<head>
    <br>                <br>     <br>     <br>     <br>     <br>     <br>     <br>     <br>     <br>     
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">


<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bootstrap Table with Search Column Feature</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style type="text/css">
    body {
background-image: url(BG.jpg);
background-size: cover;
}

    .table-wrapper {
        background: #fff;
        padding: 20px 25px;
        margin: 30px auto;
        border-radius: 3px;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    .table-title {
        color: #fff;
        background: #40b2cd;        
        padding: 16px 25px;
        margin: -20px -25px 10px;
        border-radius: 3px 3px 0 0;
    }
    .table-title h2 {
        margin: 5px 0 0;
        font-size: 24px;
    }
    .search-box {
        position: relative;
        float: right;
    }
    .search-box .input-group {
        min-width: 300px;
        position: absolute;
        right: 0;
    }
    .search-box .input-group-addon, .search-box input {
        border-color: #ddd;
        border-radius: 0;
    }   
    .search-box input {
        height: 34px;
        padding-right: 35px;
        background: #f4fcfd;
        border: none;
        border-radius: 2px !important;
    }
    .search-box input:focus {
        background: #fff;
    }
    .search-box input::placeholder {
        font-style: italic;
    }
    .search-box .input-group-addon {
        min-width: 35px;
        border: none;
        background: transparent;
        position: absolute;
        right: 0;
        z-index: 9;
        padding: 6px 0;
    }
    .search-box i {
        color: #a0a5b1;
        font-size: 19px;
        position: relative;
        top: 2px;
    }
    table.table {
        table-layout: fixed;
        margin-top: 15px;
    }
    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
    }
    table.table th i {
        font-size: 13px;
        margin: 0 5px;
        cursor: pointer;
    }
    table.table th:first-child {
        width: 60px;
    }
    table.table th:last-child {
        width: 120px;
    }
    table.table td a {
        color: #a0a5b1;
        display: inline-block;
        margin: 0 5px;
    }
    table.table td a.view {
        color: #03A9F4;
    }
    table.table td a.edit {
        color: #FFC107;
    }
    table.table td a.delete {
        color: #E34724;
    }
    table.table td i {
        font-size: 19px;
    }    
    img{display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
</style>

<script type="text/javascript">
        

$(document).ready(function(){
    // Activate tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Filter table rows based on searched term
    $("#search").on("keyup", function() {
        var term = $(this).val().toLowerCase();
        $("table tbody tr").each(function(){
            $row = $(this);
            var name = $row.find("td:nth-child(2)").text().toLowerCase();
            console.log(name);
            if(name.search(term) < 0){                
                $row.hide();
            } else{
                $row.show();
            }
        });
    });
});
</script>

</head>

<body>
     <img src="logo.png" style="width:600px; height="600px;">

 <div class="container">
        <div class="table-wrapper">         
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                    
                        
                        <h2>Student Users Details</h2> 
                        <a href="sindex.php" class="btn btn-success pull-left">Student Maintenance</a>
                    </div>
                    <div class="col-sm-6">
                        <div class="search-box">
                            <div class="input-group">

                                <input type="text" id="search" class="form-control" placeholder="Search by Name">
                                <span class="input-group-addon"><i class="material-icons">&#xE8B6;</i></span><br><br>
                                <a href="studentcreate.php" class="btn btn-success pull-right">Add New Student Users</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                    <?php
                    // Include config file
                    require_once "studentconfig.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM users";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Username</th>";
                                        echo "<th>Email</th>";
                                        echo "<th>Password</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['username'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . $row['password'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='studentread.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='studentupdate.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='studentdelete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>