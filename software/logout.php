<?php
session_start();
unset($_SESSION["current_userId"]);
session_destroy();

header("location:../index.html");
?>