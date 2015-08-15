<?php
namespace ZendSession\Session;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\SaveHandler;
use Zend\Session\SaveHandler\DbTableGateway;
use Zend\Session\SaveHandler\DbTableGatewayOptions;
use Zend\Db\TableGateway\TableGateway;

/**
 * Use to register tableGateway service that can be use to CRUD table using pre define method from tableGateway object
 * Class UserBasicInfoTableGatewayServiceFactory
 * @package ZendSession\Session
 */
class DbSaveHandlerServiceFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $sm
     * @return SaveHandler
     */
    public function createService(ServiceLocatorInterface $sm)
    {
        /** @var TableGateway $tableGateway */
        $tableGateway = $sm->get('ZendSession\Database\Table\SessionTableGateway');
        $saveHandler = new DbTableGateway($tableGateway, new DbTableGatewayOptions());
        return $saveHandler;
    }
}