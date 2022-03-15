<?php

//include ('Ramsey\Uuid');

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
        return 12345; 
    }

    public function getDateFormat()
    {
        $date = new DateTime('now');
        return $date->format('Y-m-d H:i:s');
    }

    public function saveTask($task): void{    
        
        // Abrimos nuestro fichero json        
        $allTask = json_decode($this->openfile(), true);

        // Añadimos la nueva task
        array_push($allTask, $task);
        
        // Guardamos datos en fichero json        
        $this->saveFile(json_encode($allTask));
    }

    public function listAllTask() {    
        // Abrimos nuestro fichero json        
        $tareas_json = file_get_contents(ROOT_PATH . "/lib/db/json/todoTask.json", true);                   
        // Decodificamos el json
        return json_decode($tareas_json, true);         
    }

    public function createTask(){  
        $this->titulo = $_GET['titulo'];
        $this->descripcion = $_GET['descripcion'];
        $this->estado = 'pendiente';

        $this->nextid = rand(10000, 200000);
    }

    public function deleteTask($allUsers, $user){
        
    }

    public function updateTask($allUsers, $user){
        $this->op = $_GET['op'];
        $this->user = $user;
        $this->titulo = $_GET['titulo'];
        $this->descripcion = $_GET['descripcion'];
        $this->estado = $_GET['estado'];
        $this->fec_fintarea = $_GET['fec_fintarea'];

        $key  = array_search($user['idTareas'], array_column($allUsers, 'idTareas'));
        $allUsers[$key]['titulo'] = $this->titulo;
        $allUsers[$key]['descripcion'] = $this->descripcion;
        $allUsers[$key]['estado'] = $this->estado;
        $allUsers[$key]['fec_fintarea'] = $this->fec_fintarea;

        file_put_contents(ROOT_PATH . "/lib/db/json/todoTask.json", json_encode($allUsers));    
    }

    public function changeStatusTask($allUsers, $user, $status){

        $this->user = $user;

        $this->estado = $status;

        $key  = array_search($user['idTareas'], array_column($allUsers, 'idTareas'));

        $allUsers[$key]['estado'] = $this->estado;

        file_put_contents(ROOT_PATH . "/lib/db/json/todoTask.json", json_encode($allUsers));    
    }

    public function completeTask($task){
        $this->task = $task;
    }

}
?>