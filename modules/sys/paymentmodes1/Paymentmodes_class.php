<?php 
require_once("PaymentmodesDBO.php");
class Paymentmodes
{				
	var $id;			
	var $name;			
	var $acctypeid;			
	var $remarks;			
	var $paymentmodesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->acctypeid))
			$obj->acctypeid='NULL';
		$this->acctypeid=$obj->acctypeid;
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get acctypeid
	function getAcctypeid(){
		return $this->acctypeid;
	}
	//set acctypeid
	function setAcctypeid($acctypeid){
		$this->acctypeid=$acctypeid;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	function add($obj){
		$paymentmodesDBO = new PaymentmodesDBO();
		if($paymentmodesDBO->persist($obj)){
			$this->id=$paymentmodesDBO->id;
			$this->sql=$paymentmodesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$paymentmodesDBO = new PaymentmodesDBO();
		if($paymentmodesDBO->update($obj,$where)){
			$this->sql=$paymentmodesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$paymentmodesDBO = new PaymentmodesDBO();
		if($paymentmodesDBO->delete($obj,$where=""))		
			$this->sql=$paymentmodesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$paymentmodesDBO = new PaymentmodesDBO();
		$this->table=$paymentmodesDBO->table;
		$paymentmodesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$paymentmodesDBO->sql;
		$this->result=$paymentmodesDBO->result;
		$this->fetchObject=$paymentmodesDBO->fetchObject;
		$this->affectedRows=$paymentmodesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Name should be provided";
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
