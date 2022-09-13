<?php
namespace model\database {
    use PDO;
    class Database extends PDO{
        private static $instance = null;       
    
        public function __construct(){
            $json_file = file_get_contents(__DIR__.'/file.json');
            $db = json_decode($json_file,true);
            parent::__construct('mysql:host=' . $db["db"]["server"]. ';dbname=' . $db["db"]["dbname"],$db["db"]["username"], $db["db"]["password"]);
        }
    
        public static function getInstance(){
            if(self::$instance == null){
                self::$instance = new self();
            }
            return self::$instance;
        }
    }
}
