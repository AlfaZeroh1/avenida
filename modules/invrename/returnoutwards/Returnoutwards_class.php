<?php 
require_once("ReturnoutwardsDBO.php");
//require_once("../modules/inv/returnoutwarddetails/ReturnoutwarddetailsDBO.php");
class Returnoutwards
{				
	var $id;			
	var $supplierid;			
	var $storeid;	
	var $types;
	var $documentno;			
	var $purchaseno;			
	var $purchasemodeid;
	var $currencyid;
	var $exchangerate;
	var $exchangerate2;
	var $returnedon;			
	var $memo;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $projectid;			
	var $returnoutwardsDBO;
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
		if(empty($obj->storeid))
			$obj->storeid='NULL';
		$this->storeid=$obj->storeid;
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->purchaseno=str_replace("'","\'",$obj->purchaseno);
		if(empty($obj->purchasemodeid))
			$obj->purchasemodeid='NULL';
		$this->purchasemodeid=$obj->purchasemodeid;
		$this->currencyid=$obj->currencyid;
		$this->exchangerate=$obj->exchangerate;
                $this->exchangerate2=$obj->exchangerate2;
		$this->returnedon=str_replace("'","\'",$obj->returnedon);
		$this->memo=str_replace("'","\'",$obj->memo);
		$this->types=str_replace("'","\'",$obj->types);
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

	//get storeid
	function getStoreid(){
		return $this->storeid;
	}
	//set storeid
	function setStoreid($storeid){
		$this->storeid=$storeid;
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
		$returnoutwardsDBO = new ReturnoutwardsDBO();
			if($returnoutwardsDBO->persist($obj)){		
				$returnoutwarddetails = new Returnoutwarddetails();
				$obj->returnoutwardid=$returnoutwardsDBO->id;
				$returnoutwarddetails->add($obj,$shop);

				$this->id=$returnoutwardsDBO->id;
				$this->sql=$returnoutwardsDBO->sql;
			}
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$returnoutwardsDBO = new ReturnoutwardsDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->olddocumentno' and mode='$obj->oldmode'";
		$returnoutwardsDBO->delete($obj,$where);

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->olddocumentno' and transactionid='2' mode='$obj->oldmode' ";
		$gn->delete($obj,$where);

		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->itemid=$shop['itemid'];
			$obj->quantity=$shop['quantity'];
			$obj->costprice=$shop['costprice'];
			$obj->tax=$shop['tax'];
			$obj->discount=$shop['discount'];
			$obj->total=$shop['total'];
			$obj->remarks=$shop['remarks'];
			if($returnoutwardsDBO->update($obj,$where)){
				$this->sql=$returnoutwardsDBO->sql;
			}
		}
		return true;	
	}			
	function delete($obj,$where=""){			
		$returnoutwardsDBO = new ReturnoutwardsDBO();
		if($returnoutwardsDBO->delete($obj,$where=""))		
			$this->sql=$returnoutwardsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$returnoutwardsDBO = new ReturnoutwardsDBO();
		$this->table=$returnoutwardsDBO->table;
		$returnoutwardsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$returnoutwardsDBO->sql;
		$this->result=$returnoutwardsDBO->result;
		$this->fetchObject=$returnoutwardsDBO->fetchObject;
		$this->affectedRows=$returnoutwardsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->supplierid)){
			$error="Supplier should be provided";
		}
		else if(empty($obj->purchasemodeid)){
			$error="Mode Of Payment should be provided";
		}
		else if(empty($obj->returnedon)){
			$error="Date Must be provided";
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
		else if(empty($obj->returnedon)){
			$error="Date Must be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
