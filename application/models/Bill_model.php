<?php
class Bill_model extends CI_Model {

    public function getBillCount(){
        $aData =array();
        if(isset($_REQUEST['today'])){
            $this->db->reconnect();
            $this->db->select('COUNT(*) as bill_count, SUM(bill_total) as bill_amount');
            $query = $this->db->get_where('bill_master' , array('Date(bill_date)' => date("Y-m-d"), 'deleted' => 0));
			$aData = $query->result();
		}if(isset($_REQUEST['from_date']) && isset($_REQUEST['to_date'])){
            $this->db->reconnect();
            $fDate = date('Y-m-d', strtotime($_REQUEST['from_date']));
            $tDate = date('Y-m-d', strtotime($_REQUEST['to_date']));
            $this->db->select('COUNT(*) as bill_count, SUM(bill_total) as bill_amount');
            $query = $this->db->get_where('bill_master' , array('Date(bill_date) >= ' => $fDate,'Date(bill_date) <= ' => $tDate, 'deleted' => 0));
            $aData = $query->result();
        // var_dump($this->db->last_query());// to print last executed query        
            
		}else{
            $this->db->reconnect();
            $this->db->select('COUNT(*) as bill_count, SUM(bill_total) as bill_amount');
            $query = $this->db->get_where('bill_master' , array('deleted' => 0));
            $aData = $query->result();
        }
        $this->db->close();
        return $aData;
    }

    public function saveBill(){
        $BillObj = $_REQUEST['billOBJ'];
        if(COUNT($BillObj['bill']) > 0 && $_REQUEST['userID'] > 0 && COUNT($BillObj['customer_details']) > 0){
            if(isset($BillObj['bill'][0]['bill_date']) && ($BillObj['bill'][0]['bill_date']) != ''){
                $dBillDate = date('Y-m-d', strtotime($BillObj['bill'][0]['bill_date']));
            }else{
                $dBillDate = NULL;
            }

            if(isset($BillObj['bill'][0]['challan_date']) && ($BillObj['bill'][0]['challan_date']) != ''){
                $dChallanDate = date('Y-m-d', strtotime($BillObj['bill'][0]['challan_date']));
            }else{
                $dChallanDate = NULL;
            }

            if(isset($BillObj['bill'][0]['dm_date']) && ($BillObj['bill'][0]['dm_date']) != ''){
                $dDMDate = date('Y-m-d', strtotime($BillObj['bill'][0]['dm_date']));
            }else{
                $dDMDate = NULL;
            }

            if(isset($BillObj['bill'][0]['lrmr_date']) && ($BillObj['bill'][0]['lrmr_date']) != ''){
                $dLRMRDate = date('Y-m-d', strtotime($BillObj['bill'][0]['lrmr_date']));
            }else{
                $dLRMRDate = NULL;
            }

            if(isset($BillObj['forwardTo_details'])){
                $iForwardToCustomerID = $BillObj['forwardTo_details'][0]['customer_id'];
            }else{
                $iForwardToCustomerID = 0;
            }
            
            $aBillDetails = array(
                "bill_no" => $BillObj['bill'][0]['bill_no'],
                "bill_date" => $dBillDate,
                "tax_rate" => COMPANY_IGST_TAX,
                "bill_subTotal" => round($BillObj['bill'][0]['bill_subTotal'], 2),
                "bill_cgst" => round($BillObj['bill'][0]['bill_cgst'], 2),
                "bill_sgst" => round($BillObj['bill'][0]['bill_sgst'], 2),
                "bill_igst" => round($BillObj['bill'][0]['bill_igst'], 2),
                "bill_total" => round($BillObj['bill'][0]['bill_total'], 2),
                "customer_id" => $BillObj['customer_details'][0]['customer_id'],
                "forwardTo_customer_id" => $iForwardToCustomerID,
                "challan_no" => $BillObj['bill'][0]['challan_no'] ,
                "challan_date" => $dChallanDate,
                "dm_no" => $BillObj['bill'][0]['dm_no'] ,
                "dm_date" => $dDMDate,
                "lr_or_mr_no" => $BillObj['bill'][0]['lrmr_no'] ,
                "lr_or_mr_date" => $dLRMRDate,
                "added_by" => $_REQUEST['userID']
            );

            $this->db->set($aBillDetails);
            $this->db->insert('bill_master');
            $insrtAttrId = $this->db->insert_id();
            return $insrtAttrId;
        }
    }

