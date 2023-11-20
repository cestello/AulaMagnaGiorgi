<?php

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

function input_is_valid($professore, $titolo, $data_inizio, $data_fine, $ora_inizio, $ora_fine)
{
    if ($professore == NULL)
    {
        return 1;
    }

    if ($titolo == NULL)
    {
        return 2;
    }

    if ($data_inizio == NULL)
    {
        return 3;
    }

    if ($data_fine == NULL)
    {
        return 4;
    }

    if ($ora_inizio == NULL)
    {
        return 5;
    }

    if ($ora_fine == NULL)
    {
        return 6;
    }

    return 0;
}
