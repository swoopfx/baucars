<?php
namespace JWT\Service;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Token;

// use function bin2hex;
// use function random_bytes;
use Laminas\Http\Request;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\JWT\Validation\Constraint;

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
        
        // $now = new DateTimeImmutable();
        return $this->config->builder()
            ->issuedBy($this->baseUrl().":2007")
            ->permittedFor($this->baseUrl() . "/logistics")
            ->identifiedBy(bin2hex(random_bytes(16)))
            ->relatedTo($data)
            ->withClaim('uid', $data)
            ->getToken($this->config->signer(), $this->config->signingKey());
    }

    public function parseToken($jwt)
    {
       
        $config = $this->config;
       
        
//         $config->setValidationConstraints([
//             "iss"=>$this->baseUrl()
//         ]);
       
        if (!isset($jwt)) {
            throw new \Exception("No token provided");
            exit();
        }
       
        $token = $config->parser()->parse($jwt);
       
        
//         if ($token instanceof UnencryptedToken) {
            
        $constraint = $config->validationConstraints();

            var_dump($config->validator()->validate($token, ...$constraint));
            if ($config->validator()->validate($token, ...$constraint)) {
                return $token;
            } else {
                return null;
            }
//         } else {
//             throw new \Exception("Invalid token");
//         }
        
        return null;
    }
    
    
    public function clearToken(){
        $config = $this->config;
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

