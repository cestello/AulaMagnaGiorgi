<?php /** @noinspection ALL */
/*
PRENOTAZIONE
    Professore                  (MAX 32 caratteri)
    Titolo                      (MAX 32 caratteri)
    Data inizio (gg/mm/yyyy)    (MAX 10 caratteri)
    Data fine (gg/mm/yyy)       (MAX 10 caratteri)
    Ora inizio                  (MAX 5 caratteri)
    Ora fine                    (MAX 5 caratteri)

    Descrizione (opz.)          (MAX 512 caratteri)
    Classi (opz.)               (MAX 64 caratteri)
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

    if ($status_code = input_is_valid($professore, $titolo, $data_inizio, $data_fine, $ora_inizio, $ora_fine))
    {
        // TODO: Aggiungere al database
        if ($status_code == 0)
        {
            // TODO: Procedere con la prenotazione [database]
        }
        else if ($status_code == 1)
        {
            echo("Professore non definito");
        }
        else if ($status_code == 2)
        {
            echo("Titolo non definito");
        }
        else if ($status_code == 3)
        {
            echo("Data inizio non definito");
        }
        else if ($status_code == 4)
        {
            echo("Data fine non definito");
        }
        else if ($status_code == 5)
        {
            echo("Ora inizio non definito");
        }
        else if ($status_code == 6)
        {
            echo("Ora fine non definito");
        }
        echo("Prenotazione");
    }
}
