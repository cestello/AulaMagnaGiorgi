<?php

session_start();
session_destroy();

if (isset($_COOKIE["user"]) && isset($_COOKIE["pass"])) {
    setcookie("user", '', -1, '/');
    setcookie("pass", '', -1, '/');
}

include ("./utils.php");
header("Location: " . MAINURL);
die();