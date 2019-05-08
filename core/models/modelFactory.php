<?php
/**
 * modelFactory.php file contains the implementation
 * of ModelFactory Class.
 * @author Mukarram Ishaq
 */
namespace Core\Models;

use Core\Exceptions\ClassNotFoundException;
use Core\Exceptions\InvalidModelException;
use \Exception;
use Core\Models\Database\DatabaseFactory;

class ModelFactory
{
    protected $databaseFactory = null;
    /**
     * ModelFactory constructor.
     */
    public function __construct(DatabaseFactory $dbFactory)
    {
        $this->databaseFactory = $dbFactory;
    }

    /**
     * @param $modelName
     * @return null
     * @throws ClassNotFoundException
     * @throws InvalidModelException
     */
    public function createModel($modelName)
    {

        //if Model class not found throw exception
        if (!$this->doesClassExist($modelName)) {
            throw new ClassNotFoundException("$modelName class is not found");
        }
        //make sure Model class is derived from \Core\Models\BaseModel
        //and its parent has implemented \Core\Model\ModelInterface
        if (!$this->validateModelClass($modelName)) {
            throw new InvalidModelException("$modelName is not a Model class!");
        }
        //return instance of Model class
        try {
            return new $modelName($this->databaseFactory->getDatabaseInstance());
        } catch (ClassNotFoundException $e) {
//            \Core\Log::debug($e, __FILE__, __LINE__);
            return null;
        } catch (\PDOException $e) {
//            \Core\Log::debug($e, __FILE__, __LINE__);
            return null;
        } catch (\Exception $e) {
//            \Core\Log::debug($e, __FILE__, __LINE__);
            var_dump($e);
            return null;
        }

    }

    /**
     * @access private
     * @param $class
     * @return bool
     */
    private function doesClassExist($class)
    {
        return class_exists($class);
    }

    /**
     * @access private
     * @param string $class
     * @return bool
     */
    private function validateModelClass($class)
    {
        return
            (
                array_key_exists('Core\Models\BaseModel',class_parents($class))
                &&
                array_key_exists('Core\Models\ModelInterface', class_implements($class))
            )   ? true : false;
    }


    
}
