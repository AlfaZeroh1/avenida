<?php 
require_once("DeductionchargesDBO.php");
class Deductioncharges
{				
	var $id;			
	var $deductionid;			
	var $amountfrom;			
	var $amountto;			
	var $charge;			
	var $chargetype;			
	var $remarks;			
	var $formula;			
	var $deductionchargesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->deductionid=str_replace("'","\'",$obj->deductionid);
		$this->amountfrom=str_replace("'","\'",$obj->amountfrom);
		$this->amountto=str_replace("'","\'",$obj->amountto);
		$this->charge=str_replace("'","\'",$obj->charge);
		$this->chargetype=str_replace("'","\'",$obj->chargetype);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->formula=str_replace("'","\'",$obj->formula);
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

	//get deductionid
	function getDeductionid(){
		return $this->deductionid;
	}
	//set deductionid
	function setDeductionid($deductionid){
		$this->deductionid=$deductionid;
	}

	//get amountfrom
	function getAmountfrom(){
		return $this->amountfrom;
	}
	//set amountfrom
	function setAmountfrom($amountfrom){
		$this->amountfrom=$amountfrom;
	}

	//get amountto
	function getAmountto(){
		return $this->amountto;
	}
	//set amountto
	function setAmountto($amountto){
		$this->amountto=$amountto;
	}

	//get charge
	function getCharge(){
		return $this->charge;
	}
	//set charge
	function setCharge($charge){
		$this->charge=$charge;
	}

	//get chargetype
	function getChargetype(){
		return $this->chargetype;
	}
	//set chargetype
	function setChargetype($chargetype){
		$this->chargetype=$chargetype;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get formula
	function getFormula(){
		return $this->formula;
	}
	//set formula
	function setFormula($formula){
		$this->formula=$formula;
	}

	function add($obj){
		$deductionchargesDBO = new DeductionchargesDBO();
		if($deductionchargesDBO->persist($obj)){
			$this->id=$deductionchargesDBO->id;
			$this->sql=$deductionchargesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$deductionchargesDBO = new DeductionchargesDBO();
		if($deductionchargesDBO->update($obj,$where)){
			$this->sql=$deductionchargesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$deductionchargesDBO = new DeductionchargesDBO();
		if($deductionchargesDBO->delete($obj,$where=""))		
			$this->sql=$deductionchargesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$deductionchargesDBO = new DeductionchargesDBO();
		$this->table=$deductionchargesDBO->table;
		$deductionchargesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$deductionchargesDBO->sql;
		$this->result=$deductionchargesDBO->result;
		$this->fetchObject=$deductionchargesDBO->fetchObject;
		$this->affectedRows=$deductionchargesDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
