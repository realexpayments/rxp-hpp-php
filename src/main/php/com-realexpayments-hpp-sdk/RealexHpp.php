<?php

namespace com\realexpayments\hpp\sdk;

use com\realexpayments\hpp\sdk\domain\HppRequest;
use com\realexpayments\hpp\sdk\domain\HppResponse;
use com\realexpayments\hpp\sdk\utils\JsonUtils;
use com\realexpayments\hpp\sdk\utils\ValidationUtils;
use Exception;
use Logger;


/**
 * <p>
 * RealexHpp class for converting HPP requests and responses to and from JSON.
 * This class is also responsible for validating inputs, generating defaults and encoding parameter values.
 * </p>
 * <p>
 * Creating Request JSON for Realex JS SDK
 * <code><pre>
 * $hppRequest = (new HppRequest())->addMerchantId("merchantId")->addAmount(100)...addAutoSettleFlag(true);
 * $realexHpp = new RealexHpp("mySecret");
 * $json = $realexHpp->requestToJson($hppRequest);
 * </pre></code>
 * </p>
 * <p>
 * Consuming Response JSON from Realex JS SDK
 * <code><pre>
 * $realexHpp = new RealexHpp("mySecret");
 * $hppResponse = $realexHpp->responseFromJson($responseJson);
 * </pre></code>
 * </p>
 * @author vicpada
 *
 */
class RealexHpp
{

    /**
     * @var Logger logger
     */
    private $logger;

    /**
     * Character set to use for encoding/decoding.
     */
    const ENCODING_CHARSET = "UTF-8";


    /**
     * @var string  The shared secret issued by Realex. Used to create the SHA-1 hash in the request and
     * to verify the validity of the XML response.
     */
    private $secret;

    /**
     * RealexHpp constructor
     *
     * @param string $secret
     */
    public function __construct($secret)
    {
        $this->logger = RXPLogger::getLogger(__CLASS__);
        $this->secret = $secret;
    }

    /**
     * <p>
     * Method produces JSON from <code>HppRequest</code> object.
     * Carries out the following actions:
     * <ul>
     * <li>Validates inputs</li>
     * <li>Generates defaults for security hash, order ID and time stamp (if required)</li>
     * <li>Base64 encodes inputs</li>
     * <li>Serialises request object to JSON</li>
     * </ul>
     * </p>
     *
     * @param HppRequest $hppRequest
     * @param bool $encoded <code>true</code> if the JSON values will be encoded.
     * @return HppRequest
     */
    public function requestToJson(HppRequest $hppRequest, $encoded = true)
    {

        $this->logger->info("Converting HppRequest to JSON.");

        $json = null;

        //generate defaults
        $this->logger->debug("Generating defaults.");
        $hppRequest->generateDefaults($this->secret);

        //validate request
        $this->logger->debug("Validating request.");
        ValidationUtils::validate($hppRequest);

        // build request
        $this->logger->debug("Encoding object.");
        try {
            if ($encoded === true) {
                $hppRequest = $hppRequest->encode(self::ENCODING_CHARSET);              
            }
            else {
                $hppRequest = $hppRequest->formatRequest(self::ENCODING_CHARSET);
            }
        } catch (Exception $e) {
            $this->logger->error("Exception encoding HPP request.", $e);
            throw new RealexException("Exception encoding HPP request.", $e);
        }

        //convert to JSON
        $this->logger->debug("Converting to JSON.");
        $json = JsonUtils::toJson($hppRequest);

        return $json;
    }

    /**
     * <p>
     * Method produces <code>HppRequest</code> object from JSON.
     * Carries out the following actions:
     * <ul>
     * <li>Deserialises JSON to request object</li>
     * <li>Decodes Base64 inputs</li>
     * <li>Validates inputs</li>
     * </ul>
     * </p>
     *
     * @param string $json
     * @param bool $encoded <code>true</code> if the JSON values have been encoded.
     * @return HppRequest
     */
    public function  requestFromJson($json, $encoded = true)
    {
        $this->logger->info("Converting JSON to HppRequest.");

        //convert to HppRequest from JSON
        $hppRequest = JsonUtils::fromJsonHppRequest($json);

        //decode if necessary
        if ($encoded) {
            $this->logger->debug("Decoding object.");
            try {
                $hppRequest = $hppRequest->decode(self::ENCODING_CHARSET);
            } catch (Exception $e) {
                $this->logger->error("Exception encoding HPP request.", $e);
                throw new RealexException("Exception decoding HPP request.", $e);
            }
        }

        //validate HPP request
        $this->logger->debug("Validating request.");
        ValidationUtils::validate($hppRequest);

        return $hppRequest;
    }

    /**
     * <p>
     * Method produces JSON from <code>HppResponse</code> object.
     * Carries out the following actions:
     * <ul>
     * <li>Validates inputs</li>
     * <li>Generates defaults for security hash, order ID and time stamp (if required)</li>
     * <li>Base64 encodes inputs</li>
     * <li>Serialises response object to JSON</li>
     * </ul>
     * </p>
     *
     * @param HppResponse $hppResponse
     * @return string
     */
    public function responseToJson(HppResponse $hppResponse)
    {

        $this->logger->info("Converting HppResponse to JSON.");

        $json = null;

        //generate hash
        $this->logger->debug("Generating hash.");
        $hppResponse->hash($this->secret);

        //encode
        $this->logger->debug("Encoding object.");
        try {
            $hppResponse = $hppResponse->encode(self::ENCODING_CHARSET);
        } catch (Exception $e) {
            $this->logger->error("Exception encoding HPP response.", $e);
            throw new RealexException("Exception encoding HPP response.", $e);
        }

        //convert to JSON
        $this->logger->debug("Converting to JSON.");
        $json = JsonUtils::toJson($hppResponse);

        return $json;
    }


    /**
     * <p>
     * Method produces <code>HppResponse</code> object from JSON.
     * Carries out the following actions:
     * <ul>
     * <li>Deserialises JSON to response object</li>
     * <li>Decodes Base64 inputs</li>
     * <li>Validates hash</li>
     * </ul>
     * </p>
     *
     * @param string $json
     * @param bool $encoded
     * @return HppResponse
     */
    public function responseFromJson($json, $encoded = true)
    {
        $this->logger->info("Converting JSON to HppResponse.");

        //convert to HppResponse from JSON
        $hppResponse = JsonUtils::fromJsonHppResponse($json);

        //decode if necessary
        if ($encoded) {
            $this->logger->debug("Decoding object.");
            try {
                $hppResponse = $hppResponse->decode(self::ENCODING_CHARSET);
            } catch (Exception $e) {
                $this->logger->error("Exception decoding HPP response.", $e);
                throw new RealexException("Exception decoding HPP response.", $e);
            }
        }

        //validate HPP response hash
        $this->logger->debug("Validating response hash.");
        ValidationUtils::validateResponse($hppResponse, $this->secret);

        return $hppResponse;
    }


}