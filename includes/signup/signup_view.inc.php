<?php

declare(strict_types=1);

function signup_form(){
    if (!isset($_SESSION["user_id"])) {
        echo '
        <main>
        <section class="section-1">
        <div class="content">
        <p class="signup-p">Stay motivated with progress tracking.</p>
        <p class="signup-p"> 
        Log your workouts effortlessly.</p>
        <button id="openModalBtn">Sign Up</button>
        <p>Start now risk free! 30 Day money-back guarantee</p>
            <div id="modal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Sign Up</h2>
                    <form id="signUpForm" class="signup_form" action="includes/signup/signup.inc.php" method="post">';

                    if (isset($_SESSION["signup_data"]["username"]) && !isset($_SESSION["errors_signup"]["username_taken"])) {
    
                        echo '
                        <input class="user_input" type="text" id="username" name="username" placeholder="Username" value="'.$_SESSION["signup_data"]["username"].'" required>';
    
                    } else {
    
                        echo '
                        <input class="user_input" type="text" id="username" name="username" placeholder="Username" required>';
    
                    }
    
                    echo '
                        <br>
                        <input class="user_input" type="password" id="pwd" name="pwd" placeholder="Password" required>
                        <br>';
    
                    if (isset($_SESSION["signup_data"]["email"]) && !isset($_SESSION["errors_signup"]["email_used"]) && !isset($_SESSION["errors_signup"]["invalid_email"])) {
    
                        echo '
                        <input class="user_input" type="text" id="email" name="email" placeholder="Email" value="'.$_SESSION["signup_data"]["email"].'" required>';
    
                    } else {
                        echo '
                        <input class="user_input" type="text" id="email" name="email" placeholder="Email" required>';
                    }
            
                    echo'<br>
                    <button class="modal_signup_btn" type="submit">Sign Up</button>
                    </form>
                </div>
            </div>
        <?php
        check_signup_errors();
        ?>
        </div>
        </section>
        </main>';
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