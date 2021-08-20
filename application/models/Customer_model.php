<?php
class Customer_model extends CI_Model {

    public function addNewCustomer(){
        if($_POST){
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $mobile = $_POST['mobile'];
            $altMobile = $_POST['altMobile'];
            $gendar = $_POST['gendar'];
            $stateCode = $_POST['stateCode'];
            $gstInNum = $_POST['gstInNum'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $state = $_POST['state'];
            $zip = $_POST['zip'];
            $userID = $_POST['userID'];
            $this->db->reconnect();

            $array = array(
                'first_name' => $fname,
                'last_name' => $lname,
                'gendar' => $gendar,
                'address' => $address,
                'city' => $city,
                'state' => $state,
                'pin' => $zip,
                'state_code' => $stateCode,
                'gst_in_number' => $gstInNum,
                'mobile' => $mobile,
                'alt_mobile' => $altMobile,
                'email' => $email,
                'added_by' => $userID
            );
            
            $this->db->set($array);
            $result = $this->db->insert('customers');
            // var_dump($this->db->last_query());// to print last executed query
            $this->db->close();
            return $result;
        } 
    }

    public function updateCustomer(){
        if($_POST['customerId'] && $_POST['customerId'] > 0){
            $customerID = $_POST['customerId'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $mobile = $_POST['mobile'];
            $altMobile = $_POST['altMobile'];
            $gendar = $_POST['gendar'];
            $stateCode = $_POST['stateCode'];
            $gstInNum = $_POST['gstInNum'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $state = $_POST['state'];
            $zip = $_POST['zip'];
            $userID = $_POST['userID'];
            $this->db->reconnect();

            $array = array(
                'first_name' => $fname,
                'last_name' => $lname,
                'gendar' => $gendar,
                'address' => $address,
                'city' => $city,
                'state' => $state,
                'pin' => $zip,
                'state_code' => $stateCode,
                'gst_in_number' => $gstInNum,
                'mobile' => $mobile,
                'alt_mobile' => $altMobile,
                'email' => $email,
                'added_by' => $userID
            );
            
            $this->db->where('customer_id', $customerID);
            $result = $this->db->update('customers', $array);
            // var_dump($this->db->last_query());// to print last executed query
            $this->db->close();
            return $result;
        } 
    }

    public function getAllCustomers(){
        if(!$_POST['userID']){
            return false;
        }
        $this->db->reconnect();
        $query = $this->db->get_where('customers', array('deleted' => 0));
        $this->db->close();
        return $query->result();
    }

    public function getCustomerOBJ(){
        if(!$_POST['userID']){
            return false;
        }
        $this->db->reconnect();
        $this->db->select('CONCAT(first_name, " ", last_name) as name',FALSE);
        $this->db->select('customer_id,gendar,address,city,state,pin,state_code,gst_in_number,mobile,alt_mobile,email');
        $query = $this->db->get_where('customers', array('deleted' => 0));
        $this->db->close();
        return $query->result();
    }

    public function getAllCustomersForDataTable(){
        if(!$_REQUEST['userID']){
            return false;
        }
        $this->db->reconnect();
        $query = $this->db->get_where('customers', array('deleted' => 0));
        $this->db->close();
        return $query->result();
    }

    public function getCustomersByID(){
        if(!$_POST['userID'] || !$_POST['customerId']){
            return false;
        }
        $customerId = $_POST['customerId'];
        $this->db->reconnect();
        $query = $this->db->get_where('customers', array('customer_id' => $customerId, 'deleted' => 0));
        $this->db->close();
        return $query->result();
    }

    public function getAPICustomersByID($customerId){
        // [{"name":"Anandji Sharma","customer_id":"9","gendar":"Male",
            // "address":"12, dinanath","city":"Mumbai","state":"Maharashtra",
            // "pin":"220009","state_code":"27","gst_in_number":"27HUS89HIIU1231",
            // "mobile":"9597979797","alt_mobile":"","email":"anand.sharma@gmail.com"}]
        $this->db->reconnect();
        $this->db->select('customer_id, CONCAT(first_name, " ", last_name) as name, gendar, address, city, state, pin, state_code, gst_in_number, mobile, alt_mobile, email,');
        $query = $this->db->get_where('customers', array('customer_id' => (int)$customerId, 'deleted' => 0));
        $this->db->close();
        return $query->result();
    }

    public function getAllCustomerForSelect2(){
        if(!$_REQUEST['userID']){
            return false;
        }
        $customerName = $_REQUEST['search'];
        $this->db->reconnect();
        $this->db->select('customer_id as id, CONCAT(`first_name`, " ", `last_name`) as text');
        $this->db->like('CONCAT(`first_name`, " ", `last_name`)', $customerName);
        $query = $this->db->get_where('customers', array('deleted' => 0));
        $this->db->close();
        return $query->result();
    }

    public function deleteCustomer(){
        if($_POST['userID'] && $_POST['customerId'] > 0){
            $customerID = $_POST['customerId'];           
            $this->db->reconnect();

            $array = array(                
                'deleted' => 1
            );
            
            $this->db->where('customer_id', $customerID);
            $result = $this->db->update('customers', $array);
            // var_dump($this->db->last_query());// to print last executed query
            $this->db->close();
            return $result;
        } 
    }
}
