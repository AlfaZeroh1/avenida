<?php 
require_once("BreederdeliverysDBO.php");
require_once("../../../modules/prod/breederdeliverydetails/BreederdeliverydetailsDBO.php");
class Breederdeliverys
{				
	var $id;			
	var $documentno;			
	var $breederid;			
	var $deliveredon;			
	var $week;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $breederdeliverysDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		if(empty($obj->breederid))
			$obj->breederid='NULL';
		$this->breederid=$obj->breederid;
		$this->deliveredon=str_replace("'","\'",$obj->deliveredon);
		$this->week=str_replace("'","\'",$obj->week);
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

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get breederid
	function getBreederid(){
		return $this->breederid;
	}
	//set breederid
	function setBreederid($breederid){
		$this->breederid=$breederid;
	}

	//get deliveredon
	function getDeliveredon(){
		return $this->deliveredon;
	}
	//set deliveredon
	function setDeliveredon($deliveredon){
		$this->deliveredon=$deliveredon;
	}

	//get week
	function getWeek(){
		return $this->week;
	}
	//set week
	function setWeek($week){
		$this->week=$week;
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
		$breederdeliverysDBO = new BreederdeliverysDBO();
			if($breederdeliverysDBO->persist($obj)){		
				$breederdeliverydetails = new Breederdeliverydetails();
				$obj->breederdeliveryid=$breederdeliverysDBO->id;
				$breederdeliverydetails->add($obj,$shop);

				$this->id=$breederdeliverysDBO->id;
				$this->sql=$breederdeliverysDBO->sql;
			}
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$breederdeliverysDBO = new BreederdeliverysDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->olddocumentno' and mode='$obj->oldmode'";
		$breederdeliverysDBO->delete($obj,$where);

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->olddocumentno' and transactionid='2' mode='$obj->oldmode' ";
		$gn->delete($obj,$where);

		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->varietyid=$shop['varietyid'];
			$obj->quantity=$shop['quantity'];
			$obj->memo=$shop['memo'];
			if($breederdeliverysDBO->update($obj,$where)){
				$this->sql=$breederdeliverysDBO->sql;
			}
		}
		return true;	
	}			
	function delete($obj,$where=""){			
		$breederdeliverysDBO = new BreederdeliverysDBO();
		if($breederdeliverysDBO->delete($obj,$where=""))		
			$this->sql=$breederdeliverysDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$breederdeliverysDBO = new BreederdeliverysDBO();
		$this->table=$breederdeliverysDBO->table;
		$breederdeliverysDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$breederdeliverysDBO->sql;
		$this->result=$breederdeliverysDBO->result;
		$this->fetchObject=$breederdeliverysDBO->fetchObject;
		$this->affectedRows=$breederdeliverysDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->breederid)){
			$error="Breeder should be provided";
		}
		else if(empty($obj->week)){
			$error="Calendar Week should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->breederid)){
			$error="Breeder should be provided";
		}
		else if(empty($obj->week)){
			$error="Calendar Week should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
