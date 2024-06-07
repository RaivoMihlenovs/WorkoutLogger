<?php

declare(strict_types=1);

function login_form(){
    if (isset($_SESSION["user_id"])) {
        echo '
        <nav>
        <div class="nav_content">
        <h3>Welcome '. $_SESSION["user_username"].'</h3>
        <form method="post" class="nav_form"> 
        <input class="nav_btn" type="submit" name="create_workout" value="Create Workout"/> 
        <input class="nav_btn" type="submit" name="edit_workout" value="Edit Workout"/> 
        <input class="nav_btn" type="submit" name="delete_workout" value="Delete Workout"/> 
        </form>
        <form class="nav_form" action="includes/logout.inc.php" method="post">
            <button class="logout_btn">Logout</button>
        </form>
        </div>
        </nav>
        <section class="section-1">
        <ul class="workout_list">';

        foreach ($_SESSION["user_workouts"] as $workout) {
            echo '
            <li class="workout_list_container">
            <ol class="exercise_list">
            <li> <h3>'.$workout["name"].'</h3></li>';

            // Query for exercises associated with this workout
            require_once 'includes/dbh.inc.php'; // Include your database connection file
            $workout_id = $workout["id"];
            $query = "SELECT * FROM exercise WHERE workoutId = :workout_id;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':workout_id', $workout_id);
            $stmt->execute();
            $exercises = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($exercises) > 0) {
                // Display each exercise
                foreach ($exercises as $exercise) {
                    echo '<li>'.$exercise["name"].' - Weight: '.$exercise["weight"].'kg Sets: '.$exercise["sets"].' Reps: '.$exercise["reps"].'</li>';
                }
            } else {
                // Display exercise form if no exercises are found
                echo '
                <form class="create_exercise_form" action="includes/login/exercise.inc.php" method="post">
                <input type="text" class="user_input" name="exercise_name" placeholder="Exercise Name">
                <input type="number" class="user_input" name="weight" placeholder="Weight">
                <input type="number" class="user_input" name="sets" placeholder="Sets">
                <input type="number" class="user_input" name="reps" placeholder="Reps">
                <input type="hidden" value="'.$workout_id.'" name="workout_id">
                <button class="modal_signup_btn">Add Exercise</button>
                </form>';
            }

            echo '</ol>
            </li>';
        }

        if(isset($_POST['create_workout'])) { 
            echo '
            <li>
            <ol class="exercise_list">
            <form class="create_workout_form" action="includes/login/workout.inc.php" method="post">
            <input type="text" class="user_input" name="workout_name" placeholder="Workout Name">
            <button class="modal_signup_btn">Create</button>
            </form>
            </ol>
            </li>'; 
        }

        echo '
        </ul>
        </section>';
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

$create_workout = isset($_POST['create_workout']);
$edit_workout = isset($_POST['edit_workout']);
$delete_workout = isset($_POST['delete_workout']);
