<?php
/**
 * This file contains implementation of databaseInterface.
 * @author Mukarram Ishaq
 */
namespace Core\Models\Database;

use Core\Models\Database\DatabaseInterface;

/**
 * Class MysqlDatabase
 * @package Core\Models\Database
 */
class MysqlGate implements DatabaseInterface
{
    //db connection
    private $pdo = null;

    public function __construct(\PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }

    /**
     * select function selects rows from the database.
     *
     * select function selects rows with specified columns meeting where conditions
     * and order by specified columns,
     * if $where is null/empty all rows will be returned.
     *
     * Example usage:
     * $mysqlGate->select(
     *          'studentTable',
     *          ['id','name','roll_no'],
     *          [['id','=','5'], 'AND', ['name','LIKE', '%john%'], 'OR', ['age', '<', 100]],
     *          ['id', 'name']
     *      );
     *
     * @param $tableName
     * @param array $selectedFields
     * @param array $where
     * @param array $orderby
     * @return array|mixed
     */
    public function select($tableName, array $selectedFields, array $where = [], array $orderby = [])
    {
        $data = $this->selectBuilder($tableName, $selectedFields, $where, $orderby);
        $whereData = $data['data'];
        $query = $data['query'];
        //now execute the query
        //execute the query
        try {
            $statement = $this->pdo->prepare($query);
            ($whereData != null) ? $statement->execute($whereData) : $statement->execute();
            return $statement->fetchAll();
        } catch (\PDOException $e) {
//            \Core\Log::debug($e);
            return false;
        }
    }

    /**
     * @param $tableName
     * @param array $selectedFields
     * @param array $where
     * @param array $orderby
     * @return array
     */
    public function selectBuilder($tableName, array $selectedFields, array $where = [], array $orderby = [])
    {
        //add select keyword
        $query = 'SELECT ';
        //fields which we want to retrieve
        $query .= '`'.implode("`, `", $selectedFields).'` ';
        //add table name
        $query .= 'FROM `'.$tableName.'` ';
        //add where condition
        $whereData = null;
        if (count($where) > 0) {
            $query .= 'WHERE ';
            $whereData = [];
            $size = count($where);
            foreach ($where as $item) {
                //if its a logical operator
                if ((--$size)%2 != 0) {
                    $query .= $item." ";
                    continue;
                }
                //add column name
                $query .= '`'.$item[0].'` ';
                //add operator
                $query .= $item[1].' ';
                //add question mark in place of data as its PDO
                $query .= '? ';
                //keep data of question mark in $whereData
                $whereData[] = $item[2];
            }
        }
        //add orderby in the query
        if (count($orderby) > 0) {
            $query .= 'order by `'.implode("`, `", $orderby).'`';
        }
        return ['query'=>$query, 'data'=>$whereData];
    }

