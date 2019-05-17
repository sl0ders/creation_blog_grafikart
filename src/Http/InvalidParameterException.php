<?php


namespace App\Http;


use Exception;

class InvalidParameterException extends Exception
{
    public function __construct(string $name, int $type)
    {
        if ($type === Request::INT) {
            $type = 'entier';
        } else if ($type === Request::STRING) {
            $type = 'chaine de caractere';
        }
        parent::__construct("Le parametre '".$name."' n'est pas du bon type, " . $type . " attendu");
    }

}
