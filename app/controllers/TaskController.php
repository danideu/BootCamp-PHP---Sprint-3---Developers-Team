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
            // Recoger los valores de los campos que vienen por POST
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

    //Obtener una tarea a través de su ID.
    public function getTask($id){
        //Obtenemos la lista de todos las tareas
        $taskJsonModel = new TaskJsonModel(); 
        $users = $taskJsonModel->listAllTask();
        
        //Buscamos la tarea concreta recorriendo todo el listado
        foreach ($users as $user){
            if ($user['idTareas'] == $id){
                return $user;
            }
        }
        return null;
    }

    //Actualizar la tarea según los campos añadidos en el formulario
    public function updateTaskAction() {
        $id = $_GET['id'];
        $user = $this->getTask($id);
        $this->view->updatetask = $user;
    }

    public function changestatus($status){
        echo  __FILE__ . " ".  __FUNCTION__;
        $id = $_GET['id'];
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
            $id = $_GET['id'];

            switch ($option){
                case "changestatus":
                    $status = $_GET['status'];
                    $user = $this->getTask($id);
                    $taskJsonModel = new TaskJsonModel();       
                    $allUsers = $taskJsonModel->listAllTask();
                    $taskJsonModel->changeStatusTask($allUsers, $user, $status);
                    break;
                case "update":
                    //Actualizamos registro según los datos obtenidos
                    $user = $this->getTask($id);
                    $taskJsonModel = new TaskJsonModel(); 
                    $allUsers = $taskJsonModel->listAllTask();
                    $taskJsonModel->updateTask($allUsers, $user);                    
                    break;
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
    }
}

?>

