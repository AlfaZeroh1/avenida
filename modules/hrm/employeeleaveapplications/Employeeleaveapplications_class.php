<?php 
require_once("EmployeeleaveapplicationsDBO.php");
include("class.phpmailer.php");
include("class.smtp.php"); // note, this is optional - gets called from main class if not already loaded
require_once("../../../modules/hrm/configs/Configs_class.php");

class Employeeleaveapplications
{				
	var $id;			
	var $employeeid;
	var $employeeid1;
	var $leavetypeid;			
	var $startdate;			
	var $duration;	
	var $enddate;
	var $appliedon;			
	var $status;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $type;			
	var $employeeleaveapplicationsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		
		if(empty($obj->employeeid1))
			$obj->employeeid1='NULL';
		$this->employeeid1=$obj->employeeid1;
		
		if(empty($obj->leavetypeid))
			$obj->leavetypeid='NULL';
		$this->leavetypeid=$obj->leavetypeid;
		$this->startdate=str_replace("'","\'",$obj->startdate);
		$this->duration=str_replace("'","\'",$obj->duration);
		$this->enddate=str_replace("'","\'",$obj->enddate);
		$this->appliedon=str_replace("'","\'",$obj->appliedon);
		$this->status=str_replace("'","\'",$obj->status);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		$this->type=str_replace("'","\'",$obj->type);
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

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get leavetypeid
	function getLeavetypeid(){
		return $this->leavetypeid;
	}
	//set leavetypeid
	function setLeavetypeid($leavetypeid){
		$this->leavetypeid=$leavetypeid;
	}

	//get startdate
	function getStartdate(){
		return $this->startdate;
	}
	//set startdate
	function setStartdate($startdate){
		$this->startdate=$startdate;
	}

	//get duration
	function getDuration(){
		return $this->duration;
	}
	//set duration
	function setDuration($duration){
		$this->duration=$duration;
	}

