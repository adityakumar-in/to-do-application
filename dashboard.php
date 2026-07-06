<?php


date_default_timezone_set("Asia/Kolkata");

session_start();

include "db.php";


if(!isset($_SESSION['username'])){

    header("Location: login.php");

    exit();

}



$userid = $_SESSION['userid'];



if(isset($_POST['add'])){


    $task = $_POST['task'];



    if(!empty($task)){


        $check = mysqli_query(
            $conn,
            "SELECT * FROM tasks
            WHERE userid='$userid'
            AND task_name='$task'
            AND is_active=1"
        );



        if(mysqli_num_rows($check)==0){


            mysqli_query(
                $conn,
                "INSERT INTO tasks(userid,task_name,created_at,is_active)
                VALUES('$userid','$task',CURDATE(),1)"
            );


        }


    }


}




$tasks = mysqli_query(
$conn,
"SELECT * FROM tasks
WHERE userid='$userid'
AND is_active=1"
);




$totalTasks = mysqli_query(
$conn,
"SELECT COUNT(*) as total
FROM tasks
WHERE userid='$userid'
AND is_active=1"
);


$total = mysqli_fetch_assoc($totalTasks)['total'];




$completedTasks = mysqli_query(
$conn,
"SELECT COUNT(*) as completed

FROM task_logs

JOIN tasks

ON task_logs.task_id = tasks.id


WHERE task_logs.userid='$userid'

AND task_logs.completed_date=CURDATE()

AND tasks.is_active=1"
);



$completed = mysqli_fetch_assoc($completedTasks)['completed'];



$percentage = 0;


if($total > 0){


    $percentage = ($completed / $total) * 100;


}


?>



<!DOCTYPE html>

<html>


<head>


<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard</title>

<link rel="stylesheet" href="style.css">


</head>




<body>



<div class="dashboard">



<div class="top">



<div>



<h2>

👋 Hello,

<?php echo $_SESSION['username']; ?>

</h2>



<div class="datetime">

    <p>
        <?php echo date("l, d M Y"); ?>
    </p>

    <span id="clock"></span>

</div>



</div>




<div class="progress-box">


<h3>🔥 Progress</h3>



<h1>

<?php echo $completed . "/" . $total; ?>

</h1>



<div class="progress">


<div 
class="progress-fill"
style="width:<?php echo $percentage; ?>%">

</div>


</div>


</div>


</div>





<form class="task-form" method="POST">


<input
type="text"
name="task"
placeholder="Create a daily habit...">



<button name="add">

+

</button>



</form>





<h3>Your Daily Habits</h3>



<div class="tasks">


<?php


while($row=mysqli_fetch_assoc($tasks)){


$taskid = $row['id'];



$done = mysqli_query(
$conn,
"SELECT * FROM task_logs

WHERE task_id='$taskid'

AND userid='$userid'

AND completed_date=CURDATE()"
);


?>



<div class="task-card">



<span>

<?php echo $row['task_name']; ?>

</span>




<div>


<a href="toggle_task.php?id=<?php echo $row['id']; ?>">



<?php


if(mysqli_num_rows($done)>0){


    echo "✅";


}


else{


    echo "⬜";


}


?>


</a>




<a href="delete_task.php?id=<?php echo $row['id']; ?>">


🗑️


</a>



</div>



</div>



<?php


}


?>



</div>





<div class="logout-box">


<a class="logout" href="logout.php">

Logout

</a>


</div>




</div>

<script>

function updateClock(){


    let now = new Date();


    let hours = now.getHours();

    let minutes = now.getMinutes();

    let seconds = now.getSeconds();



    hours = hours.toString().padStart(2,"0");

    minutes = minutes.toString().padStart(2,"0");

    seconds = seconds.toString().padStart(2,"0");



    document.getElementById("clock").innerHTML =
    hours + ":" + minutes + ":" + seconds;


}



updateClock();


setInterval(updateClock,1000);


</script>

</body>


</html>