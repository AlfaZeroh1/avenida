<?php 
require_once("HousesDBO.php");
class Houses
{				
	var $id;			
	var $hseno;			
	var $hsecode;			
	var $plotid;			
	var $amount;			
	var $size;			
	var $bedrms;			
	var $floor;			
	var $elecaccno;			
	var $wateraccno;			
	var $hsedescriptionid;			
	var $deposit;			
	var $vatable;			
	var $housestatusid;			
	var $rentalstatusid;			
	var $remarks;			
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;
	var $housesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->hseno=str_replace("'","\'",$obj->hseno);
		$this->hsecode=str_replace("'","\'",$obj->hsecode);
		if(empty($obj->plotid))
			$obj->plotid=NULL;
		$this->plotid=$obj->plotid;
		$this->amount=str_replace(",","",$obj->amount);
		$this->size=str_replace("'","\'",$obj->size);
		$this->bedrms=str_replace("'","\'",$obj->bedrms);
		$this->floor=str_replace("'","\'",$obj->floor);
		$this->elecaccno=str_replace("'","\'",$obj->elecaccno);
		$this->wateraccno=str_replace("'","\'",$obj->wateraccno);
		if(empty($obj->hsedescriptionid))
			$obj->hsedescriptionid=NULL;
		$this->hsedescriptionid=$obj->hsedescriptionid;
		$this->deposit=str_replace("'","\'",$obj->deposit);
		$this->depositmgtfee=str_replace("'","\'",$obj->depositmgtfee);
		$this->depositmgtfeevatable=str_replace("'","\'",$obj->depositmgtfeevatable);
		if(empty($obj->depositmgtfeevatclasseid))
			$obj->depositmgtfeevatclasseid=NULL;
		$this->depositmgtfeevatclasseid=$obj->depositmgtfeevatclasseid;
		$this->depositmgtfeeperc=str_replace("'","\'",$obj->depositmgtfeeperc);
		$this->vatable=str_replace("'","\'",$obj->vatable);
		if(empty($obj->housestatusid))
			$obj->housestatusid=NULL;
		$this->housestatusid=$obj->housestatusid;
		if(empty($obj->rentalstatusid))
			$obj->rentalstatusid=NULL;
		$this->rentalstatusid=$obj->rentalstatusid;
		$this->chargeable=str_replace("'","\'",$obj->chargeable);
		$this->penalty=str_replace("'","\'",$obj->penalty);
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

	//get hseno
	function getHseno(){
		return $this->hseno;
	}
	//set hseno
	function setHseno($hseno){
		$this->hseno=$hseno;
	}

	//get hsecode
	function getHsecode(){
		return $this->hsecode;
	}
	//set hsecode
	function setHsecode($hsecode){
		$this->hsecode=$hsecode;
	}

	//get plotid
	function getPlotid(){
		return $this->plotid;
	}
	//set plotid
	function setPlotid($plotid){
		$this->plotid=$plotid;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
	}

	//get size
	function getSize(){
		return $this->size;
	}
	//set size
	function setSize($size){
		$this->size=$size;
	}

	//get bedrms
	function getBedrms(){
		return $this->bedrms;
	}
	//set bedrms
	function setBedrms($bedrms){
		$this->bedrms=$bedrms;
	}

	//get floor
	function getFloor(){
		return $this->floor;
	}
	//set floor
	function setFloor($floor){
		$this->floor=$floor;
	}

	//get elecaccno
	function getElecaccno(){
		return $this->elecaccno;
	}
	//set elecaccno
	function setElecaccno($elecaccno){
		$this->elecaccno=$elecaccno;
	}

	//get wateraccno
	function getWateraccno(){
		return $this->wateraccno;
	}
	//set wateraccno
	function setWateraccno($wateraccno){
		$this->wateraccno=$wateraccno;
	}

	//get hsedescriptionid
	function getHsedescriptionid(){
		return $this->hsedescriptionid;
	}
	//set hsedescriptionid
	function setHsedescriptionid($hsedescriptionid){
		$this->hsedescriptionid=$hsedescriptionid;
	}

	//get deposit
	function getDeposit(){
		return $this->deposit;
	}
	//set deposit
	function setDeposit($deposit){
		$this->deposit=$deposit;
	}

	//get vatable
	function getVatable(){
		return $this->vatable;
	}
	//set vatable
	function setVatable($vatable){
		$this->vatable=$vatable;
	}

	//get housestatusid
	function getHousestatusid(){
		return $this->housestatusid;
	}
	//set housestatusid
	function setHousestatusid($housestatusid){
		$this->housestatusid=$housestatusid;
	}

	//get rentalstatusid
	function getRentalstatusid(){
		return $this->rentalstatusid;
	}
	//set rentalstatusid
	function setRentalstatusid($rentalstatusid){
		$this->rentalstatusid=$rentalstatusid;
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

	function add($obj){
		
		$houses = new Houses();
		$fields=" (max(id)+1) code ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$houses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$ob=$houses->fetchObject;
		if(empty($ob->code))
			$ob->code=1;
		
		$ob->code = str_pad($ob->code, 4, 0, STR_PAD_LEFT);
		
		$obj->hsecode="HSE".$ob->code;
		
		$housesDBO = new HousesDBO();
		if($housesDBO->persist($obj)){
			$this->id=$housesDBO->id;
			$this->sql=$housesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$housesDBO = new HousesDBO();
		if($housesDBO->update($obj,$where)){
			$this->sql=$housesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$housesDBO = new HousesDBO();
		if($housesDBO->delete($obj,$where=""))		
			$this->sql=$housesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$housesDBO = new HousesDBO();
		$this->table=$housesDBO->table;
		$housesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$housesDBO->sql;
		$this->result=$housesDBO->result;
		$this->fetchObject=$housesDBO->fetchObject;
		$this->affectedRows=$housesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->hseno)){
			$error="House No should be provided";
		}
		else if(empty($obj->hsecode)){
			$error="HSE Code should be provided";
		}
		else if(empty($obj->plotid)){
			$error="Plot should be provided";
		}
		else if(empty($obj->housestatusid)){
			$error="House Status should be provided";
		}
		else if(empty($obj->rentalstatusid)){
			$error="Rental Status should be provided";
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
