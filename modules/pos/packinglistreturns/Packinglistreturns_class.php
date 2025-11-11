<?php 
require_once("PackinglistreturnsDBO.php");
require_once("../../../modules/pos/packinglistdtreturns/PackinglistdtreturnsDBO.php");
class Packinglistreturns
{				
	var $id;			
	var $documentno;
	var $packingno;
	var $orderno;			
	var $boxno;			
	var $customerid;			
	var $packedon;			
	var $fleetid;			
	var $employeeid;			
	var $remarks;	
	var $returns;
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $packinglistreturnsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->packingno=str_replace("'","\'",$obj->packingno);
		$this->orderno=str_replace("'","\'",$obj->orderno);
		$this->boxno=str_replace("'","\'",$obj->boxno);
		if(empty($obj->customerid))
			$obj->customerid='NULL';
		$this->customerid=$obj->customerid;
		$this->packedon=str_replace("'","\'",$obj->packedon);
		if(empty($obj->fleetid))
			$obj->fleetid='NULL';
		$this->fleetid=$obj->fleetid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->returns=str_replace("'","\'",$obj->returns);
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

	//get orderno
	function getOrderno(){
		return $this->orderno;
	}
	//set orderno
	function setOrderno($orderno){
		$this->orderno=$orderno;
	}

	//get boxno
	function getBoxno(){
		return $this->boxno;
	}
	//set boxno
	function setBoxno($boxno){
		$this->boxno=$boxno;
	}

	//get customerid
	function getCustomerid(){
		return $this->customerid;
	}
	//set customerid
	function setCustomerid($customerid){
		$this->customerid=$customerid;
	}

	//get packedon
	function getPackedon(){
		return $this->packedon;
	}
	//set packedon
	function setPackedon($packedon){
		$this->packedon=$packedon;
	}

	//get fleetid
	function getFleetid(){
		return $this->fleetid;
	}
	//set fleetid
	function setFleetid($fleetid){
		$this->fleetid=$fleetid;
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
		$packinglistreturnsDBO = new PackinglistreturnsDBO();
		$packinglistdetails = new Packinglistdetails();
		//check if its returning a boxno
		if($obj->returns==1){
		  $fields="*";
		  $where=" where documentno='$obj->documentno' and boxno='$obj->boxno'";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $packinglistreturns->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  $packinglistreturns = $packinglistreturns->fetchObject;
		  $packinglistreturns->returns=1;
		  
		  $pack = new Packinglistreturns();
		  $pack = $pack->setObject($packinglistreturns);
		  if($pack->edit($pack)){
		    $obj->packinglistid=$packinglistreturnsDBO->id;
		    $packinglistdetails->add($obj,$shop);
		  }
		}
		else{
			if($packinglistreturnsDBO->persist($obj)){		
				
				$obj->packinglistid=$packinglistreturnsDBO->id;
				$packinglistdetails->add($obj,$shop);

				$this->id=$packinglistreturnsDBO->id;
				$this->sql=$packinglistreturnsDBO->sql;
			}
		}
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$packinglistreturnsDBO = new PackinglistreturnsDBO();

		$packinglistreturns = new Packinglistreturns();
		//first delete all records under old documentno
		$where=" where documentno='$obj->documentno' and boxno='$obj->boxno'";
		$packinglistreturnsDBO->delete($obj,$where);

		$packinglistreturns=$packinglistreturns->setObject($obj);
		if($packinglistreturns->add($packinglistreturns,$shop)){
		  return true;	
		}
		else
		  return false;
	}			
	function delete($obj,$where=""){			
		$packinglistreturnsDBO = new PackinglistreturnsDBO();
		if($packinglistreturnsDBO->delete($obj,$where=""))		
			$this->sql=$packinglistreturnsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$packinglistreturnsDBO = new PackinglistreturnsDBO();
		$this->table=$packinglistreturnsDBO->table;
		$packinglistreturnsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$packinglistreturnsDBO->sql;
		$this->result=$packinglistreturnsDBO->result;
		$this->fetchObject=$packinglistreturnsDBO->fetchObject;
		$this->affectedRows=$packinglistreturnsDBO->affectedRows;
	}	
	
