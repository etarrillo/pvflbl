<?php 


Class library_Model{
	private $db;

	public function library_Model(){
		global $DB;
		$this->db = $DB;
	}

	public function get_librarys($id){
		
             $sql = "SELECT l.name,l.state,l.category,l.id  FROM {library} l
		        INNER JOIN {library_category} lc on lc.id=l.category where l.category=? ";
               $params = array($id);

		      return $this->db->get_records_sql($sql,$params);
            
	}






	public function get_category(){
		
			return $this->db->get_records('library_category',array());
		
	}

	public function get_all_category(){
		return $this->db->get_records('library_category',array(),'name','id,name');
	}

	public function edit_library($i,$record){

		if(empty($i)){

			$this->db->insert_record('library',$record);
		}else{
			$record['id'] = $i;
			$this->db->update_record('library',$record);
		}

	}


	public function edit_cat_library($c,$record){

		if(empty($c)){

			$this->db->insert_record('library_category',$record);
		}else{
			$record['id'] = $c;
			$this->db->update_record('library_category',$record);
		}

	}


	public function del_library($i){

		
		$this->db->delete_records('library',array('id'=>$i));

    }


	public function get_users($data){

		$sql = "SELECT ui.userid  FROM {user_info_data} ui 
		        INNER JOIN {user} u 
                ON u.id=ui.userid WHERE ui.data = ?
                ";

		$params = array($data);

		return $this->db->get_records_sql($sql,$params);
	}


	public function delete_permission($idli,$idrol){
		

        $sql = "SELECT id FROM {library_rol} 
		        WHERE libraryid = ?
		        AND rolid = ?
                ";

        $params = array($idli,$idrol);

		$permission = $this->db->get_records_sql($sql,$params);

		foreach($permission as $p){

			$this->db->delete_records('library_rol',array('id'=>$p->id));
			$this->db->delete_records('library_permission',array('libraryid'=>$p->id));

		}

	}


     public function get_rol($id){
		return $this->db->get_records('library',array('id'=>$id),'name','id,name,state');
		
	}

}
