<?php

declare(strict_types=1);

function login_form(){
    if (isset($_SESSION["user_id"])) {
        echo '<nav>
        <h3>Welcome '. $_SESSION["user_username"].'</h3>
        <div>
        <form action="includes/logout.inc.php" method="post">
              <br>
              <button>Logout</button>
              </form>
        </div>
        </nav>
        <p>What would you like to do?</p>
        <form method="post"> 
        <input type="submit" name="viewWrkBtn"
                value="View workouts"/> 
          
        <input type="submit" name="showCreateWrkBtn"
                value="Create a new workout"/> 
        </form>
        ';
    } else {
        echo   '<nav>
                <div>
                <form class="signin_form" action="includes/login/login.inc.php" method="post">
                    <h3>Login to get started</h3>
                    <div>
                        <div>    
                            <input class="user_input" type="text" name="username" placeholder="Username">
                        </div>
                        <div>
                            <input class="user_input" type="password" name="pwd" placeholder="Password">
                        </div>
                        <br>
                        <button class="login_btn">→</button>
                    </div>
                </form>

                <?php
                check_login_errors();
                ?>
                </div>
                </nav>';
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
        echo $workout["workout_name"] . " " . $workout["weight"] . "kg" . " for " . $workout["sets"] . " sets of " . $workout["reps"] . " reps<br>";
    }
    } else {
        echo "No workouts found";
    }
    
} 

if(isset($_POST['showCreateWrkBtn'])) { 
    echo '<div class="wrkCreateView">
    <br>
      <br>
    <form action="includes/login/workout.inc.php" method="post">
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