	function checkArray($obj,$shop){
	  $x=0;
	  $bool = true;
	  $track=0;
	  $check=0;
	  while($x<count($shop)){//echo "<br/>X==".$x."<br/>";
	  $bool=true;
	  //echo "COUNT ".count($obj)." = ".count($shop[$x])."<br/>";
	  //check if there is a sub array that agrees to the larger array
	  if(true){
	    $y=0;
	    sort($shop[$x]);//echo "<br/> SHOP ";print_r($shop[$x]);echo "<br/>";
	    sort($obj);//echo "<br/> OBJ ";print_r($obj);echo "<br/>";
	    while($y<count($shop[$x])){//echo "<br/>Y==".$y."<br/>";
	    
	      if($y>0){
		if($obj[$y-1]['itemid']==$shop[$x][$y]['itemid'] and $obj[$y-1]['sizeid']==$shop[$x][$y]['sizeid'] and $obj[$y-1]['quantity']==$shop[$x][$y]['quantity']){
		  $bool=true;//echo $obj[$y-1]['itemid']." => ".$x." = ".$shop[$x][$y]['itemid']." ".$y." = Found<br/>";
		}
		else{//echo $obj[$y-1]['itemid']." => ".$x." = ".$shop[$x][$y]['itemid']." => ".$y." = NOT Found<br/>";
		  $bool=false;
		  break;
		}
	      }
	      $y++;
	    }
	  }else{echo "<br/>NOT COUNT<br/>";}
	  if($bool){//echo "CHECKED ".$x;
	  //this means the array is already found in the bigger array
	    $check=$x+1;
	    break;
	  }
	  
// 	  if(count(array_diff($obj,$shop[$x]))>0){
// 	    $bool=true;
// 	  }
// 	  else{
// 	    $bool=false;
// 	    $check=$x;
// 	    break;
// 	  }
	  //make a loop looking for a specific row, if found, break
	  //$y=0;
	    //while($y<count($shop[$x])){	  echo "<br/>X = ".$x." Y = ".$y." COUNT ".count($shop[$x])."<br/>";
	      //$bool=false;
	      //echo $x."=>".$y."=>".$shop[$x][$y]['itemid']."<br/>";
// 	      if($obj->itemid==$shop[$x][$y]['itemid'] and $obj->sizeid==$shop[$x][$y]['sizeid'] and $obj->quantity==$shop[$x][$y]['quantity']){
// 		$bool=true;
// 		$track=0;			
// 		break;
// 	      }
// 	      else{
// 		$bool=false;		
// 	      }
// 	      $y++;
// 	    }
	    $x++;
	    
	  }
	  
	  if($bool){
	  //echo "<br/>CHECK".$check."<br/>";
	    return $check;
	  }
	  else{
	   // echo "<br/>NO CHECK".$check."<br/>";
	    return "NOT FOUND";
	  }
	}
	
	function validate($obj){
		if(empty($obj->documentno)){
			$error="Packing No should be provided";
		}
		else if(empty($obj->customerid)){
			$error="Customer should be provided";
		}
		else if(empty($obj->packedon)){
			$error="Date of Packing should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
	
	
		
		$status="Boxing";
		
		
		$ipaddress = new Ipaddress();
		$fields=" * ";
		$join="";
		$groupby="";
		$having="";
		$where=" where task='$status' and ipaddress='$obj->ipaddress'";
		$ipaddress->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		
		
		if(empty($obj->documentno)){
			$error="Packing No should be provided";
		}
		else if(empty($obj->customerid)){
			$error="Customer should be provided";
		}
		else if(empty($obj->packedon)){
			$error="Date of Packing should be provided";
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
