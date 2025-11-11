<?php 
require_once("ReturnnotesDBO.php");
require_once("../../../modules/inv/returnnotedetails/ReturnnotedetailsDBO.php");

class Returnnotes
{				
	var $id;			
	var $supplierid;			
	var $documentno;			
	var $purchaseno;			
	var $purchasemodeid;			
	var $returnedon;			
	var $memo;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $projectid;			
	var $returnnotesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->supplierid))
			$obj->supplierid='NULL';
		$this->supplierid=$obj->supplierid;
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->purchaseno=str_replace("'","\'",$obj->purchaseno);
		if(empty($obj->purchasemodeid))
			$obj->purchasemodeid='NULL';
		$this->purchasemodeid=$obj->purchasemodeid;
		$this->returnedon=str_replace("'","\'",$obj->returnedon);
		$this->memo=str_replace("'","\'",$obj->memo);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		if(empty($obj->projectid))
			$obj->projectid='NULL';
		$this->projectid=$obj->projectid;
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

	//get supplierid
	function getSupplierid(){
		return $this->supplierid;
	}
	//set supplierid
	function setSupplierid($supplierid){
		$this->supplierid=$supplierid;
	}

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get purchaseno
	function getPurchaseno(){
		return $this->purchaseno;
	}
	//set purchaseno
	function setPurchaseno($purchaseno){
		$this->purchaseno=$purchaseno;
	}

	//get purchasemodeid
	function getPurchasemodeid(){
		return $this->purchasemodeid;
	}
	//set purchasemodeid
	function setPurchasemodeid($purchasemodeid){
		$this->purchasemodeid=$purchasemodeid;
	}

	//get returnedon
	function getReturnedon(){
		return $this->returnedon;
	}
	//set returnedon
	function setReturnedon($returnedon){
		$this->returnedon=$returnedon;
	}

	//get memo
	function getMemo(){
		return $this->memo;
	}
	//set memo
	function setMemo($memo){
		$this->memo=$memo;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
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

	//get projectid
	function getProjectid(){
		return $this->projectid;
	}
	//set projectid
	function setProjectid($projectid){
		$this->projectid=$projectid;
	}

	function add($obj,$shop){
		$returnnotesDBO = new ReturnnotesDBO();
			if($returnnotesDBO->persist($obj)){		
				$returnnotedetails = new Returnnotedetails();
				$obj->returnnoteid=$returnnotesDBO->id;
				$returnnotedetails->add($obj,$shop);

				$this->id=$returnnotesDBO->id;
				$this->sql=$returnnotesDBO->sql;
			}
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$returnnotesDBO = new ReturnnotesDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->olddocumentno' and mode='$obj->oldmode'";
		$returnnotesDBO->delete($obj,$where);

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->olddocumentno' and transactionid='2' mode='$obj->oldmode' ";
		$gn->delete($obj,$where);

		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->remarks=$shop['remarks'];
			$obj->itemid=$shop['itemid'];
			$obj->quantity=$shop['quantity'];
			$obj->costprice=$shop['costprice'];
			$obj->tax=$shop['tax'];
			$obj->discount=$shop['discount'];
			$obj->total=$shop['total'];
			if($returnnotesDBO->update($obj,$where)){
				$this->sql=$returnnotesDBO->sql;
			}
		}
		return true;	
	}			
	function delete($obj,$where=""){			
		$returnnotesDBO = new ReturnnotesDBO();
		if($returnnotesDBO->delete($obj,$where=""))		
			$this->sql=$returnnotesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$returnnotesDBO = new ReturnnotesDBO();
		$this->table=$returnnotesDBO->table;
		$returnnotesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$returnnotesDBO->sql;
		$this->result=$returnnotesDBO->result;
		$this->fetchObject=$returnnotesDBO->fetchObject;
		$this->affectedRows=$returnnotesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->supplierid)){
			$error="Supplier should be provided";
		}
		else if(empty($obj->purchasemodeid)){
			$error="Mode Of Payment should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->supplierid)){
			$error="Supplier should be provided";
		}
		else if(empty($obj->purchasemodeid)){
			$error="Mode Of Payment should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
