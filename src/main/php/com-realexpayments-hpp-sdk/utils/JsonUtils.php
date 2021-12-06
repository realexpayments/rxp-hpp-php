<?php


namespace com\realexpayments\hpp\sdk\utils;


use com\realexpayments\hpp\sdk\domain\HppRequest;
use com\realexpayments\hpp\sdk\domain\HppResponse;
use com\realexpayments\hpp\sdk\RXPLogger;
use Logger;

class JsonUtils
{

    /**
     * @var Logger logger
     */
    private static $logger;
    private static $initialised = false;

    /**
     * @var iMapper[] logger
     */
    private static $mappers;


    /**
     * Method serialises <code>HppRequest</code> or  <code>HppResponse</code>  to JSON.
     *
     * @param $hppObject
     * @return string
     */
    public static function toJson($hppObject)
    {
        self::Initialise();

        $mapper = self::$mappers[get_class($hppObject)];
        return $mapper->WriteValueAsString($hppObject);

    }

    /**
     * Method deserializes JSON to <code>HppRequest</code>.
     *
     * @param $json
     * @return HppRequest
     */
    public static function fromJsonHppRequest($json)
    {
        self::Initialise();

        $mapper = self::$mappers[HppRequest::GetClassName()];
        return $mapper->ReadValue($json);
    }

    /**
     * Method deserializes JSON to <code>HppResponse</code>.
     *
     * @param $json
     * @return HppResponse
     */
    public static function fromJsonHppResponse($json)
    {
        self::Initialise();

        $mapper = self::$mappers[HppResponse::GetClassName()];
        return $mapper->ReadValue($json);
    }

    private static function Initialise()
    {
        if (self::$initialised) {
            return;
        }

        self::$logger = RXPLogger::getLogger(__CLASS__);

        self::$mappers = array();

        self::$mappers[HppRequest::GetClassName()] = new RequestMapper();
        self::$mappers[HppResponse::GetClassName()] = new ResponseMapper();

        self::$initialised = true;
    }
}