<?php
namespace ZendSession;

use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use Zend\Session\SessionManager;

/**
 * Class Module
 * @package ZendSession
 */
class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $session = $e->getApplication()
            ->getServiceManager()
            ->get('ZendSession\Session\SessionManager');
        try {
            $session->start();
        } catch(\Exception $ex) {
            $e->getApplication()->getEventManager()->attach(MvcEvent::EVENT_ROUTE, function(MvcEvent $e){
                $e->stopPropagation();
                /** @var SessionManager $session */
                $session = $e->getApplication()
                    ->getServiceManager()
                    ->get('ZendSession\Session\SessionManager');
                $session->expireSessionCookie();

                $response = $e->getResponse();
                $response->getHeaders()->addHeaderLine('Location', $e->getRequest()->getUri());
                $response->setStatusCode(302);
                $response->sendHeaders();
                return $response;
            }, -10000);
        }

        $container = new Container('initialized');
        if (!isset($container->init)) {
            $serviceManager = $e->getApplication()->getServiceManager();
            $request        = $serviceManager->get('Request');

            $session->regenerateId(true);
            $container->init          = 1;
            $container->remoteAddr    = $request->getServer()->get('REMOTE_ADDR');
            $container->httpUserAgent = $request->getServer()->get('HTTP_USER_AGENT');

            $config = $serviceManager->get('Config');
            if (!isset($config['session'])) {
                return;
            }

            $sessionConfig = $config['session'];
            if (isset($sessionConfig['validators'])) {
                $chain   = $session->getValidatorChain();

                foreach ($sessionConfig['validators'] as $validator) {
                    switch ($validator) {
                        case 'Zend\Session\Validator\HttpUserAgent':
                            $validator = new $validator($container->httpUserAgent);
                            break;
                        case 'Zend\Session\Validator\RemoteAddr':
                            $validator  = new $validator($container->remoteAddr);
                            break;
                        default:
                            $validator = new $validator();
                    }

                    $chain->attach('session.validate', array($validator, 'isValid'));
                }
            }
        }
    }

    public function getConfig()
    {
        return array_merge_recursive(
            include __DIR__.'/../../config/service.config.php',
            include __DIR__.'/../../config/session.config.php'
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }
}