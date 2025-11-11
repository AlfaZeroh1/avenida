<?php 
require_once("GradedDBO.php");
class Graded
{				
	var $id;	
	var $greenhouseid;
	var $sizeid;			
	var $itemid;	
	var $datecode;
	var $quantity;			
	var $gradedon;			
	var $employeeid;
	var $downsize;
	var $barcode;			
	var $remarks;			
	var $status;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $gradedDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->sizeid))
			$obj->sizeid='NULL';
		$this->sizeid=$obj->sizeid;
		if(empty($obj->greenhouseid))
			$obj->greenhouseid='NULL';
		$this->greenhouseid=$obj->greenhouseid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->gradedon=str_replace("'","\'",$obj->gradedon);
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->downsize=$obj->downsize;
		$this->datecode=$obj->datecode;
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

	//get sizeid
	function getSizeid(){
		return $this->sizeid;
	}
	//set sizeid
	function setSizeid($sizeid){
		$this->sizeid=$sizeid;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get gradedon
	function getGradedon(){
		return $this->gradedon;
	}
	//set gradedon
	function setGradedon($gradedon){
		$this->gradedon=$gradedon;
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
		$gradedDBO = new GradedDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		
		$obj->remarks=$obj->status;
		
		while($i<$num){
			$obj->sizeid=$shop[$i]['sizeid'];
			$obj->sizename=$shop[$i]['sizename'];
			$obj->itemid=$shop[$i]['itemid'];
			$obj->itemname=$shop[$i]['itemname'];
			$obj->greenhouseid=$shop[$i]['greenhouseid'];
			$obj->greenhousename=$shop[$i]['greenhousename'];
			$obj->quantity=$shop[$i]['quantity'];
			$obj->employeeid=$shop[$i]['employeeid'];
			$obj->employeename=$shop[$i]['employeename'];
			$obj->downsize=$shop[$i]['downsize'];
			$obj->datecode=$shop[$i]['datecode'];
			$obj->barcode=$shop[$i]['barcode'];

			//this deletes the first element in the array
                        if($i<$obj->iterator-1)
                                $shop=array_slice($shop,1);

			if($gradedDBO->persist($obj)){
				$this->sql=$gradedDBO->sql;
				
				//record item stocks
				$itemstocks = new Itemstocks();
				
				$ob->recordedon=date("Y-m-d");
				$ob->actedon=$obj->gradedon;
				
				$barcode=$obj->barcode;
				$cod=strrpos($barcode,'=');
				$cc=substr($barcode,0,($cod));
				
				if($obj->status=="checkedin"  or $obj->status=="regradedin" or $obj->status=="rebunchingin" or $obj->status=="stocktake" or $obj->status=="discarded returns"  ){
				  $itemstocks->addStock($obj);
				  $query="UPDATE post_barcodes set status=1 where barcode='$cc'";//echo $query;
				  mysql_query($query);
				  }
				else{
				  $itemstocks->reduceStock($obj);
				  $query="UPDATE post_barcodes set status=0 where barcode='$cc'";//echo $query;
				  mysql_query($query);
				  }
				  
				
				
				
			}
			$i++;
		}
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$gradedDBO = new GradedDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->olddocumentno' and mode='$obj->oldmode'";
		$gradedDBO->delete($obj,$where);

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->olddocumentno' and transactionid='2' mode='$obj->oldmode' ";
		$gn->delete($obj,$where);

		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->sizeid=$shop['sizeid'];
			$obj->sizename=$shop['sizename'];
			$obj->itemid=$shop['itemid'];
			$obj->itemname=$shop['itemname'];
			$obj->quantity=$shop['quantity'];
			$obj->greenhouseid=$shop[$i]['greenhouseid'];
			$obj->greenhousename=$shop[$i]['greenhousename'];
			$obj->employeeid=$shop['employeeid'];
			$obj->datecode=$shop['datecode'];
			$obj->employeename=$shop['employeename'];
			if($gradedDBO->update($obj,$where)){
				$this->sql=$gradedDBO->sql;
			}
		}
		return true;	
	}			
	function delete($obj,$where=""){			
		$gradedDBO = new GradedDBO();
		if($gradedDBO->delete($obj,$where=""))		
			$this->sql=$gradedDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$gradedDBO = new GradedDBO();
		$this->table=$gradedDBO->table;
		$gradedDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$gradedDBO->sql;
		$this->result=$gradedDBO->result;
		$this->fetchObject=$gradedDBO->fetchObject;
		$this->affectedRows=$gradedDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->sizeid)){
			$error="Size should be provided";
		}
		else if(empty($obj->itemid)){
			$error="Item should be provided";
		}
		else if(empty($obj->quantity)){
			$error="Quantity should be provided";
		}
		else if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
		
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
	
		$status="";
		if($obj->status=="checkedin"){
		  $status="Grading Check-in";
		}
		if($obj->status=="checkedout"){
		  $status="Cold Store Returns";
		}
		if($obj->status=="stocktake"){
		  $status="Cold Store Stock Take";
		}
		if($obj->status=="regradedin"){
		  $status="Grading Check-in";
		}
		if($obj->status=="regradedout"){
		   $status="Grading Check-in";
		}
		if($obj->status=="rebunchingin"){
		   $status="Grading Check-in";
		}
		if($obj->status=="rebunchinout"){
		   $status="Grading Check-in";
		}
		
		$ipaddress = new Ipaddress();
		$fields=" * ";
		$join="";
		$groupby="";
		$having="";
		$where=" where task='$status' and ipaddress='$obj->ipaddress'";
		$ipaddress->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $ipaddress->sql;
		
		if(empty($obj->gradedon)){
			$error="Date Graded should be provided";
		}
// 		else if($ipaddress->affectedRows<=0){
// 			$error="Computer not allowed to do $status";
// 		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
