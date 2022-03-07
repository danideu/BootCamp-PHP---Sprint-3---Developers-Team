<?php

class TaskJsonModel{
    private $json = "todo.json";
    //private $tareas_json = null;

    public function __construct()
    {  
    }

    public function saveTask($task): void{
        echo 'Crear tarea';
        var_dump($task);        
    }

    public function listAllTask() {    
        // Abrimos nuestro fichero json        
        $tareas_json = file_get_contents(ROOT_PATH . "/lib/db/json/todoTask.json", true);                   
        // Decodificamos el json
        return json_decode($tareas_json, true);         
    }

    public function deleteTask($task){
        $this->task = $task;
        echo 'Eliminar tarea' . $this->task;
    }

    public function updateTask($task){
        $this->task = $task;
        var_dump($this->task);
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