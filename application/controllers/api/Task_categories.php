<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Task_categories extends CI_Controller
{
    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }
    
    public function __construct()
    {
        parent::__construct();
        $this->__resTraitConstruct();
        $this->load->model('Task_categories_model');
    }
    
    
    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $task_categories = $this->Task_categories_model->getTask_categories();
        } else {
            $task_categories = $this->Task_categories_model->getTask_categories($id);
        }
        
        // $task_categories = $this->Task_categories_model->getTask_categories();
        
        if ($task_categories) {     
            $this->response([
                'status' => true,
                'data' => $task_categories
            ], 200);
        } else{
            $this->response([
                'status' => false,
                'message' => 'id not found'
            ], 404);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');

        if ($id===null) {
            $this->response([
                'status' => true,
                // 'id'=> $id,
                'message' => 'provide an id!'
            ], 400);
        } else {
            if ($this->Task_categories_model->deleteTask_categories($id)>0) {
                //ok
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'deleted.'
                ], 200);
            } else {
                //id not found
                $this->response([
                    'status' => false,
                    'message' => 'id not found'
                ], 400);
            }
            
        }
        
    }

    public function index_post()
    {
        $data = [
            'name'   => $this->post('name'),
            
        ];
        
        if ($this->Task_categories_model->createTask_categories($data)>0) {
            $this->response([
                    'status' => true,
                    // 'id' => $id,
                    'message' => 'new task categories has been created'
                ], 201);
        } else {
            //failed
            $this->response([
                'status' => false,
                'message' => 'failed to create new data'
            ], 400);
        }
        
    }


    public function index_put()
    {
        $id=$this->put('id');
        $data = [
            'name'   => $this->put('name'),
            
        ];

        if ($this->Task_categories_model->updateTask_categories($data, $id)>0) {
            $this->response([
                    'status' => true,
                    // 'id' => $id,
                    'message' => 'task categories has been updated'
                ], 200);
        } else {
            //failed
            $this->response([
                'status' => false,
                'message' => 'failed to update data'
            ], 400);
        }
    }
}

?>