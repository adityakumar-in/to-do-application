<?php

include "db.php";


$message = "";


if(isset($_POST['register'])){


    $username = $_POST['username'];

    $email = $_POST['email'];

    $password = $_POST['password'];



    if(empty($username) || empty($email) || empty($password)){


        $message = "All fields are required";


    }
    else{


        // CHECK USERNAME EXISTS


        $checkUser = mysqli_query(
            $conn,
            "SELECT * FROM users WHERE username='$username'"
        );


        if(mysqli_num_rows($checkUser) > 0){


            $message = "Username already exists";


        }
        else{


            // CHECK EMAIL EXISTS


            $checkEmail = mysqli_query(
                $conn,
                "SELECT * FROM users WHERE email='$email'"
            );



            if(mysqli_num_rows($checkEmail) > 0){


                $message = "Email already registered";


            }
            else{


                // HASH PASSWORD


                $hashPassword = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );



                $insert = mysqli_query(
                    $conn,
                    "INSERT INTO users(username,email,password)
                    VALUES('$username','$email','$hashPassword')"
                );



                if($insert){


                    header("Location: login.php");

                    exit();


                }
                else{


                    $message = "Registration failed";


                }


            }


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


<h2>Create Account</h2>



<?php

if(!empty($message)){

    echo "<p class='error'>$message</p>";

}

?>



<form method="POST">



<input 
type="text" 
name="username" 
placeholder="Username"
>



<input 
type="email" 
name="email" 
placeholder="Email"
>



<input 
type="password" 
name="password" 
placeholder="Password"
>



<button name="register">

Register

</button>



</form>



<p>

Already have an account?

<a href="login.php">
Login
</a>

</p>



</div>



</body>


</html>