<?php

class sendMail
{
var $toUserName;
var $subject;
var $headers;
var $toList;
var $mailBody;
var $to;
public static $link = "www.roomsoom.com/rs/tasks/sales_query.php?query_id=";

        function sendMail() {
                $this->headers = "From: no-reply@roomsoom.com"."\r\n"."Reply-To: mukesh.arya@roomsoom.com";
        }
        
        public function sendMail2CustomerOnLead($customerEmail, $customerName, $location) {
        	$this->addHeaderTypeHTML();
        	$this->subject = "Thanks for contacting RoomSoom";
        	$extraTest = " Congratulations!! <br> <br> Your effort for searching a long stay accommodation finally paid off. RoomSoom received your enquiry and your requirement has been acknowledged by our team. Soon, one of our executive will contact you through call.<br> We appreciate your interest for choosing our budgeted & quality accommodation services. Our team members are desperate to provide you best experience while choosing & staying with Roomsoom all over Delhi, Noida, Gurgaon/ Gurugram, Mumbai, Pune, Bangalore & Indore.<br><br> Cheers, <br> RoomSoom Family!!<br> contact@roomsoom.com<br> +91-88 1010 7070<br> +91 7777 060 060
"; 
        	$this->to = $customerEmail;
		$ccMailList = "mukesh.arya24@gmail.com";
        	$this->addHeaderTypeCC($ccMailList);
        	$this->setMailBodyCustomer($customerName,$extraTest);
        	$this->sendMailTo();
        }
        
        public function sendMail2CallingTeam($query_owner, $id) {
        	$this->addHeaderTypeHTML();
        	$this->subject = self::$link.$id;
        	$extraTest = " Sales query $id is assigned to you. please check the content  at ". $this->subject . " please try to close query in next 5 days. <br> <br> Good Luck, <br> RoomSoom Admin"; 
        	$this->to = $query_owner."@roomsoom.com";
		echo $this->to;
       		$this->addHeaderTypeCC("mukesh.arya24@gmail.com");
        	$this->setMailBody($query_owner,$id,$extraTest);
        	$this->sendMailTo();
        }

        public function addHeaderTypeHTML() {
                $this->headers .= "\r\n";
                $this->headers .= 'MIME-Version: 1.0' . "\r\n";
                $this->headers .= 'Content-type: text/html;charset=iso-8859-1';
        }

        public function addHeaderTypeCC($ccMailList) {
                $this->headers .= "\r\n";
                $this->headers .= "Cc: ".$ccMailList;
        }

        function setSubjectCustomerWelcome() {
                $this->subject .= "Thanks for choosing RoomSoom.com";
        }
        
        function setSubjectSalesCreation($id) {
                $this->subject .= "Sales lead : $id created and assigned to you.";
        }

        function setSubjectSalesUpdate($id) {
                $this->subject .= 'Sales lead : $id updated and need your attention';
        }

        function setSubjectSalesClosed($id, $outcome) {
                $this->subject .= 'Sales lead : $id closed as $outcome';
        }


	public function setMailBodyCustomer($username, $extraText) {
                $this->mailBody = "
                        <html>
                        <head>
                          <title>Sales Lead update for last enquiry </title>
                        </head>
                        <body>
                          <p style='font-size:16px;font-color:navy;'> Dear $username, <br> <br> <br>  $extraText </p>

                        </body>
                        </html> ";
        }
        
        function setMailBody($username, $id, $extraText) {
                $this->mailBody = "
                        <html>
                        <head>
                          <title>".self::$link.$id." </title>
                        </head>
                        <body>
                          <p style='font-size:16px;font-color:navy;'> Dear $username, <br> <br> <br>  $extraText </p>

                        </body>
                        </html> ";
        }

        function setToheaders($email) {
                $this->to  = $email;
                return;
        }

        function setEscalation($manager) {
                $this->headers .= "\r\n";
                $this->headers .= "Cc: $manager";
        }

        function sendMailTo() {
                if (empty($this->to) || empty($this->headers) || empty($this->mailBody)){
                        print "mail can not be sent \n";
                }
                else {
                   if (mail($this->to, $this->subject, $this->mailBody, $this->headers) == false ) echo "mail delivery failed not accepted";
                }
        }


}//end of class
?>

