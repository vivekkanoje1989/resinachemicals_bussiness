<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->loadView('web_home');
	}

	public function do_login(){
		$this->load->model('User_model', 'User');
		$result = $this->User->get_user();
		$iCount = count($result);
		$data = array();
		if($iCount > 0){
			$id = $result[0]->id;
			$fname = $result[0]->fname;
			$lname = $result[0]->lname;
			$user_type = $result[0]->user_type;
			$username = $result[0]->username;
			$email = $result[0]->email;
			$mobile = $result[0]->mobile;
			$newdata = array(
				'id'  => $id,
				'fname'  => $fname,
				'lname'  => $lname,
				'user_type' => $user_type,
				'username'  => $username,
				'email'     => $email,
				'mobile'	=> $mobile,
				'logged_in' => true
			);		
			$this->session->set_userdata($newdata);
			$this->loadView('home', $data);
		}else{
			$data['error'] = "Error in logging in";
			$this->loadView('login', $data);
		}
	}

	public function do_logOut(){
		$logOutdata = array('id', 'fname' ,'lname' ,'user_type','username' ,'email','mobile','logged_in');	
		$this->session->unset_userdata($logOutdata);
		$this->session->sess_destroy();
		$data['success'] = "You Logged out successfully.";
		$this->loadView('login', $data);
	}

	public function loadView($page = 'login', $data=array()){
		$aParts = explode('_', $page);
		if($aParts[0] != 'web'){
			//for Business
			$Is_Logged_IN = $this->chekIsUsrLoggedIN();		
			if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php')) {
				// Whoops, we don't have a page for that!
				show_404();
			}
			
			//Generate User Full name 
			$LoggedInUser = $this->session->userdata;		
			if(count($LoggedInUser) > 1){
				$userFullName = $LoggedInUser['fname']." ".$LoggedInUser['lname'];
				$data['userID'] = $LoggedInUser['id'];
				$data['userFullName'] = $userFullName;
			}
		}

		$PageTitle = '';
		if($page == 'add_bills'){
			$PageTitle = 'billing';
		}else{
			$PageTitle = str_replace("_", " ", $page);
		}
		$data['title'] = ucfirst($PageTitle) ." | Resina Chemicals Industries"; // Capitalize the first letter		

		if($page == "login"){
			$this->load->view('pages/login', $data);
		}else if($aParts[0] == 'web'){
			$this->load->view('templates/web_header', $data);
			$this->load->view('pages/'.$page, $data);
			$this->load->view('templates/web_footer', $data);
		}else{
			if(!$Is_Logged_IN){
				$data['error'] = "User forcefully logged out";
				$this->load->view('pages/login', $data);
				return;
			}
			$this->load->view('templates/header', $data);
			$this->load->view('pages/'.$page, $data);
			$this->load->view('templates/footer', $data);
		}
	}

	public function chekIsUsrLoggedIN(){
		$LoggedInUser = $this->session->userdata;
		if(count($LoggedInUser)> 1){
			if($LoggedInUser['logged_in'] == true){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}	
	
	public function addUser(){
		$aData = array();
		$Is_Logged_IN = $this->chekIsUsrLoggedIN();	
		if(!$Is_Logged_IN){
			echo json_encode($aData);
			return false;
		}
		$this->load->model('User_model', 'User');
		$iInsertedID = $this->User->addUser();
		if($iInsertedID > 0 ){
			$aData['success'] = 'User added successfully.';
		}else {
			$aData['error'] = 'User can not be added.';
		}
		header('Content-Type: application/json');
		echo json_encode($aData);
	}

	public function updateUser(){
		$aData = array();
		$Is_Logged_IN = $this->chekIsUsrLoggedIN();	
		if(!$Is_Logged_IN){
			echo json_encode($aData);
			return false;
		}
		$this->load->model('User_model', 'User');
		$iRowAffected = $this->User->updateUser();
		if($iRowAffected > 0 ){
			$aData['success'] = 'User updated successfully.';
		}else {
			$aData['error'] = 'User can not be updated.';
		}
		header('Content-Type: application/json');
		echo json_encode($aData);
	}

	public function getAllUsers(){
		$aData = array();
		$Is_Logged_IN = $this->chekIsUsrLoggedIN();	
		if(!$Is_Logged_IN){
			echo json_encode($aData);
			return false;
		}
		$this->load->model('User_model', 'User');
		$aData = $this->User->get_all_users();
		echo json_encode($aData);
	}

	public function getUserByID(){
		$aData = array();
		$Is_Logged_IN = $this->chekIsUsrLoggedIN();	
		if(!$Is_Logged_IN){
			echo json_encode($aData);
			return false;
		}
		$this->load->model('User_model', 'User');
		$aData = $this->User->getUserByID();
		foreach ($aData as $key => $value) {
			$aData[$key]->password = $this->encryption->decrypt($value->password);
		}
		header('Content-Type: application/json');
		echo json_encode($aData);
	}	

	public function getAllUserForDataTable(){
		$aData = array();
		$Is_Logged_In = $this->chekIsUsrLoggedIN();
		if($Is_Logged_In == false){
			$aData['error'] = "action not allowed !";
			$this->loadView('login', $aData);
			return false;
		}	
		
		$data = array();
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$this->load->model('User_model', 'User');
		$result = $this->User->getAllUserForDataTable();
		
		if(!empty($result)){
			$iSrno = 0;
			foreach($result as $r) {
				$sName = $r->fname.' '.$r->lname;
				$sUserType = 'User';
				if($r->user_type == 1){
					$sUserType = 'Admin';
				}
				$sAction = '<div class="flex-row-btn"><button class="btn btn-sm btn-success btn-tbl classUpdateUserBtn" data-id="'.$r->id.'" >Update</button>
							<button class="btn btn-sm btn-danger btn-tbl classDeleteUserBtn" data-id="'.$r->id.'" >Delete</button></div>';
				$data[] = array(
					++$iSrno,
					$sName,
					$sUserType,
					$r->username,
					$r->email,
					$r->mobile,
					$this->encryption->decrypt($r->password),
					$sAction
				);
			}			
		}

		// $data = array_splice($data,$start,$length);

		$output = array(
			"draw" => $draw,
			"recordsTotal" => count($result),
			"recordsFiltered" => count($result),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function deleteUser(){		
		$aData = array();
		$Is_Logged_IN = $this->chekIsUsrLoggedIN();	
		if(!$Is_Logged_IN){
			echo json_encode($aData);
			return false;
		}
		$this->load->model('User_model', 'User');
		$iAffectedRow = $this->User->deleteUser();
		if($iAffectedRow > 0){
			$aData['success'] = "User deleted succesfully.";
		}else{
			$aData['error'] = "User can not be deleted.";
		}  
		header('Content-Type: application/json');
		echo json_encode($aData);
	}
	
	public function queryMail(){
		header('Content-Type: application/json');
		$this->load->library('email');
		$aData = array();
		//SMTP & mail configuration
		$config = array(
			'protocol'  => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'SMTPSecure' => 'tls',
			'SMTPAuth' => true,
			'smtp_user' => COMPANY_EMAIL_ADDRESS,
			'smtp_pass' => COMPANY_EMAIL_PASS,
			'mailtype'  => 'html',
			'charset'   => 'utf-8'
		);
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
		if(isset($_POST['email'])){    
			$queryName = $_POST['name'];                 
			$queryMail = $_POST['email'];                 
			$querySubject = $_POST['subject'];                 
			$queryMsg = $_POST['message'];                 
			$this->email->clear(TRUE);
			$this->email->to(COMPANY_EMAIL_ADDRESS);
			$this->email->from($queryMail);
			$this->email->subject($querySubject);
			$this->email->message($queryMsg." <br> From, <br> ".$queryName);
			// echo $this->email->print_debugger();
			if ($this->email->send()){
				$aData['success'] = "Query sent.";
				echo json_encode($aData);
			}else{
				$aData['error'] = "Query could not be sent.";
				echo json_encode($aData);
			}
		}else{
			$aData['error'] = "Query could not be sent.";
			echo json_encode($aData);
		}
	}

	public function addNewCustomer(){
	   	$aData = array();
		$Is_Logged_IN = $this->chekIsUsrLoggedIN();	
		if(!$Is_Logged_IN){
			echo json_encode($aData);
			return false;
		}
		$this->load->model('Customer_model', 'Customers');
		$aData = $this->Customers->addNewCustomer();
		echo json_encode($aData);
	}

	public function updateCustomer(){		
		$aData = array();
		$Is_Logged_IN = $this->chekIsUsrLoggedIN();	
		if(!$Is_Logged_IN){
			echo json_encode($aData);
			return false;
		}
		$this->load->model('Customer_model', 'Customers');
		$aData = $this->Customers->updateCustomer();
		echo json_encode($aData);
	}

	public function getAllCustomers(){
		$aData = array();
		$Is_Logged_IN = $this->chekIsUsrLoggedIN();	
		if(!$Is_Logged_IN){
			echo json_encode($aData);
			return false;
		}
		$this->load->model('Customer_model', 'Customers');
		$aData = $this->Customers->getAllCustomers();
		echo json_encode($aData);
	}

	public function getCustomerOBJ(){
		$aData = array();
		$Is_Logged_IN = $this->chekIsUsrLoggedIN();	
		if(!$Is_Logged_IN){
			echo json_encode($aData);
			return false;
		}
		$this->load->model('Customer_model', 'Customers');
		$aData = $this->Customers->getCustomerOBJ();
		echo json_encode($aData);
	}

	public function getAllCustomersForDataTable(){
		$aData = array();
		$Is_Logged_IN = $this->chekIsUsrLoggedIN();	
		if(!$Is_Logged_IN){
			echo json_encode($aData);
			return false;
		}
		$this->load->model('Customer_model', 'Customers');
		
		$data = array();
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$result = $this->Customers->getAllCustomersForDataTable();
		if(!empty($result)){
			$iSrno = 0;
			foreach($result as $r) {
				$iCustomerID = $r->customer_id;
				$sCustomerName = $r->first_name.' '. $r->last_name;				
				$sCity = $r->city;
				$sState = $r->state;
				$sMobile = $r->mobile;
				$sEmail = $r->email;						
				$sAction = '<div class="flex-row-btn"><button class="btn btn-sm btn-primay btn-tbl btnViewModal" data-customer_id="'.$iCustomerID.'">View</button>
							<button class="btn btn-sm btn-success btn-tbl btnUpdateModal" data-customer_id="'.$iCustomerID.'" >Update</button>
							<button class="btn btn-sm btn-danger btn-tbl btnDeleteRecord" data-customer_id="'.$iCustomerID.'" >Deleted</button><div>';
				$data[] = array(
					++$iSrno,
					$sCustomerName,
					$sCity,
					$sState,
					$sMobile,
					$sEmail,
					$sAction
				);
			}			
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => count($result),
			"recordsFiltered" => count($result),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function getCustomersByID(){		
		$aData = array();
		$Is_Logged_IN = $this->chekIsUsrLoggedIN();	
		if(!$Is_Logged_IN){
			echo json_encode($aData);
			return false;
		}
		$this->load->model('Customer_model', 'Customers');
		$aData = $this->Customers->getCustomersByID();
		echo json_encode($aData);
	}

	public function getAllCustomerForSelect2(){
		$aData = array();
		$Is_Logged_IN = $this->chekIsUsrLoggedIN();	
		if(!$Is_Logged_IN){
			echo json_encode($aData);
			return false;
		}
		$this->load->model('Customer_model', 'Customers');
		$aData['results'] = $this->Customers->getAllCustomerForSelect2();
		// header('Content-Type: application/json');
		echo json_encode($aData);
	}

	public function deleteCustomer(){		
		$aData = array();
		$Is_Logged_IN = $this->chekIsUsrLoggedIN();	
		if(!$Is_Logged_IN){
			echo json_encode($aData);
			return false;
		}
		$this->load->model('Customer_model', 'Customers');
		$aData = $this->Customers->deleteCustomer();
		echo json_encode($aData);
	}

	public function displayCardCount(){
		$aData = array();
		$Is_Logged_IN = $this->chekIsUsrLoggedIN();	
		if(!$Is_Logged_IN){
			echo json_encode($aData);
			return false;
		}
		$this->load->model('Customer_model', 'Customers');
		$aAllCustomers = $this->Customers->getAllCustomers();
		$iAllCustomersCount = count($aAllCustomers);
		if($iAllCustomersCount > 0){
			$aData['customers'] = $iAllCustomersCount;
		}else{
			$aData['customers'] = 0;
		}

		$this->load->model('Product_model', 'Products');
		$aAllProducts = $this->Products->getAllProducts();
		$iAllProcuctCount = count($aAllProducts);
		if($iAllProcuctCount > 0){
			$aData['products'] = $iAllProcuctCount;
		}else{
			$aData['products'] = 0;
		}

		echo json_encode($aData);	
	}

	public function getAllProductsForDataTable (){
		$aData = array();
		$Is_Logged_IN = $this->chekIsUsrLoggedIN();	
		if(!$Is_Logged_IN){
			echo json_encode($aData);
			return false;
		}
		$this->load->model('Product_model', 'Products');
		
		$data = array();
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$result = $this->Products->getAllProductsForDataTable();
		if(!empty($result)){
			$iSrno = 0;
			foreach($result as $r) {
				$iProductID = $r->product_id;
				$sProductName = $r->product_name;
				$sProductImage = $r->product_img_name;
				$sProduct = '<div class="row text-center"><div class="col-md-12"><img src="'.base_url().''.str_replace("./", "", UPLOAD_PRODUCT_IMG_PATH).''.$sProductImage.'" width="60" height="60" class="rounded" ></div><div class="col-md-12"><em>'.$sProductName.'</em></div></div>';
				$sHsnCode = $r->hsn_code;
				$isOfferAvailable = $r->is_offer_avilable;
				$sRateCol = '';
				$sOfferRate = '';
				if($isOfferAvailable > 0){
					$sOfferRate = '';
					$offerRate = (($r->offer_rate / $r->rate) * 100);
					$offerRate = round($offerRate, 2);
					$offerRate = round((100- $offerRate), 2);
					$sRateCol = $r->rate.' <small> /'.$r->quantity.' '.$r->unit.'</small><br><small style="color: #007bff;"><em>( Offer rate '.$offerRate.'% off )</em></small>';
				}else{
					$sRateCol = $r->rate.' <small> /'.$r->quantity.' '.$r->unit.'</small>';
				}
				$sEfctFromDate = isset($r->effective_from_date) ? date('d-m-Y', strtotime($r->effective_from_date)): '';
				$sEfctToDate = isset($r->effective_till_date) ? date('d-m-Y', strtotime($r->effective_till_date)) : '';
				$sViewAction = '<button class="btn btn-sm btn-primay btn-tbl btnViewModal" data-product_id="'.$iProductID.'">View</button>';
				$sUpdateAction = '<button class="btn btn-sm btn-success btn-tbl btnUpdateModal" data-product_id="'.$iProductID.'" >Update</button>';
				$sDeleteAction = '<button class="btn btn-sm btn-danger btn-tbl btnDeleteRecord" data-product_id="'.$iProductID.'" >Deleted</button>';

				if($this->session->userdata['user_type'] == 1){
					$sAction = '<div class="flex-row-btn">'.$sViewAction.''.$sUpdateAction.''.$sDeleteAction.'</div>';
				}else{
					$sAction = $sViewAction;
				}

				$data[] = array(
					++$iSrno,
					$sProduct,
					$sHsnCode,
					$sRateCol,
					$sEfctFromDate,
					$sEfctToDate,
					$sAction
				);
			}			
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => count($result),
			"recordsFiltered" => count($result),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function addNewProduct(){
		$aData = array();
		$Is_Logged_In = $this->chekIsUsrLoggedIN();
		if($Is_Logged_In == false){
			$aData['error'] = "action not allowed !";
			$this->loadView('login', $aData);
			return false;
		}
		if($_POST['userID'] < 2){
			$aData['error'] = "Unauthorised access !";
			return false;
		}

		if(isset($_POST['productName'])){					
			$this->load->model('Product_model', 'Products');
			$bIsProductExists = $this->Products->isProductExist($_POST['productName']);
			if($bIsProductExists){
				$aData['error'] = "Product name already exists"; 
				echo json_encode($aData);
				return false;
			}				
		}else{
			$aData['error'] = "Product name required";
			echo json_encode($aData);
			return false; 
		}
	
		//upload image
		if(isset($_FILES["imageProductUpload"])){
			if ($_FILES["imageProductUpload"]['name'] != NULL) {	
				$aParts = explode(".", $_FILES["imageProductUpload"]['name']);
				$sFileName = $aParts[0].".".$aParts[1]; 
				// $sFileName = $aParts[0].mt_rand().".".$aParts[1]; 
				$path = UPLOAD_PRODUCT_IMG_PATH;
				$checkFile = $path."".$sFileName;
				if(file_exists($checkFile)){
					$aData['error'] = "Product image already exists"; 
				}else{
					$config = array(
						'upload_path' => $path,
						'allowed_types' => 'png|jpg|jpeg|svg',
						'file_name' => $sFileName,
						'encrypt_name' => false,
					);	
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload("imageProductUpload")) {
						$error_msg = $this->upload->display_errors();
						$error_msg = str_replace("<p>", "", $error_msg);
						$error_msg = str_replace("</p>", "", $error_msg);
						$aData['error'] = $error_msg; 					
					} else {
						$upload_data = $this->upload->data("imageProductUpload");
						$aData['upload_filename'] = $sFileName;
						$aData['success_upload'] = true;					
					}	
				}				
			}	
		}	

		if(isset($aData['success_upload'])){
			if($aData['success_upload']){
				//proceed for adding new product
				$productImgname = $aData['upload_filename'];
				$bAddProduct = $this->Products->addNewProduct($productImgname);
				if($bAddProduct){
					$aData['success'] = "Product added successfully."; 
				}else{
					$aData['error'] = "Product can not be added."; 
				}	
			}
		}
		echo json_encode($aData);
	}

	public function updateProduct(){
		$aData = array();
		$Is_Logged_In = $this->chekIsUsrLoggedIN();
		if($Is_Logged_In == false){
			$aData['error'] = "action not allowed !";
			$this->loadView('login', $aData);
			return false;
		}
		if($_POST['userID'] < 1){
			$aData['error'] = "Unauthorised access !";
			echo json_encode($aData);
			return false;
		}
		if($_POST['productId'] < 1){
			$aData['error'] = "Product can not be updated !";
			echo json_encode($aData);
			return false;
		}	
		$this->load->model('Product_model', 'Products');
		if(isset($_POST['productName'])){		
			$bIsProductExists = $this->Products->isProductExistUpdate($_POST['productName']);
			if($bIsProductExists){
				$aData['error'] = "Product already exists"; 
				echo json_encode($aData);
				return false;
			}				
		}	

		$aData['success_upload'] = false;
		$iFile_error = $_FILES['imageProductUpload']['error'];
		$aOldProductDetail = $this->Products->getProductByID();
		$productImgname = '';
		if($iFile_error >  0){
			//no new upload
			$productImgname = $aOldProductDetail[0]->product_img_name;
			$aData['success_upload'] = true;			
		}else{
			//new file selected 
			//delete old file
			$checkOldFile = UPLOAD_PRODUCT_IMG_PATH."".$aOldProductDetail[0]->product_img_name;
			if(file_exists($checkOldFile)){
				unlink($checkOldFile);
			}
			//upload image
			if(isset($_FILES["imageProductUpload"])){
				if ($_FILES["imageProductUpload"]['name'] != NULL) {	
					$aParts = explode(".", $_FILES["imageProductUpload"]['name']);
					$sFileName = $aParts[0].".".$aParts[1]; 
					$path = UPLOAD_PRODUCT_IMG_PATH;
					$checkFile = $path."".$sFileName;
					if(file_exists($checkFile)){
						$aData['error'] = "Product image already exists"; 
					}else{
						$config = array(
							'upload_path' => $path,
							'allowed_types' => 'png|jpg|jpeg|svg',
							'file_name' => $sFileName,
							'encrypt_name' => false,
						);	
						$this->load->library('upload', $config);
						if (!$this->upload->do_upload("imageProductUpload")) {
							$error_msg = $this->upload->display_errors();
							$error_msg = str_replace("<p>", "", $error_msg);
							$error_msg = str_replace("</p>", "", $error_msg);
							$aData['error'] = $error_msg; 					
						} else {
							$upload_data = $this->upload->data("imageProductUpload");
							$productImgname = $sFileName;
							$aData['success_upload'] = true;					
						}	
					}				
				}	
			}
		}

		if($aData['success_upload']){
			$bUpdateProduct = $this->Products->updateProduct($productImgname);
			if($bUpdateProduct){
				$aData['success'] = "Product updated successfully."; 
			}else{
				$aData['error'] = "Product can not be updated."; 
			}
		}		
		echo json_encode($aData);
	}

	public function deleteProduct(){
		$aData = array();
		$Is_Logged_In = $this->chekIsUsrLoggedIN();
		if($Is_Logged_In == false){
			$aData['error'] = "action not allowed !";
			$this->loadView('login', $aData);
			return false;
		}
		if($_POST['userID'] < 1){
			$aData['error'] = "Unauthorised access !";
			echo json_encode($aData);
			return false;
		}

		if(isset($_POST['productId'])){
			if($_POST['productId'] > 0){
				$this->load->model('Product_model', 'Products');
				$aProduct = $this->Products->getProductByID();
				if(!empty($aProduct)){
					$deleteProduct = $this->Products->deleteProductByID();
					$productImgName = $aProduct[0]->product_img_name;
					$chkfile = UPLOAD_PRODUCT_IMG_PATH."".$productImgName;
					if(file_exists($chkfile)){
						unlink($chkfile);
						$aData['success'] = "Product deleted successfully.";
					}else{
						$aData['error'] = "Product image can not be deleted";
					}
				}else{
					$aData['error'] = "Product can not be deleted";
				}
			}
		}
		echo json_encode($aData);
	}

	public function getProductByID(){
		$aData = array();
		$Is_Logged_In = $this->chekIsUsrLoggedIN();
		if($Is_Logged_In == false){
			$aData['error'] = "action not allowed !";
			$this->loadView('login', $aData);
			return false;
		}
		if($_POST['userID'] < 1){
			$aData['error'] = "Unauthorised access !";
			echo json_encode($aData);
			return false;
		}

		if(isset($_POST['productId'])){
			if($_POST['productId'] > 0){
				$this->load->model('Product_model', 'Products');
				$aProduct = $this->Products->getProductByID();
				if(!empty($aProduct)){
					foreach ($aProduct as $key => $value) {
						$fromDate = date('d-m-Y', strtotime($value->effective_from_date));
						$tillDate = date('d-m-Y', strtotime($value->effective_till_date));
						$aProduct[$key]->effective_from_date = $fromDate;
						$aProduct[$key]->effective_till_date = $tillDate;
						$aData['product'] = $value;
					}				
				}else{
					$aData['error'] = "Product can not be set";
				}
			}
		}
		echo json_encode($aData);
	}

	public function getProductSelect2(){
		$aData = array();
		$Is_Logged_In = $this->chekIsUsrLoggedIN();
		if($Is_Logged_In == false){
			$aData['error'] = "action not allowed !";
			$this->loadView('login', $aData);
			return false;
		}
		$this->load->model('Product_model', 'Products');
		$aData = $this->Products->getProductSelect2();
		echo json_encode($aData);
	}

	public function getBillCount(){
		$aData = array();
		$Is_Logged_In = $this->chekIsUsrLoggedIN();
		if($Is_Logged_In == false){
			$aData['error'] = "action not allowed !";
			$this->loadView('login', $aData);
			return false;
		}
		if($_POST['userID'] < 1){
			$aData['error'] = "Unauthorised access !";
			echo json_encode($aData);
			return false;
		}
		
		$this->load->model('Bill_model', 'Bills');
		$aCount = $this->Bills->getBillCount();
		$aData['bill_count'] = $aCount[0]->bill_count;
		$aData['bill_amount'] = $aCount[0]->bill_amount;
		echo json_encode($aData);
	}

	public function addNewProductStock(){
		$aData = array();
		$Is_Logged_In = $this->chekIsUsrLoggedIN();
		if($Is_Logged_In == false){
			$aData['error'] = "action not allowed !";
			$this->loadView('login', $aData);
			return false;
		}
		if($_POST['userID'] < 1){
			$aData['error'] = "Unauthorised access !";
			echo json_encode($aData);
			return false;
		}

		$this->load->model('Product_model', 'Products');
		$aIsStockExist = $this->Products->isStockExist();
		$iIsStockExist = count($aIsStockExist);
		if($iIsStockExist > 0){
			$iStockID = $aIsStockExist[0]->stock_id;
			$stockQuantity = $aIsStockExist[0]->stock_qty;
			$iStockID = $this->Products->updateProductStockQty($iStockID, $stockQuantity);
			if($iStockID > 0){
				$aData['success'] = "Product stock managed successfully.";
			}else{
				$aData['error'] = "Product stock management failed.";
			}
		}else{
			$iStockID = $this->Products->addNewProductStock();
			if($iStockID > 0){
				$aData['success'] = "Product stock added successfully.";
			}else{
				$aData['error'] = "Product stock can not be added";
			}
		}
		
		echo json_encode($aData);
	}

	public function getProductStockForDataTable(){
		$aData = array();
		$Is_Logged_In = $this->chekIsUsrLoggedIN();
		if($Is_Logged_In == false){
			$aData['error'] = "action not allowed !";
			$this->loadView('login', $aData);
			return false;
		}	
		$this->load->model('Product_model', 'Products');
		$data = array();
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$result = $this->Products->getProductStock();
		if(!empty($result)){
			$iSrno = 0;
			foreach($result as $r) {
				$iProductID = $r->product_id;
				$iStockID = $r->stock_id;
				$iStockQty = $r->stock_qty;
				$sProductStrength = $r->quantity.' '.$r->unit;
				$sProductName = $r->product_name;
				$sProductImage = $r->product_img_name;
				$sProduct = '<div class="row text-center"><div class="col-md-12"><img src="'.base_url().''.str_replace("./", "", UPLOAD_PRODUCT_IMG_PATH).''.$sProductImage.'" width="60" class="rounded" ></div><div class="col-md-12"><em>'.$sProductName.' (<small>'.$sProductStrength.'</small>)</em></div></div>';

				// $sProduct = '<figure class="figure">
				// 	<img src="'.base_url().''.str_replace("./", "", UPLOAD_PRODUCT_IMG_PATH).''.$sProductImage.'" class="figure-img img-fluid rounded" alt="NO IMAGE">
				// 	<figcaption class="figure-caption"><em>'.$sProductName.'</em></figcaption>
			  	// </figure>';
			
				$sAction = '<div class="flex-row-btn"><button class="btn btn-sm btn-success btn-tbl btnUpdateModal" data-stock_id="'.$iStockID.'" >Update</button>
							<button class="btn btn-sm btn-danger btn-tbl btnDeleteRecord" data-stock_id="'.$iStockID.'" >Deleted</button></div>';
				$data[] = array(
					++$iSrno,
					$sProduct,
					$iStockQty,
					$sAction
				);
			}			
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => count($result),
			"recordsFiltered" => count($result),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function getProductStockByStockID(){
		$aData = array();
		$Is_Logged_In = $this->chekIsUsrLoggedIN();
		if($Is_Logged_In == false){
			$aData['error'] = "action not allowed !";
			$this->loadView('login', $aData);
			return false;
		}	
		$this->load->model('Product_model', 'Products');
		$aData = $this->Products->getProductStockByID();
		echo json_encode($aData);
	}

	public function updateProductStock(){
		$aData = array();
		$Is_Logged_In = $this->chekIsUsrLoggedIN();
		if($Is_Logged_In == false){
			$aData['error'] = "action not allowed !";
			$this->loadView('login', $aData);
			return false;
		}	
		$this->load->model('Product_model', 'Products');
		$iResult = $this->Products->updateProductStock();
		if($iResult > 0){
			$aData['success'] = 'Product Stock updated successfully.';
		}else{
			$aData['error'] = 'Product stock can not be updated.';
		}
		echo json_encode($aData);
	}

	public function deleteProductStockByStockID(){
		$aData = array();
		$Is_Logged_In = $this->chekIsUsrLoggedIN();
		if($Is_Logged_In == false){
			$aData['error'] = "action not allowed !";
			$this->loadView('login', $aData);
			return false;
		}	
		$this->load->model('Product_model', 'Products');
		$bResult = $this->Products->deleteProductStockByStockID();
		if($bResult){
			$aData['success'] = 'Product Stock deleted successfully.';
		}else{
			$aData['error'] = 'Product stock can not be deleted.';
		}
		echo json_encode($aData);
	}

	public function getShoppingProducts(){
		$aData = array();
		$Is_Logged_In = $this->chekIsUsrLoggedIN();
		if($Is_Logged_In == false){
			$aData['error'] = "action not allowed !";
			$this->loadView('login', $aData);
			return false;
		}	
		$this->load->model('Product_model', 'Products');
		$aResult = $this->Products->getShoppingProducts();
		$dBillDate = date('Y-m-d', strtotime($_REQUEST['dBillDate']));
		foreach ($aResult as $key => $value) {
			// 'products.product_id, products.product_name, products.product_img_name, product_stock.stock_id, product_stock.stock_qty, product_attributes.quantity, product_attributes.unit, product_attributes.rate, product_attributes.is_offer_avilable ,product_attributes.offer_rate ,product_attributes.effective_from_date, product_attributes.effective_till_date'
			$aTemp = array();
			if($value->is_offer_avilable == 1){
				$aTemp['product_id'] = $value->product_id;
				$aTemp['product_name'] = $value->product_name;
				$aTemp['hsn_code'] = $value->hsn_code;
				$aTemp['product_img_name'] = $value->product_img_name;
				$aTemp['stock_id'] = $value->stock_id;
				$aTemp['stock_qty'] = $value->stock_qty;
				$aTemp['rate'] = $value->rate;
				$aTemp['offer_rate'] = $value->offer_rate;
				$aTemp['product_qty'] = $value->quantity.' '.$value->unit;
			
				$dEfctFrom = date('Y-m-d', strtotime($value->effective_from_date));
				$dEfctTill = date('Y-m-d', strtotime($value->effective_till_date));
				$aTemp['dEfctFrom'] = $dEfctFrom;
				$aTemp['dEfctTill'] = $dEfctTill;
				if((strtotime($dBillDate) >= strtotime($dEfctFrom)) && (strtotime($dBillDate) <= strtotime($dEfctTill))){
					$aTemp['sale_rate'] = $value->offer_rate;
					$offerR = (($value->offer_rate / $value->rate) * 100);
					$offerR = round($offerR, 2);
					$offerR = round((100- $offerR), 2);
					$aTemp['offer'] = 'Offer '.$offerR.' % off';
					$aTemp['applyOffer'] = 1;
				}else{
					$aTemp['applyOffer'] = 0;
					$aTemp['sale_rate'] = $value->rate;
					$aTemp['offer'] = 'No Offer Available';
				}
				$aData[$value->product_id] = $aTemp;
			}else{
				$aTemp['applyOffer'] = 0;
				$aTemp['product_id'] = $value->product_id;
				$aTemp['product_name'] = $value->product_name;
				$aTemp['hsn_code'] = $value->hsn_code;
				$aTemp['product_img_name'] = $value->product_img_name;
				$aTemp['stock_id'] = $value->stock_id;
				$aTemp['stock_qty'] = $value->stock_qty;
				$aTemp['rate'] = $value->rate;
				$aTemp['offer_rate'] = $value->offer_rate;
				$aTemp['product_qty'] = $value->quantity.' '.$value->unit;
				$aTemp['sale_rate'] = $value->rate;
				$aTemp['offer'] = 'No Offer Available';
				$dEfctFrom = date('Y-m-d', strtotime($value->effective_from_date));
				$dEfctTill = date('Y-m-d', strtotime($value->effective_till_date));
				$aTemp['dEfctFrom'] = $dEfctFrom;
				$aTemp['dEfctTill'] = $dEfctTill;
				$aData[$value->product_id] = $aTemp;
			}
		}
		echo json_encode($aData);
	}

	public function saveBill(){
		$aData = array();
		$Is_Logged_In = $this->chekIsUsrLoggedIN();
		if($Is_Logged_In == false){
			$aData['error'] = "action not allowed !";
			$this->loadView('login', $aData);
			return false;
		}	
		$this->load->model('Bill_model', 'Bills');
		$iBillID = $this->Bills->saveBill();

		//If bill generated check item availability and save bill items
		$iProceed = false;
		if($iBillID && $iBillID > 0){
			$aItems = $_REQUEST['billOBJ']['bill_items'];
			foreach($aItems as $billItem){
				$iProceed = $this->Bills->checkBillItemsAvailability($billItem);
				if(!$iProceed){
					$aData['error_msg'] = $billItem['sProductName']." quantity exceeds.";
					echo json_encode($aData);
					return false;
				}
			}

			if($iProceed){
				foreach($aItems as $billItem){
					$iManageStock = $this->Bills->manageStock($billItem);
					$iSaveBillItems = $this->Bills->saveBillItems($iBillID, $billItem);
				}
				$aData['iBillID'] = $iBillID;
				$aData['success_msg'] = "Bill saved successfully.";
			}else{
				$bInvalidateBill = $this->Bills->invalidBill($iBillID);
				$aData['error_msg'] = "Bill items could not be saved.";
			}			
		}
		echo json_encode($aData);
	}

	public function getBillForDataTable(){
		$aData = array();
		$Is_Logged_In = $this->chekIsUsrLoggedIN();
		if($Is_Logged_In == false){
			$aData['error'] = "action not allowed !";
			$this->loadView('login', $aData);
			return false;
		}	
		
		$data = array();
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$this->load->model('Bill_model', 'Bills');
		if(isset($_REQUEST['bill_type'])){
			if($_REQUEST['bill_type'] == 'today'){
				$result = $this->Bills->getTodaysBillForDataTable();
			}else if($_REQUEST['bill_type'] == 'all'){
				$result = $this->Bills->searchBill();
			}
		}
		if(!empty($result)){
			$iSrno = 0;
			foreach($result as $r) {
				$dBillDate = date('d-m-Y', strtotime($r->bill_date));
				$sAction = '<div class="flex-row-btn"><button class="btn btn-sm btn-default btn-tbl classViewBillBtn" data-bill_id="'.$r->bill_id.'" >View</button>
							<button class="btn btn-sm btn-success btn-tbl classUpdateBillBtn" data-bill_id="'.$r->bill_id.'" >Update</button></div>';
				$data[] = array(
					++$iSrno,
					$r->bill_no,
					$dBillDate,
					$r->customer_fullName,
					$r->bill_total,
					$sAction
				);
			}			
		}

		$data = array_splice($data,$start,$length);

		$output = array(
			"draw" => $draw,
			"recordsTotal" => count($result),
			"recordsFiltered" => count($result),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function updateBillPage($iBillID, $iUpdateOrViewBill=0){
		$aData =array();
		$a = array();		
		$iBillTocustomerId = 0;
		$iBillFRDTocustomerId = 0;
		//iUpdateOrViewBill //update = 0 , view = 1
		$customerId = 0;
		if($iBillID > 0){
			$this->load->model('Bill_model', 'Bills');
			$aBillMaster = $this->Bills->getAPIBillMaster($iBillID);
			if(COUNT($aBillMaster) > 0){
				foreach($aBillMaster as $key => $value){
					if($value->bill_date){
						$aBillMaster[$key]->bill_date = date('d-m-Y', strtotime($value->bill_date));
					}
					if($value->challan_date && $value->challan_date != null && ((float)$value->challan_date)){
						$aBillMaster[$key]->challan_date = date('d-m-Y', strtotime($value->challan_date));
					}else{
						$aBillMaster[$key]->challan_date = '';
					}
					if($value->dm_date && $value->dm_date != null && ((float)$value->dm_date)){
						$aBillMaster[$key]->dm_date = date('d-m-Y', strtotime($value->dm_date));
					}else{
						$aBillMaster[$key]->dm_date = '';
					}
					if($value->lrmr_date && $value->lrmr_date != null && ((float)$value->lrmr_date)){
						$aBillMaster[$key]->lrmr_date = date('d-m-Y', strtotime($value->lrmr_date));
					}else{
						$aBillMaster[$key]->lrmr_date = '';
					}
					if((double)$value->bill_total > 0){
						$number = $value->bill_total;
						if(strlen($number) > 10){
							$aBillMaster[$key]->bill_amount_words = $this->convert_number_to_words((double)$number);
						}else{
							$aBillMaster[$key]->bill_amount_words = $this->currencyInWords((double)$number);
						}
					}
				}
				$a['bill'] = $aBillMaster;
				$iBillTocustomerId = $aBillMaster[0]->customer_id;
				$iBillFRDTocustomerId = $aBillMaster[0]->forwardTo_customer_id;

				$aBillItems = $this->Bills->getAPIBillItems($iBillID);
				if(COUNT($aBillItems) > 0){
					$a['bill_items'] = $aBillItems;
				}else{
					$a['bill_items'] = array();
				}				
			}
		}

		if($iBillTocustomerId > 0){
			$this->load->model('Customer_model', 'Customers');
			$aBillTO = $this->Customers->getAPICustomersByID($iBillTocustomerId);
			if(COUNT($aBillTO) > 0){
				$a['customer_details'] = $aBillTO;
			}else{
				$a['customer_details'] = array();
			}
		}

		if($iBillFRDTocustomerId > 0){
			$this->load->model('Customer_model', 'Customers');
			$aBillFrdTO = $this->Customers->getAPICustomersByID($iBillFRDTocustomerId);
			if(COUNT($aBillFrdTO) > 0){
				$a['forwardTo_details'] = $aBillFrdTO;
			}else{
				$a['forwardTo_details'] = array();
			}
		}	

		if($iUpdateOrViewBill){
			$aData['aViewBillOBJ'] = json_encode($a);
			$this->loadView('invoice', $aData);
		}else{			
			$aData['aUpdateBillOBJ'] = json_encode($a);
			$this->loadView('update_bills', $aData);
		}
	}

	public function updateBill(){
		header('Content-Type: application/json');
		$aData = array();
		$Is_Logged_In = $this->chekIsUsrLoggedIN();
		if($Is_Logged_In == false){
			$aData['error'] = "action not allowed !";
			$this->loadView('login', $aData);
			return false;
		}	
		if( isset($_REQUEST['billOBJ']['bill_items']) && COUNT($_REQUEST['billOBJ']['bill_items']) > 0 ){
			$iBillID = $_REQUEST['billOBJ']['bill'][0]['id'];
			$this->load->model('Product_model', 'Products');
			$aBillItems = $_REQUEST['billOBJ']['bill_items'];
			//Check stock for new item entry
			$aChkItem = array();
			foreach ($aBillItems as $key => $value) {
				$iProductID = $value['iProductId'];
				if( array_key_exists( $iProductID, $aChkItem ) ){
					if($value['sItmUnit'] == 'Dozen'){
						$aChkItem[$iProductID]['iItemQty'] += (12 * $value['itemQty']);
						$aChkItem[$iProductID]['iProductId'] = $iProductID;
						$aChkItem[$iProductID]['sProductName'] = $value['sProductName'];
					}else{
						$aChkItem[$iProductID]['iItemQty'] += (1 * $value['itemQty']);
						$aChkItem[$iProductID]['iProductId'] = $iProductID;
						$aChkItem[$iProductID]['sProductName'] = $value['sProductName'];
					}
				}else{
					if($value['sItmUnit'] == 'Dozen'){
						$aChkItem[$iProductID]['iItemQty'] = (12 * $value['itemQty']);
						$aChkItem[$iProductID]['iProductId'] = $iProductID;
						$aChkItem[$iProductID]['sProductName'] = $value['sProductName'];
					}else{
						$aChkItem[$iProductID]['iItemQty'] = (1 * $value['itemQty']);
						$aChkItem[$iProductID]['iProductId'] = $iProductID;
						$aChkItem[$iProductID]['sProductName'] = $value['sProductName'];
					}
				}
			}
		
			//Check stock available for newly added qty
			foreach ($aChkItem as $key1 => $value1) {
				$bCheckUpdatingItemStock = $this->Products->checkUpdatingItemStock($iBillID, $value1);
				if(!$bCheckUpdatingItemStock){
					$aData['error_msg'] = $value1['sProductName']." stock not available.";
					echo json_encode($aData);
					return false;
				}
			}

			if( isset($_REQUEST['billOBJ']['bill']) ){				
				$this->load->model('Product_model', 'Products');
				$bReImbersement = $this->Products->productStockReImbersement($iBillID);

				if($bReImbersement == true){
					//Update bill master
					$aBillMaster = $_REQUEST['billOBJ']['bill'];
					if(COUNT($aBillMaster) > 0){
						$this->load->model('bill_model', 'Bills');
						$bBillMaster = $this->Bills->updateAPIBillMaster($aBillMaster);

						if($bBillMaster == true){
							if( COUNT($aBillItems) > 0 ){
								$iBillItemCount = 0;
								foreach ($aBillItems as $key2 => $value2) {
									$iBillItemCount += $this->Bills->saveBillItems($iBillID, $value2);
								}
								if($iBillItemCount > 0){
									$aData['success_msg'] = 'Bill updated successfully.';
									echo json_encode($aData);
								}
							}

						}
					}

				}else{
					$aData['error_msg'] = 'Can not update bill';
					echo json_encode($aData);
				}
			}
		}else{
			$aData['error_msg'] = 'Can not update with no item selected';
		}
		return json_encode($aData);
	}

	public function currencyInWords($number){	
		$no = round($number);
		$decimals = round($number - $no, 2);
		$point = round($number - $no, 2) * 100;
		$hundred = null;
		$digits_1 = strlen($no);
		$i = 0;
		$str = array();
		$words = array('0' => '', '1' => 'one', '2' => 'two',
			'3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
			'7' => 'seven', '8' => 'eight', '9' => 'nine',
			'10' => 'ten', '11' => 'eleven', '12' => 'twelve',
			'13' => 'thirteen', '14' => 'fourteen',
			'15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
			'18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
			'30' => 'thirty', '40' => 'forty', '50' => 'fifty',
			'60' => 'sixty', '70' => 'seventy',
			'80' => 'eighty', '90' => 'ninety');
		$digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
		while ($i < ($digits_1)) {
			$divider = ($i == 2) ? 10 : 100;
			$number = floor($no % $divider);
			$no = floor($no / $divider);
			$i += ($divider == 10) ? 1 : 2;
			if ($number) {
				$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
				$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
				$str [] = ($number < 21) ? $words[$number] .
					" " . $digits[$counter] . $plural . " " . $hundred
					:
					$words[floor($number / 10) * 10]
					. " " . $words[$number % 10] . " "
					. $digits[$counter] . $plural . " " . $hundred;
			} else { $str[] = null; }
		}
		$str = array_reverse($str);
		$result = implode('', $str);
		$word = '';
		if($decimals > 0){
			$points = ($point) ?
				"point " . $words[$point / 10] . " " . 
					$words[$point = $point % 10] : '';
				$word = $result . "Rupees  " . $points . " Paise Only";
		}else{
			$word = $result . "Rupees Only";
		}
		return $word;
	}

	public function convert_number_to_words($number) {
		$hyphen      = '-';
		$conjunction = ' and ';
		$separator   = ', ';
		$negative    = 'negative ';
		$decimal     = ' point ';
		$dictionary  = array(
			0                   => 'zero',
			1                   => 'one',
			2                   => 'two',
			3                   => 'three',
			4                   => 'four',
			5                   => 'five',
			6                   => 'six',
			7                   => 'seven',
			8                   => 'eight',
			9                   => 'nine',
			10                  => 'ten',
			11                  => 'eleven',
			12                  => 'twelve',
			13                  => 'thirteen',
			14                  => 'fourteen',
			15                  => 'fifteen',
			16                  => 'sixteen',
			17                  => 'seventeen',
			18                  => 'eighteen',
			19                  => 'nineteen',
			20                  => 'twenty',
			30                  => 'thirty',
			40                  => 'fourty',
			50                  => 'fifty',
			60                  => 'sixty',
			70                  => 'seventy',
			80                  => 'eighty',
			90                  => 'ninety',
			100                 => 'hundred',
			1000                => 'thousand',
			1000000             => 'million',
			1000000000          => 'billion',
			1000000000000       => 'trillion',
			1000000000000000    => 'quadrillion',
			1000000000000000000 => 'quintillion'
		);
	
		if (!is_numeric($number)) {
			return false;
		}
	
		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
			// overflow
			trigger_error(
				'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
				E_USER_WARNING
			);
			return false;
		}
	
		if ($number < 0) {
			return $negative . $this->convert_number_to_words(abs($number));
		}
	
		$string = $fraction = null;
	
		if (strpos($number, '.') !== false) {
			list($number, $fraction) = explode('.', $number);
		}
	
		switch (true) {
			case $number < 21:
				$string = $dictionary[$number];
				break;
			case $number < 100:
				$tens   = ((int) ($number / 10)) * 10;
				$units  = $number % 10;
				$string = $dictionary[$tens];
				if ($units) {
					$string .= $hyphen . $dictionary[$units];
				}
				break;
			case $number < 1000:
				$hundreds  = $number / 100;
				$remainder = $number % 100;
				$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
				if ($remainder) {
					$string .= $conjunction . $this->convert_number_to_words($remainder);
				}
				break;
			default:
				$baseUnit = pow(1000, floor(log($number, 1000)));
				$numBaseUnits = (int) ($number / $baseUnit);
				$remainder = $number % $baseUnit;
				$string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
				if ($remainder) {
					$string .= $remainder < 100 ? $conjunction : $separator;
					$string .= $this->convert_number_to_words($remainder);
				}
				break;
		}
	
		if (null !== $fraction && is_numeric($fraction)) {
			$string .= $decimal;
			$words = array();
			foreach (str_split((string) $fraction) as $number) {
				$words[] = $dictionary[$number];
			}
			$string .= implode(' ', $words);
		}
	
		return $string;
	}
}
