<?php
namespace controller\proyecto{
  require __DIR__ . "/../Model/TareaModel.php";
  use  model\tarea\Tarea;
  class TareaController{

    private  $tarea;
    private static $instance = null;

    private function __construct(){
          $this->tarea = Tarea::getInstance();
    }

    public static function getInstance(){
      if(self::$instance == null){
          self::$instance = new self();
      }
      return self::$instance;
    }

    public function get($request){
      if (isset($request[2])){
          //definir metodo de busqueda
          $response =array(
          "mensaje" => "funcion 'busqueda no definida",
          "URIData" => $request
        );
      }else{
          $response =  $this->tarea->obtenerTareaDB();
      }
      return $response;
    }

    public function post($data){
        $data=json_decode($data,true);
        return  $this->tarea->insertarTareaDB($data);
    }
  }
}