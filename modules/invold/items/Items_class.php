<?php 
require_once("ItemsDBO.php");
class Items
{				
	var $id;	
	var $itemid;
	var $code;			
	var $name;			
	var $departmentid;			
	var $departmentcategoryid;			
	var $categoryid;			
	var $manufacturer;			
	var $strength;
	var $currencyid;
	var $costprice;			
	var $tradeprice;			
	var $retailprice;			
	var $size;			
	var $unitofmeasureid;			
	var $vatclasseid;			
	var $generaljournalaccountid;			
	var $generaljournalaccountid2;			
	var $discount;			
	var $reorderlevel;			
	var $reorderquantity;			
	var $quantity;			
	var $reducing;			
	var $status;	
	var $type;
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;	
	var $value;
	var $image;
	var $warmth;
	var $volume;
	var $package;
	var $itemsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->code=str_replace("'","\'",$obj->code);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->departmentid))
			$obj->departmentid='NULL';
		$this->departmentid=$obj->departmentid;
		
		if(empty($obj->currencyid))
			$obj->currencyid='NULL';
		$this->currencyid=$obj->currencyid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		
		if(empty($obj->departmentcategoryid))
			$obj->departmentcategoryid='NULL';
		$this->departmentcategoryid=$obj->departmentcategoryid;
		if(empty($obj->categoryid))
			$obj->categoryid='NULL';
		$this->categoryid=$obj->categoryid;
		
		$this->warmth=$obj->warmth;
		
		$this->manufacturer=str_replace("'","\'",$obj->manufacturer);
		$this->volume=str_replace("'","\'",$obj->volume);
		$this->package=str_replace("'","\'",$obj->package);
		$this->strength=str_replace("'","\'",$obj->strength);
		$this->costprice=str_replace("'","\'",$obj->costprice);
		$this->tradeprice=str_replace("'","\'",$obj->tradeprice);
		$this->retailprice=str_replace("'","\'",$obj->retailprice);
		$this->size=str_replace("'","\'",$obj->size);
		if(empty($obj->unitofmeasureid))
			$obj->unitofmeasureid='NULL';
		$this->unitofmeasureid=$obj->unitofmeasureid;
		if(empty($obj->vatclasseid))
			$obj->vatclasseid='NULL';
		$this->vatclasseid=$obj->vatclasseid;
		if(empty($obj->generaljournalaccountid))
			$obj->generaljournalaccountid='NULL';
		$this->generaljournalaccountid=$obj->generaljournalaccountid;
		if(empty($obj->generaljournalaccountid2))
			$obj->generaljournalaccountid2='NULL';
		$this->generaljournalaccountid2=$obj->generaljournalaccountid2;
		$this->discount=str_replace("'","\'",$obj->discount);
		$this->reorderlevel=str_replace("'","\'",$obj->reorderlevel);
		$this->reorderquantity=str_replace("'","\'",$obj->reorderquantity);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->reducing=str_replace("'","\'",$obj->reducing);
		$this->value=str_replace("'","\'",$obj->value);
		$this->status=str_replace("'","\'",$obj->status);
		$this->type=str_replace("'","\'",$obj->type);
		$this->image=$obj->image;
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
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

	//get code
	function getCode(){
		return $this->code;
	}
	//set code
	function setCode($code){
		$this->code=$code;
	}

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get departmentid
	function getDepartmentid(){
		return $this->departmentid;
	}
	//set departmentid
	function setDepartmentid($departmentid){
		$this->departmentid=$departmentid;
	}

	//get departmentcategoryid
	function getDepartmentcategoryid(){
		return $this->departmentcategoryid;
	}
	//set departmentcategoryid
	function setDepartmentcategoryid($departmentcategoryid){
		$this->departmentcategoryid=$departmentcategoryid;
	}

	//get categoryid
	function getCategoryid(){
		return $this->categoryid;
	}
	//set categoryid
	function setCategoryid($categoryid){
		$this->categoryid=$categoryid;
	}

	//get manufacturer
	function getManufacturer(){
		return $this->manufacturer;
	}
	//set manufacturer
	function setManufacturer($manufacturer){
		$this->manufacturer=$manufacturer;
	}

	//get strength
	function getStrength(){
		return $this->strength;
	}
	//set strength
	function setStrength($strength){
		$this->strength=$strength;
	}

	//get costprice
	function getCostprice(){
		return $this->costprice;
	}
	//set costprice
	function setCostprice($costprice){
		$this->costprice=$costprice;
	}

	//get tradeprice
	function getTradeprice(){
		return $this->tradeprice;
	}
	//set tradeprice
	function setTradeprice($tradeprice){
		$this->tradeprice=$tradeprice;
	}

	//get retailprice
	function getRetailprice(){
		return $this->retailprice;
	}
	//set retailprice
	function setRetailprice($retailprice){
		$this->retailprice=$retailprice;
	}

	//get size
	function getSize(){
		return $this->size;
	}
	//set size
	function setSize($size){
		$this->size=$size;
	}

	//get unitofmeasureid
	function getUnitofmeasureid(){
		return $this->unitofmeasureid;
	}
	//set unitofmeasureid
	function setUnitofmeasureid($unitofmeasureid){
		$this->unitofmeasureid=$unitofmeasureid;
	}

	//get vatclasseid
	function getVatclasseid(){
		return $this->vatclasseid;
	}
	//set vatclasseid
	function setVatclasseid($vatclasseid){
		$this->vatclasseid=$vatclasseid;
	}

	//get generaljournalaccountid
	function getGeneraljournalaccountid(){
		return $this->generaljournalaccountid;
	}
	//set generaljournalaccountid
	function setGeneraljournalaccountid($generaljournalaccountid){
		$this->generaljournalaccountid=$generaljournalaccountid;
	}

	//get generaljournalaccountid2
	function getGeneraljournalaccountid2(){
		return $this->generaljournalaccountid2;
	}
	//set generaljournalaccountid2
	function setGeneraljournalaccountid2($generaljournalaccountid2){
		$this->generaljournalaccountid2=$generaljournalaccountid2;
	}

	//get discount
	function getDiscount(){
		return $this->discount;
	}
	//set discount
	function setDiscount($discount){
		$this->discount=$discount;
	}

	//get reorderlevel
	function getReorderlevel(){
		return $this->reorderlevel;
	}
	//set reorderlevel
	function setReorderlevel($reorderlevel){
		$this->reorderlevel=$reorderlevel;
	}

	//get reorderquantity
	function getReorderquantity(){
		return $this->reorderquantity;
	}
	//set reorderquantity
	function setReorderquantity($reorderquantity){
		$this->reorderquantity=$reorderquantity;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get reducing
	function getReducing(){
		return $this->reducing;
	}
	//set reducing
	function setReducing($reducing){
		$this->reducing=$reducing;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
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

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	function add($obj){
		$itemsDBO = new ItemsDBO();
		if($itemsDBO->persist($obj)){
			$this->id=$itemsDBO->id;
			$this->sql=$itemsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$itemsDBO = new ItemsDBO();
		if($itemsDBO->update($obj,$where)){
			$this->sql=$itemsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$itemsDBO = new ItemsDBO();
		if($itemsDBO->delete($obj,$where=""))		
			$this->sql=$itemsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$itemsDBO = new ItemsDBO();
		$this->table=$itemsDBO->table;
		$itemsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$itemsDBO->sql;
		$this->result=$itemsDBO->result;
		$this->fetchObject=$itemsDBO->fetchObject;
		$this->affectedRows=$itemsDBO->affectedRows;
	}
	
	function getStocks($obj){
		//get item stock quantity
		$items = new Items();
		$fields="*";
		$where=" where id='$obj->itemid'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$items=$items->fetchObject;
		
		//get stocktrack transactions that contribute to the quantity
		$stocktrack = new Stocktrack();
		$fields="*";
		$where=" where itemid='$obj->itemid' and quantity>0 and issued<quantity";
		$join="";
		$having="";
		$groupby="";
		$orderby=" order by recorddate asc";
		$stocktrack->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$tt=0;
		$total=0;
		while($row=mysql_fetch_object($stocktrack->result)){
		  $tts=$tt+$row->quantity;
		  if($tts<=$obj->quantity){
		    //get value of all the items. all are issued
		    $total+=($row->quantity*$row->costprice);
		    
		  }
		  else{
		    $total+=($obj->quantity-$tts)*$row->costprice;
		  }
		  
		  //update record to issue all
		    $st = new Stocktrack();
		    $st->issued=$row->quantity;
		    $st->edit($st);
		    
		    $tt+=$row->quantity;
		}
		return $total;
	  
	}
	
	function validate($obj){
		
		$query="select * from inv_items where lower(name)=lower('$obj->name') and status='Active' ";
		if(!empty($obj->id))
		  $query.=" and id!='$obj->id' ";
		  
		mysql_query($query);
		$num = mysql_affected_rows();

		
		if(empty($obj->name)){
			$error="Name should be provided";
		}
		else if($num>0){
		  $error="Name is a duplicate!";
		}
		else if(empty($obj->unitofmeasureid)){
			$error="Unit of measure must be provided";
		}
		else if(empty($obj->categoryid)){
			$error="Category should be provided";
		}
// 		else if(empty($obj->currencyid)){
// 			$error="Currency should be provided";
// 		}
		else if(empty($obj->departmentid)){
			$error="Department should be provided";
		}
		else if(empty($obj->departmentid)){
			$error="Department should be provided";
		}
		else if(empty($obj->package)){
			$error="Package should be provided";
		}
		else if(empty($obj->costprice) and empty($obj->itemid)){
			$error="Cost Price should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
	
	function getItemValue($itemid,$quantity,$cost){
	  $query="select * from inv_items where id='$itemid'";
	  $row=mysql_fetch_object(mysql_query($query));
	  
	  $value = (($row->value*$row->quantity)+($quantity*$cost))/($row->quantity+$quantity);
	  
	  mysql_query("update inv_items set value='$value' where id='$itemid'");
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
