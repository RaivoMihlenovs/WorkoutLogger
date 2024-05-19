<?php
require_once 'includes/signup/signup_view.inc.php';
require_once 'includes/config_session.inc.php';
require_once 'includes/login/login_view.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Logger</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
        login_form();
        signup_form();
    ?>
    <img src="design.png">
    <!-- <script src="script.js"></script> -->
</body>
</html>