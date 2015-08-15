<?php
namespace ZendSession\Database\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;

/**
 * Use to register tableGateway service that can be use to CRUD table using pre define method from tableGateway object
 * Class UserBasicInfoTableGatewayServiceFactory
 * @package ZendSession\Database\Table
 */
class SessionTableGatewayServiceFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $sm
     * @return TableGateway
     */
    public function createService(ServiceLocatorInterface $sm)
    {
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        return new TableGateway('session', $dbAdapter);
    }
}