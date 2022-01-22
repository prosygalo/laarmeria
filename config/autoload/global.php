<?php
/*return [
  'db' => array(
      'driver'         => 'Pdo',
      'dsn'            => 'mysql:dbname=cdf_la_armeria_db;host:localhost',
      'driver_opcions' => array (PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES \'utf8\''),
      'username'=> 'RoselyG',
      'password'=>'RoselyGmysql'),

  'db2' => array(
      'driver'         => 'Pdo',
      'dsn'            => 'mysql:dbname=articulos_db;host:localhost',
      'driver_opcions' => array (PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES \'utf8\''),
      'username'=> 'RoselyG',
      'password'=>'RoselyGmysql'),

	   'Ldap'[
	          'host'=>'dc-server.ad.alex-tech-adventure.com',
	          'userStarTls'=>true,
			  'accountDomineName'=>'ad.alex-tech-adventure.com',
			  'accountDomineNameShort'=>'alex-tech',
			  'baseDn'=>'CN-User,DC=ad,DC=alex-tech-adventure, DC=com',
			  'accountCanonicalForm'=>\Zend\Ldap\Ldap:;ACCTNAME\FORM_BACKSLASK,
			  'accountFilterFormat'=>'($(ObjetClass=User)(sAMAccount=%s))',
			  
			  ]
	
];*/
 return array(
    'db' => array(
        //this is for primary adapter....
       /* 'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=cdf_la_armeria_db;host:localhost',
        'driver_opcions' => array (PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES \'utf8\''),
        'username'=> '',
        'password'=>'',*/
        'driver'   => 'pdo_sqlsrv',
            'host'     =>  'NEW',
            'database' =>  'cdf_laarmeria_db',
            'username' => 'laarmeria',
            'password' => 'sql4081',  
            //'prefix'   => '',
            'charset'  => 'UTF-8',
            'pooling'  => false,
            

        //other adapter when it needed...
        'adapters' => array(  
            'db2' => array(
             /* 'driver'         => 'Pdo',
               'dsn'            => 'mysql:dbname=articulos_db;host:localhost',
               'driver_opcions' =>  array (PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES \'utf8\''),
               'username'=> '',
                'password'=>'',*/
            'driver'   => 'pdo_sqlsrv',
            'host'     =>  'NEW',
            'database' =>  'articulos_db',
            'username' => 'laarmeria',
            'password' => 'sql4081',  
            //'prefix'   => '',
            'charset'  => 'UTF-8',
            'pooling'  => false,
            ),
        ),
    ),
    'service_manager' => array(
       
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
                    => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),

        'abstract_factories' => array(
            'Zend\Db\Adapter\AdapterAbstractServiceFactory',
        ),
    ),
);



