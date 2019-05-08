<?php
/**
 * Model Interface file.
 * @author Mukarram Ishaq
 */
namespace Core\Models;

/**
 * Interface ModelInterface
 * @package Core\Models
 */
Interface ModelInterface
{
    /**
     * @return mixed
     */
    public function save();

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id);

    /**
     * @param array $where
     * @return mixed
     */
    public function find(array $where);

    /**
     * @return mixed
     */
    public function all();

    /**
     * @return mixed
     */
    public function delete();

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

}