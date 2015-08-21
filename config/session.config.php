<?php
return array(
    'session' => array(
        'config' => array(
            'class' => 'Zend\Session\Config\SessionConfig',
            'options' => array(
                'name' => 'rrcomzendsession',
                'gc_maxlifetime' => (60*60*24*365),
                //'cookie_lifetime' => (60*60*24*365),
            ),
        ),
        'save_handler' => 'ZendSession\Session\DbSaveHandler',
        'storage' => 'Zend\Session\Storage\SessionArrayStorage',
        'db_save_handler_table' => 'zf_session',
        'auto_create_table' => 'true',
        'validators' => array(
            'Zend\Session\Validator\RemoteAddr',
            'Zend\Session\Validator\HttpUserAgent',
        ),
    ),
);