<?php

session_start();

include "db.php";

if(!isset($_SESSION['userid'])){


    header("Location: login.php");

    exit();


}

$task_id = $_GET['id'];

$userid = $_SESSION['userid'];


$check = mysqli_query(
$conn,
"SELECT * FROM task_logs
WHERE task_id='$task_id'
AND userid='$userid'
AND completed_date=CURDATE()"
);



if(mysqli_num_rows($check)>0){


    mysqli_query(
    $conn,
    "DELETE FROM task_logs
    WHERE task_id='$task_id'
    AND userid='$userid'
    AND completed_date=CURDATE()"
    );


}

else{


    mysqli_query(
    $conn,
    "INSERT INTO task_logs
    (task_id,userid,completed_date)

    VALUES
    ('$task_id','$userid',CURDATE())"
    );


}


header("Location: dashboard.php");


?>