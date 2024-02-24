<?php

if (isset($_COOKIE["user"]) && isset($_COOKIE["pass"])) {
    setcookie("user", '', -1, '/');
    setcookie("pass", '', -1, '/');
}

include_once "./utils.php";
header("Location: " . MAINURL);
die();
