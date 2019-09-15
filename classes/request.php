<?php

class request implements I_request{

    private $path = "../";

    public function __constructor(){

    }

    //root directory access is only as fast as the server's file r/w speed,
    //which makes sense

    public function write_php_ini(){
        $php_ini = file_get_contents($this->path."readonly/template_php_ini.txt");
        file_put_contents("php.ini",$php_ini,LOCK_EX);
    }

    public function write_htaccess(){
        $htaccess = file_get_contents($this->path."readonly/template_htaccess.txt");
        file_put_contents(".htaccess",$htaccess,LOCK_EX);
    }

    public function filter_request(){
        unset($_POST,$_FILES);
        //filter SUPERGLOBALS
        //$GLOBALS
        //$_SERVER
        //$_REQUEST
        //$_POST
        //$_GET
        //$_FILES
        //$_ENV
        //$_COOKIE
        //$_SESSION
    }

    public function application_root(){
        chdir("../app");
    }

    public function start_application(){
        require_once("index.php");//maybe index.php is good too, but its not the one in the root
    }

    public function exit_application(){
        $this->_exit();
    }

    //************ private *************//

    private function _exit($p=""){
    		print_r($p);
    		while(true){
    			exit();
    			$this->_exit($p=".".$p);
    		}
    }

}

?>
