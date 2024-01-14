<?php
session_start();
include "db_conn.php";

if (isset($_POST['cname'])){

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $user_id = $_SESSION['id'];
    $cname = validate($_POST['cname']);

    if(empty($cname)){
        header("Location: home.php?error=collection name is required");
        exit();
    }
    else{
        $sql = "INSERT INTO collections(user_id, collection_name) VALUES('$user_id', '$cname')";
        $result =  mysqli_query($conn, $sql);
        if ($result){
            header("Location: home.php?success=Your collection has been created successfully");
            exit();
        }
        else{
            header("Location: home.php?error=Unknown error occurred&$user_data");
            exit();
        }
    }
}
else{
    header("Location: home.php");
    exit();
}