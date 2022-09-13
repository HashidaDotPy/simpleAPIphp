<?php

namespace controller\route{
    require __DIR__ . '/TareaController.php';
    use controller\proyecto\TareaController;

    class App{
        private static $instance = null;
        private $uri;
        private $obj;
        private $data;
        private $http;

        private function __construct($uri,$http,$data){
            $this->uri=$uri;
            $this->obj=$this->findObj($uri[1]);
            $this->http = $http;
            $this->data = $data;
        }
        public static function getInstance($uri,$http,$data){
            if(self::$instance == null){
                self::$instance = new self($uri,$http,$data);
            }
            return self::$instance;
        }

        public function run(){
            if(!isset($this->obj)){
                if($this->uri[1] == "" || $this->uri[1] == "/"){
                    echo json_encode(["value"=>"APIDavidBarrios"],JSON_PRETTY_PRINT);
                    header("HTTP/1.1 200 OK");
                }else{
                    header("HTTP/1.1 404 Not Found");
                }

            }else{
                echo json_encode($this->execMethod($this->http, $this->uri,$this->data),JSON_PRETTY_PRINT);
                header("HTTP/1.1 200 OK");
            }
            return null;
        }

        private function findObj($obj){
            if($obj == "Tarea"){
                return TareaController::getInstance();
            }else{
                return null;
            }
        }

        private function execMethod($http,$uri,$data){
            if($http == "GET"){
                return $this->obj->get($uri);
            }elseif ($http == "POST"){
                return $this->obj->post($data);
            }else{
                return null;
            }
        }
    }
}