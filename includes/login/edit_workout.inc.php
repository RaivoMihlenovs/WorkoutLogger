<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_POST["workout_name"])) {
        die("Required form data missing.");
    }

    $workout_name = $_POST["workout_name"];
    $workout_id = $_POST["workout_id"];

    try {
        require_once '../config_session.inc.php';
        require_once '../dbh.inc.php';
        require_once 'login_model.inc.php';
        require_once 'login_contr.inc.php';

        $errors = [];

        if (is_workout_taken($pdo, $workout_name)) {
            $errors["workout_taken"] = "Workout already exists";
        }

        if ($errors) {
            $_SESSION["errors_workout"] = $errors;

            $workout_data = [
                "workout_name" => $workout_name,
            ];
            $_SESSION["workout_data"] = $workout_data;

            header("Location: ../../index.php");
            die();
        }

        edit_workout($pdo, $workout_name, $workout_id, $_SESSION["user_id"]);

        $_SESSION["user_workouts"] = get_workouts($pdo, $_SESSION["user_id"]);

        $pdo = null;
        $stmt = null;
        header("Location: ../../index.php");
        die();
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
    
} else {
    header("Location: ../index.php");
    die();
}