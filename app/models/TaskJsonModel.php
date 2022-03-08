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

    public function getDateFormat()
    {
        $date = new DateTime('now');
        return $date->format('Y-m-d H:i:s');
    }

    public function saveTask($task): void{    
        // Codificamos stdClass >> JSON
       /* $taskJson = json_encode((array)$task);
        echo 'NEW task JSON:';
        print_r($taskJson);
        echo '</pre>';*/
        
        // Abrimos nuestro fichero json        
        $allTask = json_decode($this->openfile(), true);
        /*echo 'ALL :';
        echo '<pre>';
        print_r($allTask);
        echo '</pre>';

        echo '******************* :';
        echo '<pre>';
        print_r(json_encode($allTask));
        echo '</pre>';*/

        // Añadimos la nueva task
        array_push($allTask, $task);
        
        //$a=json_encode($allTask);
        /*echo '******************* :';
        echo '<pre>';
        print_r($a);
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

    public function deleteTask($task){  
        
        /*echo 'TASK:';
        echo '<pre>';
        print_r($task);
        echo '</pre>';*/

        // Abrimos nuestro fichero json        
        $allTask = json_decode($this->openfile(), true);
       
        /*echo 'ALL :';
        echo '<pre>';
        print_r($allTask);
        echo '</pre>';*/

        // Buscamos task
        foreach($allTask as $key=>$value) {
            if($value['idTareas'] == $task['idTareas']) {
                unset($allTask[$key]);
            }    
        }

        // Guardamos datos en fichero json
        /*echo 'SAVE:';
        echo '<pre>';
        print_r($allTask);
        echo '</pre>';*/
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