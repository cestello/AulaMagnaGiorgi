<?php
function check()
{
    if (isset($_COOKIE['user']) && isset($_COOKIE['pass'])) {
        $email = $_COOKIE['user'];
        $password = $_COOKIE['pass'];
        $conn = connect_to_database();
        $sql_query = "SELECT password FROM utenti WHERE email = '" . $email . "';";
        $query_answer = $conn->query($sql_query);
        if ($query_answer === FALSE || $query_answer->num_rows === 0) {
            $_SESSION['message'] = "1 Nuh uh, 0 cookie vuln";
            include("./logout.php");
            $conn->close();
            return false;
        } else {
            $row = $query_answer->fetch_assoc();
            $db_password = $row["password"];
            if ($password === $db_password) {
                $_SESSION['message'] = "Sei Loggato";
                $conn->close();
                return true;
            } else {
                $_SESSION['message'] = "2 Nuh uh, 0 cookie vuln";
                include("./logout.php");
                $conn->close();
                return false;
            }
        }
    } else {
        return false;
    }
}
?>