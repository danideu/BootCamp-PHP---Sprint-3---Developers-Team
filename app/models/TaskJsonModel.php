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

    public function changeStatusTask($allUsers, $user){

        $this->user = $user;
        
        $estado = $this->user['estado'];

        if ($estado == 'pendiente'){
            $estado = 'completado';
        }

        $key  = array_search($user['idTareas'], array_column($allUsers, 'idTareas'));

        $allUsers[$key]['estado'] = $estado;

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