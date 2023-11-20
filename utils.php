<?php

function is_used($email)
{
    // TODO: Controlla se esiste già un account legato a questa mail [database]
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

?>