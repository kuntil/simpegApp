<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user_operation_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
    
    public function getListOperationByUser($user_id){
    	
    	$this->db->query("SELECT obj.object_name, obj.object_operation, tbl1.operation FROM object_tbl obj
		LEFT JOIN
		(SELECT uo.object_name, uo.object_operation, uo.operation  
		FROM user_operation_tbl uo 
		JOIN users_groups ug ON
		ug.group_id = uo.id 
		AND ug.user_id = '".$user_id."'
		) tbl1 ON
		obj.object_name = tbl1.object_name AND
		obj.object_operation = tbl1.object_operation");
    	if ($query->num_rows()> 0) {
    		foreach ( $query->result() as $row ) {
    			$data [] = $row;
    		}
    		return $data;
    	}
    	return false;
    	
    }
    
    public function updateByQid($data){
    	$this->operation = $data['operation'];
    	$this->db->update('user_operation_tbl',$this,array('qid'=>$data['qid']));
    }
    
    public function create($user_id){
    	$sql = "INSERT INTO user_operation_tbl(id, object_name, object_operation, operation) SELECT '".$user_id."',object_name, object_operation, 'N' FROM object_tbl";
    	$this->db->query($sql);
    }
    
    public function delete($user_id){
    	$this->db->delete('user_operation_tbl',array('user_id'=>$user_id));
    }
    
    public function userSecurity($user_id,$table,$operation){
    	$this->db->select('1');
    	$this->db->from('user_operation_tbl uo');
    	$this->db->where('uo.id',$user_id);
    	$this->db->where('uo.object_name',$table);
    	$this->db->where('uo.object_operation',$table.'.'.$operation);
    	$query = $this->db->get();
    	if($query->num_rows()!=0){
    		return true;
    	}else{
    		return false;
    	}
    }
}
