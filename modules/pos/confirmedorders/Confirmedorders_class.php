<?php 
require_once("ConfirmedordersDBO.php");
require_once("../../../modules/pos/confirmedorderdetails/ConfirmedorderdetailsDBO.php");
class Confirmedorders
{				
	var $id;			
	var $orderno;			
	var $customerid;
	var $consigneeid;
	var $orderedon;				
	var $confirmedon;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $confirmedordersDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->orderno=str_replace("'","\'",$obj->orderno);
		if(empty($obj->customerid))
			$obj->customerid='NULL';
		$this->customerid=$obj->customerid;
		if(empty($obj->consigneeid))
			$obj->consigneeid='NULL';
		$this->consigneeid=$obj->consigneeid;
		$this->orderedon=str_replace("'","\'",$obj->orderedon);
		$this->confirmedon=str_replace("'","\'",$obj->confirmedon);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
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

	//get orderno
	function getOrderno(){
		return $this->orderno;
	}
	//set orderno
	function setOrderno($orderno){
		$this->orderno=$orderno;
	}

	//get customerid
	function getCustomerid(){
		return $this->customerid;
	}
	//set customerid
	function setCustomerid($customerid){
		$this->customerid=$customerid;
	}

	//get orderedon
	function getOrderedon(){
		return $this->orderedon;
	}
	//set orderedon
	function setOrderedon($orderedon){
		$this->orderedon=$orderedon;
	}
	
	//get confirmedon
	function getConfirmedon(){
		return $this->confirmedon;
	}
	//set confirmedon
	function setConfirmedon($confirmedon){
		$this->confirmedon=$confirmedon;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
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

	function add($obj,$shop){
		$confirmedordersDBO = new ConfirmedordersDBO();
			if($confirmedordersDBO->persist($obj)){		
				$confirmedorderdetails = new Confirmedorderdetails();
				$obj->confirmedorderid=$confirmedordersDBO->id;
				$confirmedorderdetails->add($obj,$shop);

				$this->id=$confirmedordersDBO->id;
				$this->sql=$confirmedordersDBO->sql;
			}
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$confirmedordersDBO = new ConfirmedordersDBO();

		//first delete all records under old documentno
		$where=" where orderno='$obj->orderno'";
		$confirmedordersDBO->delete($obj,$where);
		
		$confirmedorders=new Confirmedorders();
		$where=" where orderno='$obj->orderno' ";
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$confirmedorderby="";
		$confirmedorders->retrieve($fields,$join,$where,$having,$groupby,$confirmedorderby);
		$confirmedorders=$confirmedorders->fetchObject;
		
		$where=" where confirmedorderid='$confirmedorders->id'";
		$confirmedorderdetails = new Confirmedorderdetails();
		$confirmedorderdetails->delete($obj,$where);

		$confirmedorders = new Confirmedorders();
		$confirmedorders->add($obj,$shop);

		
		return true;	
	}			
	function delete($obj,$where=""){			
		$confirmedordersDBO = new ConfirmedordersDBO();
		if($confirmedordersDBO->delete($obj,$where=""))		
			$this->sql=$confirmedordersDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$confirmedordersDBO = new ConfirmedordersDBO();
		$this->table=$confirmedordersDBO->table;
		$confirmedordersDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$confirmedordersDBO->sql;
		$this->result=$confirmedordersDBO->result;
		$this->fetchObject=$confirmedordersDBO->fetchObject;
		$this->affectedRows=$confirmedordersDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->customerid)){
			$error="Customer should be provided";
		}
		else if(empty($obj->orderedon)){
			$error="Date Ordered should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->customerid)){
			$error="Customer should be provided";
		}
		else if(empty($obj->orderedon)){
			$error="Date Ordered should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
