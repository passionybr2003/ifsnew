<?php 
class Commonfuns {
    public static function constants($param){
        $constants['localhostName'] = 'http://localhost:8087/';
        $constants['serverName'] = 'http://www.getifsccodes.com/';
        
        return $constants[$param];
    }
    
    public function __construct(){
        $this->require_once_files();
        $this->dbparameters();   
    }
    
    public function dbparameters(){
        $serverIp = '31.220.16.20';
        if($_SERVER['SERVER_NAME'] == 'localhost'){
                    define('DB_HOST','127.0.0.1');
                    define('DB_USER','root');
                    define('DB_PWD','');
                    define('DB_NAME','code');
        } else {
                define('DB_HOST','127.0.0.1');
                define('DB_USER','u131272043_ifsc');
                define('DB_PWD','Camellias@123@');
                define('DB_NAME','u131272043_codes');
        }
    }
    
    public function require_once_files(){
        require_once 'classes/dbConnection.php';
        require_once 'classes/sitemapgenerator.php';
        require_once 'classes/ImageCompression.php';
        require_once 'classes/SmtpMail.php';
    }
    
    public static function sanitize($str){
         $data = trim($str);
         $data = filter_var($data, FILTER_SANITIZE_STRING);
         return $data;
    }
    
    public function real_string($value){
        $db = new Dbconnect();
	return $db->real_string($value);
    }
    
    public function sanitizeUrl($str){
        $str = str_replace(" ","-",$str);
        $str = str_replace(",","_",$str);
        $str = htmlspecialchars_decode(htmlspecialchars($str, ENT_SUBSTITUTE, 'UTF-8'));
        $str = preg_replace ('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $str);
        $str = str_replace("--","-",$str);
        $str = str_replace(".","",$str);
        
        return $str;
    }

 
    
}
?>