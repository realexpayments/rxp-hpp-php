<?php

namespace com\realexpayments\hpp\sdk\utils;
use com\realexpayments\hpp\sdk\domain\HppRequest;
use com\realexpayments\hpp\sdk\domain\HppResponse;


/**
 * Interface iMapper. Interface used to represent mappers between JSON objects
 * and domain objects
 *
 * @package com\realexpayments\hpp\sdk\utils
 * @author vicpada
 */
interface iMapper
{
    /**
     *
     * Receives a domain object and generates a Json string
     *
     * @param HppRequest|HppResponse $mappable
     * @return string
     */
    public function  WriteValueAsString($mappable);


    /**
     *
     * Receives a Json string and generates a domain object
     *
     * @param string $value
     * @return HppRequest|HppResponse
     */
    public function  ReadValue($value);

}