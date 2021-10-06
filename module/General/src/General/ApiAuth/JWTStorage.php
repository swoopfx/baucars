<?php
namespace General\ApiAuth;

use Laminas\Authentication\Storage\StorageInterface;
use Lcobucci\JWT\Token;
use OutOfBoundsException;
use RuntimeException;
use General\Service\JwtService;

/**
 *
 * @author mac
 *        
 */
class JWTStorage implements StorageInterface
{

    const SESSION_CLAIM_NAME = 'session-data';

    const DEFAULT_EXPIRATION_SECS = 600;

    /**
     *
     * @var bool
     */
    private $hasReadClaimData = false;

    /**
     *
     * @var Token
     */
    private $token;

    /**
     *
     * @var StorageInterface
     */
    private $wrapped;

    /**
     *
     * @var JwtService
     */
    private $jwt;

    /**
     *
     * @var int
     */
    private $expirationSecs;

    // TODO - Insert your code here
    
    /**
     *
     * @param JwtService $jwt            
     * @param StorageInterface $wrapped            
     * @param int $expirationSecs            
     */
    public function __construct(JwtService $jwt, StorageInterface $wrapped, $expirationSecs = self::DEFAULT_EXPIRATION_SECS)
    {
        $this->jwt = $jwt;
        $this->wrapped = $wrapped;
        $this->expirationSecs = $expirationSecs;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Laminas\Authentication\Storage\StorageInterface::isEmpty()
     */
    public function isEmpty()
    {
        return $this->read() === null;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Laminas\Authentication\Storage\StorageInterface::read()
     */
    public function read()
    {
        if (! $this->hasReadClaimData) {
            $this->hasReadClaimData = true;
            if ($this->shouldRefreshToken()) {
                $this->writeToken($this->retrieveClaim());
            }
        }
        
        return $this->retrieveClaim();
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Laminas\Authentication\Storage\StorageInterface::write()
     */
    public function write($contents)
    {
        if ($contents !== $this->read()) {
            $this->writeToken($contents);
        }
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Laminas\Authentication\Storage\StorageInterface::clear()
     */
    public function clear()
    {
        $this->wrapped->clear();
    }

    /**
     *
     * @return bool
     */
    private function hasTokenValue()
    {
        return ($this->wrapped->read() !== null);
    }

    /**
     *
     * @return Token|null
     */
    private function retrieveToken()
    {
        if ($this->token === null) {
            $this->token = $this->jwt->parseToken($this->wrapped->read());
        }
        
        return $this->token;
    }

    /**
     *
     * @return mixed|null
     */
    private function retrieveClaim()
    {
        if (! $this->hasTokenValue()) {
            return null;
        }
        
        try {
            return $this->retrieveToken()->getClaim(self::SESSION_CLAIM_NAME);
        } catch (OutOfBoundsException $e) {
            return null;
        }
    }

    /**
     *
     * @return bool
     */
    private function shouldRefreshToken()
    {
        if (! $this->hasTokenValue()) {
            return false;
        }
        
        try {
            return date('U') >= ($this->retrieveToken()->getClaim('iat') + 60) && $this->retrieveClaim() !== null;
        } catch (OutOfBoundsException $e) {
            return false;
        }
    }

    /**
     *
     * @param
     *            $claim
     */
    private function writeToken($claim)
    {
        try {
            $this->token = $this->jwt->createSignedToken(self::SESSION_CLAIM_NAME, $claim, $this->expirationSecs);
            
            $this->wrapped->write($this->token->__toString());
        } catch (RuntimeException $e) {}
    }
}

