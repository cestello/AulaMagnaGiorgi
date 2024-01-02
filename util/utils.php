<?php /** @noinspection ALL */

/**
 * Controlla se una mail è già stata utilizzata
 *
 * @param $email da controllare
 * @return true
 */

const mainurl = "http://138.41.20.100/~rizzello2400/";
function connect_to_database() 
{
    $servername = "mysql.giorgi.edu";
    $username = "5aiu16";
    $password = "utenti";
    $dbname = "5ai23rizzello";
    $connection = new mysqli($servername, $username, $password, $dbname);
    return $connection;
}

function is_used($email)
{
    $conn = connect_to_database();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql_query = "SELECT email FROM utenti WHERE email = '". $email . "';";

    $query_answer = $conn->query($sql_query);
    if($query_answer->num_rows > 0) {
        $conn->close();
        return true;
    }

    $conn->close();
    return false;
}

function is_valid($password, $confirm_password)
{
    $len_pwd = strlen($password);
    if ($len_pwd < 8 || $len_pwd > 32)
    {
        return 1;
    }

    if (!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', $password))
    {
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
    if ($len_email < 7 || $len_email > 128)
    {
        return 1;
    }

    if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email))
    {
        return 2;
    }
    
    return 0;
}

function input_is_valid($anno, $mese, $giorno, $ora_inizio, $ora_fine, $titolo, $descrizione)
{
    if ($anno == NULL)
    {
        return 1;
    }

    if ($mese == NULL)
    {
        return 2;
    }

    if ($giorno == NULL)
    {
        return 3;
    }

    if ($ora_inizio == NULL)
    {
        return 4;
    }

    if ($ora_fine == NULL)
    {
        return 5;
    }

    if ($titolo == NULL)
    {
        return 6;
    }

    if ($descrizione == NULL)
    {
        return 7;
    }

    return 0;
}
