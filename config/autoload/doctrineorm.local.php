
<?php


return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' =>'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'user'     => "ezekiel",
//                     'user'     => "root",
                    "password"=>"Oluwaseun1@",
//                     'password' => "Jolaoso1234@#$",
//                     'dbname'   => "baucars_invest",
                    'dbname'   => "baucars",
                    'encoding' => 'utf8',
                )))));