    /**
     * delete function deletes rows from the table.
     *
     * delete function deletes rows from the table meeting where conditions.
     * if $where is null/empty all rows will be affected.
     *
     * Example usage:
     * $mysqlGate->delete(
     *          'studentTable',
     *          [['id','=','5'], 'AND', ['name','LIKE', '%john%'], 'OR', ['age', '<', 100]],
     *      );
     *
     * @param $tableName
     * @param array $where
     * @return mixed
     */
    public function delete($tableName, array $where = [])
    {
        $data = $this->deleteBuilder($tableName, $where);
        $query = $data['query'];
        $whereData = $data['data'];
        //now execute the query
        //execute the query
        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute($whereData);
            return $statement->rowCount();
        } catch (\PDOException $e) {
//            \Core\Log::debug($e);
            return false;
        }
    }

    /**
     * @param $tableName
     * @param array $where
     * @return array
     */
    public function deleteBuilder($tableName, array $where)
    {
        //add delete keyword
        $query = 'DELETE ';
        //add table name
        $query .= 'FROM `'.$tableName.'` ';
        //add where condition
        $whereData = null;
        if (count($where) > 0) {
            $whereData = [];
            $query .= 'WHERE ';
            $size = count($where);
            foreach ($where as $item) {
                //check if its a compare operator
                if ((--$size)%2 != 0) {
                    $query .= $item.' ';
                    continue;
                }
                //add column name
                $query .= '`'.$item[0].'` ';
                //add operator
                $query .= $item[1].' ';
                //add question mark in place of data as its PDO
                $query .= '? ';
                //keep data of question mark in $whereData
                $whereData[] = $item[2];

            }
        }
        return ['query'=>$query, 'data'=>$whereData];
    }

    /**
     * update function update the column values of the rows.
     *
     * update function update the column values of the rows meeting where condition,
     * if $where is null/empty all rows will be affected.
     *
     * Example usage:
     * $mysqlGate->update(
     *          'studentTable',
     *          ['id'=>3,'name'=>'blah','roll_no'=>'2340'],
     *          [['id','=','5'], 'AND', ['name','LIKE', '%john%'], 'OR', ['age', '<', 100]],
     *      );
     *
     * @param $tableName
     * @param array $set
     * @param array $where
     * @return mixed
     */
    public function update($tableName, array $set, array $where=[])
    {
        $data = $this->updateBuilder($tableName, $set, $where);
        $query = $data['query'];
        $values = $data['data'];
        //now execute the query
        //execute the query
        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute($values);
            return $statement->rowCount();
        } catch (\PDOException $e) {
//            \Core\Log::debug($e);
            return false;
        }
    }

    /**
     * @param $tableName
     * @param array $set
     * @param array $where
     * @return array
     */
    public function updateBuilder($tableName, array $set, array $where)
    {
        //add update keyword
        $query = 'UPDATE ';
        //add table name
        $query .= '`'.$tableName.'` ';
        //add set clause
        $query .= 'SET ';
        $setData = [];
        $size = count($set);
        foreach ($set as $columnName => $columnValue) {
            //add column name
            $query .= '`'.$columnName.'` ';
            //add equal operator
            $query .= '= ';
            //add "?" as its a prepared statement
            $query .= '? ';
            //add value into the $setData
            $setData[] = $columnValue;
            //check if its not a last item
            if ((--$size) > 0) {
                $query .= ', ';
            }
        }
        //add where condition
        $whereData = null;
        if (count($where) > 0) {
            $query .= 'WHERE ';
            $whereData = [];
            $size = count($where);
            foreach ($where as $item) {
                //check if its a compare operator
                if ((--$size)%2 != 0) {
                    $query .= $item.' ';
                    continue;
                }
                //add column name
                $query .= '`'.$item[0].'` ';
                //add operator
                $query .= $item[1].' ';
                //add question mark in place of data as its PDO
                $query .= '? ';
                //keep data of question mark in $whereData
                $whereData[] = $item[2];
            }
        }
        return ['query'=>$query, 'data'=>array_merge($setData,$whereData)];
    }

    /**
     * insert function inserts row into the table.
     *
     * insert function inserts a single row into the table in one call.
     *
     * Example usage:
     * $mysqlGate->insert(
     *          'studentTable',
     *          ['name'=>'jutt','roll_no'=>2345, 'age'=>20],
     *      );
     *
     * @param $tableName
     * @param array $keyValuePairs
     * @return bool
     */
    public function insert($tableName, array $keyValuePairs)
    {
        $data = $this->insertBuilder($tableName, $keyValuePairs);
        $query = $data['query'];
        $rowData = $data['data'];
        //now execute the query
        //execute the query
        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute($rowData);
            return $statement->rowCount();
        } catch (\PDOException $e) {
//            \Core\Log::debug($e);
            return false;
        }
    }

    /**
     * @param $tableName
     * @param array $keyValuePairs
     * @return array
     */
    public function insertBuilder($tableName, array $keyValuePairs)
    {
        //add insert keyword
        $query = "INSERT INTO `$tableName` SET ";
        $insertData = [];
        $size = count($keyValuePairs);
        foreach ($keyValuePairs as $columnName => $columnValue) {
            $query .= "`$columnName` = ? ";
            $insertData[] = $columnValue;
            //check if its not last
            if ((--$size) > 0) {
                $query .= ', ';
            }
        }
        return ['query'=>$query, 'data'=>$insertData];
    }

    /**
     * @param $schemaName
     * @param $tableName
     * @return mixed
     */
    public function getAllColumnNames($schemaName, $tableName)
    {
        $query = "SELECT `COLUMN_NAME` ".
            "FROM `INFORMATION_SCHEMA`.`COLUMNS` ".
            "WHERE `TABLE_SCHEMA` = :schema ".
            "AND `TABLE_NAME` = :table";

        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute(['schema'=>$schemaName, 'table'=>$tableName]);
            $columns = $statement->fetchAll(\PDO::FETCH_NUM);
            $allColumns = [];
            // insert all columns into one array
            for ($i = 0; $i < count($columns); $i++) {
                $allColumns =  array_merge($allColumns, $columns[$i]);
            }
            return $allColumns;
        } catch (\PDOException $e) {
//            \Core\Log::debug($e);
            return null;
        }
    }
}
