<?php 
require_once("PurchaseordersDBO.php");
class Purchaseorders
{				
	var $id;			
	var $itemid;			
	var $documentno;			
	var $requisionno;			
	var $supplierid;			
	var $remarks;			
	var $quantity;			
	var $costprice;			
	var $tradeprice;			
	var $tax;			
	var $total;			
	var $memo;			
	var $orderedon;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $purchaseordersDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->itemid=str_replace("'","\'",$obj->itemid);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->requisionno=str_replace("'","\'",$obj->requisionno);
		$this->supplierid=str_replace("'","\'",$obj->supplierid);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->costprice=str_replace("'","\'",$obj->costprice);
		$this->tradeprice=str_replace("'","\'",$obj->tradeprice);
		$this->tax=str_replace("'","\'",$obj->tax);
		$this->total=str_replace("'","\'",$obj->total);
		$this->memo=str_replace("'","\'",$obj->memo);
		$this->orderedon=str_replace("'","\'",$obj->orderedon);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		return $this;
	
	}
	//get id
	function getId(){
		return $this->id;
	}
	//set id
	function setId($id){
		$this->id=$id;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get requisionno
	function getRequisionno(){
		return $this->requisionno;
	}
	//set requisionno
	function setRequisionno($requisionno){
		$this->requisionno=$requisionno;
	}

	//get supplierid
	function getSupplierid(){
		return $this->supplierid;
	}
	//set supplierid
	function setSupplierid($supplierid){
		$this->supplierid=$supplierid;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get costprice
	function getCostprice(){
		return $this->costprice;
	}
	//set costprice
	function setCostprice($costprice){
		$this->costprice=$costprice;
	}

	//get tradeprice
	function getTradeprice(){
		return $this->tradeprice;
	}
	//set tradeprice
	function setTradeprice($tradeprice){
		$this->tradeprice=$tradeprice;
	}

	//get tax
	function getTax(){
		return $this->tax;
	}
	//set tax
	function setTax($tax){
		$this->tax=$tax;
	}

	//get total
	function getTotal(){
		return $this->total;
	}
	//set total
	function setTotal($total){
		$this->total=$total;
	}

	//get memo
	function getMemo(){
		return $this->memo;
	}
	//set memo
	function setMemo($memo){
		$this->memo=$memo;
	}

	//get orderedon
	function getOrderedon(){
		return $this->orderedon;
	}
	//set orderedon
	function setOrderedon($orderedon){
		$this->orderedon=$orderedon;
	}

	//get createdby
	function getCreatedby(){
		return $this->createdby;
	}
	//set createdby
	function setCreatedby($createdby){
		$this->createdby=$createdby;
	}

	//get createdon
	function getCreatedon(){
		return $this->createdon;
	}
	//set createdon
	function setCreatedon($createdon){
		$this->createdon=$createdon;
	}

	//get lasteditedby
	function getLasteditedby(){
		return $this->lasteditedby;
	}
	//set lasteditedby
	function setLasteditedby($lasteditedby){
		$this->lasteditedby=$lasteditedby;
	}

	//get lasteditedon
	function getLasteditedon(){
		return $this->lasteditedon;
	}
	//set lasteditedon
	function setLasteditedon($lasteditedon){
		$this->lasteditedon=$lasteditedon;
	}

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	function add($obj,$shop){
		$purchaseordersDBO = new PurchaseordersDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->quantity=$shop[$i]['quantity'];
			$obj->itemid=$shop[$i]['itemid'];
			$obj->remarks=$shop[$i]['remarks'];
			if($purchaseordersDBO->persist($obj)){		
				$this->id=$purchaseordersDBO->id;
				$this->sql=$purchaseordersDBO->sql;
			}
			$i++;
		}
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$purchaseordersDBO = new PurchaseordersDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->olddocumentno' and mode='$obj->oldmode'";
		$purchaseordersDBO->delete($obj,$where);

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->olddocumentno' and transactionid='2' mode='$obj->oldmode' ";
		$gn->delete($obj,$where);

		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->quantity=$shop['quantity'];
			$obj->itemid=$shop['itemid'];
			$obj->remarks=$shop['remarks'];
			if($purchaseordersDBO->update($obj,$where)){
				$this->sql=$purchaseordersDBO->sql;
			}
		}
		return true;	
	}			
	function delete($obj,$where=""){			
		$purchaseordersDBO = new PurchaseordersDBO();
		if($purchaseordersDBO->delete($obj,$where=""))		
			$this->sql=$purchaseordersDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$purchaseordersDBO = new PurchaseordersDBO();
		$this->table=$purchaseordersDBO->table;
		$purchaseordersDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$purchaseordersDBO->sql;
		$this->result=$purchaseordersDBO->result;
		$this->fetchObject=$purchaseordersDBO->fetchObject;
		$this->affectedRows=$purchaseordersDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->id)){
			$error=" should be provided";
		}
		else if(empty($obj->documentno)){
			$error="Document No. should be provided";
		}
		else if(empty($obj->supplierid)){
			$error="Supplier should be provided";
		}
		else if(empty($obj->quantity)){
			$error="Quantity should be provided";
		}
		else if(empty($obj->costprice)){
			$error="Cost Price should be provided";
		}
		else if(empty($obj->tradeprice)){
			$error="Trade Price should be provided";
		}
		else if(empty($obj->tax)){
			$error="Tax should be provided";
		}
		else if(empty($obj->total)){
			$error="Total should be provided";
		}
		else if(empty($obj->orderedon)){
			$error="Order On should be provided";
		}
		else if(empty($obj->createdby)){
			$error="CreatedBy should be provided";
		}
		else if(empty($obj->createdon)){
			$error="CreatedOn should be provided";
		}
		else if(empty($obj->lasteditedby)){
			$error="LastEditedBy should be provided";
		}
		else if(empty($obj->lasteditedon)){
			$error="LastEditedOn should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->documentno)){
			$error="Document No. should be provided";
		}
		else if(empty($obj->supplierid)){
			$error="Supplier should be provided";
		}
		else if(empty($obj->orderedon)){
			$error="Order On should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