    public function getTodaysBillForDataTable(){
        if(!$_REQUEST['userID']){
            return false;
        }
        $dToday = date('Y-m-d');
        $this->db->reconnect();
        $this->db->select('a.bill_id, a.bill_no, a.bill_date, a.bill_total, b.customer_id, CONCAT(b.first_name, " ", b.last_name) as customer_fullName');
        $this->db->from('bill_master as a');
        $this->db->join('customers as b', 'b.customer_id = a.customer_id', 'left');
        $this->db->where(array('a.deleted' => 0, 'DATE(a.bill_date)' => $dToday, 'b.deleted' => 0));
        // $this->db->order_by('DATE(a.bill_date)', 'DESC');
        $query = $this->db->get();
        // var_dump($this->db->last_query());// to print last executed query        
        $this->db->close();
        return $query->result();
    }

    public function searchBill(){
        if(!$_REQUEST['userID']){
            return false;
        }
        $dToday = date('Y-m-d');
        $this->db->reconnect();
        $this->db->select('a.bill_id, a.bill_no, a.bill_date, a.bill_total, b.customer_id, CONCAT(b.first_name, " ", b.last_name) as customer_fullName');
        $this->db->from('bill_master as a');
        $this->db->join('customers as b', 'b.customer_id = a.customer_id', 'left');
        $aSerch =array('a.deleted' => 0, 'b.deleted' => 0);
        if( isset($_REQUEST['dBillFrmDate']) && isset($_REQUEST['dBillToDate']) ){
            $aSerch['DATE(a.bill_date) >='] = date('Y-m-d', strtotime($_REQUEST['dBillFrmDate']));
            $aSerch['DATE(a.bill_date) <='] = date('Y-m-d', strtotime($_REQUEST['dBillToDate']));
        }
        if(isset($_REQUEST['iBillCustomerID'])){
            if($_REQUEST['iBillCustomerID'] > 0){
                $aSerch['a.customer_id'] = $_REQUEST['iBillCustomerID'];
            }
        }
       
        $this->db->where($aSerch);
        $this->db->order_by('DATE(a.bill_date)', 'DESC');
        // if(isset($_REQUEST['start']) && isset($_REQUEST['length'])){
        //     $limit = $_REQUEST['start'];
        //     $offset = $_REQUEST['length'];
        //     $this->db->limit($offset, $limit);
        // }
        $query = $this->db->get();
        // var_dump($this->db->last_query());// to print last executed query        
        $this->db->close();
        return $query->result();
    }

    public function checkBillItemsAvailability($billItem){
        $iProductID = $billItem['iProductId'];
        if($iProductID > 0){
            if($billItem['sItmUnit'] == "Dozen"){
                $itemQty = 12 * (int)$billItem['itemQty'];
            }else{
                $itemQty = (int)$billItem['itemQty'];
            }
            $this->db->reconnect();
            $this->db->select('*');
            $this->db->from('product_stock');
            $this->db->where(array('deleted' => 0, 'product_id' => (int)$iProductID, 'stock_qty >= ' => (int)$itemQty ));
            $iCount = $this->db->count_all_results();            
            // var_dump($this->db->last_query());// to print last executed query        
            $this->db->close();
            if($iCount){
                return true;
            }else{
                return false;
            }
        }
    }

    public function invalidBill($iBillID){
        if(!$iBillID){
            return false;
        }
        $this->db->reconnect();
        $data = array(
            'deleted' => 1
        );        
        $this->db->where('bill_id', $iBillID);
        $this->db->update('bill_master', $data);
        // var_dump($this->db->last_query());// to print last executed query        
        $this->db->close();
        return true;
    }

