<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Tasks extends CI_Controller
{
    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }
    
    public function __construct()
    {
        parent::__construct();
        $this->__resTraitConstruct();
        $this->load->model('Tasks_model');
    }
    
    
    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $tasks = $this->Tasks_model->getTasks();
        } else {
            $tasks = $this->Tasks_model->getTasks($id);
        }
        
        // $tasks = $this->Tasks_model->getTasks();
        
        if ($tasks) {     
            $this->response([
                'status' => true,
                'data' => $tasks
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
            if ($this->Tasks_model->deleteTasks($id)>0) {
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
            'category_id'   => $this->post('category_id'),
            'title'         => $this->post('title'),
            'description'   => $this->post('description'),
            'start_date'    => $this->post('start_date'),
            'finish_date'   => $this->post('finish_date'),
            'status'        => $this->post('status')
            
        ];
        
        if ($this->Tasks_model->createTasks($data)>0) {
            $this->response([
                    'status' => true,
                    // 'id' => $id,
                    'message' => 'new tasks has been created'
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
            'category_id'   => $this->put('category_id'),
            'title'         => $this->put('title'),
            'description'   => $this->put('description'),
            'start_date'    => $this->put('start_date'),
            'finish_date'   => $this->put('finish_date'),
            'status'        => $this->put('status')
            
        ];

        if ($this->Tasks_model->updateTasks($data, $id)>0) {
            $this->response([
                    'status' => true,
                    // 'id' => $id,
                    'message' => 'tasks has been updated'
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