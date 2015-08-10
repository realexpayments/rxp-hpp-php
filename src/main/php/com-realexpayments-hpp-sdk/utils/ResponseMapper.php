<?php

namespace com\realexpayments\hpp\sdk\utils;


use com\realexpayments\hpp\sdk\domain\HppResponse;

class ResponseMapper implements iMapper
{

    /**
     *
     * Receives a domain object and generates a Json string
     *
     * @param HppResponse $response
     * @return string
     */
    public function  WriteValueAsString($response)
    {
        return json_encode($response);
    }


    /**
     *
     * Receives a Json string and generates a domain object
     *
     * @param string $value
     * @return HppResponse
     */
    public function  ReadValue($value)
    {
        return json_decode($value);
    }

}