<?php
use OpenApi\Generator;

require ("../../vendor/autoload.php");
$openapi = Generator::scan([
    '../../module/JWT/src/JWT/Controller',
    '../../module/Logistics/src/Logistics/Controller',
    '../../module/Wallet/src/Wallet/Controller',
]);
// $openapi = \OpenApi\Generator::scan();
header('Content-Type: application/json');
echo $openapi->toJson();