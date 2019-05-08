<?php
/**
 * cRUD.php contains definition of CRUD Trait
 * @author Mukarram Ishaq
 */
namespace Core\Controllers\Traits;

use Core\Request;
use Core\Views\View;
/**
 * Trait CRUD
 * @package Core\Controllers\Traits
 */
trait CRUD {

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
//        \Core\Log::debug($request);
        //check method
        if ($request->getMethod() == "GET") {
            return $this->view->render("crud/create", ['object'=>$this->model]);
        }
        $inputs = $request->getInput();
        //check if user already exists with this primary field
        if ($this->model->findById($inputs[$this->model->primaryField])) {
            $message = "Object with this ".$this->model->primaryField.":".$inputs[$this->model->primaryField]." already exists";
            return $this->view->render("crud/info", ['type'=>'danger', 'info'=>$message]);
        }
        //otherwise create it
//        \Core\Log::debug($inputs);
        $this->model->create($inputs);
        $message = "New object created successfully!";
        return $this->view->render("crud/info", ['type'=>'success', 'info'=>$message]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function read(Request $request, $id)
    {
        //if $id is "all" or empty
        if ($id == "all" or empty($id)) {
            //then show all
            $objs = $this->model->all();
            //if array is empty
            if (count($objs) <= 0) {
                return $this->view->render("crud/list", ['none'=>'Nothing to show!']);
            }
            return $this->view->render("crud/list", ['all' => $objs]);

        }
        $obj= $this->model->findById($id);
        if (count($obj) <= 0) {
            return $this->view->render("crud/list", ['none'=>'Nothing to show!']);
        }
        return $this->view->render("crud/view", ['object'=>$obj]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        //find object with this id
        $object = $this->model->findById($id);
        //if no object found
        if (!$object) {
            return $this->view->render("crud/info", ["info"=>"Object with id:$id not found!", "type"=>"danger"]);
        }
        //if method is get
        if ($request->getMethod() == "GET") {
            $actionURL = $request->getActualURL();
//            \Core\Log::debug($object->allProperties, __FILE__, __LINE__);
            //return edit form
            return $this->view->render("crud/edit", ["object"=>$object, "action"=>$actionURL]);
        }

        //otherwise update it
        $inputs = $request->getInput();
        foreach ($object->allProperties as $property) {
            $object->$property = $inputs["$property"];
        }
        $message = "Object updated successfully!";
        //now save it
        if (!is_bool($object->save())) {
            $message = "A new objected with id:$object->id created!";
        }
        return $this->view->render("crud/info",["type" => "success", "info"=>$message]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function delete(Request $request, $id)
    {
        $object = $this->model->findById($id);
        //if object is not found
        if (!$object) {
            return $this->view->render("crud/info", ['info'=>'Object with id='.$id.' not found!', 'type'=>'danger']);
        }
        $object->delete();
        return $this->view->render("crud/info", ['info'=>'deleted successfully!', 'type'=>'success']);
    }
}
