<?php
/*
PRENOTAZIONE
    Professore                  (MAX 32 caratteri)
    Titolo                      (MAX 32 caratteri)
    Data inizio (gg/mm/yyyy)    (MAX 10 caratteri)
    Data fine (gg/mm/yyy)       (MAX 10 caratteri)
    Ora inizio                  (MAX 5 caratteri)
    Ora fine                    (MAX 5 caratteri)
    Descrizione (opz.)          (MAX 512 caratteri)
    Classi (opz.)
*/

if ($_SERVER["METHOD_REQUEST"] == "POST")
{
    $professore = $_POST["professore"];
    $titolo = $_POST["titolo"];
    $data_inizio = $_POST["data-inizio"];
    $data_fine = $_POST["data-fine"];
    $ora_inizio = $_POST["ora-inizio"];
    $ora_fine = $_POST["ora-fine"];
    $descrizione = $_POST["descrizione"];
    $classi = $_POST["classi"];

    if (input_is_valid($professore, $titolo, $data_inizio, $data_fine, $ora_inizio, $ora_fine))
    {
        // TODO: Aggiungere al database
        echo("Prenotazione");
    }
}
