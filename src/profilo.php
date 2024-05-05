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
    $email = $_COOKIE['email'];
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

    $stmt = $conn->prepare("SELECT * FROM eventi NATURAL JOIN strumentazioni ORDER BY data ASC, ora_inizio ASC");

    if (!$stmt->execute()) {
        $stmt->close();
        $conn->close();
        return array(
            "Errore non previsto nella query"
        );
    }

    $stmt->store_result();
    if ($stmt->num_rows <= 0) {
        $stmt->close();
        $conn->close();
        return array(
            "Nessuna nuova prenotazione"
        );
    }

    $row = array(
        "id" => "0",
        "data" => "1970-01-01",
        "ora_inizio" => "08:00",
        "ora_fine" => "08:30",
        "docente_referente" => "default",
        "posti" => -1,
        "titolo" => "default",
        "descrizione" => "default",
        "email" => "default",
        "stato" => -1,
        "pc_personale" => 0,
        "attacco_hdmi" => 0,
        "microfono" => 0,
        "adattatore_apple" => 0,
        "live" => 0,
        "rete" => 0,
        "proiettore" => 0,
        "mixer" => 0,
        "vga" => 0,
        "cavi_audio" => 0
    );

    $stmt->bind_result(
        $row["id"],
        $row["titolo"],
        $row["data"],
        $row["ora_inizio"],
        $row["ora_fine"],
        $row["descrizione"],
        $row["email"],
        $row["stato"],
        $row["docente_referente"],
        $row["posti"],
        $row["pc_personale"],
        $row["attacco_hdmi"],
        $row["microfono"],
        $row["adattatore_apple"],
        $row["live"],
        $row["rete"],
        $row["proiettore"],
        $row["mixer"],
        $row["vga"],
        $row["cavi_audio"]
    );

    $result = array();
    while ($stmt->fetch()) {
        $stato = "";
        if ($row["stato"] === 0) {
            $stato = "non visionato";
        } elseif ($row["stato"] === 1) {
            $stato = "accettato";
        } elseif ($row["stato"] === 2) {
            $stato = "rifiutato";
        } elseif ($row["stato"] === 3) {
            $stato = "annullato";
        } elseif ($row["stato"] === 4) {
            $stato = "scaduto";
        } else {
            $stato = "errore nel determinare lo stato";
        }

        foreach ($row as &$i) {
            if ($i === 0) {
                $i = "No";
            } elseif ($i === 1) {
                $i = "Si";
            }
        }

        $stringa = "Stato: " . $stato . "<br>" . "Nome: " . $row["titolo"] . "<br>" . "Richiesto da: " . $row["email"] . "<br>" .
            "Data: " . $row["data"] . " Dalle ore: " . $row["ora_inizio"] . " alle " .
            $row["ora_fine"] . "<br>" . "Docente referente: " . $row["docente_referente"] . "<br>"
            . "Posti: " . $row["posti"] . "<br>" . "Pc personale: " . $row["pc_personale"] . "<br>"
            . "Attacco HDMI: " . $row["attacco_hdmi"] . "<br>" . "Microfono: " . $row["microfono"] . "<br>"
            . "Adattatore Apple: " . $row["adattatore_apple"] . "<br>" . "live: " . $row["live"] . "<br>"
            . "Rete: " . $row["rete"] . "<br>" . "Proiettore: " . $row["proiettore"] . "<br>"
            . "Mixer: " . $row["mixer"] . "<br>" . "Vga: " . $row["vga"] . "<br>"
            . "Cavi audio: " . $row["cavi_audio"] . "<br>";

        if (isset($descrizione) && $descrizione !== "") {
            $stringa .= "Descrizione: " . $descrizione . "<br>";
        }

        $stringa .= "<br>";
        array_push($result, $stringa);
    }

    $stmt->close();
    $conn->close();
    return $result;
}
