<?php
/**
 * DatabaseInterface php file.
 * @author Mukarram Ishaq
 */
namespace Core\Models\Database;

/**
 * Interface DatabaseInterface
 * @package Core\Models\Database
 */
Interface DatabaseInterface
{
    /**
     * @param $tableName
     * @param array $selectedFields
     * @param array $where
     * @param array $orderby
     * @return array
     */
    public function select($tableName, array $selectedFields, array $where=[], array $orderby=[]);

    /**
     * @param $tableName
     * @param array $where
     * @return mixed
     */
    public function delete($tableName, array $where=[]);

    /**
     * @param $tableName
     * @param array $set
     * @param array $where
     * @return mixed
     */
    public function update($tableName, array $set, array $where=[]);

    /**
     * @param $tableName
     * @param array $keyValuePairs
     * @return mixed
     */
    public function insert($tableName, array $keyValuePairs);

    /**
     * @param $schemaName
     * @param $tableName
     * @return mixed
     */
    public function getAllColumnNames($schemaName, $tableName);
}