    public function manageStock($billItem){
        $iProductID = $billItem['iProductId'];
        if($iProductID > 0){
            if($billItem['sItmUnit'] == "Dozen"){
                $itemQty = 12 * (int)$billItem['itemQty'];
            }else{
                $itemQty = (int)$billItem['itemQty'];
            }
            $this->db->reconnect();
            $this->db->set('stock_qty', 'stock_qty - '.$itemQty, FALSE);
            $this->db->where(array('product_id'=> (int)$iProductID, 'deleted' => 0));
            $this->db->update('product_stock'); 
            $iResult = $this->db->affected_rows();
            // var_dump($this->db->last_query());// to print last executed query        
            $this->db->close();
            if($iResult > 0){
                return true;
            }else{
                return false;
            }
        } 
    }

    public function saveBillItems($iBillID, $billItem){
        if($iBillID > 0 && COUNT($billItem) > 0){         
            $item_product_id = $billItem["iProductId"];
            $item_name = $billItem["sProductName"];
            $hsn_code = $billItem["sHsnCode"];
            $item_quantity_unit = $billItem["unit"];
            $item_rate = $billItem["sProductRate"];
            $bill_quantity = $billItem["itemQty"];
            $bill_rate = $billItem["itemAmount"];
            $bill_unit = $billItem["sItmUnit"];
            $added_by = $_REQUEST["userID"];
            $this->db->reconnect();
            $sql = "INSERT INTO `bill_items`(`item_product_id`, `bill_id`, `item_name`, `hsn_code`, `item_quantity_unit`, `item_rate`, `bill_quantity`, `bill_rate`, `bill_unit`, `added_by`) VALUES ('$item_product_id', '$iBillID', '$item_name', '$hsn_code', '$item_quantity_unit', '$item_rate', '$bill_quantity', '$bill_rate', '$bill_unit', '$added_by')";
            $this->db->query($sql);
            $insrtBillItemId = $this->db->insert_id();
            $this->db->close();
            return $insrtBillItemId;
        }
    }

    public function getAPIBillMaster($iBIllID){
        $this->db->reconnect();
        $this->db->select('bill_id as id, bill_no, bill_date, bill_cgst, bill_sgst, bill_igst, bill_subTotal, bill_total, challan_no, challan_date, dm_no, dm_date, lr_or_mr_no as lrmr_no, lr_or_mr_date as lrmr_date, customer_id, forwardTo_customer_id');
        $this->db->from('bill_master');
        $this->db->where(array('bill_id' => $iBIllID, 'deleted' => 0));      
        $query = $this->db->get();
        // var_dump($this->db->last_query());// to print last executed query        
        $this->db->close();
        return $query->result();
    }

    public function getAPIBillItems($iBillID){
        $this->db->reconnect();
        $this->db->select('item_id, item_product_id as iProductId, bill_id, item_name as sProductName, hsn_code as sHsnCode, item_quantity_unit as unit, item_rate as sProductRate, bill_quantity as itemQty, bill_rate as itemAmount, bill_unit as sItmUnit');
        $this->db->from('bill_items');
        $this->db->where(array('bill_id' => (int)$iBillID, 'deleted' => 0));      
        $query = $this->db->get();
        // var_dump($this->db->last_query());// to print last executed query        
        $this->db->close();
        return $query->result();
    }

