<?php


namespace com\realexpayments\hpp\sdk\utils;


use com\realexpayments\hpp\sdk\domain\HppRequest;
use com\realexpayments\hpp\sdk\domain\HppResponse;
use com\realexpayments\hpp\sdk\RealexValidationException;
use com\realexpayments\hpp\sdk\RPXLogger;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Logger;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;


/**
 * Class validates HPP request and response objects.
 *
 * @author vicpada
 */
class ValidationUtils
{

    /**
     * @var Logger logger
     */
    private static $logger;
    private static $initialised = false;

    /**
     * @var ValidatorInterface validator
     */
    private static $validator;


    /**
     * Method validates HPP request object using JSR-303 bean validation.
     *
     * @param HppRequest|HppResponse $hppRequest
     */
    public static function validate(HppRequest $hppRequest)
    {
        self::Initialise();

        $violations = self::$validator->validate($hppRequest);

        if ($violations->count() > 0) {
            $validationMessages = array();

            foreach ($violations as $violation) {

                /* @var ConstraintViolationInterface $violation */
                $validationMessages[] = $violation->getMessage();
            }

            $message = "HppRequest failed validation with the following errors:";
            foreach ($validationMessages as $validationMessage) {
                $message .= $validationMessage . '.';
            }

            self::$logger->info($message);
            throw new RealexValidationException("HppRequest failed validation", $validationMessages);
        }

    }


    private static function Initialise()
    {
        if (self::$initialised) {
            return;
        }

        $vendor_dir = __DIR__ . "/../../../../../vendor";
        $loader = require $vendor_dir . '/autoload.php';

        AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

        self::$logger = RPXLogger::getLogger(__CLASS__);

        self::$validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();


        self::$initialised = true;
    }

    /**
     * Method validates HPP response hash.
     *
     * @param HppResponse $hppResponse
     * @param string $secret
     */
    public static function validateResponse(HppResponse $hppResponse, $secret)
    {
        self::Initialise();

        if (!$hppResponse->isHashValid($secret)) {
            self::$logger->error("HppResponse contains an invalid security hash.");
            throw new RealexValidationException("HppResponse contains an invalid security hash");
        }
    }
}