<?php

/**
 * Numero di iterazioni dell'operazione di hasing
 * della stessa stringa
 */
const HASH_ROUNDS = 12;

/**
 * Crea l'hash della password ottenuta in base al numero
 * di rounds (iterazioni)
 *
 * @param string password dell'utente
 * @return string hashed_password password hashata
 */
function creaHash($password)
{
    $hashed_password = $password;
    for ($i = 0; $i < HASH_ROUNDS; $i++) {
        $hashed_password = hash('sha256', $hashed_password);
    }
    return $hashed_password;
}

/**
 * Crea il cookie da assegnare all'utente
 *
 * @param string email dell'utente
 * @param string hashed_password hash della password dell'utente
 * @return string cookie in base64
 */
function creaCookie($email, $hashed_password)
{
    $data = array(
        "email" => $email,
        "hashed_password" => $hashed_password
    );
    return hash('sha256', json_encode($data));
}

/**
 * Controlla se l'utente è loggato o meno basandosi sui cookie
 * di sessione
 *
 * @return bool se l'utente è loggato
 */
function controllaSeLoggato()
{
    $loggato = false;
    if (isset($_COOKIE['email']) && isset($_COOKIE['session'])) {
        $email = $_COOKIE['email'];
        $cookie = $_COOKIE['session'];

        $conn = connectToDatabase();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT password FROM utenti WHERE email = ?");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            if ($stmt->store_result() && $stmt->num_rows > 0) {
                $stmt->bind_result($hash_pwd_db);
                $stmt->fetch();
                if ($cookie === creaCookie($email, $hash_pwd_db)) {
                    $loggato = true;
                } else {
                    $_SESSION['message'] = "Cookie errato";
                    $stmt->close();
                    $conn->close();
                    logout();
                }
            } else {
                $_SESSION['message'] = "Cookie errato";
                $stmt->close();
                $conn->close();
                logout();
            }
        }
        
        // echo $_SESSION['message'];
        $stmt->close();
        $conn->close();
    } elseif (isset($_COOKIE['email']) || isset($_COOKIE['session'])) {
        setcookie('>:(', 'flag{cosa_stai_facendo_con_i_cookie?}', time() + 10, '/');
        logout();
    }
    return $loggato;
}

/**
 * Controlla se l'utente abbia i permessi di admin in base
 * ai cookie che possiede
 *
 * @return bool se l'utente è un admin
 */
function controllaSeAdmin()
{
    $email = $_COOKIE['email'];
    $cookie = $_COOKIE['session'];

    $conn = connectToDatabase();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT password, admin FROM utenti WHERE email = ?");
    $stmt->bind_param("s", $email);
    $admin = false;
    if ($stmt->execute()) {
        if ($stmt->store_result() && $stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password, $admin);
            $stmt->fetch();
        } else {
            $_SESSION['message'] = "1 Nuh uh, 0 cookie vulnerability";
            $conn->close();
            $stmt->close();
            logout();
        }
    }
    $conn->close();
    $stmt->close();

    if ($cookie === creaCookie($email, $hashed_password)) {
        return $admin;
    }
    return false;
}
