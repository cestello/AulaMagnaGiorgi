<?php
$nome = "";
$cognome = "";
$email = "";

/**
 * Raccoglie le informazioni dell'utente e ne genera il profilo personale
 *
 * @return array dati dell'utente
 */
function generaUtente()
{
    $nome = "";
    $cognome = "";
    $email = "";

    $conn = connectToDatabase();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT nome, cognome FROM utenti WHERE email = ?");
    $email = $_COOKIE["user"];
    $stmt->bind_param("s", $email);

    if (!$stmt->execute()) {
        $_SESSION['message'] = "Errore non previsto nella query";
    }

    $stmt->store_result();
    if ($stmt->num_rows <= 0) {
        $_SESSION["message"] = "Utente inesistente";
    } else {
        $stmt->bind_result($nome, $cognome);
        $stmt->fetch();
        $risultato = array(
            "email" => $email,
            "nome" => $nome,
            "cognome" => $cognome
        );
    }

    $stmt->close();
    $conn->close();
    return $risultato;
}

/**
 * Raccoglie gli eventi legati all'utente per disporli sul proprio profilo
 *
 * @return array record di eventi
 */
function generaEventi()
{
    $conn = connectToDatabase();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_COOKIE["user"];
    $stmt = $conn->prepare("SELECT * FROM eventi WHERE email = ? ORDER BY data DESC, ora_inizio ASC");
    $stmt->bind_param("s", $email);

    $result = array();
    if ($stmt->execute()) {
        $stmt->store_result();
        $stmt->bind_result($id, $titolo, $data, $ora_inizio, $ora_fine, $descrizione, $email_r, $stato, $professore_referente, $posti);
        while ($stmt->fetch()) {
            $row = array(
                "ID" => $id,
                "titolo" => $titolo,
                "data" => $data,
                "ora_inizio" => $ora_inizio,
                "ora_fine" => $ora_fine,
                "descrizione" => $descrizione,
                "email" => $email_r,
                "stato" => $stato,
                "professore_referente" => $professore_referente,
                "posti" => $posti
            );
            $result[] = $row;
        }
    } else {
        $_SESSION['message'] = "Errore non previsto nella query";
    }

    $stmt->close();
    $conn->close();
    return $result;
}
