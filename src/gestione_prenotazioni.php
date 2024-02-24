<?php

include_once "./utils.php";

/**
 * Trova il tipo di stato richiesto
 *
 * @param string $tipo di stato
 */
function trovaTipo($tipo)
{
    if($tipo === "type-nonvisionati") {
        setupPrenotazioni(0);
    } elseif ($tipo === "type-accettati") {
        setupPrenotazioni(1);
    } elseif ($tipo === "type-rifiutati") {
        setupPrenotazioni(2);
    } elseif ($tipo === "type-annullati") {
        setupPrenotazioni(3);
    } elseif ($tipo === "type-scaduti") {
        setupPrenotazioni(4);
    } else {
        echo "Tipo errato";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET)) {
    if (isset($_GET["ID"]) && $_GET["ID"] !== null) {
        trovaTipo($_REQUEST["ID"]);
    } else {
        echo "ID non valido";
    }
} else {
    echo "Tipo di richiesta errato";
}
