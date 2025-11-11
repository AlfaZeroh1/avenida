<?php 
require_once("PurchaseordersDBO.php");
require_once("../../../modules/proc/purchaseorderdetails/PurchaseorderdetailsDBO.php");
class Purchaseorders
{				
	var $id;			
	var $projectid;			
	var $documentno;			
	var $requisitionno;			
	var $supplierid;			
	var $remarks;			
	var $orderedon;	
	var $currencyid;
	var $rate;
	var $eurorate;
	var $file;
	var $status;
	var $type;
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
		if(empty($obj->projectid))
			$obj->projectid='NULL';
		$this->projectid=$obj->projectid;
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->requisitionno=str_replace("'","\'",$obj->requisitionno);
		if(empty($obj->supplierid))
			$obj->supplierid='NULL';
		$this->supplierid=$obj->supplierid;
		if(empty($obj->currencyid))
			$obj->currencyid='NULL';
		$this->currencyid=$obj->currencyid;
		$this->status=$obj->status;
		$this->type=$obj->type;
		$this->rate=str_replace("'","\'",$obj->rate);
		$this->eurorate=str_replace("'","\'",$obj->eurorate);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->orderedon=str_replace("'","\'",$obj->orderedon);
		$this->file=str_replace("'","\'",$obj->file);
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

	//get projectid
	function getProjectid(){
		return $this->projectid;
	}
	//set projectid
	function setProjectid($projectid){
		$this->projectid=$projectid;
	}

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get requisitionno
	function getRequisitionno(){
		return $this->requisitionno;
	}
	//set requisitionno
	function setRequisitionno($requisitionno){
		$this->requisitionno=$requisitionno;
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

	//get orderedon
	function getOrderedon(){
		return $this->orderedon;
	}
	//set orderedon
	function setOrderedon($orderedon){
		$this->orderedon=$orderedon;
	}

	//get file
	function getFile(){
		return $this->file;
	}
	//set file
	function setFile($file){
		$this->file=$file;
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
			if($purchaseordersDBO->persist($obj)){	
			
			require_once("../../pm/tasks/Tasks_class.php");
			$obj->module="proc";
			$obj->role="purchaseorders";
			
			
			if($obj->type=="cash"){
			  $tasks = new Tasks();
			  $tasks->workFlow($obj);
			}
				$purchaseorderdetails = new Purchaseorderdetails();
				$obj->purchaseorderid=$purchaseordersDBO->id;
				$purchaseorderdetails->add($obj,$shop);

				$this->id=$purchaseordersDBO->id;
				$this->sql=$purchaseordersDBO->sql;
			}
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$purchaseordersDBO = new PurchaseordersDBO();
		
		$purchaseorders  = new Purchaseorders();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where documentno='$obj->documentno'";
		$purchaseorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$purchaseorders=$purchaseorders->fetchObject;
		
		$purchaseorderdetails = new Purchaseorderdetails();
		$where=" where purchaseorderid='$purchaseorders->id' ";
		$purchaseorderdetails->delete($obj,$where);		
		
		//first delete all records under old documentno
		$where=" where documentno='$obj->documentno'";
		$purchaseordersDBO->delete($obj,$where);

		if($this->add($obj,$shop))
		  return true;		
	}	
	
	function checkReceived($obj){
		$purchaseorders  = new Purchaseorders();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where documentno='$obj->documentno'";
		$purchaseorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$purchaseorders=$purchaseorders->fetchObject;
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
		if(empty($obj->documentno)){
			$error="Document No. should be provided";
		}else if(empty($obj->supplierid)){
			$error="Supplier should be provided";
		}else if(empty($obj->orderedon)){
			$error="Order On should be provided";
		}else if(empty($obj->currencyid)){
			$error="Currency should be provided";
		}else if(empty($obj->rate)){
			$error="Rate should be provided";
		}else if(empty($obj->eurorate)){
			$error="Euro rate should be provided";
		}else if(empty($obj->memo)){
			$error="Memo should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->documentno)){
			$error="Document No. should be provided";
		}else if(empty($obj->supplierid)){
			$error="Supplier should be provided";
		}else if(empty($obj->orderedon)){
			$error="Order On should be provided";
		}else if(empty($obj->currencyid)){
			$error="Currency should be provided";
		}else if(empty($obj->rate)){
			$error="Rate should be provided";
		}else if(empty($obj->eurorate)){
			$error="Euro rate should be provided";
		}else if(empty($obj->memo)){
			$error="Memo should be provided";
		}	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
