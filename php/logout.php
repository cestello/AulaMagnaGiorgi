<?php
setcookie("user", "", time() - 3600);
setcookie("pass", "", time() - 3600);
setcookie("PHPSESSID", "", time() - 3600);
unset($_COOKIE["user"]);
unset($_COOKIE["pass"]);
unset($_COOKIE["PHPSESSID"]);
header("Location: " . $url . "../index.php");
die();
?>