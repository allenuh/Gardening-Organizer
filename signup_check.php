<?php
session_start();
include "db_conn.php";

if (isset($_POST['uname']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['confirm_password'])){

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);
    $name = validate($_POST['name']);
    $confirm_pass = validate($_POST['confirm_password']);

    $user_data = 'uname='. $uname. '&name='. $name;

    if(empty($uname)){
        header("Location: signup.php?error=Username is required&$user_data");
        exit();
    }
    else if(empty($pass)){
        header("Location: signup.php?error=Password is required&$user_data");
        exit();
    }
    else if(empty($name)){
        header("Location: signup.php?error=Name is required&$user_data");
        exit();
    }
    else if(empty($confirm_pass)){
        header("Location: signup.php?error=Confirm your password&$user_data");
        exit();
    }
    else if($pass !== $confirm_pass){
        header("Location: signup.php?error=The confirmation password does not match&$user_data");
        exit();
    }

    else{
        //hashing the password
        $pass = md5($pass);

        $sql = "SELECT * FROM users WHERE username='$uname' ";
        $result =  mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0){
            header("Location: signup.php?error=This username is not available&$user_data");
            exit();
        }
        else{
            $sql2 = "INSERT INTO users(username, password, name) VALUES('$uname', '$pass', '$name')";
            $result2 =  mysqli_query($conn, $sql2);
            if ($result2){
                header("Location: signup.php?success=Your account has been created successfully");
                exit();
            }
            else{
                header("Location: signup.php?error=Unknown error occurred&$user_data");
                exit();
            }
        }
 
    }
}
else{
    header("Location: signup.php");
    exit();
}