	//get appliedon
	function getAppliedon(){
		return $this->appliedon;
	}
	//set appliedon
	function setAppliedon($appliedon){
		$this->appliedon=$appliedon;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
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

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	//get type
	function getType(){
		return $this->type;
	}
	//set type
	function setType($type){
		$this->type=$type;
	}

	function add($obj){
		$employeeleaveapplicationsDBO = new EmployeeleaveapplicationsDBO();
		if($employeeleaveapplicationsDBO->persist($obj)){
		
		
			$obj->module="hrm";
			$obj->role="employeeleaveapplications";
			
			$obj->documentno=$employeeleaveapplicationsDBO->id;
			
			$tasks = new Tasks();
			$tasks->workFlow($obj);
		
			$this->id=$employeeleaveapplicationsDBO->id;
			$this->sql=$employeeleaveapplicationsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeeleaveapplicationsDBO = new EmployeeleaveapplicationsDBO();
		if($employeeleaveapplicationsDBO->update($obj,$where)){
			$this->sql=$employeeleaveapplicationsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeeleaveapplicationsDBO = new EmployeeleaveapplicationsDBO();
		if($employeeleaveapplicationsDBO->delete($obj,$where=""))		
			$this->sql=$employeeleaveapplicationsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeeleaveapplicationsDBO = new EmployeeleaveapplicationsDBO();
		$this->table=$employeeleaveapplicationsDBO->table;
		$employeeleaveapplicationsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeeleaveapplicationsDBO->sql;
		$this->result=$employeeleaveapplicationsDBO->result;
		$this->fetchObject=$employeeleaveapplicationsDBO->fetchObject;
		$this->affectedRows=$employeeleaveapplicationsDBO->affectedRows;
	}
        function sendMail($id,$emp,$bodys,$employeeid,$from){echo "here";
		$mail = new PHPMailer();
		
		$email="";
		
		$employees = new Employees();
		$fields=" hrm_employees.*, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeename ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where id='$emp' and officemail!=''";
		$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employees->sql;
		$employees=$employees->fetchObject;
		
 
                $employee = new Employees();
		$fields="hrm_employees.*,hrm_assignments.name ";
		$join=" left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employees.id='$employeeid' and officemail!=''";
		$employee->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employee->sql;
		$employee=$employee->fetchObject;
		
		$employ = new Employees();
		$fields="hrm_employees.*,hrm_assignments.name ";
		$join=" left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employees.id='$from' ";
		$employ->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employ=$employ->fetchObject;
		
		$employeeleaveapplications=new Employeeleaveapplications();
		$where=" where hrm_employeeleaveapplications.id=$id ";
		$fields=" hrm_employeeleaveapplications.*,concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) employeename ";
		$join=" left join hrm_employees on hrm_employees.id=hrm_employeeleaveapplications.employeeid ";
		$having="";
		$groupby="";
		$orderby="";
		$employeeleaveapplications->retrieve($fields,$join,$where,$having,$groupby,$orderby);//$employeeleaveapplications->sql;
		$employeeleaveapplications=$employeeleaveapplications->fetchObject;
		
                if($bodys=='Approved Owner'){
                   $body="Your Application of Leave of ".$employeeleaveapplications->duration." days that Starts on ".$employeeleaveapplications->startdate." has been Approved by ".$employ->name;
                   $email=$employees->officemail;
                   $empid=$employees->id;
                }elseif($bodys=='Declined Owner'){
                   $body="Your Application of Leave of ".$employeeleaveapplications->duration." days that Starts on ".$employeeleaveapplications->startdate." has been Declined by ".$employ->name;
                   $email=$employees->officemail;
                   $empid=$employees->id;
                }elseif($bodys=='Approved Empl'){
                   $body="An Application of Leave by ".$employees->employeename." for ".$employeeleaveapplications->duration." days that Starts on ".$employeeleaveapplications->startdate." has been Approved by ".$employ->name." And is awaiting Your Approval";
                   $email=$employee->officemail;
                   $empid=$employee->id;
                }elseif($bodys=='Declined Empl'){
                   $body="An Application of Leave by ".$employees->employeename." for ".$employeeleaveapplications->duration." days that Starts on ".$employeeleaveapplications->startdate." has been Declined by ".$employ->name;
                   $email=$employee->officemail;
                   $empid=$employee->id;
                }
		
		$mail->IsSMTP();
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
		$mail->Host       = "mail.gmail.com";      // sets GMAIL as the SMTP server
		$mail->Port       = 465;                   // set the SMTP port

		$query="select value from hrm_configs where name='EMAIL'";
		$row=mysql_fetch_object(mysql_query($query));
		$mail->Username   = $row->value;  // GMAIL username

		$query="select value from hrm_configs where name='PASSWORD'";
		$row=mysql_fetch_object(mysql_query($query));
		$mail->Password   = $row->value;            // GMAIL password

		$mail->From       = "replyto@yourdomain.com";
		$mail->FromName   = "WiseDigits HRM";
		$mail->Subject    = "Leave Application Approval ";
		$mail->AltBody    = ""; //Text Body
		$mail->WordWrap   = 50; // set word wrap

		$mail->MsgHTML($body);

		$employees = new Employees();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where id='$empid' ";
		$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employees=$employees->fetchObject;

		//create a resource folder
		$configs = new Configs();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where name='DMS_RESOURCE'";
		$configs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$configs=$configs->fetchObject;

		//add address
		if(!empty($email)){
		$mail->AddAddress($email,$employees->firstname." ".$employees->middlename." ".$employees->lastname);
                
		$mail->IsHTML(true); // send as HTML
                                   
		  if(!$mail->Send()) {
		    echo "Mailer Error: " . $mail->ErrorInfo;
		  } else {
		    echo "Message has been sent";
		  }
		  }
		}
	function validate($obj){
		if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
		else if(empty($obj->startdate)){
			$error="Start Date should be provided";
		}
		else if(empty($obj->duration)){
			$error="Duration (Working Days) should be provided";
		}else if(empty($obj->appliedon)){
			$error="Applied on should be provided";
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
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
