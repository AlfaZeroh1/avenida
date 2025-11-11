<?php 
require_once("PlantingsDBO.php");
require_once("../../..//modules/prod/plantingdetails/PlantingdetailsDBO.php");
class Plantings
{				
	var $id;			
	var $documentno;			
	var $breederdeliveryid;			
	var $breederid;			
	var $plantedon;			
	var $week;			
	var $employeeid;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $plantingsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		if(empty($obj->breederdeliveryid))
			$obj->breederdeliveryid='NULL';
		$this->breederdeliveryid=$obj->breederdeliveryid;
		if(empty($obj->breederid))
			$obj->breederid='NULL';
		$this->breederid=$obj->breederid;
		$this->plantedon=str_replace("'","\'",$obj->plantedon);
		$this->week=str_replace("'","\'",$obj->week);
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
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

	//get breederdeliveryid
	function getBreederdeliveryid(){
		return $this->breederdeliveryid;
	}
	//set breederdeliveryid
	function setBreederdeliveryid($breederdeliveryid){
		$this->breederdeliveryid=$breederdeliveryid;
	}

	//get breederid
	function getBreederid(){
		return $this->breederid;
	}
	//set breederid
	function setBreederid($breederid){
		$this->breederid=$breederid;
	}

	//get plantedon
	function getPlantedon(){
		return $this->plantedon;
	}
	//set plantedon
	function setPlantedon($plantedon){
		$this->plantedon=$plantedon;
	}

	//get week
	function getWeek(){
		return $this->week;
	}
	//set week
	function setWeek($week){
		$this->week=$week;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
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
		$plantingsDBO = new PlantingsDBO();
			if($plantingsDBO->persist($obj)){		
				$plantingdetails = new Plantingdetails();
				$obj->plantingid=$plantingsDBO->id;
				$plantingdetails->add($obj,$shop);

				$this->id=$plantingsDBO->id;
				$this->sql=$plantingsDBO->sql;
			}
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$plantingsDBO = new PlantingsDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->olddocumentno' and mode='$obj->oldmode'";
		$plantingsDBO->delete($obj,$where);

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->olddocumentno' and transactionid='2' mode='$obj->oldmode' ";
		$gn->delete($obj,$where);

		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->varietyid=$shop['varietyid'];
			$obj->areaid=$shop['areaid'];
			$obj->quantity=$shop['quantity'];
			$obj->memo=$shop['memo'];
			if($plantingsDBO->update($obj,$where)){
				$this->sql=$plantingsDBO->sql;
			}
		}
		return true;	
	}			
	function delete($obj,$where=""){			
		$plantingsDBO = new PlantingsDBO();
		if($plantingsDBO->delete($obj,$where=""))		
			$this->sql=$plantingsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$plantingsDBO = new PlantingsDBO();
		$this->table=$plantingsDBO->table;
		$plantingsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$plantingsDBO->sql;
		$this->result=$plantingsDBO->result;
		$this->fetchObject=$plantingsDBO->fetchObject;
		$this->affectedRows=$plantingsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->breederdeliveryid)){
			$error="Breeder Delivery should be provided";
		}
		else if(empty($obj->breederid)){
			$error="Breeder should be provided";
		}
		else if(empty($obj->plantedon)){
			$error="Planting Date should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->breederdeliveryid)){
			$error="Breeder Delivery should be provided";
		}
		else if(empty($obj->breederid)){
			$error="Breeder should be provided";
		}
		else if(empty($obj->plantedon)){
			$error="Planting Date should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
