<?php 
require_once("RejectsDBO.php");
class Rejects
{				
	var $id;			
	var $rejecttypeid;			
	var $sizeid;
	var $greenhouseid;
	var $varietyid;			
	var $quantity;			
	var $harvestedon;			
	var $reportedon;			
	var $employeeid;			
	var $barcode;			
	var $remarks;			
	var $status;
	var $reduce;
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $rejectsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->rejecttypeid))
			$obj->rejecttypeid='NULL';
		$this->rejecttypeid=$obj->rejecttypeid;
		if(empty($obj->sizeid))
			$obj->sizeid='NULL';
		$this->sizeid=$obj->sizeid;
		if(empty($obj->greenhouseid))
			$obj->greenhouseid='NULL';
		$this->greenhouseid=$obj->greenhouseid;
		if(empty($obj->varietyid))
			$obj->varietyid='NULL';
		$this->varietyid=$obj->varietyid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->harvestedon=str_replace("'","\'",$obj->harvestedon);
		$this->reportedon=str_replace("'","\'",$obj->reportedon);
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->barcode=str_replace("'","\'",$obj->barcode);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->status=str_replace("'","\'",$obj->status);
		$this->reduce=str_replace("'","\'",$obj->reduce);
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

	//get rejecttypeid
	function getRejecttypeid(){
		return $this->rejecttypeid;
	}
	//set rejecttypeid
	function setRejecttypeid($rejecttypeid){
		$this->rejecttypeid=$rejecttypeid;
	}

	//get sizeid
	function getSizeid(){
		return $this->sizeid;
	}
	//set sizeid
	function setSizeid($sizeid){
		$this->sizeid=$sizeid;
	}
	
	//get greenhouseid
	function getGreenhouseid(){
		return $this->greenhouseid;
	}
	//set greenhouseid
	function setGreenhouseid($greenhouseid){
		$this->greenhouseid=$greenhouseid;
	}


	//get varietyid
	function getVarietyid(){
		return $this->varietyid;
	}
	//set varietyid
	function setVarietyid($varietyid){
		$this->varietyid=$varietyid;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get harvestedon
	function getHarvestedon(){
		return $this->harvestedon;
	}
	//set harvestedon
	function setHarvestedon($harvestedon){
		$this->harvestedon=$harvestedon;
	}

	//get reportedon
	function getReportedon(){
		return $this->reportedon;
	}
	//set reportedon
	function setReportedon($reportedon){
		$this->reportedon=$reportedon;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get barcode
	function getBarcode(){
		return $this->barcode;
	}
	//set barcode
	function setBarcode($barcode){
		$this->barcode=$barcode;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
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

	function add($obj, $shop){
		$rejectsDBO = new RejectsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		
		$obj->remarks=$obj->status;
		
		while($i<$num){
		  $obj->sizeid=$shop[$i]['sizeid'];
		  $obj->sizename=$shop[$i]['sizename'];
		  $obj->varietyid=$shop[$i]['varietyid'];
		  $obj->varietyname=$shop[$i]['varietyname'];
		  $obj->quantity=$shop[$i]['quantity'];
		  $obj->employeeid=$shop[$i]['employeeid'];
		  $obj->employeename=$shop[$i]['employeename'];
		  $obj->rejecttypeid=$shop[$i]['rejecttypeid'];
		  $obj->greenhouseid=$shop[$i]['greenhouseid'];
		  $obj->remarks=$shop[$i]['remarks'];
		  
		  $ob = $this->setObject($obj);
		  $i++;
		  if($rejectsDBO->persist($ob)){
		
			//record item stocks		
			if($obj->reduce=="reduce")
			{
			  $itemstocks = new Varietystocks();
			  $itemstocks->reduceStock($obj);
			}				
				
		}
	      }
	      
	      return true;
		
	}
	
	function edit($obj,$shop,$where=""){
		$rejectsDBO = new RejectsDBO();
		if($rejectsDBO->update($obj,$where)){
			$this->sql=$rejectsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$rejectsDBO = new RejectsDBO();
		if($rejectsDBO->delete($obj,$where=""))		
			$this->sql=$rejectsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$rejectsDBO = new RejectsDBO();
		$this->table=$rejectsDBO->table;
		$rejectsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$rejectsDBO->sql;
		$this->result=$rejectsDBO->result;
		$this->fetchObject=$rejectsDBO->fetchObject;
		$this->affectedRows=$rejectsDBO->affectedRows;
	}			
	function validate($obj){
		
		if(empty($obj->harvestedon)){
			$error="Date Harvested should be provided";
		}
// 		else if(empty($obj->employeeid)){
// 			$error="Employee should be provided";
// 		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->harvestedon)){
			$error="Date Harvested should be provided";
		}
		else if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
