<?php
class Product_model extends CI_Model {

    public function getProductByName(){
        $aData =array();
        if(isset($_POST['productName'])){
            $productName = $_POST['productName'];
            $this->db->reconnect();
            $this->db->like('LOWER(product_name)', strtolower($productName), 'both');
			$query = $this->db->select('product_id as id, product_name as text')->limit(10)->get("products");
			$aData = $query->result();
		}
        $this->db->close();
        return $aData;
    }

    public function getProductSelect2(){
        $aData =array();
        if(isset($_REQUEST['term'])){
            $term = $_REQUEST['term'];
            $this->db->reconnect();
            $this->db->like('LOWER(product_name)', strtolower($term), 'both');
			$query = $this->db->select('product_id as id, product_name as text')->limit(10)->get("products");
            $aData = $query->result();
            // var_dump($this->db->last_query());// to print last executed query        
		}
        $this->db->close();
        return $aData;
    }

    public function isProductExist($productName){
        $aData =array();
        if($productName){
            $this->db->reconnect();
            $this->db->select('product_id, product_name');
            $this->db->limit(1);          
			$query = $this->db->get_where('products', array('product_name' => $productName, 'deleted' => 0));
			$aData = $query->result();
        }
        // var_dump($this->db->last_query());// to print last executed query        
        $this->db->close();
        if(count($aData) > 0){
            return true;
        }else{
            return false;
        }
    }

    public function isProductExistUpdate($productName){
        $aData =array();
        $productId = $_POST['productId'];
        if($productName){
            $this->db->reconnect();
            $this->db->select('product_id, product_name');
            $this->db->limit(1);          
			$query = $this->db->get_where('products', array('product_id !=' => $productId, 'product_name' => $productName, 'deleted' => 0));
			$aData = $query->result();
        }
        // var_dump($this->db->last_query());// to print last executed query        
        $this->db->close();
        if(count($aData) > 0){
            return true;
        }else{
            return false;
        }
    }
    
    public function addNewProduct($productImgName){
        $bResult = false;
        if($_POST){  
            $efctFromDate = null;
            $efctToDate = null;
            $OfferRate = 0; 
            $isOfferAvailable = 0; 
            if(isset($_POST['isOfferAvailable'])){
                $isOfferAvailable = 1;
                $OfferRate = $_POST['OfferRate'];
                $efctFromDate = date('Y-m-d', strtotime($_POST['efctFromDate']));
                $efctToDate = date('Y-m-d', strtotime($_POST['efctToDate']));
            }
            $hsnCode = $_POST['hsnCode'];
            $productName = $_POST['productName'];
            $quantity = $_POST['quantity'];
            $rate = $_POST['rate'];
            $unit = $_POST['unit'];          
            $userID = $_POST['userID'];
            $this->db->reconnect();
            $sql = "INSERT INTO `products` (`product_name`, `product_img_name`, `added_by` ) VALUES ('".$productName."','".$productImgName."','" .$userID."')";
            $this->db->query($sql);
            $insertId = $this->db->insert_id();
            if($insertId > 0){
                $arrayProductAttr = array(
                    'product_id' => $insertId,
                    'quantity' => $quantity,
                    'hsn_code' => $hsnCode,
                    'unit' => $unit,
                    'rate' => $rate,
                    'offer_rate' => $OfferRate,
                    'is_offer_avilable' => $isOfferAvailable,
                    'effective_from_date' => $efctFromDate,
                    'effective_till_date' => $efctToDate,
                    'added_by' => $userID
                );
                $this->db->set($arrayProductAttr);
                $this->db->insert('product_attributes');
                $insrtAttrId = $this->db->insert_id();
                if($insrtAttrId > 0){
                    $bResult = true;
                }else{
                    $bResult = false;
                }
            }else{
                $bResult = false;
            }
            // var_dump($this->db->last_query());// to print last executed query
            $this->db->close();
            return $bResult;//boolean
        } 
    }

    public function getAllProductsForDataTable(){
        if(!$_REQUEST['userID']){
            return false;
        }
        $this->db->reconnect();
        $this->db->select('products.product_id, products.product_name, products.product_img_name, product_attributes.quantity, product_attributes.hsn_code, product_attributes.unit, product_attributes.rate, product_attributes.offer_rate,product_attributes.is_offer_avilable, product_attributes.effective_from_date, product_attributes.effective_till_date');
        $this->db->from('products');
        $this->db->join('product_attributes', 'product_attributes.product_id = products.product_id', 'left');
        $this->db->where(array('products.deleted' => 0, 'product_attributes.deleted' => 0));
        $query = $this->db->get();
        $this->db->close();
        return $query->result();
    }

