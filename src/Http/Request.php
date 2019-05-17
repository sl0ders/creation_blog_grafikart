<?php


namespace App\Http;


use PHPUnit\Framework\Exception;

class Request
{
    const INT = 1;
    const STRING = 2;
    /**
     * @var array
     */
    private $get;


    public function __construct(array $get)
    {
        $this->get = $get;
    }

    /**
     * @param string $name
     * @param null $default
     * @param int $type
     * @return null
     * @throws InvalidParameterException
     */
    public function get(string $name, $default = null, $type = self::STRING)
    {
        if (!isset($this->get[$name])) {
            return $default;
        }
        if ($type === self::INT && !filter_var($this->get[$name], FILTER_VALIDATE_INT)) {
            throw new InvalidParameterException($name, $type);
        }
        if ($type === self::INT){
            return (int)$this->get[$name];
        }
        return(string)$this->get[$name];
    }
}