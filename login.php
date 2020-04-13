<?php

session_start();

if (isset($_SESSION['username1']) && !empty($_SESSION['username1'])) {
//   echo '<script type="text/javascript" language="javascript">
//                window.open("index.php?Role=' . $Role . '");</script>';
}

//  $host = "etaksi.co.uk.mysql";
//  $username = "etaksi_co_uk_myapplication_db";
//  $password = "Security2009";
//  $database = "etaksi_co_uk_myapplication_db";
//  $GLOBALS['db'] = "etaksi_co_uk_myapplication_db";
//  $message = "";


$host = "localhost";
$username = "root";
$password = "";
$database = "myapplication_db";
$GLOBALS['db'] = "myapplication_db";
$message = "";


try {
    $connect = new PDO("mysql:host=$host; dbname=$database", $username, $password);
    // include('dbconnection.php');
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST["login"])) {
        if (empty($_POST["username"]) || empty($_POST["password"])) {
            $message = '<label>All fields are required</label>';
        } else {
            $query = "SELECT * FROM users WHERE (username = :username OR email=:username) AND (password = :password)";
            $statement = $connect->prepare($query);
            $statement->execute(
                    array(
                        'username' => $_POST["username"],
                        'password' => $_POST["password"]
                    )
            );
            $count = $statement->rowCount();
            $row = $statement->fetch(PDO::FETCH_NUM);
            if ($count > 0) {
                $_SESSION["id1"] = $row[0];
                $_SESSION["username1"] = $_POST["username"];
                $_SESSION["Role"] = $row[4];
                $_SESSION['start'] = time();
                $_SESSION["version"] = "V101";
                $_SESSION["Cname"] = "Guardian FM Limited";
                $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);
                $_SESSION['Role'] = $row[14];
                $id = $row[0];
                $Role = $row[14];


                $currmon = date("M-Y");
                
 SessionStatus($id, $_SESSION["username1"]);
 
      
                header("location:index.php?Role='" . $Role . "'");
            } else {
                $message = '<label>Wrong Username or Password</label>';
            }
        }
    }
} catch (PDOException $error) {
    $message = $error->getMessage();
}


function SessionStatus($id, $username) {

    include './dbconnection.php';

    //Check
    $sql = "SELECT * FROM `user_active` WHERE `user_id`='$id'";
    $result = mysqli_query($connect, $sql);

    $row = mysqli_fetch_array($result);
    if (mysqli_num_rows($result) > 0) {

        //Found Update

        $sql = "UPDATE `user_active` SET `status`='Active' WHERE `user_id`=" . $id . "";
        if (mysqli_query($connect, $sql)) {
//            echo 'Record has been Updated Succesfully ';
        } else {
            echo "ERROR IN QUERY" . $connect->error;
        };
    } else {
        //Not  Found Insert
        $query = "INSERT INTO `user_active`(`user_id`, `username`, `status`) VALUES ('" . $id . "','" . $username . "','Active')";
//        echo $query;
        if (mysqli_query($connect, $query)) {
//            echo 'Record has been save Successfullly ';
        } else {
            echo "ERROR IN QUERY" . $connect->error;
        };
    }
}
?> 
 
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>EagleWF Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!-- Include the above in your HEAD tag -->

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link href="css/logincss.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
     <div class="main">
    
    
    <div class="container">
<center>
<div class="middle">
      <div id="login">

          <form   method="post" id="auth_div" autocomplete="off">

          <fieldset class="clearfix">

              <p ><span class="fa fa-user"></span><input type="text" name="username"  Placeholder="Email" required autocomplete="off"></p> <!-- JS because of IE support; better: placeholder="Username" -->
            <p><span class="fa fa-lock"></span><input type="password" name="password" Placeholder="Password" required autocomplete="off"></p> <!-- JS because of IE support; better: placeholder="Password" -->
            
             <div>
                                <span style="width:48%; text-align:left;  display: inline-block;"><a class="small-text" href="#">Forgot
                                password?</a></span>
                                <span style="width:50%; text-align:right;  display: inline-block;"><input type="submit" name="login" value="Login" ></span>
                            </div>
  <?php
                                if (isset($message)) {
                                    echo '<h3 class="text-danger">' . $message . '</h3>';
                                }
                                ?>
          </fieldset>
<div class="clearfix"></div>
        </form>

        <div class="clearfix"></div>

      </div> <!-- end login -->
      <div class="logo">Eagle (WF)
          
          <div class="clearfix"></div>
      </div>
      
      </div>
</center>
    </div>

</div>
    </body>
</html>