    public function getAllProducts(){
        if(!$_REQUEST['userID']){
            return false;
        }
        $this->db->reconnect();
        $this->db->select('products.product_id, products.product_name, products.product_img_name, product_attributes.quantity, product_attributes.hsn_code, product_attributes.unit, product_attributes.rate, product_attributes.offer_rate, product_attributes.is_offer_avilable, product_attributes.effective_from_date, product_attributes.effective_till_date');
        $this->db->from('products');
        $this->db->join('product_attributes', 'product_attributes.product_id = products.product_id', 'left');
        $this->db->where(array('products.deleted' => 0, 'product_attributes.deleted' => 0));
        $query = $this->db->get();
        $this->db->close();
        return $query->result();
    }

    public function updateProduct($productImgName){
        $bResult = false;
        if($_POST && $_POST['productId'] > 0){          
            $efctFromDate = null;
            $efctToDate = null;
            $isOfferAvailable = 0; 
            $OfferRate = 0;
            if(isset($_POST['isOfferAvailable'])){
                $isOfferAvailable = 1;
                $OfferRate = $_POST['OfferRate'];
                $efctFromDate = date('Y-m-d', strtotime($_POST['efctFromDate']));
                $efctToDate = date('Y-m-d', strtotime($_POST['efctToDate']));
            }
            $hsnCode = $_POST['hsnCode'];
            $productId = $_POST['productId'];
            $productName = $_POST['productName'];
            $quantity = $_POST['quantity'];
            $rate = $_POST['rate'];
            $unit = $_POST['unit'];          
            $userID = $_POST['userID'];
            $this->db->reconnect();
            $sql = "UPDATE `products` SET `product_name` = '".$productName."' , `product_img_name` = '".$productImgName."', `added_by`= '" .$userID."' WHERE `product_id`= '".$productId."' AND `deleted`='0' ";
            $this->db->query($sql);
            $insertId = $productId;
            if($insertId > 0){
                $sqlAttr = "UPDATE `product_attributes` SET  `deleted`='1' WHERE `product_id`= '".$productId."' AND `deleted`='0' ";
                $this->db->query($sqlAttr);

                $arrayProductAttr = array(
                    'product_id' => $insertId,
                    'quantity' => $quantity,
                    'hsn_code' => $hsnCode,
                    'unit' => $unit,
                    'rate' => $rate,
                    'offer_rate' => $OfferRate,
                    'is_offer_avilable' => $isOfferAvailable,
                    'effective_from_date' => $efctFromDate,
                    'effective_till_date' => $efctToDate,
                    'added_by' => $userID
                );
                $this->db->set($arrayProductAttr);
                $this->db->insert('product_attributes');
                $insrtAttrId = $this->db->insert_id();
                if($insrtAttrId > 0){
                    $bResult = true;
                }else{
                    $bResult = false;
                }
            }else{
                $bResult = false;
            }
            // var_dump($this->db->last_query());// to print last executed query
            $this->db->close();
            return $bResult;//boolean
        }
    } 

    public function getProductByID(){
        if(!$_POST['userID'] || !$_POST['productId']){
            return false;
        }
        $productId = (int)$_POST['productId'];
        $this->db->reconnect();
        $this->db->select('products.product_id, products.product_name, products.product_img_name, product_attributes.quantity, product_attributes.hsn_code, product_attributes.unit, product_attributes.rate, product_attributes.offer_rate, product_attributes.is_offer_avilable,product_attributes.effective_from_date, product_attributes.effective_till_date');
        $this->db->from('products');
        $this->db->join('product_attributes', 'product_attributes.product_id = products.product_id', 'left');
        $this->db->where(array('products.product_id' => $productId, 'products.deleted' => 0, 'product_attributes.deleted' => 0));
        $query = $this->db->get();
        $this->db->close();
        return $query->result();
    }

    public function deleteProductByID(){
        if($_POST['userID'] && $_POST['productId'] > 0){
            $productId = $_POST['productId'];           
            $this->db->reconnect();
            $array = array(                
                'deleted' => 1
            );     
            $sql1 = "UPDATE `products` SET `deleted` ='1' WHERE `product_id` = '".$productId ."'";
            $this->db->query($sql1);       

            $this->db->where('product_id', $productId);
            $result2 = $this->db->update('product_attributes', $array);
            // var_dump($this->db->last_query());// to print last executed query
            $this->db->close();
            return $result2;
        } 
    }

    public function addNewProductStock(){
        if($_POST['userID']){
            $productId = (int)$_POST['stockProductId'];
            $stockQuantity = (int)$_POST['stockQuantity'];
            $userID = (int)$_POST['userID'];
            $this->db->reconnect();
            $arrayStock = array(
                'product_id' => $productId,
                'stock_qty' => $stockQuantity,
                'added_by' => $userID
            );
            $this->db->set($arrayStock);
            $this->db->insert('product_stock');
            $iStockId = $this->db->insert_id();
            // var_dump($this->db->last_query());// to print last executed query
            $this->db->close();
            return $iStockId;
        }
    }

