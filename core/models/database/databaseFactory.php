<?php
namespace Core\Models\Database;

use Core\Exceptions\ClassNotFoundException;

/**
 * DatabaseFactory Class.
 * @package \Core\Models\Database;
 */
class DatabaseFactory
{
    protected $config = null;
    
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     * @throws \Core\Exceptions\ClassNotFoundException|\PDOException
     */
    public function getDatabaseInstance()
    {
        $driverName = $this->getCurrentDatabaseDriverClassName();
        if ($driverName === null) {
            throw new ClassNotFoundException("Database driver class not found!");
        }
        $gateName = $this->getCurrentGateClassName();
        if ($gateName === null) {
            throw new ClassNotFoundException("Database Gate class not found!");
        }
        try {
            $driverInstance = call_user_func_array("$driverName::getConnection", [$this->config['db_dsn'],
                $this->config['db_user'], $this->config['db_password']]);
            return new $gateName($driverInstance->pdo);
        } catch (\Exception $e) {
            return null;
        }

    }

    /**
     * @return null|string
     */
    public function getCurrentGateClassName()
    {
        //if $config['db_driver_class_name'] is not set
        if (!isset($this->config['db_driver'])) {
            return null;
        }
        return '\\Core\\Models\\Database\\'.ucfirst($this->config['db_driver'].'Gate');
    }

    /**
     * @return null|string
     */
    public function getCurrentDatabaseDriverClassName()
    {
        //if $config['db_driver_class_name'] is not set
        if (!isset($this->config['db_driver_class_name'])) {
            return null;
        }
        return '\\Core\\Models\\Database\\Drivers\\'.ucfirst($this->config['db_driver_class_name']);
    }
}
