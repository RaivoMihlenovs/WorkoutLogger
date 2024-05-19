<?php

declare(strict_types=1);

function login_form(){
    if (isset($_SESSION["user_id"])) {
        echo '<h1>Welcome '. $_SESSION["user_username"].'</h1>
        <p>What would you like to do?</p>
        <form method="post"> 
        <input type="submit" name="viewWrkBtn"
                value="View workouts"/> 
          
        <input type="submit" name="showCreateWrkBtn"
                value="Create a new workout"/> 
        </form>
        ';

        echo '<form action="includes/logout.inc.php" method="post">
              <br>
              <button>Logout</button>
              </form>';
    } else {
        echo   '<h1>Login to get started</h1>
                <div>
                <h1>Login</h1>
                <form action="includes/login/login.inc.php" method="post">
                    <label for="username">Username</label>
                    <input type="text" name="username">
                    <br>
                    <label for="pwd">Password</label>
                    <input type="password" name="pwd">
                    <br>
                    <button>Login</button>
                </form>

                <?php
                check_login_errors();
                ?>
                </div>';
    }
}

function check_login_errors(){
    if (isset($_SESSION["error_login"])) {
        $errors = $_SESSION["error_login"];

        echo "<br>";

        foreach ($errors as $error) {
            echo '<p>' . $error .'</p>';
        }

        unset($_SESSION["error_login"]);
    }
    elseif (isset($_GET["login"]) && $_GET["login"] === "success") {
        echo "<br>";
        echo '<p>Login success!</p>';
    }
}

if(isset($_POST['viewWrkBtn'])) { 
    if (!empty($_SESSION["user_workouts"])) {
    foreach ($_SESSION["user_workouts"] as $workout) {
        echo $workout["workout_name"] . " " . $workout["sets"] . " sets of " . $workout["reps"] . " reps using " . $workout["weight"] . "kg<br>";
    }
    } else {
        echo "No workouts found";
    }
    
} 
if(isset($_POST['showCreateWrkBtn'])) { 
    echo '<div class="wrkCreateView">
    <br>
      <br>
    <form action="includes/workout/workout.inc.php" method="post">
    <label for="workout_name">Workout name</label>
    <input type="text" name="workout_name">
    <br>
    <label for="sets">Sets</label>
    <input type="number" name="sets">
    <br>
    <label for="reps">Reps</label>
    <input type="number" name="reps">
    <br>
    <label for="weight">Weight</label>
    <input type="number" name="weight">
    <br>
    <button>Create</button>
    </form>
    </div>'; 
} 