    public function getProductStock(){
        if($_REQUEST['userID']){
            $this->db->reconnect();
            $this->db->select('products.product_id, products.product_name, products.product_img_name, product_stock.stock_id, product_stock.stock_qty, product_attributes.quantity, product_attributes.unit');
            $this->db->from('product_stock');
            $this->db->join('products', 'products.product_id = product_stock.product_id', 'left');
            $this->db->join('product_attributes', 'product_attributes.product_id = product_stock.product_id', 'left');
            $this->db->where(array('products.deleted' => 0, 'product_stock.deleted' => 0, 'product_attributes.deleted' => 0));
            $query = $this->db->get();
            $this->db->close();
            return $query->result();
        }
    }

    public function getProductStockByID(){
        if($_REQUEST['userID'] && $_REQUEST['stockID']){
            $iStockID = $_REQUEST['stockID'];
            $this->db->reconnect();
            $this->db->select('products.product_id, products.product_name, products.product_img_name, product_stock.stock_id, product_stock.stock_qty');
            $this->db->from('product_stock');
            $this->db->join('products', 'products.product_id = product_stock.product_id', 'left');
            $this->db->where(array('products.deleted' => 0, 'product_stock.deleted' => 0, 'product_stock.stock_id' => $iStockID));
            $query = $this->db->get();
            $this->db->close();
            return $query->result();
        } 
    }

    public function updateProductStock(){
        if($_REQUEST['userID'] && $_REQUEST['stockID']){
            $iStockID = $_REQUEST['stockID'];
            $iProductID = $_REQUEST['stockProductId'];
            $iStockQty = $_REQUEST['stockQuantity'];
            $this->db->reconnect();
            $this->db->where(array('product_id' => $iProductID,'stock_id' => $iStockID, 'deleted'=> 0));
            $this->db->update('product_stock', array( 'stock_qty' => $iStockQty ));
            // var_dump($this->db->last_query());// to print last executed query
            $result = $this->db->affected_rows();
            $this->db->close();
            return $result;
        }
    }

    public function isStockExist(){
        if($_REQUEST['userID']){
            $iStockProductID = (int)$_REQUEST['stockProductId'];
            $this->db->reconnect();
            $this->db->select('product_stock.product_id, product_stock.stock_id, product_stock.stock_qty');
            $this->db->from('product_stock');
            $this->db->where(array('product_stock.deleted' => 0, 'product_stock.product_id' => $iStockProductID));
            $query = $this->db->get();
            $this->db->close();
            return $query->result();
        } 
    }

    public function updateProductStockQty($iStockID, $stockQuantity){
        if($_REQUEST['userID'] && $iStockID > 0){
            $iProductID = (int)$_REQUEST['stockProductId'];
            $iStockQty = (int)$_REQUEST['stockQuantity'] + (int)$stockQuantity;
            $this->db->reconnect();
            $this->db->where(array('product_id' => $iProductID,'stock_id' => (int)$iStockID, 'deleted'=> 0));
            $this->db->update('product_stock', array( 'stock_qty' => (int)$iStockQty ));
            // var_dump($this->db->last_query());// to print last executed query
            $result = $this->db->affected_rows();
            $this->db->close();
            return $result;
        }
    }

    public function deleteProductStockByStockID(){
        if($_POST['userID'] && $_POST['stockID'] > 0){
            $stockID = $_POST['stockID'];           
            $this->db->reconnect();
            $array = array(                
                'deleted' => 1
            );     
            $this->db->reconnect();
            $this->db->where('stock_id', $stockID);
            $result = $this->db->update('product_stock', $array);
            // var_dump($this->db->last_query());// to print last executed query
            $this->db->close();
            return $result;
        } 
    }

    public function getShoppingProducts(){
        if($_REQUEST['userID']){
            $searchTerm = $_REQUEST['searchTerm'];
            $searchOrderBy = ($_REQUEST['searchOrderBy'] == 'rate') ? 'product_attributes.rate' : 'products.product_name';
            $this->db->reconnect();
            $this->db->select('products.product_id, products.product_name, products.product_img_name, product_stock.stock_id, product_stock.stock_qty, product_attributes.hsn_code, product_attributes.quantity, product_attributes.unit, product_attributes.rate, product_attributes.is_offer_avilable ,product_attributes.offer_rate ,product_attributes.effective_from_date, product_attributes.effective_till_date');
            $this->db->from('product_stock');
            $this->db->join('products', 'products.product_id = product_stock.product_id', 'left');
            $this->db->join('product_attributes', 'product_attributes.product_id = product_stock.product_id', 'left');
            if($searchTerm){
                $this->db->like('LOWER(products.product_name)', strtolower($searchTerm), 'both');
            }
            $this->db->where(array('products.deleted' => 0, 'product_stock.deleted' => 0, 'product_attributes.deleted' => 0));
            $this->db->order_by($searchOrderBy, "asc");
            $query = $this->db->get();
            // var_dump($this->db->last_query());// to print last executed query
            $this->db->close();
            return $query->result();
        }
    }

