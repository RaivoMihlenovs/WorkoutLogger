<?php

declare(strict_types=1);

function is_input_empty(string $username, string $pwd)
{
    if (empty($username || empty($pwd))) {
        return true;
    } else {
        return false;
    }
}

function is_username_wrong(array|bool $result)
{
    if (!$result) {
        return true;
    } else {
        return false;
    }
}

function is_password_wrong(string $pwd, string $hashedPwd)
{
    if (!password_verify($pwd, $hashedPwd)) {
        return true;
    } else {
        return false;
    }
}

function is_workout_taken(object $pdo, string $workout_name){
    if (get_workout_name($pdo, $workout_name)){
        return true;
    } else {
        return false;
    }
}

function is_exercise_valid(string $exercise_name, int $weight, int $sets, int $reps) {
    if (empty($exercise_name) || $weight <= 0 || $sets <= 0 || $reps <= 0) {
        return false;
    } else {
        return true;
    }
}

function create_workout(object $pdo, string $workout_name, int $userId){
    set_workout($pdo, $workout_name, $userId);
}

function show_workouts(object $pdo, int $userId){
    get_workouts($pdo, $userId);
}

function create_exercise(object $pdo, string $exercise_name, int $weight, int $sets, int $reps, int $workout_id){
set_exercise($pdo, $exercise_name, $weight, $sets, $reps, $workout_id);
}