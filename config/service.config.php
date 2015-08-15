<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'ZendSession\Database\Table\SessionTableGateway' => 'ZendSession\Database\Table\SessionTableGatewayServiceFactory',
            'ZendSession\Session\DbSaveHandler' => 'ZendSession\Session\DbSaveHandlerServiceFactory',
            'ZendSession\Session\SessionManager' => 'ZendSession\Session\SessionManagerServiceFactory',
        ),
    ),
);