<?php 
class SmtpMail {
   
    private $_smtpServer = "127.0.0.1";
    private $_smtpPort = "25";
    private $_smtpUser = "raghavender.yb";
    private $_smtpPass = "snapdragon123!";
    private $_from = "raghavender.yb@gmail.com";
    
    public function smtp_client ( $to, $subject, $body)  {
         $this->SmtpServer = $this->_smtpServer;
         $this->SmtpUser = base64_encode ($this->_smtpUser);
         $this->SmtpPass = base64_encode ($this->_smtpPass);
         $this->from = $this->_from;
         $this->to = $to;
         $this->subject = $subject;
         $this->newLine = "\r\n";

         $this->subject = $subject;
         $this->body = $body;

         if ($this->_smtpPort == "") {
            $this->PortSMTP = 25;
         } else {
            $this->PortSMTP = $this->_smtpPort;
         }
     }

    public function send_mail () {
        $talk = array();
        if ($SMTPIN = fsockopen ($this->SmtpServer, $this->PortSMTP)) {
            fputs ($SMTPIN, "EHLO ".$HTTP_HOST."\r\n");  
            $talk["hello"] = fgets ( $SMTPIN, 1024 ); 

            fputs($SMTPIN, "auth login\r\n");
            $talk["res"]=fgets($SMTPIN,1024);
            fputs($SMTPIN, $this->SmtpUser."\r\n");
            $talk["user"]=fgets($SMTPIN,1024);

            fputs($SMTPIN, $this->SmtpPass."\r\n");
            $talk["pass"]=fgets($SMTPIN,256);

            fputs ($SMTPIN, "MAIL FROM: <".$this->from.">\r\n");  
            $talk["From"] = fgets ( $SMTPIN, 1024 );  
            fputs ($SMTPIN, "RCPT TO: <".$this->to.">\r\n");  
            $talk["To"] = fgets ($SMTPIN, 1024); 

            fputs($SMTPIN, "DATA\r\n");
            $talk["data"]=fgets( $SMTPIN,1024 );

            //Construct Headers
            $headers = "MIME-Version: 1.0" . $this->newLine;
            $headers .= "Content-type: text/html; charset=iso-8859-1" . $this->newLine;
            $headers .= "From: <".$this->from.">". $this->newLine;
            $headers .= "To: <".$this->to.">". $this->newLine;
            $headers .= "Bcc: $this->newLine";
            $headers .= "Subject: ".$this->subject. $this->newLine;

            fputs($SMTPIN, $headers."\r\n\r\n".$this->body."\r\n.\r\n");
            $talk["send"]=fgets($SMTPIN,256);

            //CLOSE CONNECTION AND EXIT ... 

            fputs ($SMTPIN, "QUIT\r\n");  
            fclose($SMTPIN); 
        }   
        return $talk;
    }        

}
?>