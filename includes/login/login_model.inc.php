<?php

declare(strict_types=1);

function get_user(object $pdo, string $username){
    $query = "SELECT * FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function set_workout(object $pdo, string $workout_name, int $userId){
    $query = "INSERT INTO workout (name, userId) VALUES (:workout_name, :userId);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":workout_name", $workout_name);
    $stmt->bindParam(":userId", $userId);
    $stmt->execute();
}

function edit_workout(object $pdo, string $workout_name, int $workout_id, int $user_id){
    $query = "UPDATE workout SET name = :workout_name WHERE userId = :user_id and id = :workout_id;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':workout_name', $workout_name);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':workout_id', $workout_id);
        $stmt->execute();
}

function delete_workout(object $pdo, string $workout_name, int $workout_id, int $user_id){
    $query = "DELETE FROM workout WHERE name = :workout_name AND userId = :user_id AND id = :workout_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':workout_name', $workout_name);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':workout_id', $workout_id);
    error_log("Executing SQL query: $query with name: $workout_name, userId: $user_id, workoutId: $workout_id");
    $stmt->execute();
    $affected_rows = $stmt->rowCount();
    error_log("Rows affected: $affected_rows");
}

function set_exercise(object $pdo, string $exercise_name, int $weight, int $sets, int $reps, int $workout_id) {
    $query = "INSERT INTO exercise (workoutId, name, sets, reps, weight) VALUES (:workout_id, :name, :sets, :reps, :weight);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':workout_id', $workout_id);
    $stmt->bindParam(':name', $exercise_name);
    $stmt->bindParam(':sets', $sets);
    $stmt->bindParam(':reps', $reps);
    $stmt->bindParam(':weight', $weight);
    $stmt->execute();
}

function get_workouts(object $pdo, int $userId){
    $query = "SELECT * FROM workout WHERE userId = :userId;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":userId", $userId);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_workout_id(object $pdo, string $workout_name, int $user_id){
    $query = "SELECT id FROM workout WHERE name = :workout_name AND userId = :user_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":workout_name", $workout_name);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_workout_name(object $pdo, string $workout_name){
    $query = "SELECT name FROM workout WHERE name = :workout_name;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":workout_name", $workout_name);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}
