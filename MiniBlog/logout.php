<?php
require_once "includes/header.php";
require_once "database/connection.php";
?>
<?php

session_start();

session_destroy();

header("Location: login.php");

exit();
?>
<?php
require_once "includes/footer.php";
?>