<?php
/**
 * queryable trait file
 * @author Mukarram Ishaq
 */
namespace Core\Models\Traits;

trait Queryable {
    private $DELETE = false;
    private $UPDATE = false;
    private $SELECT = false;
    private $CREATE = false;

    private $createQuery = null;
    private $selectQuery = null;
    private $updateQuery = null;
    private $deleteQuery = null;

    private $whereQueryPart = null;
    private $setQueryPart = null;
    private $orderByQueryPart = null;
    private $limitQueryPart = null;

    private $noOfRowsAffected = 0;
    private $noOfRowsInserted = 0;


    /**
     * @param array $row
     * @return Queryable
     */
    public static function create(array $row)
    {
        $modelObject = new self();

        return $modelObject;
    }

    /**
     * @param mixed ...$columns
     * @return Queryable
     */
    public static function select(...$columns)
    {
        $modelObject = new self();

        return $modelObject;
    }

    /**
     * @param array $keyValuePairs
     * @return Queryable
     */
    public static function update(array $keyValuePairs)
    {
        $modelObject = new self();

        return $modelObject;
    }

    /**
     * @return Queryable
     */
    public static function delete()
    {
        $modelObject = new self();

        return $modelObject;
    }

    /**
     * @param string $columnName
     * @param string $operator
     * @param string $value
     * @return Queryable $this
     */
    public function where($columnName, $operator, $value)
    {

        return $this;
    }

    /**
     * @param string $columnName
     * @param string $value
     * @return string $this
     */
    public function set($columnName, $value)
    {

        return $this;
    }

    public function execute()
    {

    }
}