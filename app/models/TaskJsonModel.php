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

    public function createTask(){
        echo '<br>CREAR TAREA' . '<br>';  
        $this->titulo = $_GET['titulo'];
        $this->descripcion = $_GET['descripcion'];
        $this->estado = 'pendiente';

        $this->nextid = rand(10000, 200000);
        
        // $newUser = [
        //     {
        //         "idTareas" => "nextid",
        //         "titulo": "Subir a producción la tarea B01-001",
        //         "descripcion": "Subir los cambios realizados en la tarea B01-001 a producción mediante Git",
        //         "estado": "pendiente",
        //         "fec_creacion": "2021-06-23 17:59:51",
        //         "fec_modif": "2021-06-23 17:59:51",
        //         "fec_fintarea": ""
        //     }
        // ];

        // array_push($allUsers, $newUser);
    }

    public function deleteTask($allUsers, $user){
        echo '<br>ELIMINAR TAREA' . '<br>';  
        
    }

    public function updateTask($allUsers, $user){
        $this->op = $_GET['op'];
        $this->user = $user;
        $this->titulo = $_GET['titulo'];
        $this->descripcion = $_GET['descripcion'];

        // echo '<br>ACTUALIZAR TAREA' . '<br>';
        // echo '<br>Opción: ' . $this->op . '<br>';
        // echo '<br>Id: ' . $this->user['idTareas'] . '<br><br>';

        // echo '<br>Título: ' . $this->titulo . '<br>';
        // echo '<br>Título: ' . $this->descripcion . '<br>';

        $key  = array_search($user['idTareas'], array_column($allUsers, 'idTareas'));
        $allUsers[$key]['titulo'] = $this->titulo;
        $allUsers[$key]['descripcion'] = $this->descripcion;

        file_put_contents(ROOT_PATH . "/lib/db/json/todoTask.json", json_encode($allUsers));    
    }

    public function changeStatusTask($allUsers, $user, $status){

        $this->user = $user;
        
        // $estado = $this->user['estado'];

        // if ($estado == 'pendiente'){
        //     $estado = 'completado';
        // }
        $this->estado = $status;

        $key  = array_search($user['idTareas'], array_column($allUsers, 'idTareas'));

        $allUsers[$key]['estado'] = $this->estado;

        file_put_contents(ROOT_PATH . "/lib/db/json/todoTask.json", json_encode($allUsers));    
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