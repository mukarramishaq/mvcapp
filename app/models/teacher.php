<?php
/**
 * Teacher Model Class File.
 * @author Mukarram Ishaq
 */
namespace App\Models;

use Core\Models\BaseModel;
use Core\Models\Database\DatabaseInterface;
/**
 * Class Teacher
 * @package App\Models
 */
class Teacher extends BaseModel
{

    /**
     * Teacher constructor.
     * @param DatabaseInterface $database
     */
    public function __construct(DatabaseInterface $database)
    {
        parent::__construct($database);
        $this->table = "teachers";
        $this->loadClassPublicProperties();
    }

    /**
     * Teacher destructor.
     */
    public function __destruct()
    {
        parent::__destruct(); // TODO: Change the autogenerated stub
    }
}