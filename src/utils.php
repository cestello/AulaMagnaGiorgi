<?php /** @noinspection ALL */

const MAINURL = "http://138.41.20.100/~rizzello2400/";

function connect_to_database()
{
    $servername = "mysql.giorgi.edu";
    $username = "5aiu16";
    $password = "utenti";
    $dbname = "5ai23rizzello";
    $connection = new mysqli($servername, $username, $password, $dbname);
    return $connection;
}

function is_mail_used($email, $conn)
{
    $sql_query = "SELECT email FROM utenti WHERE email = '" . $email . "';";

    $query_answer = $conn->query($sql_query);
    if ($query_answer->num_rows > 0) {
        $conn->close();
        return true;
    }

    return false;
}

function is_password_valid($password, $confirm_password)
{
    $len_pwd = strlen($password);
    if ($len_pwd < 8 || $len_pwd > 32) {
        return 1;
    }

    if (!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', $password)) {
        return 2;
    }

    if ($confirm_password != $password) {
        return 3;

    }
    return 0;
}

function is_mail_valid($email)
{
    $len_email = strlen($email);
    if ($len_email < 7 || $len_email > 128) {
        return 1;
    }

    if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
        return 2;
    }

    return 0;
}

function checkDataCorrente($data)
{
    $obj = date_diff(date_create(date("Y-m-d")), date_create($data));
    $giorni = intval($obj->format("%R%a"));
    if ($giorni < 0) {
        return false;
    }
    return true;
}

function input_is_valid($anno, $mese, $giorno, $ora_inizio, $ora_fine, $titolo)
{
    if (!isset($anno)) {
        return 1;
    }

    if (!isset($mese)) {
        return 2;
    }

    if (!isset($giorno)) {
        return 3;
    }

    if (!isset($ora_inizio)) {
        return 4;
    }

    if (!isset($ora_fine)) {
        return 5;
    }

    if (!isset($titolo)) {
        return 6;
    }

    if (!checkDataCorrente($anno . "-" . $mese . "-" . $giorno)) {
        return 7;
    }

    return 0;
}

function check_ora($ora_inizio_0, $ora_fine_0, $ora_inizio_1, $ora_fine_1)
{
    $ora_inizio_0_int = intval(str_replace(":", "", $ora_inizio_0));
    $ora_fine_0_int = intval(str_replace(":", "", $ora_fine_0));
    $ora_inizio_1_int = intval(str_replace(":", "", $ora_inizio_1));
    $ora_fine_1_int = intval(str_replace(":", "", $ora_fine_1));

    // echo("a. " . $ora_inizio_0 . " b: " . $ora_fine_0);
    // echo("c. " . $ora_inizio_1 . " d: " . $ora_fine_1);

    if ($ora_inizio_0_int >= $ora_inizio_1_int && $ora_inizio_0_int < $ora_fine_1_int) {
        return false;
    }

    if ($ora_fine_0_int > $ora_inizio_1_int && $ora_fine_0_int <= $ora_fine_1_int) {
        return false;
    }
    return true;
}

function check_evento_esistente($data, $ora_inizio, $ora_fine)
{
    $conn = connect_to_database();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $sql_query = "SELECT * FROM eventi WHERE data='" . $data . "' AND stato=1;";
        $query_answer = $conn->query($sql_query);
        if ($query_answer === FALSE) {
            $_SESSION['message'] = "Errore non previsto nella registrazione";
            $conn->close();
            return false;
        }

        if ($query_answer->num_rows <= 0) {
            $conn->close();
            return true;
        }

        while ($row = $query_answer->fetch_assoc()) {
            $row["ora_inizio"] = substr($row["ora_inizio"], 0, -3);
            $row["ora_fine"] = substr($row["ora_fine"], 0, -3);
            if (!check_ora($row["ora_inizio"], $row["ora_fine"], $ora_inizio, $ora_fine)) {
                $_SESSION['message'] = "Orario gia' prenotato";
                $conn->close();
                return false;
            }
        }
        $conn->close();
        return true;
    }
}

function getDataByID($ID)
{
    $conn = connect_to_database();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $sql_query = "SELECT * FROM eventi WHERE ID=" . $ID . ";";
        $query_answer = $conn->query($sql_query);
        if ($query_answer === FALSE || $query_answer->num_rows <= 0) {
            $_SESSION['message'] = "Errore non previsto nella query";
            $conn->close();
            return array(-1, -1, -1);
        }
        if ($query_answer->num_rows <= 0) {
            $conn->close();
            return array(0, 0, 0);
        }
        $answer = $query_answer->fetch_assoc();
        return array($answer["data"], $answer["ora_inizio"], $answer["ora_fine"]);
    }
}