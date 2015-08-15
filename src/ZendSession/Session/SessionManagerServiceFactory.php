<?php
namespace ZendSession\Session;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\SessionManager;
use Zend\Session\Container;

/**
 * Use to register tableGateway service that can be use to CRUD table using pre define method from tableGateway object
 * Class UserBasicInfoTableGatewayServiceFactory
 * @package ZendSession\Session
 */
class SessionManagerServiceFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $sm
     * @return SessionManager
     */
    public function createService(ServiceLocatorInterface $sm)
    {
        $config = $sm->get('config');
        if (isset($config['session'])) {
            $session = $config['session'];

            $sessionConfig = null;
            if (isset($session['config'])) {
                $class = isset($session['config']['class'])  ? $session['config']['class'] : 'Zend\Session\Config\SessionConfig';
                $options = isset($session['config']['options']) ? $session['config']['options'] : array();
                $sessionConfig = new $class();
                $sessionConfig->setOptions($options);
            }

            $sessionStorage = null;
            if (isset($session['storage'])) {
                $class = $session['storage'];
                $sessionStorage = new $class();
            }

            $sessionSaveHandler = null;
            if (isset($session['save_handler'])) {
                $sessionSaveHandler = $sm->get($session['save_handler']);
            }

            $sessionManager = new SessionManager($sessionConfig, $sessionStorage, $sessionSaveHandler);
        } else {
            $sessionManager = new SessionManager();
        }
        Container::setDefaultManager($sessionManager);
        return $sessionManager;
    }
}