    public function updateAPIBillMaster($aBillMaster){
        $this->db->reconnect();
        if(isset($aBillMaster[0]['bill_date']) && ($aBillMaster[0]['bill_date']) != ''){
            $dBillDate = date('Y-m-d', strtotime($aBillMaster[0]['bill_date']));
        }else{
            $dBillDate = NULL;
        }

        if(isset($aBillMaster[0]['challan_date']) && ($aBillMaster[0]['challan_date']) != ''){
            $dChallanDate = date('Y-m-d', strtotime($aBillMaster[0]['challan_date']));
        }else{
            $dChallanDate = NULL;
        }

        if(isset($aBillMaster[0]['dm_date']) && ($aBillMaster[0]['dm_date']) != ''){
            $dDMDate = date('Y-m-d', strtotime($aBillMaster[0]['dm_date']));
        }else{
            $dDMDate = NULL;
        }

        if(isset($aBillMaster[0]['lrmr_date']) && ($aBillMaster[0]['lrmr_date']) != ''){
            $dLRMRDate = date('Y-m-d', strtotime($aBillMaster[0]['lrmr_date']));
        }else{
            $dLRMRDate = NULL;
        }

        $bill_no = $aBillMaster[0]['bill_no'];
        $bill_date = $dBillDate;
        $tax_rate = COMPANY_IGST_TAX;
        $bill_cgst = round($aBillMaster[0]['bill_cgst'] , 2);
        $bill_sgst = round($aBillMaster[0]['bill_sgst'], 2);
        $bill_igst = round($aBillMaster[0]['bill_igst'], 2);		
        $bill_subTotal = round($aBillMaster[0]['bill_subTotal'], 2);
        $bill_total = round($aBillMaster[0]['bill_total'], 2);
        $customer_id = $aBillMaster[0]['customer_id'];
        $forwardTo_customer_id = $aBillMaster[0]['forwardTo_customer_id'];	
        $challan_no = $aBillMaster[0]['challan_no'];
        $challan_date = $dChallanDate;
        $dm_no = $aBillMaster[0]['dm_no'];
        $dm_date = $dDMDate;
        $lr_or_mr_no = $aBillMaster[0]['lrmr_no'];
        $lr_or_mr_date = $dLRMRDate;
        $added_by = $_REQUEST['userID'];

        // $aUpdArray = array(
        //     "bill_no" => $aBillMaster[0]['bill_no'],
        //     "bill_date" => $dBillDate,
        //     "tax_rate" => (int)COMPANY_IGST_TAX,
        //     "bill_cgst" => (float)round($aBillMaster[0]['bill_cgst'] , 2),
        //     "bill_sgst" => (float)round($aBillMaster[0]['bill_sgst'], 2),
        //     "bill_igst" => (float)round($aBillMaster[0]['bill_igst'], 2),		
        //     "bill_subTotal" => (float)round($aBillMaster[0]['bill_subTotal'], 2),
        //     "bill_total" => (float)round($aBillMaster[0]['bill_total'], 2),
        //     "customer_id" => (int)$aBillMaster[0]['customer_id'],
        //     "forwardTo_customer_id" => (int)$aBillMaster[0]['forwardTo_customer_id'],	
        //     "challan_no" => $aBillMaster[0]['challan_no'],
        //     "challan_date" => $dChallanDate,
        //     "dm_no" => $aBillMaster[0]['dm_no'],
        //     "dm_date" => $dDMDate,
        //     "lr_or_mr_no" => $aBillMaster[0]['lrmr_no'],
        //     "lr_or_mr_date" => $dLRMRDate,
        //     "added_by" => (int)$_REQUEST['userID']
        // );
        $iBillID = $aBillMaster[0]['id'];
        // $this->db->where(array('bill_id' => (int)$iBillID, 'deleted'=> 0));
        // $this->db->set($aUpdArray);
        // $this->db->update('bill_master');
        $sBillQuery = "UPDATE `bill_master` SET `bill_no`='{$bill_no}', `bill_date`='{$bill_date}',`tax_rate`='{$tax_rate}',
        `bill_cgst`='{$bill_cgst}', `bill_sgst`='{$bill_sgst}',`bill_igst`='{$bill_igst}',`bill_subTotal`='{$bill_subTotal}',
        `bill_total`='{$bill_total}', `customer_id`='{$customer_id}', `forwardTo_customer_id`='{$forwardTo_customer_id}',
         `challan_no`='{$challan_no}',`challan_date`='{$challan_date}',`dm_no`='{$dm_no}',`dm_date`='{$dm_date}',
         `lr_or_mr_no`='{$lr_or_mr_no}', `lr_or_mr_date`='{$lr_or_mr_date}',`added_by`='{$added_by}'
         WHERE `bill_id`='{$iBillID}' AND `deleted`='0' ";
        $this->db->query($sBillQuery);
        $iAffRows = $this->db->affected_rows();
        // var_dump($this->db->last_query());// to print last executed query        

        $this->db->close();
        if($iAffRows > 0){
            return true;
        }else{
            return false;
        }
    }

}
