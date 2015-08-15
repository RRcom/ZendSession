<?php
return array(
    'session' => array(
        'config' => array(
            'class' => 'Zend\Session\Config\SessionConfig',
            'options' => array(
                'name' => 'rrcomzendsession',
                //'cookie_lifetime' => (60*60*24*365),
            ),
        ),
        'save_handler' => 'ZendSession\Session\DbSaveHandler',
        'storage' => 'Zend\Session\Storage\SessionArrayStorage',
        'validators' => array(
            'Zend\Session\Validator\RemoteAddr',
            'Zend\Session\Validator\HttpUserAgent',
        ),
    ),
);