<?php

//include ('Ramsey\Uuid');

class TaskJsonModel{
    private $json = "todo.json";
    //private $tareas_json = null;    
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
        //$uuid = Uuid::uuid4();
        //return $uuid->toString();/
        return 12345; 
    }

    public function getDateFormat($date)
    {
        $date = new DateTime($date);
        return $date->format('Y-m-d H:i:s');
    }

    public function saveTask($task): void{    
        // Abrimos nuestro fichero json        
        $allTask = json_decode($this->openfile(), true);

        // Añadimos la nueva task
        array_push($allTask, get_object_vars($task));
        
        /*echo '<pre>';
        print_r($allTask);
        echo '</pre>';
        echo '****************************<pre>';
        print_r(json_encode($allTask));
        echo '</pre>';*/

        // Guardamos datos en fichero json        
        $this->saveFile(json_encode($allTask));
    }

    public function listAllTask() {    
        // Abrimos nuestro fichero json        
        $tareas_json = file_get_contents(ROOT_PATH . "/lib/db/json/todoTask.json", true);                   
        // Decodificamos el json
        return json_decode($tareas_json, true);         
    }

    public function deleteTask($task) {  
        // Abrimos nuestro fichero json        
        $allTask = json_decode($this->openfile(), true);
       
        // Buscamos task
        foreach($allTask as $key=>$value) {
            if($value['idTareas'] == $task['idTareas']) {
                unset($allTask[$key]);
            }    
        }

        // Guardamos datos en fichero json       
        $this->saveFile($allTask);
    }

    public function updateTask($task){
        $this->task = $task;
        echo 'Actualziar tarea' . $this->task;
    }

    public function completeTask($task){
        $this->task = $task;
        echo 'Completar tarea' . $this->task;
    }

    public function fetchOne($id)
    {
        $sql = 'select * from ' . $this->_table;
        $sql .= ' where id = ?';

        $statement = $this->_dbh->prepare($sql);
        $statement->execute(array($id));

        return $statement->fetch(PDO::FETCH_OBJ);
    }
}
?>