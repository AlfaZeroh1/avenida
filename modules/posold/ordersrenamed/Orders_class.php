<?php 
require_once("OrdersDBO.php");
require_once("../../../modules/pos/orderdetails/OrderdetailsDBO.php");
class Orders
{				
	var $id;
	var $shiftid;
	var $brancheid;
	var $brancheid2;
	var $orderno;	
	var $tableno;
	var $customerid;
	var $consigneeid;
	var $orderedon;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ordersDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->orderno=str_replace("'","\'",$obj->orderno);
		$this->shiftid=str_replace("'","\'",$obj->shiftid);
		$this->tableno=str_replace("'","\'",$obj->tableno);
		if(empty($obj->customerid))
			$obj->customerid='NULL';
		$this->customerid=$obj->customerid;
		if(empty($obj->brancheid))
			$obj->brancheid='NULL';
		$this->brancheid=$obj->brancheid;
		
		if(empty($obj->brancheid2))
			$obj->brancheid2='NULL';
		$this->brancheid2=$obj->brancheid2;
		
		if(empty($obj->consigneeid))
			$obj->consigneeid='NULL';
		$this->consigneeid=$obj->consigneeid;
		$this->orderedon=str_replace("'","\'",$obj->orderedon);
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

	//get orderno
	function getOrderno(){
		return $this->orderno;
	}
	//set orderno
	function setOrderno($orderno){
		$this->orderno=$orderno;
	}

	//get customerid
	function getCustomerid(){
		return $this->customerid;
	}
	//set customerid
	function setCustomerid($customerid){
		$this->customerid=$customerid;
	}

	//get orderedon
	function getOrderedon(){
		return $this->orderedon;
	}
	//set orderedon
	function setOrderedon($orderedon){
		$this->orderedon=$orderedon;
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
		$ordersDBO = new OrdersDBO();
			
			$defs=mysql_fetch_object(mysql_query("select (max(orderno)+1) orderno from pos_orders"));
			if($defs->orderno == null){
				$defs->orderno=1;
			}
			$obj->orderno=$defs->orderno;
			
			if($ordersDBO->persist($obj)){		
				$orderdetails = new Orderdetails();
				$obj->orderid=$ordersDBO->id;
				$orderdetails->add($obj,$shop);

				$this->id=$ordersDBO->id;
				$this->sql=$ordersDBO->sql;
			}
		return $obj->orderno;	
	}			
	function edit($obj,$where="",$shop){
		$ordersDBO = new OrdersDBO();

		if($obj->action=="CANCEL"){
		  $query="select * from pos_orders where id='$obj->id'";
		  $ob = mysql_fetch_object(mysql_query($query));
		  $ob->remarks = $obj->remarks;
		  $ob = $this->setObject($ob);
		  $ob->status=2;
		  
		  $ordersDBO->update($ob);
		}else{
		  //first delete all records under old documentno
		  $where=" where orderno='$obj->orderno'";
		  $ordersDBO->delete($obj,$where);
		  
		  $orders=new Orders();
		  $where=" where orderno='$obj->orderno' ";
		  $fields="*";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $orders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  $orders=$orders->fetchObject;
		  
		  $where=" where orderid='$orders->id'";
		  $orderdetails = new Orderdetails();
		  $orderdetails->delete($obj,$where);

		  $orders = new Orders();
		  $orders->add($obj,$shop);
		}
		
		return true;	
	}			
	function delete($obj,$where=""){			
		$ordersDBO = new OrdersDBO();
		if($ordersDBO->delete($obj,$where=""))		
			$this->sql=$ordersDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$ordersDBO = new OrdersDBO();
		$this->table=$ordersDBO->table;
		$ordersDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$ordersDBO->sql;
		$this->result=$ordersDBO->result;
		$this->fetchObject=$ordersDBO->fetchObject;
		$this->affectedRows=$ordersDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->orderedon)){
			$error="Date Ordered should be provided";
		}
		else if(empty($obj->tableno)){
			$error="Table No should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->orderedon)){
			$error="Date Ordered should be provided";
		}
		else if(empty($obj->tableno)){
			$error="Table No should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
