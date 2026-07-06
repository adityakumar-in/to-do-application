<?php

session_start();

include "db.php";


if(isset($_POST['login'])){


    $username = $_POST['username'];

    $password = $_POST['password'];



    if(empty($username) || empty($password)){


        $error = "All fields required";


    }


    else{


        $query = "SELECT * FROM users 
        WHERE username='$username'";


        $result = mysqli_query($conn,$query);



        if(mysqli_num_rows($result) > 0){


            $row = mysqli_fetch_assoc($result);



            if(password_verify($password,$row['password'])){


                $_SESSION['userid'] = $row['id'];

                $_SESSION['username'] = $row['username'];


                header("Location: dashboard.php");

                exit();


            }


            else{


                $error = "Wrong username or password";


            }


        }


        else{


            $error = "Wrong username or password";


        }


    }


}


?>


<!DOCTYPE html>

<html>

<head>

<title>Register</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="style.css">

</head>



<body>


<div class="container">


<h2>Login</h2>



<?php if(isset($error)){ ?>


<p class="error">

<?php echo $error; ?>

</p>


<?php } ?>



<form method="POST">


<input
type="text"
name="username"
placeholder="Username">


<input
type="password"
name="password"
placeholder="Password">



<button name="login">

Login

</button>



<p class="register-text">

Don't have an account?

<a href="register.php">Register</a>

</p>



</form>


</div>


</body>


</html>