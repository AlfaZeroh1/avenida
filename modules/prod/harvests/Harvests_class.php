<?php 
require_once("HarvestsDBO.php");
class Harvests
{				
	var $id;			
	var $varietyid;			
	var $sizeid;			
	var $plantingdetailid;			
	var $greenhouseid;			
	var $quantity;			
	var $harvestedon;			
	var $employeeid;			
	var $barcode;			
	var $remarks;			
	var $status;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $harvestsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->varietyid))
			$obj->varietyid='NULL';
		$this->varietyid=$obj->varietyid;
		if(empty($obj->sizeid))
			$obj->sizeid='NULL';
		$this->sizeid=$obj->sizeid;
		if(empty($obj->plantingdetailid))
			$obj->plantingdetailid='NULL';
		$this->plantingdetailid=$obj->plantingdetailid;
		if(empty($obj->greenhouseid))
			$obj->greenhouseid='NULL';
		$this->greenhouseid=$obj->greenhouseid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->harvestedon=str_replace("'","\'",$obj->harvestedon);
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->barcode=str_replace("'","\'",$obj->barcode);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->status=str_replace("'","\'",$obj->status);
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

	//get varietyid
	function getVarietyid(){
		return $this->varietyid;
	}
	//set varietyid
	function setVarietyid($varietyid){
		$this->varietyid=$varietyid;
	}

	//get sizeid
	function getSizeid(){
		return $this->sizeid;
	}
	//set sizeid
	function setSizeid($sizeid){
		$this->sizeid=$sizeid;
	}

	//get plantingdetailid
	function getPlantingdetailid(){
		return $this->plantingdetailid;
	}
	//set plantingdetailid
	function setPlantingdetailid($plantingdetailid){
		$this->plantingdetailid=$plantingdetailid;
	}

	//get greenhouseid
	function getGreenhouseid(){
		return $this->greenhouseid;
	}
	//set greenhouseid
	function setGreenhouseid($greenhouseid){
		$this->greenhouseid=$greenhouseid;
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

	function add($obj,$shop){
		$harvestsDBO = new HarvestsDBO();
			$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->varietyid=$shop[$i]['varietyid'];
			$obj->varietyname=$shop[$i]['varietyname'];
			$obj->sizeid=$shop[$i]['sizeid'];
			$obj->sizename=$shop[$i]['sizename'];
			$obj->plantingdetailid=$shop[$i]['plantingdetailid'];
			$obj->plantingdetailname=$shop[$i]['plantingdetailname'];
			$obj->greenhouseid=$shop[$i]['greenhouseid'];
			$obj->areaname=$shop[$i]['areaname'];
			$obj->quantity=$shop[$i]['quantity'];

			//this deletes the first element in the array
			if($i<$obj->iterator-1)
				$shop=array_slice($shop,1);

			if($harvestsDBO->persist($obj)){
				//$this->sql=$harvestsDBO->sql;
				
				//record variety stocks
				$varietystocks = new Varietystocks();
				
				$obj->recordedon=date("Y-m-d");
				$obj->actedon=$obj->harvestedon;
				
				if($obj->status=="checkedin" or $obj->status=="return" or $obj->status=="stocktake")
				  $varietystocks->addStock($obj);
				else
				  $varietystocks->reduceStock($obj);
			}
			$i++;
		}
		return true;		
	}			
	function edit($obj,$where="",$shop){
		$harvestsDBO = new HarvestsDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->olddocumentno' and mode='$obj->oldmode'";
		$harvestsDBO->delete($obj,$where);

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->olddocumentno' and transactionid='2' mode='$obj->oldmode' ";
		$gn->delete($obj,$where);

		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->varietyid=$shop['varietyid'];
			$obj->varietyname=$shop['varietyname'];
			$obj->sizeid=$shop['sizeid'];
			$obj->sizename=$shop['sizename'];
			$obj->plantingdetailid=$shop['plantingdetailid'];
			$obj->plantingdetailname=$shop['plantingdetailname'];
			$obj->greenhouseid=$shop['greenhouseid'];
			$obj->areaname=$shop['areaname'];
			$obj->quantity=$shop['quantity'];
			if($harvestsDBO->update($obj,$where)){
				$this->sql=$harvestsDBO->sql;
			}
		}
		return true;	
	}			
	function delete($obj,$where=""){			
		$harvestsDBO = new HarvestsDBO();
		if($harvestsDBO->delete($obj,$where=""))		
			$this->sql=$harvestsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$harvestsDBO = new HarvestsDBO();
		$this->table=$harvestsDBO->table;
		$harvestsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$harvestsDBO->sql;
		$this->result=$harvestsDBO->result;
		$this->fetchObject=$harvestsDBO->fetchObject;
		$this->affectedRows=$harvestsDBO->affectedRows;
	}			
	function validate($obj){
		$status="";
		if($obj->status=="checkedin"){
		  $status="Harvest Check-In";
		}
		if($obj->status=="checkedout"){
		  $status="Harvest Check-out";
		}
		if($obj->status=="return"){
		  $status="Pre-cool Returns";
		}
		if($obj->status=="stocktake"){
		  $status="Pre-cool Stock Take";
		}
		
		$ipaddress = new Ipaddress();
		$fields=" * ";
		$join="";
		$groupby="";
		$having="";
		$where=" where task='$status' and ipaddress='$obj->ipaddress'";
		$ipaddress->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		
		if(empty($obj->varietyid)){
			$error="Variety should be provided";
		}
		/*else if(empty($obj->sizeid)){
			$error="Sizes should be provided";
		}*//*
		else if(empty($obj->plantingdetailid)){
			$error="Planting Detail should be provided";
		}*/
		else if(empty($obj->greenhouseid)){
			$error="Area should be provided";
		}
		else if(empty($obj->quantity)){
			$error="Quantity should be provided";
		}
		else if(empty($obj->harvestedon)){
			$error="Date Harvested should be provided";
		}
		else if($ipaddress->affectedRows<=0){
			$error="Computer not allowed to do $status";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){	
	
		$status="";
		if($obj->status=="checkedin"){
		  $status="Harvest Check-In";
		}
		if($obj->status=="checkedout"){
		  $status="Harvest Check-out";
		}
		if($obj->status=="return"){
		  $status="Pre-cool Returns";
		}
		if($obj->status=="stocktake"){
		  $status="Pre-cool Stock Take";
		}
		
		$ipaddress = new Ipaddress();
		$fields=" * ";
		$join="";
		$groupby="";
		$having="";
		$where=" where task='$status' and ipaddress='$obj->ipaddress'";
		$ipaddress->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		
		if(empty($obj->harvestedon)){
			$error="Date Harvested should be provided";
		}
		
		else if($ipaddress->affectedRows<=0){
			$error="Computer not allowed to do $status";
		}
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
