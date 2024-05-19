<?php

declare(strict_types=1);

function signup_form(){
    if (!isset($_SESSION["user_id"])) {
        echo '<div>
        <h1>Signup</h1>
        <form action="includes/signup/signup.inc.php" method="post">';

            if (isset($_SESSION["signup_data"]["username"]) && !isset($_SESSION["errors_signup"]["username_taken"])) {
    
                echo '<label for="username">Username</label>
                <input type="text" name="username" value="'.$_SESSION["signup_data"]["username"].'">';
    
            } else {
    
                echo '<label for="username">Username</label>
                <input type="text" name="username">';
    
            }
    
            echo '<br>
            <label for="pwd">Password</label>
            <input type="password" name="pwd">
            <br>';
    
            if (isset($_SESSION["signup_data"]["email"]) && !isset($_SESSION["errors_signup"]["email_used"]) && !isset($_SESSION["errors_signup"]["invalid_email"])) {
    
                echo '<label for="email">Email</label>
                <input type="text" name="email" value="'.$_SESSION["signup_data"]["email"].'">';
    
            } else {
                echo '<label for="email">Email</label>
                <input type="text" name="email">';
            }
        
            
        echo'<br>
            <button>Sign Up</button>
        </form>
    
        <?php
        check_signup_errors();
        ?>
        </div>';
    }
}

function check_signup_errors(){
    if (isset($_SESSION["errors_signup"])) {
        $errors = $_SESSION["errors_signup"];

        echo "<br>";

        foreach ($errors as $error){
            echo '<p>' . $error . '</p>';
        }

        unset($_SESSION["errors_signup"]);
    } else if(isset($_GET["signup"]) && $_GET["signup"] === "success"){
        echo '<br>';
        echo '<p>Signup success!</p>';
    }
}