<?php
namespace model\tarea{
    require __DIR__."/Database.php";

    use mysql_xdevapi\Exception;
    use PDO;
    use model\database\Database;
    class Tarea{
        private $pdo;
        private static $instance = null;
        private $response=[
            "code" => 0 ,
            "message" => ""
            ];
        private function __construct(){
            $this->pdo=Database::getInstance();
        }

        public static function getInstance(){
            if(self::$instance == null){
                self::$instance = new self();
            }
            return self::$instance;
        }

        function obtenerTareaDB(){
            $data = $this->pdo->prepare('call getall_tarea()');

            if($data->execute()) {
                if(($row = $data->fetch(PDO::FETCH_ASSOC)) !== false){
                    do {
                        foreach($row AS $k=>$v) {
                            if(is_numeric($v)) $row[$k] = $v + 0;
                        }
                        $reout[] = $row;
                    }
                    while($row = $data->fetch(PDO::FETCH_ASSOC));
                }
            }
            return  $reout;
        }

        function insertarTareaDB($params){
            try {
                $data = $this->pdo->prepare('call new_tarea(:nombre)');
                $data->bindParam(':nombre', $params[0]['nombre'], PDO::PARAM_STR);
                $data->execute();
                $this->response["code"] = 1;
                $this->response["message"] = "ok";
                return $this->response;
            }catch (Exception $e){
                $this->response["code"] = 0;
                $this->response["message"] = $e;
                return $this->response;
            }

        }
    }
}
