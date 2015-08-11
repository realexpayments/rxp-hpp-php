<?php


namespace com\realexpayments\hpp\sdk;

use Exception;
use RuntimeException;


/**
 * An exception class for general Realex SDK errors. All other SDK exceptions will extend this class.
 *
 * @author vicpada
 *
 */
class RealexException extends RuntimeException
{

    const serialVersionUID = -2270549234447218179;


    /**
     * RealexException constructor.
     *
     * @param string $message
     * @param Exception $e
     */
    public function __construct($message, Exception $e = null)
    {
        parent::__construct($message, 0, $e);

    }


}