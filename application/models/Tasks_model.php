<?php


class Tasks_model extends CI_Model
{
    public function getTasks($id=null)
    {
        if ($id===null) {
            return $this->db->get('tasks')->result_array();
        } else {
            return $this->db->get_where('tasks',['id'=>$id])->result_array();
        }
        
        
        
        
    }
    
    public function deleteTasks($id)
    {
        $this->db->delete('tasks',['id'=>$id]);
        return $this->db->affected_rows();
    }

    public function createTasks($data)
    {
        $this->db->insert('tasks',$data);
        return $this->db->affected_rows();
    }

    public function updateTasks($data, $id)
    {
        $this->db->update('tasks', $data, ['id'=>$id]);
        return $this->db->affected_rows();
    }


}


?>