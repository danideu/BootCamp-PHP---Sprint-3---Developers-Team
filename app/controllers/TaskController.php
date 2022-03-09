<?php


class TaskController extends ApplicationController
{    
	public function indexAction()
	{
		$this->view->message = "hello from test::index";

	}
	
	public function checkAction()
	{
		echo "hello from test::check";
	}

    public function createTaskAction() {       

        if (isset($_POST['titulo']) || isset($_POST['descripcion'])) {
            // Recoger los valores de los campos
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];

            // Validar la información contra bd o js
            $task = new stdClass();               
            //@TODO Cambiar por una clase Util     
            $taskJsonModel = new TaskJsonModel(); 
            $task->idTareas = $taskJsonModel->generateUuid();
            $task->titulo = $titulo;
            $task->descripcion = $descripcion;
            $task->estado = TaskJsonModel::ESTADO_PDTE;            
            $task->fec_creacion = $taskJsonModel->getDateFormat();
            $task->fec_modif = "";
            $task->fec_fintarea = "";

            // Guardamos la task
            $taskJsonModel->saveTask($task);     
        }
    }
    
    public function deleteTaskAction($idTask) {
        // Obtenemos el objeto task
        $task = $this->getTask($idTask);
        
        // Eliminamos la task seleccionada
        $taskJsonModel = new TaskJsonModel();
        $users = $taskJsonModel->listAllTask();
        $taskJsonModel->deleteTask($users, $task);
        
        // Refrescamos la lista
        $this->view->showtask = $taskJsonModel->listAllTask();
    }

    public function getTask($id){
        // echo  __FILE__ . " ".  __FUNCTION__;
        
        $taskJsonModel = new TaskJsonModel(); 
        $users = $taskJsonModel->listAllTask();
        foreach ($users as $user){
            if ($user['idTareas'] == $id){
                // var_dump($user);
                return $user;
            }
        }
        return null;
    }

    public function updateTaskAction() {
        echo  __FILE__ . " ".  __FUNCTION__;
        echo "<br>UpdateTaskAction<br>";
        $id = $_GET['idTarea'];
        $user = $this->getTask($id);
        // var_dump($user);
        $this->view->updatetask = $user ;
        // $action == 'update' ? 'Actualizamos el registro' : $this->view->updatetask = $user ;
        
    }

    public function changestatus($status){
        echo  __FILE__ . " ".  __FUNCTION__;
        $id = $_GET['idTarea'];
        $user = $this->getTask($id);
        $taskJsonModel = new TaskJsonModel();     
        $allUsers = $taskJsonModel->listAllTask();  
        $taskJsonModel->changeStatusTask($allUsers, $user, $status);
    }

    public function showTaskAction() {      
       //Declaramos un objeto de tipo Model  
       $taskJsonModel = new TaskJsonModel();

       //Chequeamos si es cambio de estado
       if (isset($_GET['op'])){ 
           
            $option = $_GET['op'];
            $id = $_GET['idTarea'];

            switch ($option){
                case "changestatus":
                    $status = $_GET['status'];
                    $user = $this->getTask($id);
                    $taskJsonModel = new TaskJsonModel();       
                    $allUsers = $taskJsonModel->listAllTask();
                    $taskJsonModel->changeStatusTask($allUsers, $user, $status);
                    break;
                case "update":
                    $titulo = $_GET['titulo'];
                    $descripcion = $_GET['descripcion'];
                    //Enviamos a la página del Listado
                    // echo '<h1>Actualizamos el registro</h1>';
                    // echo 'Título: ' . $titulo . '<br>';
                    // echo 'Descripción: ' . $descripcion . '<br>';
                    //Actualizamos registro según los datos obtenidos
                    $user = $this->getTask($id);
                    $taskJsonModel = new TaskJsonModel(); 
                    $allUsers = $taskJsonModel->listAllTask();
                    $taskJsonModel->updateTask($allUsers, $user);                    
                    break;
                // case "delete":
                //     // echo "Delete task action";
                //     $user = $this->getTask($id);
                //     $taskJsonModel = new TaskJsonModel(); 
                //     $allUsers = $taskJsonModel->listAllTask();
                //     $taskJsonModel->deleteTask($allUsers, $user); 
                //     break;
                case "create":
                    $this->createTaskAction();
                    break;     
                case "delete":
                    $this->deleteTaskAction($id);
                    break;
                default:
                    echo "Este valor no corresponde a ninguna acción";
                    break;
            }
        }
        // Pasamos los parametros del controller a la vista 
        $this->view->showtask = $taskJsonModel->listAllTask();
    }

    public function changeStateTaskAction() {
        echo  __FILE__ . " ".  __FUNCTION__;
    }

    // public function getTask($id){
    //     $taskJsonModel = new TaskJsonModel(); 
    //     $users = $taskJsonModel->listAllTask();

    //     /*echo "ID: " . $id . "<br>"; 
    //     echo '<pre>';
    //     print_r($users);
    //     echo '</pre>';*/

    //     foreach ($users as $user){
    //         if ($user['idTareas'] == $id){
    //             /*echo '<pre>';
    //             print_r($user);
    //             echo '</pre>';*/
    //             return $user;
    //         }
    //     }
    //     return null;
    // }
}

?>

