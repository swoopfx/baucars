<?php
namespace General\Service;

use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\Configuration;
use Laminas\Stdlib\DateTime;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;

/**
 *
 * @author mac
 *        
 */
class JwtService
{

    private $key;

    /**
     *
     * @var Configuration
     */
    private $config;

    /**
     *
     * @var array
     */
    private $payload;

    private $request;

    // TODO - Insert your code here
    public function createSigneToken(array $customeData)
    {
        return JWT::encode(array_merge($payload, $customeData), $this->key);
    }

    public function createSignedTokenLoc()
    {
        $builder = new \Lcobucci\JWT\Builder();
        
        $now = new DateTime();
        $token = $builder->permittedFor('http://localhost:2007')
            ->
        // ->identifiedBy('4f1g23a12aa')
        withClaim('uid', 1)
            ->withHeader('foo', 'bar')
            ->getToken($this->config->signer(), $this->config->signingKey());
        // var_dump($builder);
        return $token->__toString();
    }

    /**
     *
     * @var Signer
     */
    private $signer;

    /**
     *
     * @var Parser
     */
    private $parser;

    /**
     *
     * @var string
     */
    private $verifyKey;

    /**
     *
     * @var string
     */
    private $signKey;

    /**
     *
     * @param Signer $signer            
     * @param Parser $parser            
     * @param
     *            $verifyKey
     * @param
     *            $signKey
     */
    public function __construct(Signer $signer, Parser $parser, $verifyKey, $signKey)
    {
        $this->signer = $signer;
        $this->verifyKey = $verifyKey;
        $this->signKey = $signKey;
        $this->parser = $parser;
    }

    public function createSignedToken($claim, $value, $expirationSecs)
    {
        if (empty($this->signKey)) {
            throw new RuntimeException('Cannot sign a token, no sign key was provided');
        }
        
        $timestamp = date('U');
        // return (new Builder())->setIssuedAt($timestamp)
        // ->setExpiration($timestamp + $expirationSecs)
        // ->set($claim, $value)
        // ->sign($this->signer, $this->signKey)
        // ->getToken();
        
        return (new Builder())->setIssuedAt($timestamp)
            ->setExpiration($timestamp * $expirationSecs)
            ->set($claim, $value)
            ->sign($this->signer, $this->signKey)
            ->getToken();
    }

    public function parseToken($token)
    {
        try {
            $token = $this->parser->parse($token);
        } catch (InvalidArgumentException $invalidToken) {
            return new Token();
        }
        
        if (! $token->validate(new ValidationData())) {
            return new Token();
        }
        
        if (! $token->verify($this->signer, $this->verifyKey)) {
            return new Token();
        }
        
        return $token;
    }

    /**
     *
     * @return the $key
     */
    public function getKey()
    {
        return $this->key;
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
     * @param field_type $key            
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
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
     * @return the $payload
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     *
     * @param array $payload            
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     *
     * @return the $request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     *
     * @param field_type $request            
     */
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }
}

