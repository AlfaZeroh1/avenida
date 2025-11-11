<?php 
require_once("CustomerseasonsDBO.php");
class Customerseasons
{				
	var $id;			
	var $customerid;			
	var $seasonid;			
	var $startdate;			
	var $enddate;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $customerseasonsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->customerid))
			$obj->customerid='NULL';
		$this->customerid=$obj->customerid;
		if(empty($obj->seasonid))
			$obj->seasonid='NULL';
		$this->seasonid=$obj->seasonid;
		$this->startdate=str_replace("'","\'",$obj->startdate);
		$this->enddate=str_replace("'","\'",$obj->enddate);
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

	//get customerid
	function getCustomerid(){
		return $this->customerid;
	}
	//set customerid
	function setCustomerid($customerid){
		$this->customerid=$customerid;
	}

	//get seasonid
	function getSeasonid(){
		return $this->seasonid;
	}
	//set seasonid
	function setSeasonid($seasonid){
		$this->seasonid=$seasonid;
	}

	//get startdate
	function getStartdate(){
		return $this->startdate;
	}
	//set startdate
	function setStartdate($startdate){
		$this->startdate=$startdate;
	}

	//get enddate
	function getEnddate(){
		return $this->enddate;
	}
	//set enddate
	function setEnddate($enddate){
		$this->enddate=$enddate;
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

	function add($obj){
		$customerseasonsDBO = new CustomerseasonsDBO();
		if($customerseasonsDBO->persist($obj)){
			$this->id=$customerseasonsDBO->id;
			$this->sql=$customerseasonsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$customerseasonsDBO = new CustomerseasonsDBO();
		if($customerseasonsDBO->update($obj,$where)){
			$this->sql=$customerseasonsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$customerseasonsDBO = new CustomerseasonsDBO();
		if($customerseasonsDBO->delete($obj,$where=""))		
			$this->sql=$customerseasonsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$customerseasonsDBO = new CustomerseasonsDBO();
		$this->table=$customerseasonsDBO->table;
		$customerseasonsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$customerseasonsDBO->sql;
		$this->result=$customerseasonsDBO->result;
		$this->fetchObject=$customerseasonsDBO->fetchObject;
		$this->affectedRows=$customerseasonsDBO->affectedRows;
	}		
	function getCustomerSeason($customerid,$date){
	  $customerseasons = new Customerseasons();
	  $fields="*";
	  $join="";
	  $orderby="";
	  $groupby="";
	  $having="";
	  $where=" where startdate<='$date' and enddate>='$date' and customerid='$customerid'";
	  $customerseasons->retrieve($fields,$join,$where,$having,$orderby);//echo $customerseasons->sql;
	  if($customerseasons->affectedRows>0){
	    
	  }
	  return $customerseasons->fetchObject;
	  
	}
	function validate($obj){
		if(empty($obj->customerid)){
			$error="Customer should be provided";
		}
		else if(empty($obj->seasonid)){
			$error="Season should be provided";
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
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
