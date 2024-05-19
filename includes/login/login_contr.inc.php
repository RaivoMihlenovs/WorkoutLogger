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

function create_workout(object $pdo, string $workout_name, int $sets, int $reps, int $weight, int $usersId){
    set_workout($pdo, $workout_name, $sets, $reps, $weight, $usersId);
}