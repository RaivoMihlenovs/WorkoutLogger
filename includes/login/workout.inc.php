<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_POST["workout_name"])) {
        die("Required form data missing.");
    }

    $workout_name = $_POST["workout_name"];

    try {
        require_once '../config_session.inc.php';
        require_once '../dbh.inc.php';
        require_once 'login_model.inc.php';
        require_once 'login_contr.inc.php';

        create_workout($pdo, $workout_name, $_SESSION["user_id"]);
        $_SESSION["user_workouts"] = show_workouts($pdo, $_SESSION["user_id"]);

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