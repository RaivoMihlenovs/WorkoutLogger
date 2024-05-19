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

function set_workout(object $pdo, string $workout_name, int $sets, int $reps, int $weight , int $usersId){
    $query = "INSERT INTO workouts (workout_name, sets, reps, weight, usersId) VALUES (:workout_name, :sets, :reps, :weight, :usersId);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":workout_name", $workout_name);
    $stmt->bindParam(":sets", $sets);
    $stmt->bindParam(":reps", $reps);
    $stmt->bindParam(":weight", $weight);
    $stmt->bindParam(":usersId", $usersId);
    $stmt->execute();
}

function get_workouts(object $pdo, string $usersId){
    $query = "SELECT * FROM workouts WHERE usersId = :usersId;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":usersId", $usersId);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}