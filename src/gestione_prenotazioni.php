<?php

include 'utils.php';

/**
 * 
 */
function trova_tipo($tipo)
{
    if($tipo === "type-nonvisionati") {
        setup_prenotazioni(0);
    } else if($tipo === "type-accettati") {
        setup_prenotazioni(1);
    } else if($tipo === "type-rifiutati") {
        setup_prenotazioni(2);
    } else if($tipo === "type-annullati") {
        setup_prenotazioni(3);
    } else if($tipo === "type-scaduti") {
        setup_prenotazioni(4);
    } else {
        echo("Tipo errato");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && sizeof($_GET) > 0) {
    if (isset($_GET["ID"]) && $_GET["ID"] !== null) {
        trova_tipo($_REQUEST["ID"]);
    } else {
        echo("ID non valido");
    }
} else {
    echo("Tipo di richiesta errato");
}