<?php
namespace JWT\Service;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Token;

// use function bin2hex;
// use function random_bytes;
use Laminas\Http\Request;

/**
 *
 * @author mac
 *        
 */
final class JWTIssuer
{

    // TODO - Insert your code here
    private $config;

    /**
     *
     * @var Request
     */
    private $requestObject;

    public function __construct(Configuration $config)
    {
        $this->config = $config;
    }

    public function issueToken($data): Token
    {
       
//         $now = new DateTimeImmutable();
        return $this->config->builder()
            ->issuedBy($this->baseUrl())
            ->permittedFor($this->baseUrl() . "/logistics")
            ->identifiedBy(bin2hex(random_bytes(16)))
            ->relatedTo($data['uid'])
            ->withClaim('uid', $data["uid"])
            ->getToken($this->config->signer(), $this->config->signingKey());
    }

    private function baseUrl()
    {
        $uri = $this->requestObject->getUri();
        $scheme = $uri->getScheme();
        $host = $uri->getHost();
        $base = sprintf('%s://%s', $scheme, $host);
        return $base;
    }

    /**
     *
     * @return the $config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     *
     * @return the $requestObject
     */
    public function getRequestObject()
    {
        return $this->requestObject;
    }

    /**
     *
     * @param \Lcobucci\JWT\Configuration $config            
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     *
     * @param \Laminas\Http\Request $requestObject            
     */
    public function setRequestObject($requestObject)
    {
        $this->requestObject = $requestObject;
        return $this;
    }
}

