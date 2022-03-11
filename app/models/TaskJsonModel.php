<?php

//use Ramsey\Uuid\Uuid;
//require_once (ROOT_PATH . '/vendor/Ramsey/Uuid/Uuid');

class TaskJsonModel{
    public const ESTADO_PDTE = 'Pendiente';
    public const ESTADO_COMP = 'Completado';

    public function __construct()
    {  
    }
   
    private function openFile(): string
    {
        return file_get_contents(ROOT_PATH . "/lib/db/json/todoTask.json", true);                   
    }

    private function saveFile($data): void
    {
        file_put_contents(ROOT_PATH . "/lib/db/json/todoTask.json", json_encode($data));  
    }
    
    public function generateUuid()
    {
        // Generamos el ID de la task             
        //return \Ramsey\Uuid\Uuid::uuid4()->toString(); 
        return rand(1,50);
    }

    public function getDateFormat($date)
    {
        $date = new DateTime($date);
        return $date->format('Y-m-d H:i:s');
    }

    public function saveTask($task): void{    
        // Obtenemos la lista de tareas
        $allTask = $this->listAllTask();

        // Añadimos la nueva task
        array_push($allTask, get_object_vars($task));

        // Guardamos datos en fichero json        
        $this->saveFile($allTask);
    }

    public function listAllTask() {    
        // Abrimos nuestro fichero json        
        $tareas_json = $this->openfile();                   
        // Decodificamos el json
        return  json_decode($tareas_json, true);         
    }

    public function deleteTask($task) {  
        // Obtenemos la lista de tareas
        $allTask = $this->listAllTask(); 

        // Buscamos task
        foreach($allTask as $key=>$value) {
            if($value['idTareas'] == $task['idTareas']) {
                unset($allTask[$key]);
            }    
        }

        // Reorganizamos los indices del array
        $allTaskAux=array_values($allTask);
        
        // Guardamos datos en fichero json       
        $this->saveFile($allTaskAux);
    }   
}

?>