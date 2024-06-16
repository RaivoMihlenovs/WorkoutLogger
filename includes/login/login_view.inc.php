<?php

declare(strict_types=1);

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

function login_form() {
    if (isset($_SESSION["user_id"])) {
        echo '
        <nav>
        <div class="nav_content">
        <h3>Welcome ' . $_SESSION["user_username"] . '</h3>
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
            <div>';

            if (isset($_POST['edit_workout'])){
                echo '
                <form method="post" action="includes/login/edit_workout.inc.php">
                <input type="hidden" name="workout_id" value="' . $workout["id"] . '">
                <input type="text" class="user_input" name="workout_name" value="'.$workout["name"].'"/>
                <input class="add_exercise_btn" type="submit" name="edit_workout" value="Edit"/> 
                </form>';
            } else {
                echo '<li style="list-style-type: none;"><h3>' . $workout["name"] . '</h3></li>';
            }

            if (isset($_POST['delete_workout'])){
                echo '
                <form method="post" action="includes/login/delete_workout.inc.php">
                <input type="hidden" name="workout_id" value="'.$workout['id'].'">
                <input type="hidden" name="workout_name" value="'.$workout['name'].'">
                <input class="add_exercise_btn" type="submit" name="delete_workout" value="Delete"/> 
                </form>';
            }

            require_once 'includes/dbh.inc.php';
            $workout_id = $workout["id"];
            $query = "SELECT * FROM exercise WHERE workoutId = :workout_id;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':workout_id', $workout_id);
            $stmt->execute();
            $exercises = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($exercises) > 0) {
                echo '<ol class="exercise_container">';
                foreach ($exercises as $exercise) {
                    echo '<li style="list-style-type: none;" id="' . $exercise["id"] . '">' . $exercise["name"] . ' - Weight: ' . $exercise["weight"] . 'kg Sets: ' . $exercise["sets"] . ' Reps: ' . $exercise["reps"] . '</li>';
                }

                $buttonClicked = false;
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_exercise'])) {
                    $buttonClicked = true;
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_exercise'])) {
                    $buttonClicked = true;
                }

                echo '</ol>
                <form method="post" class="exercise_form">
                <input type="hidden" name="workout_id" value="' . $workout_id . '">
                <input class="add_exercise_btn ' . ($buttonClicked ? 'hidden' : '') . '" type="submit" name="add_exercise" id="add_exercise_btn" value="Add Exercise"/>
                </form>';

                if (isset($_POST["add_exercise"]) && $_POST["workout_id"] == $workout_id) {
                    echo '<form class="create_exercise_form" action="includes/login/exercise.inc.php" method="post">
                    <input type="text" class="user_input" name="exercise_name" placeholder="Exercise Name">
                    <input type="number" class="user_input" name="weight" placeholder="Weight">
                    <input type="number" class="user_input" name="sets" placeholder="Sets">
                    <input type="number" class="user_input" name="reps" placeholder="Reps">
                    <input type="hidden" value="' . $workout_id . '" name="workout_id">
                    <button class="add_exercise_btn">Add Exercise</button>
                    </form>';
                }

                echo '</div>
                <form method="post" class="select_exercise_form">
                <select class="exercise_select ' . ($buttonClicked ? 'hidden' : '') . '" name="selected_exercise_id">
                <option value="">Select an Exercise to Edit/Delete</option>';

                foreach ($exercises as $exercise) {
                    echo '<option name="' . $exercise["id"] . '" value="' . $exercise["id"] . '">' . $exercise["name"] . '</option>';
                }

                echo '
                </select>
                <input type="hidden" name="selected_workout_id" value="' .  $workout_id . '">
                <input class="add_exercise_btn ' . ($buttonClicked ? 'hidden' : '') . '" type="submit" name="edit_exercise" value="Edit Exercise"/>
                <input class="add_exercise_btn ' . ($buttonClicked ? 'hidden' : '') . '" type="submit" name="delete_exercise" value="Delete Exercise"/>
                </form>';

                if (isset($_POST["edit_exercise"]) && $_POST["selected_workout_id"] == $workout_id) {
                $selected_exercise_id = $_POST["selected_exercise_id"];

                    $query = "SELECT * FROM exercise WHERE id = :exercise_id;";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':exercise_id', $selected_exercise_id);
                    $stmt->execute();
                    $selected_exercise = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($selected_exercise) {
                        echo '
                        <form class="edit_exercise_form" action="includes/login/edit_exercise.inc.php" method="post">
                        <input type="hidden" name="exercise_id" value="' . $selected_exercise["id"] . '">
                        <input type="text" class="user_input"       name="exercise_name" value="' . $selected_exercise["name"] . '">
                        <input type="number" class="user_input" name="weight" value="' . $selected_exercise["weight"] . '">
                        <input type="number" class="user_input" name="sets" value="' . $selected_exercise["sets"] . '">
                        <input type="number" class="user_input" name="reps" value="' . $selected_exercise["reps"] . '">
                        <button class="modal_signup_btn" name="edit_exercise" value="Edit Exercise">Edit Exercise</button>
                        </form>';
                    }
                }

                if (isset($_POST["delete_exercise"]) && $_POST["selected_workout_id"] == $workout_id) {
                    $selected_exercise_id = $_POST["selected_exercise_id"];

                    if ($selected_exercise_id) {
                        $query = "DELETE FROM exercise WHERE id = :exercise_id";
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(':exercise_id', $selected_exercise_id);
                        $stmt->execute();

                        echo '<script type="text/javascript">
                        deleteExercise(' . $selected_exercise_id . ');
                        </script>';
                    }
            }
                
            } else {
                echo '
                <form class="create_exercise_form" action="includes/login/exercise.inc.php" method="post">
                    <input type="text" class="user_input" name="exercise_name" placeholder="Exercise Name">
                    <input type="number" class="user_input" name="weight" placeholder="Weight">
                    <input type="number" class="user_input" name="sets" placeholder="Sets">
                    <input type="number" class="user_input" name="reps" placeholder="Reps">
                    <input type="hidden" value="' . $workout_id . '" name="workout_id">
                    <button class="add_exercise_btn">Add Exercise</button>
                </form>';
            }
            
            echo '</ol>
            </li>';
        }

        if (isset($_POST['create_workout'])) { 
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
        echo '
        <nav>
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
                </form>';
                // check_login_errors();
            echo '</div>
        </nav>';
    }
}

$create_workout = isset($_POST['create_workout']);
$edit_workout = isset($_POST['edit_workout']);
$delete_workout = isset($_POST['delete_workout']);
