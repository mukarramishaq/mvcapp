<?php
/**
 * BaseModel Class file.
 * @author Mukarram Ishaq
 */
namespace Core\Models;

use Core\Models\ModelInterface;
use Core\Models\Database\DatabaseInterface;
class BaseModel implements ModelInterface
{
    protected $table = null;
    public $primaryField = "id";
    private $database = null;

    public $allProperties = null;

    /**
     * BaseModel constructor.
     * @param DatabaseInterface $database
     */
    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;
        $this->table = strtolower(__CLASS__).'s';
        $this->loadClassPublicProperties();
    }

    /**
     * BaseModel destructor.
     */
    public function __destruct()
    {
        unset($this->database);
        unset($this->table);
        //destroy each property
        foreach ($this->allProperties as $property) {
            unset($this->$property);
        }
        unset($this->allProperties);
        unset($this->primaryField);
    }

    /**
     * @return void
     */
    protected function loadClassPublicProperties()
    {
        $columnNames = $this->database->getAllColumnNames($GLOBALS['config']['db_dbname'], $this->table);
        //looop through each column name
        $this->allProperties = array();
        foreach ($columnNames as $key => $value) {
            //make it class properties
            $this->$value = null;
            //add it to allProperties array too.
            $this->allProperties[] = $value;
        }
    }

    /**
     * @return bool|mixed
     */
    public function save()
    {
        $set = [];
        $where = [];
        //create set and where array
        $size = count($this->allProperties);
        foreach ($this->allProperties as $field) {
            $set[$field] = $this->$field;
        }
        //primary field
        $primaryField = $this->primaryField;
        $where[] = [$this->primaryField, "=", $this->$primaryField];
//        \Core\Log::debug($where, __FILE__, __LINE__);
        //if row already exists
        if (count($this->database->select($this->table, $this->allProperties, $where)) > 0) {
            $result = $this->database->update($this->table, $set, $where);
            return ($result !== false) ? true: false;
        }
        //otherwise insert new row
        return $this->database->insert($this->table, $set);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {   $objs = [];
        $arrayOfRows = $this->database->select($this->table, $this->allProperties, [["id","=",$id]]);
        foreach ($arrayOfRows as $row) {
            $objs[] = $this->create($row, false);
        }
        //only return the first one
        return $objs[0];
    }

    /**
     * @param array $where
     * @return array|mixed
     */
    public function find(array $where)
    {
        $objs = [];
        $arrayOfRows = $this->database->select($this->table, $this->allProperties, $where);
        foreach ($arrayOfRows as $row) {
            $objs[] = $this->create($row, false);
        }
        //return the objects array
        return $objs;

    }

    /**
     * @return array|mixed
     */
    public function all()
    {
        $objs = [];
        $arrayOfRows = $this->database->select($this->table, $this->allProperties, []);
        //create objects
        foreach ($arrayOfRows as $row) {
            $objs[] = $this->create($row, false);
        }
        return $objs;
    }

    /**
     * @return bool|mixed
     */
    public function delete()
    {
        $where = [];
        //create where data
        $size = count($this->allProperties);
        foreach ($this->allProperties as $property) {
            $where[] = [$property, "=", $this->$property];
            //check if its not the last
            if ((--$size) > 0 ) {
                //add logical operator
                $where[] = " AND ";
            }
        }
        $result = $this->database->delete($this->table, $where);
        //if there is no error
        if ($result !== false) {
            $this->__destruct();
            return true;
        }
        return false;
    }

    /**
     * @param array $data
     * @param bool $commit true mean commit to database and false not commit to database
     * @return BaseModel|mixed
     */
    public function create(array $data, $commit = true)
    {
        $obj = new self($this->database);
        $obj->table = $this->table;
        $obj->loadClassPublicProperties();
        //set values to the properties
        foreach ($data as $key=>$value) {
            $obj->$key = $value;
        }
        //when to commit to database
        if ($commit) {
            $obj->save();
        }

        return $obj;
    }

}