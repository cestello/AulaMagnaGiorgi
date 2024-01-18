<?php

function prenota($value, $ID)
{
    $conn = connect_to_database();
    $sql_query = "UPDATE eventi SET stato = " . $value . " WHERE ID = " . $ID . ";";
    $query_answer = $conn->query($sql_query);
    if ($query_answer === FALSE) {
        $_SESSION['message'] = "Errore nel collegamento";
        $conn->close();
        return;
    }
    $conn->close();
}
function gestisci_prenotazione($value, $ID)
{
    if ($value === 1) {
        $tmp = getDataByID($ID);
        $tmp[1] = substr($tmp[1], 0, -3);
        $tmp[2] = substr($tmp[2], 0, -3); //ok
        if (!check_evento_esistente($tmp[0], $tmp[1], $tmp[2])) {
            $_SESSION["message"] = "Giorno gia' prenotato";
        } else {
            prenota($value, $ID);
        }
    } else {
        prenota($value, $ID);
    }
}

function gestisci_input($ID, $tipo)
{
    if ($tipo == "accetta") {
        gestisci_prenotazione(1, $ID);
    } else if ($tipo == "rifiuta") {
        gestisci_prenotazione(2, $ID);
    } else {
        $_SESSION["message"] = "I valori della richiesta GET sono settati male";
    }
}

function setup_prenotazioni($stato)
{
    $conn = connect_to_database();
    $sql_query = "SELECT * FROM eventi WHERE stato = " . $stato . ";";
    $query_answer = $conn->query($sql_query);
    if ($query_answer === FALSE) {
        $_SESSION['message'] = "Errore nel collegamento";
        $conn->close();
    } else {
        $records = array();
        while ($row = $query_answer->fetch_assoc()) {
            $records[] = $row;
        }
        if (sizeof($records) <= 0) {
            echo ("Nessuna nuova prenotazione");
        } else {
            foreach ($records as $row) {
                echo ('<div class="events-container ' . $row["ID"] . '">');
                echo ("Nome: " . $row["nome"] . "<br>" . "Richiesto da: " . $row["email"] . "<br>" .
                    "Data: " . $row["data"] . " Dalle ore: " . $row["ora_inizio"] . " alle " .
                    $row["ora_fine"] . "<br>");
                if (isset($row["descrizione"]) && $row["descrizione"] !== "") {
                    echo ("Descrizione: " . $row["descrizione"] . "<br>");
                }
                echo ("<br>");

                echo ('<input type="button" name="accetta" value="accetta" id="' .
                    $row["ID"] . '" onClick="gestisci_richiesta(this.id, this.name)">');

                echo ('<input type="button" name="rifiuta" value="rifiuta" id="' .
                    $row["ID"] . '" onClick="gestisci_richiesta(this.id, this.name)">');
                echo ("</div><br>");
            }
        }
    }
    $conn->close();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && sizeof($_GET) > 0) {
    if (isset($_GET["ID"]) && isset($_GET["name"])) {
        gestisci_input($_REQUEST["ID"], $_REQUEST["name"]);
    } else {
        $_SESSION["message"] = "Errore";
    }
}