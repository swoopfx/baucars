<?php
namespace General\Service;

use Lcobucci\JWT\Claim\Basic;
use General\ApiAuth\JWTStorage;
use Lcobucci\JWT\Token;

/**
 *
 * @author mac
 *        
 */
class JwtAuthenticate
{

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    public function create($userId){
        $claim1 = new Basic(JWTStorage::SESSION_CLAIM_NAME, $userId);
        return [
            // no token present in underlying storage
            [null, null, true, 'newValue'],
            //invalid token present in underlying storage; write new value
            ['token', new Token(), true, 'newValue'],
            //token with same value as written
            ['token', new Token([], ['session-data' => $claim1]), false, 'user1'],
            //token with different value to written
            ['token', new Token([], ['session-data' => $claim1]), true, 'newValue'],
        ];
    }
}

