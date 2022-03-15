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
        if (!empty($_POST['task']) || !empty($_POST['user'])) {

            // Recoger los valores de los campos
            $taskTitle = $_POST['task'];
            $description = $_POST['description'];
            $user = $_POST['user'];
            $dateStart = $_POST['dateStart'];
            $dateEnd = $_POST['dateEnd'];

            // Validar la información contra bd o js
            $task = new stdClass();               
            //@TODO Cambiar por una clase Util     
            $taskJsonModel = new TaskJsonModel(); 
            $task->idTareas = $taskJsonModel->generateUuid();
            $task->usuario = $user;
            $task->titulo = $taskTitle;
            $task->descripcion = $description;
            $task->estado = TaskJsonModel::ESTADO_PDTE;            
            $task->fec_creacion = $taskJsonModel->getDateFormat($dateStart);
            $task->fec_modif = "";
            $task->fec_fintarea = $taskJsonModel->getDateFormat($dateEnd);

            // Guardamos la task
            $taskJsonModel->saveTask($task);     

            // Refrescamos la lista
            $this->view->showtask = $taskJsonModel->listAllTask();
        }
    }
    
    public function deleteTaskAction($idTask) {
        // Obtenemos el objeto task
        $task = $this->getTask($idTask);
        
        // Eliminamos la task seleccionada
        $taskJsonModel = new TaskJsonModel();
        $taskJsonModel->deleteTask($task);
        
        // Refrescamos la lista
        $this->view->showtask = $taskJsonModel->listAllTask();
    }

    public function updateTaskAction() {
        echo "<br>UpdateTaskAction<br>";
        $id = $_GET['idTarea'];
        $user = $this->getTask($id);
        // var_dump($user);
        $this->view->updatetask = $user ;
        // $action == 'update' ? 'Actualizamos el registro' : $this->view->updatetask = $user ;
    }

    public function changestatus($status){
        $id = $_GET['idTarea'];
        $user = $this->getTask($id);
        $taskJsonModel = new TaskJsonModel();
        $allUsers = $taskJsonModel->listAllTask();
        $taskJsonModel->changeStatusTask($allUsers, $user, $status);
    }

    public function showTaskAction() {      
       //Declaramos un objeto de tipo Model  
       $taskJsonModel = new TaskJsonModel();

       // En función de la operación a realizar, llamamos al método correspondiente
       if (isset($_GET['op'])) {
            $op = $_GET['op'];
            $id = $_GET['id']; //  $id = $_GET['id'];

            switch($op) {
                case 'create':
                    $this->createTaskAction();
                    break;
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
                    //Actualizamos registro según los datos obtenidos
                    $user = $this->getTask($id);
                    $taskJsonModel = new TaskJsonModel();
                    $allUsers = $taskJsonModel->listAllTask();
                    $taskJsonModel->updateTask($allUsers, $user);
                    break;
                case 'delete':
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

    public function getTask($id){
        $taskJsonModel = new TaskJsonModel(); 
        $users = $taskJsonModel->listAllTask();

        foreach ($users as $user){
            if ($user['idTareas'] == $id){
                return $user;
            }
        }
        return null;
    }
}

