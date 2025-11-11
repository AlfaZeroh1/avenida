<?php 
require_once("FleetmaintenancesDBO.php");
class Fleetmaintenances
{				
	var $id;			
	var $assetid;			
	var $maintenanceon;			
	var $startmileage;			
	var $endmileage;			
	var $supplierid;			
	var $purchasemodeid;			
	var $oiladded;			
	var $oilcost;			
	var $fueladded;			
	var $fuelcost;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $fleetmaintenancesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->assetid))
			$obj->assetid='NULL';
		$this->assetid=$obj->assetid;
		$this->maintenanceon=str_replace("'","\'",$obj->maintenanceon);
		$this->startmileage=str_replace("'","\'",$obj->startmileage);
		$this->endmileage=str_replace("'","\'",$obj->endmileage);
		if(empty($obj->supplierid))
			$obj->supplierid='NULL';
		$this->supplierid=$obj->supplierid;
		if(empty($obj->purchasemodeid))
			$obj->purchasemodeid='NULL';
		$this->purchasemodeid=$obj->purchasemodeid;
		$this->oiladded=str_replace("'","\'",$obj->oiladded);
		$this->oilcost=str_replace("'","\'",$obj->oilcost);
		$this->fueladded=str_replace("'","\'",$obj->fueladded);
		$this->fuelcost=str_replace("'","\'",$obj->fuelcost);
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

	//get assetid
	function getAssetid(){
		return $this->assetid;
	}
	//set assetid
	function setAssetid($assetid){
		$this->assetid=$assetid;
	}

	//get maintenanceon
	function getMaintenanceon(){
		return $this->maintenanceon;
	}
	//set maintenanceon
	function setMaintenanceon($maintenanceon){
		$this->maintenanceon=$maintenanceon;
	}

	//get startmileage
	function getStartmileage(){
		return $this->startmileage;
	}
	//set startmileage
	function setStartmileage($startmileage){
		$this->startmileage=$startmileage;
	}

	//get endmileage
	function getEndmileage(){
		return $this->endmileage;
	}
	//set endmileage
	function setEndmileage($endmileage){
		$this->endmileage=$endmileage;
	}

	//get supplierid
	function getSupplierid(){
		return $this->supplierid;
	}
	//set supplierid
	function setSupplierid($supplierid){
		$this->supplierid=$supplierid;
	}

	//get purchasemodeid
	function getPurchasemodeid(){
		return $this->purchasemodeid;
	}
	//set purchasemodeid
	function setPurchasemodeid($purchasemodeid){
		$this->purchasemodeid=$purchasemodeid;
	}

	//get oiladded
	function getOiladded(){
		return $this->oiladded;
	}
	//set oiladded
	function setOiladded($oiladded){
		$this->oiladded=$oiladded;
	}

	//get oilcost
	function getOilcost(){
		return $this->oilcost;
	}
	//set oilcost
	function setOilcost($oilcost){
		$this->oilcost=$oilcost;
	}

	//get fueladded
	function getFueladded(){
		return $this->fueladded;
	}
	//set fueladded
	function setFueladded($fueladded){
		$this->fueladded=$fueladded;
	}

	//get fuelcost
	function getFuelcost(){
		return $this->fuelcost;
	}
	//set fuelcost
	function setFuelcost($fuelcost){
		$this->fuelcost=$fuelcost;
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
		$fleetmaintenancesDBO = new FleetmaintenancesDBO();
		if($fleetmaintenancesDBO->persist($obj)){
			$this->id=$fleetmaintenancesDBO->id;
			$this->sql=$fleetmaintenancesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$fleetmaintenancesDBO = new FleetmaintenancesDBO();
		if($fleetmaintenancesDBO->update($obj,$where)){
			$this->sql=$fleetmaintenancesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$fleetmaintenancesDBO = new FleetmaintenancesDBO();
		if($fleetmaintenancesDBO->delete($obj,$where=""))		
			$this->sql=$fleetmaintenancesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$fleetmaintenancesDBO = new FleetmaintenancesDBO();
		$this->table=$fleetmaintenancesDBO->table;
		$fleetmaintenancesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$fleetmaintenancesDBO->sql;
		$this->result=$fleetmaintenancesDBO->result;
		$this->fetchObject=$fleetmaintenancesDBO->fetchObject;
		$this->affectedRows=$fleetmaintenancesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->assetid)){
			$error="Asset should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
