<?php /** @noinspection ALL */

/**
 * Controlla se una mail è già stata utilizzata
 *
 * @param $email da controllare
 * @return true
 */
function is_used($email)
{
    // TODO: Controlla se esiste già un account legato a questa mail [database]
    return true;
}

function is_valid($password)
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
