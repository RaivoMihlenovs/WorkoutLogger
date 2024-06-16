<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["workout_name"]) || !isset($_POST["workout_id"])) {
        die("Required form data missing.");
    }

    $workout_name = $_POST["workout_name"];
    $workout_id = $_POST["workout_id"];

    error_log("Workout Name: $workout_name");
    error_log("Workout ID: $workout_id");

    try {
        require_once '../config_session.inc.php';
        require_once '../dbh.inc.php';
        require_once 'login_model.inc.php';
        require_once 'login_contr.inc.php';

        delete_workout($pdo, $workout_name, $workout_id, $_SESSION["user_id"]);
        $_SESSION["user_workouts"] = get_workouts($pdo, $_SESSION["user_id"]);

        $stmt = null;
        $pdo = null;
        header("Location: ../../index.php");
        die();
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    die();
}
