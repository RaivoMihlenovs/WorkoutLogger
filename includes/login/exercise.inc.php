<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Debugging: Print the POST data
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    // Ensure we receive all required POST data
    if (!isset($_POST["exercise_name"], $_POST["weight"], $_POST["sets"], $_POST["reps"], $_POST["workout_id"])) {
        die("Required form data missing.");
    }

    $exercise_name = $_POST["exercise_name"];
    $weight = $_POST["weight"];
    $sets = $_POST["sets"];
    $reps = $_POST["reps"];
    $workout_id = $_POST["workout_id"];

    try {
        require_once '../config_session.inc.php';
        require_once '../dbh.inc.php';
        require_once 'login_model.inc.php';
        require_once 'login_contr.inc.php';

        // Convert $weight, $sets, $reps, and $workout_id to integers
        $weight = (int)$weight;
        $sets = (int)$sets;
        $reps = (int)$reps;
        $workout_id = (int)$workout_id;

        create_exercise($pdo, $exercise_name, $weight, $sets, $reps, $workout_id);

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