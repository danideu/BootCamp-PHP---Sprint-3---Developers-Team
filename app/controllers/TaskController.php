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
        $taskJsonModel->deleteTask($task);
        
        // Refrescamos la lista
        $this->view->showtask = $taskJsonModel->listAllTask();
    }

    public function updateTaskAction() {
        echo  __FILE__ . " ".  __FUNCTION__;
    }

    public function showTaskAction() {      
       //Declaramos un objeto de tipo Model  
       $taskJsonModel = new TaskJsonModel();       
       
       // Pasamos los parametros del controller a la vista 
       $this->view->showtask = $taskJsonModel->listAllTask();

       // En función de la operación a realizar, llamamos al método correspondiente
       if (isset($_GET['op'])) {
            $op = $_GET['op'];
            $id = $_GET['id'];

            switch($op) {
                case 'create':
                    $this->createTaskAction();
                    break;     
                case 'delete':
                      $this->deleteTaskAction($id);
                      break;                
            }
       }
    }

    public function changeStateTaskAction() {
        echo  __FILE__ . " ".  __FUNCTION__;
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

