<?php


session_start();

include "db.php";

if(!isset($_SESSION['userid'])){


    header("Location: login.php");

    exit();


}


$id = $_GET['id'];

$userid = $_SESSION['userid'];


mysqli_query(
$conn,
"UPDATE tasks
SET is_active=0
WHERE id='$id'
AND userid='$userid'"
);


header("Location: dashboard.php");


?>