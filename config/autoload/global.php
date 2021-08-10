<?php
return [
  'db' => array(
      'driver'         => 'Pdo',
      'dsn'            => 'mysql:dbname=guias_de_remision;host:localhost',
      'driver_opcions' => array (PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES \'utf8\''),
      'username'=> 'RoselyG',
      'password'=>'RoselyGmysql'),

    /* 'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
                    => 'Zend\Db\Adapter\AdapterServiceFactory',
          ),
       ),

     'service_manager' => array(
    'factories' => array(
        'Conductor/Model/Conductor' => function($sm){
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $album = new \Conductor\Model\ConductorForm();
            $album->setDbAdapter($dbAdapter);
            return $album;
        },
    ),
),*/

	  /* 'Ldap'[
	          'host'=>'dc-server.ad.alex-tech-adventure.com',
	          'userStarTls'=>true,
			  'accountDomineName'=>'ad.alex-tech-adventure.com',
			  'accountDomineNameShort'=>'alex-tech',
			  'baseDn'=>'CN-User,DC=ad,DC=alex-tech-adventure, DC=com',
			  'accountCanonicalForm'=>\Zend\Ldap\Ldap:;ACCTNAME\FORM_BACKSLASK,
			  'accountFilterFormat'=>'($(ObjetClass=User)(sAMAccount=%s))',
			  
			  ]
	*/
];
