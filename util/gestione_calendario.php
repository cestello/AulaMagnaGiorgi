<?php
// Converti i dati in formato JSON e invia come risposta al client

header('Content-Type: application/json');
echo (json_encode($dati));
?>