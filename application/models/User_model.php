<?php
class User_model extends CI_Model {

    public function get_user()
    {   
        if($_POST){
            $aData = array();
            $username = $_POST['Username'];
            $password = $_POST['Password'];
            $this->db->reconnect();
            $query = $this->db->get_where('users', array('username' => $username, 'deleted' => 0));
            // var_dump($this->db->last_query());// to print last executed query
            $aResult = $query->result();
            $this->db->close();
            if(count($aResult) > 0){
                foreach ($aResult as $key => $value) {
                    $sPlainPass = $this->encryption->decrypt($value->password);
                    if( $sPlainPass === $password && $value->username === $username){
                        $aData[]=$value;
                    }
                }                
            }
            return $aData;
        }    
    }

    public function add_user_uploads($uploadData=array()){
        if(!empty($uploadData)){
            $fileName = $uploadData['file_name'];
            $addedBy = $uploadData['added_by'];
            $data = array(
                    'file_name' => $fileName,
                    'added_by' => $addedBy,
            );
            $this->db->reconnect();
            $result =  $this->db->insert('user_documents', $data);
            $this->db->close();
            return $result;
        }
    }

    public function get_allDocuments_by_userID($userID)
    {   
        if(!$userID){
            return false;
        }
        $this->db->reconnect();
        $query = $this->db->get_where('user_documents', array('added_by' => $userID, 'deleted' => 0));
        $this->db->close();
        return $query->result();
    }

    public function delete_user_uploads($file_id){
        if(!$file_id){
            return false;
        }
        $this->db->reconnect();
        $data = array(
            'deleted' => 1
        );
        $result = $this->db->update('user_documents', $data, array('id' => $file_id));
        $this->db->close();
        return $result;
    }
   
    public function addUser(){
        if($_REQUEST['userID'] > 0){
            $results = 0;
            $password = $this->encryption->encrypt($_REQUEST["password"]);
            $this->db->reconnect();
            $data = array(
                'fname' => $_REQUEST["fname"],
                'lname' => $_REQUEST["lname"],
                'email' => $_REQUEST["email"],
                'mobile' => $_REQUEST["mobile"],
                'username' => $_REQUEST["username"],
                'password' => $password,
                'user_type' => $_REQUEST["userType"],
                'added_by' => $_REQUEST["userID"]
            );
            $this->db->insert('users', $data);
            $results = $this->db->insert_id();
            $this->db->close();
            return $results;
        }
    }

    public function updateUser(){
        if($_REQUEST['userID'] > 0 && $_REQUEST['ID'] > 0){
            $results = 0;
            $password = $this->encryption->encrypt($_REQUEST["password"]);
            $this->db->reconnect();
            $data = array(
                'fname' => $_REQUEST["fname"],
                'lname' => $_REQUEST["lname"],
                'email' => $_REQUEST["email"],
                'mobile' => $_REQUEST["mobile"],
                'username' => $_REQUEST["username"],
                'password' => $password,
                'user_type' => $_REQUEST["userType"],
                'added_by' => $_REQUEST["userID"]
            );
            $this->db->update('users', $data, array('id' => (int)$_REQUEST['ID']));
            $results = $this->db->affected_rows();
            $this->db->close();
            return $results;
        }
    }

    public function get_all_users(){
        $results = array();
        $this->db->reconnect();
        if(!empty($this->input->get("q"))){
			$this->db->like('LOWER(username)', strtolower($this->input->get("q")), 'both');
			$query = $this->db->select('id,username as text')->limit(10)->get("users");
			$results = $query->result();
		}
        $this->db->close();
        return $results;
    }

    public function getUserByID(){
        $results = array();
        if($_REQUEST['userID'] > 0){
            $this->db->reconnect();		
            $this->db->select('id, fname, lname, email, mobile, user_type, username, password');	
			$query = $this->db->get_where("users", array( 'deleted' => 0, 'id'=> (int)$_REQUEST['ID']));
			$results = $query->result();
		}
        $this->db->close();
        return $results;
    }

    public function getAllUserForDataTable(){
        $results = array();
        $this->db->reconnect();
        if($_REQUEST['userID'] > 0){
            $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
            $query = $this->db->get_where("users", array('deleted' => 0));
			$results = $query->result();
        }
        // var_dump($this->db->last_query());// to print last executed query
        $this->db->close();
        return $results;
    }

    public function deleteUser(){
        if($_REQUEST['userID'] > 0){
            $this->db->reconnect();
            $data = array(
                'deleted' => 1
            );
            $this->db->update('users', $data, array('id' => (int)$_REQUEST['delUserID']));
            $iAffected = $this->db->affected_rows();
            $this->db->close();
            return $iAffected;         
        }
    }
}
?>