<?php
/**
 *MysqlPDO file.
 *
 *This file contains only class "MysqlPDO" which handles the responsibility
 *of connecting to database.
 *@author Mukarram Ishaq
 */
namespace Core\Models\Database\Drivers;

use \PDO;

/**
 *MysqlPDO connectivity class.
 *
 *This is a Final and Singleton class which means you cannot extends it and this
 *will produce only one instance
 *
 *@final
 * @package \Core\Models\Database\Drivers
 *@access public
 */
final class MysqlPDO
{
    /**
     *@var string $dsn database connection string
     */
    private $dsn = null;

    /**
     *@var array $option attribute properties of PDO object
     */
    private $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    );
    /**
     *@var PDO $pdo holds instance of PDO with established connection
     */
    public $pdo = null;

    /**
     *@var MysqlPDO $instance holds the instance of MysqlPDO Class
     */
    private static $instance = null;

    /**
     *Contructor of MysqlPDO Class.
     *
     *@param string $dsn database connection string
     *@param string $username
     *@param string $password
     */
    final private function __construct($dsn,$username,$password)
    {
        $this->dsn = $dsn;
        try {
            //connect and return a PDO instance
            $this->pdo = new PDO($dsn, $username, $password, $this->options);
        } catch (\PDOException $e) {
//            \Core\Log::debug($e);
        }

    }

    /**
     * stop cloning.
     * @return void
     */
    final private function __clone(){}

    final public function serialize(){}
    final public function unserialize($data){}

    /**
     * stop deserialization.
     * @return void
     */
    final public function __wakeup(){}

    final public function __sleep(){}


    /**
     *getConnection function return the instance of this class
     *
     *@param string $dsn a connections string
     *@param string $username username of the user having access to the database
     *@param string $password password of the user having access to the database
     *@return MysqlPDO $instance.
     */
    public static function getConnection($dsn,$username,$password)
    {
        if (self::$instance == null) {
            self::$instance = new MysqlPDO($dsn,$username,$password);
        }
        return self::$instance;
    }


}