    //Update old stock while updating bill
    public function productStockReImbersement($iBillID){
        $bResult = false;
        if($_REQUEST['userID'] && $iBillID > 0){
            $this->db->reconnect();
            $this->db->select('item_product_id, bill_quantity, bill_unit');
            // $this->db->from('bill_items');
            $queryGetItems = $this->db->get_where('bill_items', array('bill_id' => (int)$iBillID, 'deleted' => 0));
            $this->db->close();
            $aItems = $queryGetItems->result();
            $iItemCount = COUNT($aItems);
            //Reimberse Stock qty
            $iAffectedRows = 0;
            if($iItemCount > 0){
                $this->db->reconnect();
                foreach ($aItems as $key => $value) {
                    $iNewStockQty = 0;
                    if($value->bill_unit == 'Dozen'){
                        $iNewStockQty = 12 * $value->bill_quantity;
                    }else{
                        $iNewStockQty = 1 * $value->bill_quantity;
                    }
                    $iNewStockQty = 'stock_qty+'.$iNewStockQty;

                    $this->db->where(array('product_id' => (int)$value->item_product_id, 'deleted'=> 0));
                    $this->db->set('stock_qty', $iNewStockQty, FALSE);
                    $this->db->update('product_stock');
                    $iAffectedRows += $this->db->affected_rows(); 
                    // var_dump($this->db->last_query());// to print last executed query
                }
                $this->db->close();              
            }

            $iAffRows = 0;
            if($iAffectedRows > 0){
                $this->db->reconnect();
                $this->db->where(array('bill_id' => (int)$iBillID, ));
                $this->db->update('bill_items', array( 'deleted'=> 1 ));
                $iAffRows += $this->db->affected_rows();
                $this->db->close();              
            }
            if($iAffRows > 0){
                $bResult = true;
            }
        }
        return $bResult;
    }

    public function checkUpdatingItemStock($iBillID, $aItem){
        $aData =array();
        $this->db->reconnect();
        $this->db->select('item_product_id, bill_quantity, bill_unit');
        $this->db->from('bill_items');
        $this->db->where( array('bill_id' => (int)$iBillID, 'deleted' => 0) );
        $queryGetItems = $this->db->get();
        // var_dump($this->db->last_query());// to print last executed query
        $this->db->close();
        $aOldItems = $queryGetItems->result();
        // var_dump("aOldItems : ", $aOldItems);

        $aChkItem = array();
        foreach ($aOldItems as $key => $value) {
            $iProductID = $value->item_product_id;
            if( array_key_exists( $iProductID, $aChkItem ) ){
                if($value->bill_unit == 'Dozen'){
                    $aChkItem[$iProductID]['iItemQty'] += (12 * $value->bill_quantity);
                    $aChkItem[$iProductID]['iProductId'] = $iProductID;
                }else{
                    $aChkItem[$iProductID]['iItemQty'] += (1 * $value->bill_quantity);
                    $aChkItem[$iProductID]['iProductId'] = $iProductID;
                }
            }else{
                if($value->bill_unit == 'Dozen'){
                    $aChkItem[$iProductID]['iItemQty'] = (12 * $value->bill_quantity);
                    $aChkItem[$iProductID]['iProductId'] = $iProductID;
                }else{
                    $aChkItem[$iProductID]['iItemQty'] = (1 * $value->bill_quantity);
                    $aChkItem[$iProductID]['iProductId'] = $iProductID;
                }
            }
        }

        if ( COUNT($aItem) > 0) {
            $iProductId = $aItem['iProductId'];
            $iItemQty = 0;
            // var_dump("aChkItem : ", $aChkItem);
            if( array_key_exists( $iProductId, $aChkItem) ){                
                $iItemQty = abs($aChkItem[$iProductId]['iItemQty'] - $aItem['iItemQty']);
            }else{
                $iItemQty = $aItem['iItemQty'];
            }
            // var_dump("iProductId : ", $iProductId);
            // var_dump("iItemQty : ", $iProductId);
            $this->db->reconnect();
            $this->db->from('product_stock');
            $this->db->where(array( 'product_id' => (int)$iProductId, 'stock_qty >=' => (int)$iItemQty, 'deleted' => 0));
            $iCount = $this->db->count_all_results();
            $this->db->close();
            // var_dump($this->db->last_query());// to print last executed query
            if($iCount < 1){               
                return false;
            }else{
                return true;
            }
        }
    }
}
