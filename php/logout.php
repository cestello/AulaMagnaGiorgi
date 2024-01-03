<?php
session_start();
session_destroy();
const MAINURL = "http://138.41.20.100/~rizzello2400/";
if (isset($_COOKIE["user"]) && isset($_COOKIE["pass"])) {
    setcookie("user", '', -1, '/');
    setcookie("pass", '', -1, '/');
}

header("Location: " . MAINURL . "index.php");
die();
?>