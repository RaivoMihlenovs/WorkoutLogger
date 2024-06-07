<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit_exercise'])) {
    if (!isset($_POST['exercise_id'], $_POST['exercise_name'], $_POST['weight'], $_POST['sets'], $_POST['reps'])) {
        die("Required form data missing.");
    }

    try {
        require_once '../dbh.inc.php';

        $exercise_id = $_POST['exercise_id'];
        $exercise_name = $_POST['exercise_name'];
        $weight = $_POST['weight'];
        $sets = $_POST['sets'];
        $reps = $_POST['reps'];

        $sql = "UPDATE exercise SET name = :exercise_name, weight = :weight, sets = :sets, reps = :reps WHERE id = :exercise_id;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':exercise_name', $exercise_name);
        $stmt->bindParam(':weight', $weight);
        $stmt->bindParam(':sets', $sets);
        $stmt->bindParam(':reps', $reps);
        $stmt->bindParam(':exercise_id', $exercise_id);

        if ($stmt->execute()) {
            header("Location: ../../index.php?edit=success");
            exit();
        } else {
            header("Location: ../../index.php?edit=error");
            exit();
        }
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    die();
}
?>
