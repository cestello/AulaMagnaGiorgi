<?php
session_start();
session_destroy();

if (isset($_COOKIE["user"]) && isset($_COOKIE["pass"])) {
    setcookie("user", '', -1, '/');
    setcookie("pass", '', -1, '/');
}

header('location: http://138.41.20.100/~rizzello2400/index.php');
die();
?>