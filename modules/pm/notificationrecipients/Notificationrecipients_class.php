<?php 
require_once("NotificationrecipientsDBO.php");
class Notificationrecipients
{				
	var $id;			
	var $notificationid;			
	var $employeeid;
	var $customerid;
	var $fromemployeeid;
	var $email;
	var $tel;
	var $body;
	var $projectid;
	var $notificationtypeid;
	var $notifiedon;			
	var $readon;			
	var $status;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $notificationrecipientsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->projectid))
			$obj->projectid='NULL';
		$this->projectid=$obj->projectid;
		if(empty($obj->notificationid))
			$obj->notificationid='NULL';
		$this->notificationid=$obj->notificationid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		
		if(empty($obj->customerid))
			$obj->customerid='NULL';
		$this->customerid=$obj->customerid;
		
		if(empty($obj->fromemployeeid))
			$obj->fromemployeeid='NULL';
		$this->fromemployeeid=$obj->fromemployeeid;
		
		$this->email=str_replace("'","\'",$obj->email);
		$this->tel=str_replace("'","\'",$obj->tel);
		$this->body=str_replace("'","\'",$obj->body);
		$this->notificationtypeid=str_replace("'","\'",$obj->notificationtypeid);
		$this->notifiedon=str_replace("'","\'",$obj->notifiedon);
		$this->readon=str_replace("'","\'",$obj->readon);
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

	//get notificationid
	function getNotificationid(){
		return $this->notificationid;
	}
	//set notificationid
	function setNotificationid($notificationid){
		$this->notificationid=$notificationid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}
	
	//get fromemployeeid
	function getFromemployeeid(){
		return $this->fromemployeeid;
	}
	//set fromemployeeid
	function setFromemployeeid($fromemployeeid){
		$this->fromemployeeid=$fromemployeeid;
	}

	//get email
	function getEmail(){
		return $this->email;
	}
	//set email
	function setEmail($email){
		$this->email=$email;
	}

	//get notifiedon
	function getNotifiedon(){
		return $this->notifiedon;
	}
	//set notifiedon
	function setNotifiedon($notifiedon){
		$this->notifiedon=$notifiedon;
	}

	//get readon
	function getReadon(){
		return $this->readon;
	}
	//set readon
	function setReadon($readon){
		$this->readon=$readon;
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

	function add($obj){
		$notificationrecipientsDBO = new NotificationrecipientsDBO();
        
		if($notificationrecipientsDBO->persist($obj)){
			if(true){
			  $this->sendSMS($obj);
			}
			
			$this->id=$notificationrecipientsDBO->id;
			$this->sql=$notificationrecipientsDBO->sql;
			return true;	
		}
	}
	
	function sendSMS($obj){
	    require_once('../../../AfricasTalkingGateway.php');
	    
	    $username = $_SESSION['smsusername']; 
	    $apikey = $_SESSION['smsapikey'];
	    
	    $username="Hacienda";
	    $apikey="a0fe560f7ce216b60eef04f390872aa466b4e114be99737eebec93dd666f8647";
	    
	    $gateway = new AfricasTalkingGateway($username, $apikey);
	    
	    $query="select * from hrm_employees where id='$obj->employeeid'";
	    $r = mysql_fetch_object(mysql_query($query));
	    
	    $obj->body="AVENIDA: ".$obj->body;
	    try
	    {
	      $results = $gateway->sendMessage($r->phoneno, $obj->body);
	    }
	    catch ( AfricasTalkingGatewayException $e )
	    {
	      echo "Encountered an error while sending: ".$e->getMessage();
	    }
	}
	
	function edit($obj,$where=""){
		$notificationrecipientsDBO = new NotificationrecipientsDBO();
		if($notificationrecipientsDBO->update($obj,$where)){
			$this->sql=$notificationrecipientsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$notificationrecipientsDBO = new NotificationrecipientsDBO();
		if($notificationrecipientsDBO->delete($obj,$where=""))		
			$this->sql=$notificationrecipientsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$notificationrecipientsDBO = new NotificationrecipientsDBO();
		$this->table=$notificationrecipientsDBO->table;
		$notificationrecipientsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$notificationrecipientsDBO->sql;
		$this->result=$notificationrecipientsDBO->result;
		$this->fetchObject=$notificationrecipientsDBO->fetchObject;
		$this->affectedRows=$notificationrecipientsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->notificationid)){
			$error="Notification should be provided";
		}
		else if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
		else if(empty($obj->status)){
			$error="Status should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
		else if(empty($obj->status)){
			$error="Status should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
