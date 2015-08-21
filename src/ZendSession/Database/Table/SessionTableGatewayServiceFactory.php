<?php
namespace ZendSession\Database\Table;

use Zend\Config\Config;
use Zend\Db\Adapter\Adapter;
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
        /** @var Adapter $dbAdapter */
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        /** @var Config $config */
        $config = $sm->get('Config');
        $session = isset($config['session']) ? $config['session'] : array();
        if(!empty($session['auto_create_table'])) {
            $dbPlatform = strtolower($dbAdapter->getDriver()->getDatabasePlatformName());
            $tableName = isset($session['db_save_handler_table']) ? $session['db_save_handler_table'] : 'session';
            switch($dbPlatform) {
                case 'sqlite':
                    $dbAdapter->query("CREATE TABLE IF NOT EXISTS $tableName (id VARCHAR PRIMARY KEY, name VARCHAR , modified INTEGER, lifetime INTEGER, data TEXT)", Adapter::QUERY_MODE_EXECUTE);
                    break;
                case 'mysql':
                    $dbAdapter->query("
                        CREATE TABLE IF NOT EXISTS $tableName (
                        id varchar(32) NOT NULL,
                        name varchar(32) NOT NULL,
                        modified int(11) NOT NULL,
                        lifetime int(11) NOT NULL,
                        data text NOT NULL,
                        PRIMARY KEY (id,name)
                        ) ENGINE=InnoDB DEFAULT CHARSET=latin1
                    ", Adapter::QUERY_MODE_EXECUTE);
                    break;
            }
        }
        return new TableGateway($tableName, $dbAdapter);
    }
}